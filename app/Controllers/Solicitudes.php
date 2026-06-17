<?php

namespace App\Controllers;

use App\Models\Solicitudes_model;
use App\Models\Almacen_model;
use CodeIgniter\API\ResponseTrait;
use PhpOffice\PhpSpreadsheet\Calculation\TextData\Replace;

class Solicitudes extends BaseController
{

	use ResponseTrait;

	//Metodo para cargar el catalogo de existencias
	public function catalog()
	{
		$model = new Almacen_model();
		$query = $model->mostrarCatologo();
		$rows = array();
		$heading = array("Producto", "Presentacion", "");
		if ($query->resultID->num_rows > 0) {
			foreach ($query->getResult() as $row) {
				if ($row->numexis > 0) {
					$rows[] =  array(
						utf8_decode(ucwords($row->prodmodel)),
						utf8_decode(ucwords($model->obtenerPresentacionProd($row->codbar))),
						'<button id="' . $row->codbar . '" class="btn btn-sm btn-info add-detail"><i class="fas fa-plus"></i>Añadir</button>'
					);
				}
			}
		} else {
			$rows[] = array('<td colspan="3">Sin Registros</td>');
		}
		$tbody = $this->generarTabla($heading, $rows);
		return $tbody;
	}


	//Metodo para cargar la vista de las requisicioness*/
	public function nuevaRequisicion()
	{
		if ($this->session->get('logged')) {
			//Solicitamos un nuevo numero de orden
			$model = new Solicitudes_model();
			$numorden = $model->getNumOrden();
			$query = $model->addNumOrden(array(
				'numorden' => $numorden,
				'fecsol'   => date('Y-m-d'),
				'ordstatus' => 4,
				'usureg'    => $this->session->get('userid')
			));
			unset($model);
			$tbody = $this->catalog();
			//Armamos la vista

			echo view('template/header');
			echo view('template/nav_bar');
			echo view('catalog/newreq', array('tbody' => $tbody, 'numorden' => $numorden));
			echo view('template/footer');
			echo view('catalog/footer');
		} else {
			return redirect()->to('/');
		}
	}

	//Metodo que actualiza el detalle de la preorden
	public function actualizaPreorden()
	{
		$model = new Solicitudes_model();
		$headings = array("Descripcion del producto", "N° de unidades", "Acciones");
		$rows = array();
		if ($this->request->isAJAX() && $this->session->get('logged')) {
			$datos = json_decode(base64_decode(utf8_encode($this->request->getPost('data'))), TRUE);
			$query = $model->consultarSolicitud($datos["numorden"]);
			if ($query->resultID->num_rows > 0) {
				foreach ($query->getResult() as $row) {
					$rows[] = array(utf8_decode($row->prodmodel), $row->numuni, '<button class="btn btn-sm btn-danger eliminar" id="' . $row->detalleid . '"><i class="fas fa-trash"></i> Eliminar</button>');
				}
			} else {
				$rows[] = array('<td colspan="3">Aún no se han solicitado productos</td>', '', '');
			}
			$tabla = $this->generarTabla($headings, $rows);
			return $this->respond(array("message" => "success", "data" => $tabla), 200);
		} else {
			return redirect()->to('/403');
		}
	}
	//Metodo que añade elementos en las presolicitudes
	public function addDetalle()
	{
		$model = new Solicitudes_model();
		if ($this->request->isAJAX() && $this->session->get('logged')) {
			$datos = json_decode(utf8_decode(base64_decode($this->request->getPost('data'))), TRUE);
			//Validamos que el item no haya sido añadido previamente
			if ($model->itemExists($datos['codbar'], $datos['numorden'])) {
				$query = $model->updateItem($datos);
				if ($query) {
					return $this->respond(array('message' => 'Item Actualizado exitosamente', 200));
				} else {
					return $this->respond(array('message' => 'Error al añadir el item', 500));
				}
			} else {
				$query = $model->addItem($datos);
				if ($query) {
					return $this->respond(array('message' => 'Item Añadido exitosamente'), 200);
				} else {
					return $this->respond(array('message' => 'Error al añadir el item'), 500);
				}
			}
		} else {
			return redirect()->to('/');
		}
	}

	/*Metodo para listar el historico de prerequerimientos*/

