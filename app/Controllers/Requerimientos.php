<?php

namespace App\Controllers;

use App\Models\Requerimientos_model;
use CodeIgniter\API\ResponseTrait;

class Requerimientos extends BaseController
{

	use ResponseTrait;


	//Funcion que usaremos para crear tablas
	private function crearTabla($heading, $data)
	{
		$tabla = $this->generarTabla($heading, $data);
		return $tabla;
	}

	//Metodo para obtener los requerimientos en el modulo principal del usuario
	public function obtenerRequerimientoPorUsuario()
	{
		$model = new Requerimientos_model();
		$rows = array();
		$headings = array("N° de requerimiento", "Fecha de Solicitud", "Estatus de Solicitud", "Acciones");
		if ($this->session->get('logged')) {
			$usuario = $this->session->get('userid');
			$query = $model->getReqByUser($usuario);
			if ($query->resultID->num_rows > 0) {
				foreach ($query->getResult() as $row) {
					if ($row->prereqstat == '4') {
$rows[] = array($row->prereqid, $this->formatearFecha($row->prereqfecsol), $row->statusnom, '<a href="/confprereq/' . $row->prereqid . '" class="btn-edit-circle" title="Detalles"><i class="fas fa-search"></i></a>');
					} else if ($row->prereqstat == '3') {
$rows[] = array($row->prereqid, $this->formatearFecha($row->prereqfecsol), $row->statusnom, '<a href="/verreqaprob/' . (1000000 + intval($row->prereqid)) . '" class="btn-edit-circle" title="Detalles"><i class="fas fa-search"></i></a>');
					} else {
$rows[] = array($row->prereqid, $this->formatearFecha($row->prereqfecsol), $row->statusnom, '<a href="/ver-requerimiento/' . (1000000 + intval($row->prereqid)) . '" class="btn-edit-circle" title="Detalles"><i class="fas fa-search"></i></a>');
					}
				}
			} else {
				$rows[] = array("Sin registros");
			}
			$tabla = $this->generarTabla($headings, $rows);
			return $this->respond(array("message" => "success", "data" => $tabla), 200);
		} else {
			return redirect()->to('/403');
		}
	}

	//Metodo para cargar un nuevo requerimiento
	public function index()
	{


		$model = new Requerimientos_model();
		if ($this->session->get('logged')) {
			//Insertamos el Requerimiento en la BD
			$newPreReq = array(
				'prereqid'      => $model->getID(),
				'prereqususol'  => $this->session->get('userid'),
				'prereqfecsol'  => date('Y-m-d'),
				'prereqstat'    => 4,
				'prereqdepsol'  => $this->session->get("deptid")
			);
			$query = $model->newPreReq($newPreReq);

			//	if ($query->connID->affected_rows == 1) {
			//Cargamos la vista
			echo view('template/header');
			echo view('template/nav_bar');
			echo view('requerimientos/nuevo_requerimiento', $newPreReq);
			echo view('template/footer');
			echo view('requerimientos/footer');
			//} else {
			//return redirect()->to('/500');
			//}
		} else {
			return redirect()->to('/403');
		}
	}

	//Metodo para añadir items al requerimiento
	public function create()
	{
		$model = new Requerimientos_model();
		if ($this->request->isAJAX() && $this->session->get('logged')) {
			$imgfile = $this->request->getFile('reqimgref');
			$imgname = '';
			$datos = $this->request->getPost();
			//Verificamos que el archivo sea valido
			if ($imgfile->isValid()) {
				//Movemos el archivo
				$imgname = $imgfile->getRandomName();
				$imgfile->move(ROOTPATH . 'public/img', $imgname);
			} else {
				$imgname = 'no_image.jpg';
			}
			//Armamos el arreglo para insertarlo en la BD
			$newReqDet = array(
				"prereqid"    => $datos["reqid"],
				"prodmar"     => utf8_encode($datos["reqmarca"]),
				"prodmodel"   => utf8_encode($datos["reqmodelo"]),
				"prodcantsol" => $datos["reqcantidad"],
				"imgrefprod"  => $imgname
			);
			$query = $model->addDetailPreReq($newReqDet);
			if ($query->connID->affected_rows == 1) {
				return $this->respond(["message" => "success"], 200);
			} else {
				return $this->respond(["message" => "error"], 500);
			}
		} else {
			return redirect()->to('/403');
		}
	}

