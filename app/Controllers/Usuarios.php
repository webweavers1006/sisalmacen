<?php

namespace App\Controllers;

use App\Models\Usuarios_model;

use CodeIgniter\RESTful\ResourceController;

class Usuarios extends ResourceController
{

	//Metodo queo obtiene todos los usuarios disponibles
	public function listar_Usuarios()

	{
		
		$model = new Usuarios_model();
		$query = $model->get_all();
		
		if (empty($query)) {
			$usuarios = [];
		} else {
			$usuarios = $query;
		}
		echo json_encode($usuarios);
	}


	public function index()
	{
		if ($this->request->isAJAX()) {
			$response = array();
			$model = new Usuarios_model();
			$query = $model->get_all_2();
			$datos = array();
			if ($query->resultID->num_rows > 0) {
				foreach ($query->getResult() as $row) {
					$datos[] = array($row->userid, $row->usupnom, $row->ususnom, $row->usupape, $row->ususape, $row->usuemail, $row->depnom);
				}
				$response['status'] = 200;
				$response['message'] = 'Datos obtenidos exitosamente';
				$response['data'] = $datos;
			} else {
				$response['status'] = 404;
				$response['message'] = 'Sin registros';
			}
			return json_encode($response);
		} else {
			redirect()->to('/403');
		}
	}

	public function show($id = null)
	{
		$model = new Usuarios_model();
		$query = $model->get_single($id);
		$data = array();
		if ($query->resultID->num_rows > 0) {
			foreach ($query->getResult() as $row) {
				$data['userid']   = $row->userid;
				$data['userpnom'] = $row->usupnom;
				$data['usersnom'] = $row->ususnom;
				$data['userpape'] = $row->usupape;
				$data['userspae'] = $row->ususape;
				$data['useremail'] = $row->usuemail;
				$data['depid'] = $row->deptid;
				$data['usudir'] = $row->dirid;
				$data['usudep'] = $row->deptid;
				$data['usurol'] = $row->idrol;
				$data['borrado'] = $row->borrado;
			}
		} else {
			redirect()->to('/');
		}
		echo view('template/header');
		echo view('template/nav_bar');
		echo view('usuarios/edituser', $data);
		echo view('template/footer');
		echo view('usuarios/addfooter');
	}

	/*Metodo que obtiene los departamentos por los directorios*/

	public function getDeptDetalles($id = null)
	{
		$response = array();
		$data = array();
		if ($this->request->isAJAX()) {
			$model = new Usuarios_model();
			$query = $model->getDepByDir($id);
			if ($query->resultID->num_rows > 0) {
				foreach ($query->getResult() as $row) {
					$data[] = array($row->deptid, $row->depnom);
				}
				$response['status'] = 200;
				$response['message'] = 'Datos cargados correctamente';
				$response['data'] = $data;
				return json_encode($response);
			} else {
				$response['status'] = 404;
				$response['message'] = 'not found';
				$response['data'] = $data;
				return json_encode($response);
			}
		} else {
			return redirect()->to('/');
		}
	}
	/*Metodo para mostrar el form de agregar usuario*/
	public function addUser()
	{
		echo view('template/header');
		echo view('template/nav_bar');
		echo view('usuarios/adduser');
		echo view('template/footer');
		echo view('usuarios/addfooter');
	}
	/*Metodo que registra o edita segun sea el caso*/
	public function create()
	{
		if ($this->request->isAJAX()) {
			$response = array();
			$datos = json_decode(utf8_encode(base64_decode($this->request->getPost('data'))));
			$model = new Usuarios_model();
			$data = array();
			if (strlen($datos->userid) == 0) {
				$data['usupnom'] = $datos->userpnom;
				$data['ususnom'] = $datos->usersnom;
				$data['usupape'] = $datos->userpape;
				$data['ususape'] = $datos->userspae;
				$data['usuemail'] = $datos->useremail;
				$data['usupass'] = password_hash($datos->userpass, PASSWORD_BCRYPT);
				$data['idrol'] = $datos->usurol;
				$data['deptid'] = $datos->usudep;
				$query = $model->add_new($data);
				if ($query) {
					$response['status'] = 200;
					$response['message'] = 'Operacion completada';
				} else {
					$response['status'] = 500;
					$response['message'] = 'Hubo un error';
				}
				return json_encode($response);
			} else {
				$data['userid']   = $datos->userid;
				$data['usupnom'] = $datos->userpnom;
				$data['ususnom'] = $datos->usersnom;
				$data['usupape'] = $datos->userpape;
				$data['ususape'] = $datos->userspae;
				$data['usuemail'] = $datos->useremail;
				$data['borrado'] = $datos->borrado;
				$data['idrol'] = $datos->usurol;
				$data['deptid'] = $datos->usudep;
				$query = $model->edit($data);
				if ($query) {
					$response['status'] = 200;
					$response['message'] = 'Operacion realizada correctamente';
				} else {
					$response['status'] = 500;
					$response['message'] = 'Error en la edicion del dato';
				}
			}
			return json_encode($response);
		} else {
			return redirect()->to('/');
		}
	}

	/*Metodo para Cambiar la clave del Usuario*/

	public function reset_password()
	{
		if ($this->request->isAJAX()) {
			$model = new Usuarios_model();
			$data = array();
			if ($this->session->get('logged') and $this->request->isAJAX()) {
				//Obtenemos los datos del formulario
				$datos = json_decode(utf8_encode(base64_decode($this->request->getPost('data'))));
				$data['usupass'] = password_hash($datos->userpass, PASSWORD_BCRYPT);
				$data['userid'] = $datos->id_user;
				$query = $model->edit($data);
				if ($query) {
					$mesaje = 1;
					return json_encode($mesaje);
				} else {
					$mesaje = 2;
					return json_encode($mesaje);
				}
			}
		} else {
			return redirect()->to('/');
		}
	}


	/*Metodo para eliminar un registro*/
	public function delete($id = null)
	{
		if ($this->request->isAJAX()) {
			$response = array();
			$model = new Usuarios_model();
			$query = $model->delete_user($id);
			if ($query) {
				$response['status'] = 200;
				$response['message'] = 'Consulta realizada exitosamente';
			} else {
				$response['status'] = 500;
				$response['message'] = 'Error al eliminar';
			}
			echo json_encode($response);
		} else {
			return redirect()->to('/');
		}
	}

	//Metodo para que el usuario pueda cambiar su contraseña
	public function perfil($id = NULL)
	{
		$model = new Usuarios_model();
		$query = $model->get_single($id);
		$data = array();
		if ($query->resultID->num_rows > 0) {
			foreach ($query->getResult() as $row) {
				$data['userid']   = $row->userid;
				$data['userpnom'] = $row->usupnom;
				$data['usersnom'] = $row->ususnom;
				$data['userpape'] = $row->usupape;
				$data['userspae'] = $row->ususape;
				$data['useremail'] = $row->usuemail;
				$data['depid'] = $row->deptid;
				$data['usudir'] = $row->dirid;
				$data['usudep'] = $row->deptid;
				$data['usurol'] = $row->idrol;
			}
		} else {
			redirect()->to('/');
		}
		echo view('template/header');
		echo view('template/nav_bar');
		echo view('perfil/perfil.php', $data);
		echo view('template/footer');
		echo view('usuarios/addfooter');
	}
}