	public function obtenerPreordenes()
	{
		if ($this->request->isAJAX() && $this->session->get('logged')) {
			$model = new Solicitudes_model();
			$query = $model->getPreordenes($this->session->get('userid'), "2");
			$tbody = '';
			//Mostramos las preordenes
			if ($query->resultID->num_rows > 0) {
				foreach ($query->getResult() as $row) {
					$tbody .= '<tr>
					<td>' . $row->numorden . '</td>
					<td data-order="' . date('Y-m-d', strtotime($row->fecsol)) . '">' . $this->formatearFecha($row->fecsol) . '</td>
					<td>' . $row->statusnom . '</td>
					<td>' . urldecode($row->comentario) . '</td>';

					if ($row->ordstatus == '4') {
$tbody .= '<td><a href="/preordenesdetalle/' . $row->numorden . '" class="btn-edit-circle" title="Detalle"><i class="fas fa-search"></i></a></td>';
					} else if ($row->ordstatus == '3') {
$tbody .= '<td><a href="/detalledespacho/' . $row->numorden . '" class="btn-edit-circle" title="Detalle"><i class="fas fa-search"></i></a></td>';
					} else {
$tbody .= '<td><a href="/verpreorden/' . $row->numorden . '" class="btn-edit-circle" title="Detalle"><i class="fas fa-search"></i></a></td>';
					}
					$tbody .= '</tr>';
				}
			} else {
				$tbody .= '<tr><td colspan="4" class="text-center">Sin registros</td></tr>';
			}
			return $this->respond(array('message' => 'success', 'data' => $tbody), 200);
		} else {
			return redirect()->to('/');
		}
	}

	//Metodo que muestra la tabla de las ordenes solicitadas

	public function obtenerOrdenes()
	{
		if ($this->request->isAJAX() && $this->session->get('logged')) {
			$model = new Solicitudes_model();
			$query = $model->getOrdenes($this->session->get('userid'));
			$tbody = '';
			//Mostramos las preordenes
			if ($query->resultID->num_rows > 0) {
				foreach ($query->getResult() as $row) {
					$tbody .= '<tr>
					<td>' . $row->numorden . '</td>
					<td>' . $this->formatearFecha($row->fecaprob) . '</td>
					<td>' . $row->statusnom . '</td>
					<td><a href="/ordendetalle/' . $row->numorden . '">Detalle</a></td>
					</tr>';
				}
			} else {
				$tbody .= '<tr><td colspan="4" class="text-center">Sin registros</td></tr>';
			}
			return $this->respond(array('message' => 'success', 'data' => $tbody), 200);
		} else {
			return redirect()->to('/');
		}
	}

	public function preordenesdetalle($id = NULL)
	{
		if ($this->session->get('logged') && $id != NULL) {
			$model = new Solicitudes_model();
			$query = $model->detallePreorden($id);
			$rows = array();
			if ($query->resultID->num_rows > 0) {
				foreach ($query->getResult() as $row) {
					$rows[] = array($row->detalleid, utf8_decode($row->prodmodel), $row->numuni, '<button class="btn btn-sm btn-danger eliminar" id="' . $row->detalleid . '"><i class="fas fa-trash"></i>Eliminar</button>');
				}
			} else {
				$rows[] = array('<td colspan="5" class="text-center">Esta solicitud esta vacia, añade items con el botón Añadir</td>');
			}

			//Cargamos la vista 

			echo view('template/header');
			echo view('template/nav_bar');
			echo view('catalog/detpreorder', array('tbody' => $this->generarTabla(["ID Item", "Descripcion", "Unidades Solicitadas", "Acciones"], $rows), 'numorden' => $id));
			echo view('template/footer');
			echo view('catalog/footer');
		} else {
			return redirect()->to('/');
		}
	}

	//Metodo para añadir nuevos items a una solicitud ya creada

	public function editarPreorden($id = NULL)
	{
		if ($this->session->get('logged')) {
			$tbody = $this->catalog();
			echo view('template/header');
			echo view('template/nav_bar');
			echo view('catalog/newreq', array('tbody' => $tbody, 'numorden' => $id));
			echo view('template/footer');
			echo view('catalog/footer');
		} else {
			return redirect()->to('/');
		}
	}

	//Metodo para eliminar la preorden

	public function eliminarPreorden($id = NULL)
	{
		if ($this->session->get('logged')) {
			$model = new Solicitudes_model();
			$query = $model->deletePreorden($id);
			if ($query) {
				return redirect()->to('/inicio');
			} else {
				echo view('errors/html/production');
			}
		} else {
			return redirect()->to('/');
		}
	}

	//Metodo para eliminar items de la preorden 

