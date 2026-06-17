<?php

namespace App\Controllers;

use App\Models\Usuarios_model;
use CodeIgniter\API\ResponseTrait;
//Importamos la libreria PHPMailer, que ya tenemos la configuracion para enviar y recibir correos, gracias a la Intranet
require_once APPPATH . '/ThirdParty/PHPMailer/PHPMailer.php';
require_once APPPATH . '/ThirdParty/PHPMailer/Exception.php';
require_once APPPATH . '/ThirdParty/PHPMailer/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Login extends BaseController
{

	use ResponseTrait;

	public function signin()
	{
		$model = new Usuarios_model();
		$session = session();
		if ($this->request->isAJAX()) {
			$datos = json_decode(base64_decode($this->request->getPost('data')));
			$data['usuemail'] = $datos->usuemail;
			$query = $model->login_user($data);
			if ($query->resultID->num_rows > 0) {
				$userdata = array();
				foreach ($query->getResult() as $row) {
					if ($row->borrado === '0') { // Condición para usuario activo
						if (password_verify($datos->usupass, $row->usupass)) {
							$userdata['userid']   = $row->userid;
							$userdata['usupnom']  = utf8_decode(trim($row->usupnom));
							$userdata['usupape']  = utf8_decode(trim($row->usupape));
							$userdata['usuemail'] = utf8_decode(trim($row->usuemail));
							$userdata['usurol']   = intval($row->idrol);
							$userdata["deptid"]   = $row->deptid;
							$userdata['logged']   = TRUE;
							$session->set($userdata);
							//USUARIO ENCONTRADO
							$mensaje = 0;
							return json_encode($mensaje);
						} else {
							//CLAVE INVALIDA
							$mensaje = 1;
							return json_encode($mensaje);
						}
					} else {
						//USUARIO INACTIVO
						$mensaje = 2;
						return json_encode($mensaje);
					}
				}
			} else {
				//USUARIO O CONTRASEÑA INCORRECTA
				$mensaje = 3;
				return json_encode($mensaje);
			}
		} else {
			redirect()->to('/403');
		}
	}

	//Envio de correo de recuperacion
	public function sendRecoverEmail()
	{
		$mail = new PHPMailer();
		$model = new Usuarios_model();
		$dataEmail = array();
		if ($this->request->isAJAX()) {
			$datos = json_decode(base64_decode(utf8_encode($this->request->getPost('data'))), TRUE);
			//Verificamos que el usuario este registrado en el sistema
			$query = $model->getUserByMail($datos["email"]);
			//Si lo esta, generamos un JSON con los datos para generar la recuperacion
			if ($query->resultID->num_rows > 0) {
				//Grabamos el nombre del usuario
				foreach ($query->getResult() as $row) {
					$dataEmail["name"] = $row->usupnom . ' ' . $row->usupape;
				}
				$dataEmail["email"] = $datos["email"];
				$dataEmail["timestamp_generate"] = strtotime(date('Y-m-d H:i:s'));
				$dataEmail["timestamp_expire"] = strtotime("5 minutes", $dataEmail["timestamp_generate"]);
				//Codificamos el JSON y lo encriptamos
				$urlData = base64_encode(json_encode($dataEmail));
				$dataEmail["urldata"] = $urlData;
				$el_servidor  = "172.16.0.161";
				$el_puerto    = "587";
				$el_remitente = "adminsistemas@sapi.gob.ve";
				$el_pass      = "As.12345";
				try {
					$smtpOptions = array(
						'ssl' => array(
							'verify_peer' => false,
							'verify_peer_name' => false,
							'allow_self_signed' => true
						)
					);
					$io_mail = new PHPMailer();
					$io_mail->isSMTP();
					$io_mail->Host = $el_servidor;
					$io_mail->Port = $el_puerto;
					$io_mail->SMTPAuth = true;
					$io_mail->Username = $el_remitente;
					$io_mail->Password = $el_pass;
					$io_mail->SMTPOptions = $smtpOptions;
					$io_mail->setFrom($el_remitente);
					$io_mail->AddAddress($dataEmail["email"], $dataEmail["name"]); // Agrega la dirección de correo de destino
					$io_mail->FromName = "No Reply";
					$io_mail->Subject = utf8_decode("Recuperación de Contraseña de SISALMACEN");
					$io_mail->Body = view('mail/recover', $dataEmail);
					$io_mail->AltBody = 'Este es un mensaje de prueba enviado desde el servidor SMTP';
					if ($io_mail->send()) {
						$url = base_url('mail/recover');
						$link = "<a href='$url' </a>";
						return $this->respond(["message" => "Revisa tu correo para seguir los pasos de recuperación. $link"], 200);
					} else {
						return $this->respond(["message" => "No se pudo enviar el correo, pongase en contacto con el administrador del sistema para más información"], 404);
					}
				} catch (Exception $e) {
					echo 'Error al establecer la conexión SMTP: ' . $e->getMessage();
				}
			}
		} else {
			return redirect()->to('/');
		}
	}
	//Metodo que carga la vista para recuperar la contraseña
	public function settingNewPass($datos = NULL)
	{
		//$data = $datos;
		$cadena_codificada = $datos;
		$cadena_decodificada = base64_decode($cadena_codificada);
		$cadena = $cadena_decodificada;
		$arreglo = explode(",", $cadena);
		$data['email'] = str_replace('"', '', explode(":", $arreglo[1])[1]);

		if (is_null($arreglo)) {
			return redirect()->to('/');
		} else {
			echo view("template/header");
			echo view("set_password/content", $data);
			echo view("set_password/footer");
		}
	}
	//Metodo que permite el cambio de contraseña
	public function changepassword()
	{
		$model = new Usuarios_model();
		if ($this->request->isAJAX()) {
			$datos = json_decode(base64_decode($this->request->getPost('data')), TRUE);
			//Encriptamos la contraseña
			$pass = password_hash($datos["newpass"], PASSWORD_BCRYPT);
			$query = $model->setNewPassword($datos["username"], $pass);
			if ($query) {
				return $this->respond(["message" => "Contraseña cambiada exitosamente"], 200);
			} else {
				return $this->respond(["message" => "ha ocurrido un error, pongase en contacto con el administrador del sistema"], 500);
			}
		} else {
			return redirect()->to('/403');
		}
	}

	public function logout()
	{
		$this->session->destroy();
		return redirect()->to('/');
	}
}