	//Metodo para listar los detalles del pre requerimiento
	public function show($id = NULL)
	{
		$rows[] = array();
		$heading = array('', 'Marca', "Descripcion", "Unidades Solicitadas", "Acciones");
		$model = new Requerimientos_model();
		if ($this->session->get('logged')) {
			//Metodo para listar los detalles via AJAX
			switch ($this->request->isAJAX()) {
				case TRUE:
					$query = $model->getDetailPreReq($id);
					if ($query->resultID->num_rows > 0) {
						foreach ($query->getResult() as $row) {
							$rows[] = array('<img style="max-width:3rem;" src="' . base_url() . '/img/' . $row->imgrefprod . '">', utf8_decode($row->prodmar), utf8_decode($row->prodmodel), $row->prodcantsol, '<button class="btn btn-sm btn-danger eliminar" id="' . $row->detid . '"><i class="fas fa-trash"></i> Eliminar </button>');
						}
					} else {
						$rows[] = array('<td colspan="5">Sin Registros</td>');
					}
					return $this->respond(["message" => "success", "data" => $this->crearTabla($heading, $rows)]);
					break;
					//En caso de no venir por AJAX,cargamos una vista completa con los detalles para editarla
				default:
					$query = $model->getDetailPreReq($id);
					if ($query->resultID->num_rows > 0) {
						foreach ($query->getResult() as $row) {
							$rows[] = array('<img style="max-width:3rem;" src="' . base_url() . '/img/' . $row->imgrefprod . '">', utf8_decode($row->prodmar), utf8_decode($row->prodmodel), $row->prodcantsol, '<button class="btn btn-sm btn-danger eliminar" id="' . $row->detid . '"><i class="fas fa-trash"></i> Eliminar </button>');
						}
					} else {
						$rows[] = array('<td colspan="5">Sin Registros</td>');
					}
					$tpldata = array(
						"reqid" => $id,
						"tabla" => $this->crearTabla($heading, $rows)
					);
					echo view("template/header");
					echo view("template/nav_bar");
					echo view('requerimientos/editar_requerimiento', $tpldata);
					echo view("template/footer");
					echo view("requerimientos/footer");
					break;
			}
		}
	}

	//Metodo para eliminar un item del pre Requerimiento
	public function delete($id = NULL)
	{
		if ($this->session->get('logged') && $this->request->isAJAX()) {
			$deleteItem = array(
				"detid" => $id
			);
			$model = new Requerimientos_model();
			$query = $model->deleteItemPreReq($deleteItem);
			if ($query->connID->affected_rows == 1) {
				return $this->respond(["message" => "success"], 200);
			} else {
				return $this->respond(["message" => "error"], 500);
			}
		} else {
			return redirect()->to('/403');
		}
	}

	//Metodo para eliminar los Prerequerimientos
	public function deletePreReq()
	{
		$model = new Requerimientos_model();
		if ($this->session->get('logged') && $this->request->isAJAX()) {
			$datos = json_decode(utf8_encode(base64_decode($this->request->getPost('data'))), TRUE);
			$query = $model->delPreReq($datos["prereqid"]);
			if ($query) {
				return $this->respond(["message" => "success"], 200);
			} else {
				return $this->respond(["message" => "error"], 500);
			}
		} else {
			return redirect()->to('/403');
		}
	}


	//Metodo para confirmar un prerequermiento
	public function confirmPreReq()
	{
		$model = new Requerimientos_model();
		if ($this->session->get('logged') && $this->request->isAJAX()) {
			$datos = json_decode(utf8_encode(base64_decode($this->request->getPost('data'))), TRUE);
			$query = $model->changeStatus('1', $datos["status"], $datos["reqid"]);
			if ($query) {
				return $this->respond(["message" => "success"], 200);
			} else {
				return $this->respond(["message" => "error"], 500);
			}
		} else {
			return redirect()->to('/403');
		}
	}
	//Metodo para listar los requerimientos en el modulo de administrador
	public function list()
	{
		$model = new Requerimientos_model();
		$rows[] = array();
		$heading = array('N° Requerimiento', "Usuario Solicitante", "Departamento", "Acciones");
		if ($this->session->get('usurol') == 2 || $this->session->get('usurol') == 1 && $this->session->get('logged')) {
			//Obtenemos los requerimientos solicitados
			$query = $model->listReqByAp();
			if ($query->resultID->num_rows > 0) {
				foreach ($query->getResult() as $row) {
$rows[] = array($row->prereqid, utf8_decode($row->usupnom . ' ' . $row->usupape), utf8_decode($row->depnom), '<a href="/apprereq/' . $row->prereqid . '" class="btn-edit-circle" title="Detalles"><i class="fas fa-search"></i></a>');
				}
			} else {
				$rows[] = array('<td colspan="4">No hay requerimientos por aprobar</td>', "", "", "");
			}
			$tabla = $this->crearTabla($heading, $rows);
			echo view('template/header');
			echo view('template/nav_bar');
			echo view("requerimientos/lista_requerimiento", ["tabla" => $tabla]);
			echo view('template/footer');
			echo view('requerimientos/footer');
		} else {
			return redirect()->to('/403');
		}
	}