	public function eliminarItemPreOrden()
	{
		if ($this->request->isAJAX() && $this->session->get('logged')) {
			$model = new Solicitudes_model();
			$tbody = '';
			$datos = json_decode(base64_decode($this->request->getPost('data')), TRUE);
			$query = $model->deleteItemPreorden($datos['itemid']);
			if ($query) {
				$query = $model->detallePreorden($datos['numorden']);
				if ($query->resultID->num_rows > 0) {
					foreach ($query->getResult() as $row) {
						$tbody .= '
						<tr>
						<td class="text-center">' . $row->detalleid . '</td>
						<td class="text-center">' . utf8_decode($row->prodmar) . '</td>
						<td class="text-center">' . utf8_decode($row->prodmodel) . '</td>
						<td class="text-center">' . $row->numuni . '</td>
						<td><button class="btn btn-sm btn-danger eliminar" id="' . $row->detalleid . '"><i class="fas fa-trash"></i>Eliminar</button></td>
						</tr>';
					}
				} else {
					$tbody .= '
					<tr>
					<td colspan="5" class="text-center">Esta solicitud esta vacia, añade items con el botón Añadir</td>
					</tr>
					';
				}
				return $this->respond(array('message' => 'success', 'data' => $tbody), 200);
			} else {
				return $this->respond(array('message' => 'error'), 500);
			}
		} else {
			return redirect()->to('/');
		}
	}

	//Metodo para aprobar las preordenes
	public function aprobarPreorden($id = NULL, $comentario = NULL)

	{
		
		// echo ('<br>');
		// echo ($id);
		if ($this->session->get('logged')) {
			$model = new Solicitudes_model();
			$comentario = str_replace('%20', ' ', $comentario);
			$query = $model->confirmarPreorden($id, $comentario);
			if ($query) {
				return redirect()->to('/inicio');
			}
		} else {
			return redirect()->to('/');
		}
	}

	//Metodo para ver las preordenes en Tramite

	public function verPreorden($id = NULL)
	{
		if ($this->session->get('logged')) {
			$model = new Solicitudes_model();
			$rows = array();
			$tabla = $model->detallePreorden($id);
			$userdata = array();
			//Detalles de la preorden
			if ($tabla->resultID->num_rows > 0) {
				foreach ($tabla->getResult() as $row) {
					$rows[] = array($row->detalleid, utf8_decode($row->prodmar), utf8_decode($row->prodmodel), $row->numuni);
				}
			} else {
				$rows[] = ['<td colspan="4" class="text-center">Sin Registros</td>', "<td></td>", "<td></td>", "<td></td>"];
			}
			$userdata['tbody'] = $this->generarTabla(["ID Item", "Marca", "Modelo", "Cantidad solicitada"], $rows);
			//Datos del solicitante
			$datos = $model->getDatosPreorden($id);
			if ($datos->resultID->num_rows > 0) {
				foreach ($datos->getResult() as $row) {
					$userdata['numorden'] = $row->numorden;
					$userdata['fecsol'] = $this->formatearFecha($row->fecsol);
					$userdata['usupnom'] = $row->usupnom;
					$userdata['usupape'] = $row->usupape;
					$userdata['depnom'] = $row->depnom;
					$userdata['dirnom'] = $row->dirnom;
				}
			}
			echo view('template/header');
			echo view('template/nav_bar');
			echo view('catalog/verpreorden', $userdata);
			echo view('template/footer');
			echo view('catalog/footer');
		} else {
			return redirect()->to('/');
		}
	}

	/*

	Metodos para las ordenes

	*/

	//Metodo para obtener las solicitudes en Tramite
	public function requerimientosPorAprobar()
	{
		if ($this->session->get('logged') && $this->session->get('usurol') == '1' || $this->session->get('usurol') == '2') {
			$model = new Solicitudes_model();
			$query = $model->obtenerEnTramite();
			$tbody = '';

			if ($query->resultID->num_rows > 0) {
				foreach ($query->getResult() as $row) {
					$tbody .= '
					<tr>
					<td >' . $row->numorden . '</td>
					<td>' . $this->formatearFecha($row->fecsol) . '</td>
					<td>' . utf8_decode($row->usupnom) . ' ' . utf8_decode($row->usupape) . '</td>
					<td><a href="/aprobarpreorden/' . $row->numorden . '">Ver solicitud</a></td>
					</tr>';
				}
			} else {
				$tbody .= '<tr><td colspan="5" class="text-center">Sin Registros</td></tr>';
			}

			echo view('template/header');
			echo view('template/nav_bar');
			echo view('catalog/solicitudes_aprobar', array('tbody' => $tbody));
			echo view('template/footer');
			echo view('catalog/footer');
		} else {
			return redirect()->to('/');
		}
	}

	//Metodo para ver la preorden y pasarla a orden

	public function apruebapreorden($id = NULL)
	{
		$model = new Solicitudes_model();
		$almacen = new Almacen_model();
		$query = $model->comparaExistencia($id);
		$rows = array();
		$tpldata = array();
		if ($query->resultID->num_rows > 0) {
			foreach ($query->getResult() as $row) {
				//Validacion para setear el contador en la solicitud, si se dispone de inventario
				if (intval($row->numexis) >= intval($row->numuni)) {
					$rows[] = array(utf8_decode($row->prodmodel), ucwords($almacen->obtenerPresentacionProd($row->codbar)), $row->numuni,  '<input class="custom-range" data-prettify-enabled data-prettify-separator="." id="' . $row->detalleid . '" type="text" name="' . $row->detalleid . '" value="' . $row->numuni . '" data-type="single" data-min="0" data-max="' . $row->numexis . '" data-from="" data-to="' . $row->numexis . '" data-step="1" data-hasgrid="true">');
				}
				//De lo contrario, estará en cero
				else {
					$rows[] = array(utf8_decode($row->prodmodel),  ucwords($almacen->obtenerPresentacionProd($row->codbar)), $row->numuni, '<input class="custom-range" data-prettify-enabled data-prettify-separator="." id="' . $row->detalleid . '" type="text" name="' . $row->detalleid . '" value="" data-type="single" data-min="0" data-max="' . $row->numexis . '" data-from="0" data-to="' . $row->numexis . '" data-step="1" data-hasgrid="true">');
				}
			}
		} else {
			$rows[] = array('<td class="text-center" colspan="5">Esta Solicitud está sin registros</td>', "<td></td>", "<td></td>", "<td></td>", "<td></td>");
		}
		//Obtenemos ahora los datos del usuario
		$ususoldata = $model->datosPreorden($id);
		if ($ususoldata->resultID->num_rows > 0) {
			foreach ($ususoldata->getResult() as $row) {
				$tpldata['fecsol'] = $this->formatearFecha($row->fecsol);
				$tpldata['usupnom'] = utf8_decode($row->usupnom);
				$tpldata['usupape'] = utf8_decode($row->usupape);
				$tpldata['userid']  = $row->userid;
				$tpldata['depnom'] = $row->depnom;
				$tpldata['dirnom'] = $row->dirnom;
				$tpldata['comentario'] = $row->comentario;
			}
		} else {
			return redirect()->to('/500');
		}
		$tpldata['numorden'] = $id;
		$tpldata['tbody'] = $this->generarTablaReporte(["Descripcion", "Presentacion", "Cantidad solicitada", "Cantidad a Aprobar"], $rows);
		echo view('template/header');
		echo view('template/nav_bar');
		echo view('catalog/ver_solicitud', $tpldata);
		echo view('template/footer');
		echo view('catalog/footer');
	}

	//Metodo para añadir nueva orden ya aprobada

	public function nuevaOrden()
	{
		$model = new Solicitudes_model();
		$dataBatch = array();
		if ($this->request->isAJAX() && $this->session->get('logged')) {
			$datos = json_decode(utf8_encode(base64_decode($this->request->getPost('data'))), TRUE);
			//Verificar que los detalles de las ordenes esten completos
			if (empty($datos["items"])) {
				return $this->respond(["message" => "Esta orden no posee ningun item a aprobar"], 202);
			} else {
				//Armar los datos para insertarlos en la BD
				//Armando para generar la solicitud
				$newOrden = array(
					'numorden' => $datos['numorden'],
					'fecaprob' => date('Y-m-d'),
					'statusid' => 2,
					'usuaprob' => $this->session->get('userid'),
					'ususol'   => $datos['ususol']
				);

				$query = $model->newOrden($newOrden);
				if ($query) {
					//Cambiamos el status de la preorden a aprobado para que no nos salga mas
					$model->cambiarStatusPreorden($datos['numorden'], "2");
					foreach ($datos["items"] as $row) {
						$itemData = $model->findItemPreorden($row['itemid']);
						if ($itemData->resultID->num_rows > 0) {
							$dataItem = $itemData->getRowArray();
							//Armamos el batch para actualizar en una operacion
							$dataBatch[] = [
								"numorden" => $datos["numorden"],
								"codbar"   => $dataItem['codbar'],
								"numuniap" => $row["numuniap"],
							];
							//Descontamos del inventario
							$model->actualizaExistencias($dataItem['codbar'], $row['numuniap'], 2);
						}
					}
					//Insertamos el detalle de la orden
					$query = $model->insertarDetallesOrden($dataBatch);
					if ($query) {
						return $this->respond(['message' => 'success'], 200);
					} else {
						return $this->respond(["message" => 'error'], 500);
					}
				} else {
					return $this->respond(["message" => 'error'], 500);
				}
			}
		} else {
			return redirect()->to('/403');
		}
	}