	//Metodo para mostrar el requerimiento y aprobarlo
	public function confirmarPrerequerimiento($id = NULL)
	{
		$model = new Requerimientos_model();
		$tpldata = array();
		$rows[] = array();
		if ($this->session->get('logged') && $this->session->get('usurol') == 2 || $this->session->get('usurol') == 1 && !is_null($id)) {
			//Obtenemos los detalles de la solicitud
			$detalles = $model->getDetailsByID('1', $id);
			if ($detalles->resultID->num_rows > 0) {
				foreach ($detalles->getResult() as $row) {
					$tpldata["reqid"]      = $row->prereqid;
					$tpldata["fechasol"]   = $this->formatearFecha($row->prereqfecsol);
					$tpldata["usupnom"]    = $row->usupnom;
					$tpldata["usupape"]    = $row->usupape;
					$tpldata["dirnom"]     = $row->dirnom;
					$tpldata["depnom"]     = $row->depnom;
					$tpldata["ususol"]     = $row->userid;
				}
			} else {
				return redirect()->to('/404');
			}
			//Obtenemos los items de la solicitud
			$items = $model->getDetailPreReq($id);
			if ($items->resultID->num_rows > 0) {
				foreach ($items->getResult() as $row) {
					$rows[] = array(
						'<img style="max-width:4rem;" src="' . base_url() . '/img/' . $row->imgrefprod . '">',
						utf8_decode($row->prodmar),
						utf8_decode($row->prodmodel),
						$row->prodcantsol,
						'<input class="custom-range" data-prettify-enabled data-prettify-separator="." id="' . $row->detid . '" type="text" name="' . $row->detid . '" value="' . $row->prodcantsol . '" data-type="single" data-min="0" data-max="' . $row->prodcantsol . '" data-from="" data-to="' . $row->prodcantsol . '" data-step="1" data-hasgrid="true">'
					);
				}
			} else {
				$rows[] = array('<td colspan="5">Esta solicitud no tiene registros</td>');
			}
			//Generamos la tabla
			$tpldata["tbody"] = $this->crearTabla(["", "Marca", "Descripcion", "Cantidad Solicitada", "Cantidad a Aprobar"], $rows);

			//Inyectamos los datos a la vista
			echo view("template/header");
			echo view("template/nav_bar");
			echo view("requerimientos/aprobar_requerimiento", $tpldata);
			echo view("template/footer");
			echo view("requerimientos/footer");
		} else {
			return redirect()->to('/403');
		}
	}

	//Metodo para tomar el pre requerimiento y registrarlo como requerimiento
	public function registrarRequerimiento()
	{
		$model = new Requerimientos_model();
		$datosReq = array();
		$detalleReq = array();
		if ($this->session->get('logged') && $this->request->isAJAX() && $this->session->get('usurol') == 1 || $this->session->get('usurol') == 2) {
			$datos = json_decode(utf8_encode(base64_decode($this->request->getPost('data'))), TRUE);
			//Obtenemos los datos de la solicitud para insertarlos en la tabla de los requerimientos
			$datosSolicitud = $model->getDetailsByID('1', $datos["num_req"]);
			//De encontrarlos, hacemos el arreglo para insertarlos en la BD
			if ($datosSolicitud->resultID->num_rows > 0) {
				foreach ($datosSolicitud->getResult() as $row) {
					$datosReq["reqid"]    = $row->prereqid;
					$datosReq["ususol"]   = $row->prereqususol;
					$datosReq["fechasol"] = $row->prereqfecsol;
					$datosReq["fecapsol"] = date("Y-m-d");
					$datosReq["depsol"]   = $row->prereqdepsol;
					$datosReq["statussol"] = 2;
				}
				//Luego de cargar los datos, cargamos los detalles
				foreach ($datos["items"] as $row) {
					$buff = $model->getDetailByID($row["itemid"]);
					$detalleReq[] = array(
						"detmar"       => $buff["prodmar"],
						"detmod"       => $buff["prodmodel"],
						"reqid"        => $datos["num_req"],
						"detnumunisol" => $buff["prodcantsol"],
						"detnumuniap"  => $row["numuniap"],
						"detimgref"    => $buff["imgrefprod"]
					);
				}
				//Insertamos en la BD los detalles de la solicitud
				$query = $model->newReq($datosReq, $detalleReq);
				if ($query) {
					unset($query);
					//Cambiamos el estatus al pre requerimiento 
					$model->changeStatus('1', '2', $datos["num_req"]);
					return $this->respond(["message" => "success"], 200);
				} else {
					return $this->respond(["message" => "error"], 500);
				}
			} else {
				return $this->respond(["message" => "Not Found"], 404);
			}
		} else {
			return redirect()->to('/403');
		}
	}
}