	//Metodo que obtiene todas las ordenes para anularlas

	public function listaOrdenes()
	{
		if ($this->session->get('logged') && $this->session->get('usurol') == 1 || $this->session->get('usurol') == 2) {
			$model = new Solicitudes_model();
			$query = $model->obtenerAprobadas();
			$rows = array();
			if ($query->resultID->num_rows > 0) {
				foreach ($query->getResult() as $row) {
					if ($row->statusid == "2") {
						$rows[] = array(
							$row->numorden,
							$this->formatearFecha($row->fecaprob),
							utf8_decode($row->statusnom),
							'<a class="btn btn-sm btn-primary" href="/detalle-orden/' . $row->numorden . '">Detalles</a>'
						);
					}
				}
			} else {
				$rows[] = array('<td colspan="4" class="text-center">Esta solicitud no posee ningun registro</td>', "<td></td>", "<td></td>", "<td></td>");
			}

			$tbody = $this->generarTabla(array("N° de Orden", "Fecha de Aprobacion", "Estatus", "Acciones"), $rows);

			echo view('template/header');
			echo view('template/nav_bar');
			echo view('ordenes/lista_ordenes_anulables', array("table" => $tbody));
			echo view('template/footer');
			echo view('ordenes/footer');;
		} else {
			return redirect()->to('/403');
		}
	}

	//Metodo para el detalle de la orden a anular

	public function verDetalleOrden($id = NULL)
	{
		$model = new Solicitudes_model();
		$query = $model->comparaExistencia($id);
		$rows = array();
		$tpldata = array();
		//Validacion de usuario y login
		if ($this->session->get('logged') && $this->session->get('usurol') == 1 || $this->session->get('usurol') == 2) {
			//Si la orden tiene registros, se muestra
			if ($query->resultID->num_rows > 0) {
				foreach ($query->getResult() as $row) {
					//Validacion para setear el contador en la solicitud, si se dispone de inventario
					if (intval($row->numexis) > intval($row->numuni)) {
						$rows[] = array(utf8_decode($row->prodmar), utf8_decode($row->prodmodel), $row->numuni, '<input class="custom-range" data-prettify-enabled data-prettify-separator="." id="' . $row->detalleid . '" type="text" name="' . $row->detalleid . '" value="' . $row->numuni . '" data-type="single" data-min="0" data-max="' . $row->numexis . '" data-from="" data-to="' . $row->numexis . '" data-step="1" data-hasgrid="true">');
					}
					//De lo contrario, estará en cero
					else {
						$rows[] = array(utf8_decode($row->prodmar), utf8_decode($row->prodmodel), $row->numuni, '<input class="custom-range" data-prettify-enabled data-prettify-separator="." id="' . $row->detalleid . '" type="text" name="' . $row->detalleid . '" value="" data-type="single" data-min="0" data-max="' . $row->numexis . '" data-from="0" data-to="' . $row->numexis . '" data-step="1" data-hasgrid="true">');
					}
					//Arreglo con los datos a inyectar a la vista
					$tpldata['numorden'] = $row->numorden;
					// $tpldata['fecsol'] = $this->formatearFecha($row->fecsol);
					//$tpldata['usupnom'] = utf8_decode($row->usupnom);
					//$tpldata['usupape'] = utf8_decode($row->usupape);
					// $tpldata['userid']  = $row->userid;
					// $tpldata['depnom'] = utf8_decode($row->depnom);
					// $tpldata['dirnom'] = utf8_decode($row->dirnom);

					//Obtenemos ahora los datos del usuario
					$ususoldata = $model->datosPreorden($id);
					if ($ususoldata->resultID->num_rows > 0) {
						foreach ($ususoldata->getResult() as $row) {
							$tpldata['fecsol'] = $this->formatearFecha($row->fecsol);
							$tpldata['usupnom'] = utf8_decode($row->usupnom);
							$tpldata['usupape'] = utf8_decode($row->usupape);
							$tpldata['userid']  = $row->userid;
							$tpldata['depnom'] = $row->depnom;
							$tpldata['dirnom'] = $row->dirnom;
						}
					}
				}
			} else {
				$rows[] = array('<td colspan="3"> Sin Registros </td>');
			}
			//Generamos la tabla
			$tpldata["table"] = $this->generarTabla(array("Marca", "Modelo", "Cantidad Solicitada", "Cantidad a Aprobar"), $rows);

			//Generamos la vista
			echo view('template/header');
			echo view('template/nav_bar');
			echo view('ordenes/detalle-orden', $tpldata);
			echo view('template/footer');
			echo view('ordenes/footer');
		} else {
			return redirect()->to('/403');
		}
	}


	//Metodo para anular las ordenes
	public function anularOrden()
	{
		$model = new Solicitudes_model();
		if ($this->session->get('logged') && $this->request->isAJAX()) {
			$datos = json_decode(utf8_encode(base64_decode($this->request->getPost('data'))), TRUE);
			//Sumamos al inventario los items de la orden
			$query = $model->obtenerSalida($datos["numorden"], 2);
			if ($query->resultID->num_rows > 0) {
				foreach ($query->getResult() as $row) {
					$model->actualizaExistencias($row->codbar, $row->numuniap, 1);
				}
				//Eliminamos la orden
				$delete = $model->eliminarOrden($datos["numorden"]);
				//Si el borrado es exitoso
				if ($delete) {
					if ($model->cambiarStatusPreorden($datos["numorden"], 1)) {
						return $this->respond(["message" => "Solicitud anulada exitosamente"], 200);
					}
				} else {
					return $this->respond(["message" => "Error"], 500);
				}
			} else {
				return $this->respond(array("message" => "La solicitud no tiene ningun item"), 203);
			}
		} else {
			return redirect()->to('/403');
		}
	}

	//Metodo para actualizar la orden ya aprobada
	public function actualizarOrden()
	{
		$model = new Solicitudes_model();
		if ($this->session->get('logged') && $this->request->isAJAX()) {
			$datos = json_decode(utf8_encode(base64_decode($this->request->getPost('data'))), TRUE);
			//Sumamos al inventario los items de la orden
			$query = $model->obtenerSalida($datos["numorden"], 2);
			if ($query->resultID->num_rows > 0) {
				foreach ($query->getResult() as $row) {
					//Actualizamos las existencias
					$model->actualizaExistencias($row->codbar, $row->numuniap, 1);
				}
				//Eliminamos la orden
				$delete = $model->eliminarOrden($datos["numorden"]);
				//Si el borrado es exitoso
				if ($delete) {
					//Registramos la orden nuevamente con sus detalles
					//Armando arreglo para generar la solicitud
					$newOrden = array(
						'numorden' => $datos['numorden'],
						'fecaprob' => date('Y-m-d'),
						'statusid' => 2,
						'usuaprob' => $this->session->get('userid'),
						'ususol'   => $datos['ususol']
					);
					//Generamos la orden nuevamente
					$query = $model->newOrden($newOrden);
					if ($query) {
						foreach ($datos["items"] as $row) {
							$itemData = $model->findItemPreorden($row['itemid']);
							if ($itemData->resultID->num_rows > 0) {
								$dataItem = $itemData->getRowArray();
								//Armamos el batch para actualizar en una operacion
								$dataBatch[] = [
									"numorden" => $datos["numorden"],
									"codbar"   => $dataItem['codbar'],
									"numuniap" => $row["numuniap"],
								];
								//Descontamos del inventario
								$model->actualizaExistencias($dataItem['codbar'], $row['numuniap'], 2);
							}
						}
						//Insertamos el detalle de la orden
						$query = $model->insertarDetallesOrden($dataBatch);
						if ($query) {
							return $this->respond(['message' => 'success'], 200);
						} else {
							return $this->respond(["message" => 'error'], 500);
						}
					}
				} else {
					return $this->respond(["message" => "error"], 500);
				}
			}
		} else {
			return redirect()->to('/403');
		}
	}


	//Metodo para rechazar una orden
	public function rechazarOrden($id = NULL)
	{
		if ($this->session->get('logged') && $this->session->get('usurol') == 1 || $this->session->get('usurol') == 2) {
			$model = new Solicitudes_model();
			if ($model->cambiarStatusPreorden($id, 5)) {
				return redirect()->to('/listarequisiciones');
			}
		} else {
			return redirect()->to('/403');
		}
	}
}
