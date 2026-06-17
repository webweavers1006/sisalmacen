<?php

namespace App\Controllers;

use App\Models\Almacen_model;
use CodeIgniter\API\ResponseTrait;
use App\Models\Solicitudes_model;
use App\Models\Requerimientos_model;
use App\Models\Productos_model;
use App\Models\Direccion;
class Almacen extends BaseController
{

	use ResponseTrait;

	/*Metodo que carga una tabla con lo que contiene el almacen*/

	public function existencias()
	{
		if ($this->session->get('logged') && $this->session->get('usurol') == 1 || $this->session->get('usurol') == 2 || $this->session->get('usurol') == 3) {
			echo view('template/header');
			echo view('template/nav_bar');
			echo view('almacen/existencias/content');
			echo view('template/footer');
			echo view('almacen/existencias/footer');
		} else {
			return redirect()->to('/');
		}
	}



	//Metodo que obtiene todas existencias disponibles
	public function listar_existencias($id_categoria=null)
	{
		$model = new Almacen_model();
		$query = $model->obtenerExistencias($id_categoria);
		$existencias = [];
		if (!empty($query)) {
			foreach ($query as $row) {
				$existencia = [
					'prodmodel' => utf8_decode($row->prodmodel),
					'itemid' => $row->itemid,
					'numexis' => $row->numexis,
					'codbar' => $row->codbar,
					'prodmar' => utf8_decode($row->prodmar),
					'stock_minimo' => utf8_decode($row->stock_minimo),
				];
				$existencias[] = $existencia;
			}
		}
		return $this->response->setJSON($existencias);
	}

	public function getExistenciasConImagenes($id_categoria = null)
	{
		$model = new Almacen_model();
		$query = $model->obtenerExistenciasConImagen($id_categoria);
		$existencias = [];
		if (!empty($query)) {
			foreach ($query as $row) {
				$existencia = [
					'codbar' => $row->codbar,
					'prodmar' => utf8_decode($row->prodmar),
					'prodmodel' => utf8_decode($row->prodmodel),
					'itemid' => $row->itemid,
					'numexis' => $row->numexis,
					'stock_minimo' => utf8_decode($row->stock_minimo),
					'id_categoria' => $row->id_categoria,
					'cat_nombre' => utf8_decode($row->cat_nombre),
				];
				// Always provide imagen_base64: custom if exists, else default sin_img.png
				$default_img_path = WRITEPATH . '../public/documentos_productos/sin_img.png';
				$img_path = ($row->prodimg && $row->prodimg != 'sin_img.png') 
					? WRITEPATH . '../public/documentos_productos/' . $row->prodimg 
					: $default_img_path;
				
				if (file_exists($img_path)) {
					$imageData = base64_encode(file_get_contents($img_path));
					$mime = mime_content_type($img_path);
					$existencia['imagen_base64'] = 'data:' . $mime . ';base64,' . $imageData;
				}
				$existencias[] = $existencia;
			}
		}
		return $this->response->setJSON($existencias);
	}


		public function stock_minimo()
	{
		if ($this->session->get('logged') && $this->session->get('usurol') == 1 || $this->session->get('usurol') == 2 || $this->session->get('usurol') == 3) {
			echo view('template/header');
			echo view('template/nav_bar');
			echo view('almacen/stock_minimo/content');
			echo view('template/footer');
			echo view('almacen/stock_minimo/footer');
		} else {
			return redirect()->to('/');
		}
	}



//Metodo queo obtiene todas existencias disponibles
	public function listar_stock_minimo()
	{
		$model = new Almacen_model();
		$query = $model->obtenerExistencias_Stock_Minimo();
		$existencias = [];
		if (!empty($query)) {
			foreach ($query as $row) {
				$existencia = [
					//PARA PRUEBAS EN LOCAL POR EL DESCODE NO FUNCIONA
					
					// 'prodmodel' => $row->prodmodel,
					// 'itemid' => $row->itemid,
					// 'numexis' => $row->numexis,
					// 'codbar' => $row->codbar,
					// 'prodmar' => $row->prodmar,
					//'stock_minimo' => utf8_decode($row->stock_minimo),

					//PARA PRODUCCION
					'prodmodel' => utf8_decode($row->prodmodel),
					'itemid' => $row->itemid,
					'numexis' => $row->numexis,
					'codbar' => $row->codbar,
					'prodmar' => utf8_decode($row->prodmar),
					'stock_minimo' => utf8_decode($row->stock_minimo),
					//Agrega más valores según sea necesario
				];
				$existencias[] = $existencia;
			}
		}
		return $this->response->setJSON($existencias);
	}





	public function reporte_despachos()
	{
		if ($this->session->get('logged') && $this->session->get('usurol') == 1 || $this->session->get('usurol') == 2 || $this->session->get('usurol') == 3) {
			$direccion = new Direccion();
			
			$selectDefault = '<option value="0" selected>Todos</option>';
					$selectDireccion = "";
					$query = $direccion->get_all_data();
					if ($query->resultID->num_rows > 0) {
						$selectDireccion .= $selectDefault;
						foreach ($query->getResult() as $row) {
							$selectDireccion .= '<option value="' . $row->dirid . '">' . utf8_decode($row->dirnom) . '</option>';
						}
					} else {
						$selectDireccion = $selectDefault;
					}
					$tpldata = ["selectDireccion" => $selectDireccion];
			
			
			echo view('template/header');
			echo view('template/nav_bar');
			echo view('almacen/reporte_despachos/content',$tpldata);
			echo view('template/footer');
			echo view('almacen/reporte_despachos/footer');
		} else {
			return redirect()->to('/');
		}
	}

	

//Metodo queo obtiene todas existencias disponibles
public function listar_reporte_despachos($desde=null,$hasta=null,$direccion=null)
{

	
	$model = new Almacen_model();
	
	$query = $model->listar_reporte_despachos($desde,$hasta,$direccion);
	$despachos = [];
	if (!empty($query)) {
		foreach ($query as $row) {
			$existencia = [
				//PARA PRUEBAS EN LOCAL POR EL DESCODE NO FUNCIONA
				
				'numorden' => $row->numorden,
				'statusnom' => $row->statusnom,
				'direccion' => $row->dirnom,
				'ususol' => $row->nombre,
				'fecsal' => $row->fecsalidas,	
			];
			$despachos[] = $existencia;
		}
	}
	return $this->response->setJSON($despachos);
}
	





	//Metodo quee busca si un producto tiene exixtencias 
	public function buscar_producto_existencias($buscar_codbar = null)
	{
		$model = new Almacen_model();
		$query = $model->buscar_producto_existencias($buscar_codbar);
		if (empty($query)) {
			$existencias = [];
		} else {
			$existencias = $query;
		}
		echo json_encode($existencias);
	}


	// public function existencias()
	// {
	// 	if ($this->session->get('logged') && $this->session->get('usurol') == 1 || $this->session->get('usurol') == 2 || $this->session->get('usurol') == 3) {
	// 		$model = new Almacen_model();
	// 		$query = $model->obtenerExistencias();
	// 		$tbody = '';
	// 		if ($query->resultID->num_rows > 0) {
	// 			foreach ($query->getResult() as $row) {
	// 				if ($row->numexis > 0 && $row->numexis < 10) {
	// 					$tbody .= '<tr class="table-warning"><td>' . $row->itemid . '</td><td>' . utf8_decode($row->prodmar) . '</td><td>' . utf8_decode($row->prodmodel) . '</td><td>' . $row->numexis . '</td></tr>';
	// 				} else if ($row->numexis == 0) {
	// 					$tbody .= '<tr class="table-danger"><td>' . $row->itemid . '</td><td>' . utf8_decode($row->prodmar) . '</td><td>' . utf8_decode($row->prodmodel) . '</td><td>' . $row->numexis . '</td></tr>';
	// 				} else {
	// 					$tbody .= '<tr class="table-light"><td>' . $row->itemid . '</td><td>' . utf8_decode($row->prodmar) . '</td><td>' . utf8_decode($row->prodmodel) . '</td><td>' . $row->numexis . '</td></tr>';
	// 				}
	// 			}
	// 		} else {
	// 			$tbody .= '<tr class="table-light"><td colspan="4" class="text-center">Sin Registros</td>';
	// 		}
	// 		echo view('template/header');
	// 		echo view('template/nav_bar');
	// 		echo view('almacen/existencias/content', array('tbody' => $tbody));
	// 		echo view('template/footer');
	// 		echo view('almacen/existencias/footer');
	// 	} else {
	// 		return redirect()->to('/');
	// 	}
	// }


	/*Metodo que obtiene las salidas del almacen*/
	public function salidas()
	{
		if ($this->session->get('logged') && $this->session->get('usurol') == 1 || $this->session->get('usurol') == 2 || $this->session->get('usurol') == 3) {
			$model = new Almacen_model();
			$query = $model->obtenerSalidas();
			$heading = array("Nº de Registro", "Fecha de Salida", "Nº de Orden", "Destino", "Procesado por", "Acciones");
			$rows = array();
			if ($query->resultID->num_rows > 0) {
				foreach ($query->getResult() as $row) {
					$rows[] = array(
						$row->salidaid,
						$this->formatearFecha($row->fecsal),
						$row->numorden,
						utf8_decode($row->depnom),
						utf8_decode($row->usupnom) . ' ' . utf8_decode($row->usupape),
						'<a href="/detalledespacho/' . $row->numorden . '">Detalles</a>'
					);
				}
			} else {
				$rows[] = array('<td colspan="6" class="text-center">Sin Registros</td>', " ", " ", " ", " ", " ");
			}
			echo view('template/header');
			echo view('template/nav_bar');
			echo view('almacen/salidas/content', array('tbody' => $this->generarTabla($heading, $rows)));
			echo view('template/footer');
			echo view('almacen/existencias/footer');
		} else {
			return redirect()->to('/');
		}
	}

	/*Metodo que obtiene las entradas del almacen*/
	public function entradas()
	{
		if ($this->session->get('logged') && $this->session->get('usurol') == 1 || $this->session->get('usurol') == 3) {
			$model = new Almacen_model();
			$query = $model->obtenerEntradas();
			$tbody = '';
			if ($query->resultID->num_rows > 0) {
				foreach ($query->getResult() as $row) {
					$tbody .= '
					<tr>
					<td>' . $row->numregent . '</td>
					<td>' . $row->numfac . '</td>
					<td>' . utf8_decode($row->nomprov) . '</a></td>
					<td>' . $this->formatearFecha($row->fecfac) . '</td>
					<td>' . $this->formatearFecha($row->fecent) . '</td>
					<td>' . utf8_decode($row->usupnom) . ' ' . utf8_decode($row->usupape) . '</td>
					<td>' . $row->entcoment . '</td>
					<td class="p-3">
            <a href="/detalleent/' . $row->numregent . '" class="inline-flex items-center justify-center w-10 h-10 bg-[#007bff] hover:bg-[#0056b3] rounded-full shadow-md hover:shadow-lg transition-all duration-200 text-white" title="Ver detalles">
              <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
              </svg>
            </a>
          </td>
					</tr>';
				}
			} else {
				$tbody .= '<tr class="table-light"><td colspan="7" class="text-center">Sin Registros</td>';
			}
			echo view('template/header');
			echo view('template/nav_bar');
			echo view('almacen/entradas/content', array('tbody' => $tbody));
			echo view('template/footer');
			echo view('almacen/entradas/footer');
		} else {
			return redirect()->to('/');
		}
	}

	/*Metodo que refresca la tabla en las existencias*/

	public function refrescarTabla()
	{
		if (
			$this->request->isAJAX() && $this->session->get('logged') && $this->session->get('usurol') == 1
			|| $this->session->get('usurol') == 3
		) {
			$model = new Almacen_model();
			$query = $model->obtenerExistencias();
			$tbody = '';
			if ($query->resultID->num_rows > 0) {
				foreach ($query->getResult() as $row) {
					if ($row->numexis > 5 && $row->numexis < 10) {
						$tbody .= '<tr class="table-warning"><td>' . $row->itemid . '</td><td>' . utf8_decode($row->prodmodel) . '</td><td>' . $row->numexis . '</td></tr>';
					} else if ($row->numexis < 5) {
						$tbody .= '<tr class="table-danger"><td>' . $row->itemid . '</td><td>' . utf8_decode($row->prodmodel) . '</td><td>' . $row->numexis . '</td></tr>';
					} else {
						$tbody .= '<tr class="table-light"><td>' . $row->itemid . '</td><td>' . utf8_decode($row->prodmodel) . '</td><td>' . $row->numexis . '</td></tr>';
					}
				}
			} else {
				$tbody .= '<tr class="table-light"><td colspan="4" class="text-center">Sin Registros</td>';
			}
			return $this->respond(json_encode(array('message' => 'Ejecutado exitosamente', 'tbody' => $tbody)), 200);
		} else {
			return redirect()->to('/');
		}
	}

	/*Metodo que carga la vista para registrar una entrada al almacen*/
	public function registrarEntrada()
	{
		if ($this->session->get('logged') && $this->session->get('usurol') == 1 || $this->session->get('usurol') == 3) {
			$tpldata["tbody"] = $this->cargarExistencias();
			echo view('template/header');
			echo view('template/nav_bar');
			echo view('almacen/entradas/registrar_entrada', $tpldata);
			echo view('template/footer');
			echo view('almacen/entradas/footer');
		} else {
			return redirect()->to('/');
		}
	}
	//Metodo para listar los despachos
	public function despachos()
	{
		$model = new Solicitudes_model();
		if ($this->session->get('logged') && $this->session->get('usurol') == 1 || $this->session->get('usurol') == 3) {
			//Obtenemos las solicitudes aprobadas
			$query = $model->obtenerAprobadas();
			$rows = array();
			$heading = array("N° de orden", "Fecha de aprobacion", "Usuario Solicitante", "Estatus", "Acciones");
			if ($query->resultID->num_rows > 0) {
				foreach ($query->getResult() as $row) {
					if (intval($row->numorden) < 1000000) {
						if ($row->statusid == '2') {
							$rows[] = array(
								$row->numorden,
								$this->formatearFecha($row->fecaprob),
								$row->usupnom . ' ' . $row->usupape,
								$row->statusnom,
								'<a href="/verdespacho/' . $row->numorden . '">Detalles</a>'
							);
						} else {
							$rows[] = array(
								$row->numorden,
								$this->formatearFecha($row->fecaprob),
								$row->usupnom . ' ' . $row->usupape,
								$row->statusnom,
								'<a href="/detalledespacho/' . $row->numorden . '">Detalles</a>'
							);
						}
					}
				}
			} else {
				$rows[] = array('<td colspan="4" class="text-center">Sin Registros</td>', " ", " ", " ");
			}
			//Obtenemos los requerimientos a cargar
			$req_model = new Requerimientos_model();
			$tabla = array();
			$tabheading = array("N° Requerimiento", "Usuario Solicitante", "Fecha de Solicitud", "Fecha de Aprobacion", "Acciones");
			$tabrows = array();
			$lstReq = $req_model->getAllReqAp();
			if ($lstReq->resultID->num_rows > 0) {
				foreach ($lstReq->getResult() as $row) {
					if ($row->statussol == '2') {
						$tabrows[] = array($row->reqid, utf8_decode($row->usupnom) . " " . utf8_decode($row->usupape), $this->formatearFecha($row->fechasol), $this->formatearFecha($row->fecapsol), '<a href="/despachareq/' . $row->reqid . '">Detalles</a>');
					} else {
						$tabrows[] = array($row->reqid, utf8_decode($row->usupnom) . " " . utf8_decode($row->usupape), $this->formatearFecha($row->fechasol), $this->formatearFecha($row->fecapsol), '<a href="/verdespachoreq/' . $row->reqid . '">Detalles</a>');
					}
				}
			} else {
				$tabrows[] = array('<td colspan="5">Sin Registros</td>');
			}
			echo view('template/header');
			echo view('template/nav_bar');
			echo view('almacen/salidas/lista_salidas', array('tbody' => $this->generarTabla($heading, $rows), "tbody2" => $this->generarTabla($tabheading, $tabrows)));
			echo view('template/footer');
			echo view('almacen/salidas/footer');
		} else {
			return redirect()->to('/');
		}
	}

	/*Metodo que registra una nueva entrada al almacen*/
	public function newEntrada()
	{
		if ($this->request->isAJAX() && $this->session->get('logged')) {
			$data = array();
			$datos = json_decode(utf8_encode(base64_decode($this->request->getPost('data'))), TRUE);
			$model = new Almacen_model();
			$datos['usuregent'] = $this->session->get('userid');
			$datos['numregent'] = intval($model->getLastID()) + 1;
			$query = $model->registrarEntrada($datos);
			if ($query) {
				return $this->respond(array('message' => 'success', 'num_op' => $datos['numregent']), 200);
			} else {
				return $this->respond(array('message' => 'error'), 500);
			}
		} else {
			return redirect()->to('/403');
		}
	}
	/*Metodo para registrar un detalle de la entrada*/
	public function addDetalle()
	{
		if ($this->request->isAJAX() && $this->session->get('logged')) {
			$datos = json_decode(utf8_encode(base64_decode($this->request->getPost('data'))), TRUE);
			$model = new Almacen_model();
			$query = $model->registrarDetalle($datos);
			if ($query) {
				return $this->respond(array('message' => 'success'), 200);
			} else {
				return $this->respond(array('message' => 'error'), 500);
			}
		} else {
			return redirect()->to('/403');
		}
	}

	/*Metodo para obtener los detalles de la entrada*/
	public function detalleEntrada($id = NULL)
	{

		$model = new Almacen_model();
		$tpldata = array();
		$tbody = '';
		if ($this->session->get('logged')) {
			$detalles = $model->getDetalles($id);
			if ($detalles->resultID->num_rows > 0) {
				foreach ($detalles->getResult() as $row) {
					$tbody .= '<tr>
					<td>' . utf8_encode($row->prodmodel) . '</td>
					<td>' . utf8_encode($row->prodpresent) . '</td>
					<td>' . $row->numunid . '</td>
					<td>' . $row->costuni . '</td>
					</tr>';
				}
			} else {
				$tbody .= '<tr><td colspan="5">Sin Registros<td></tr>';
			}
			$tpldata['tbody'] = $tbody;
			$detFactura = $model->getDetalleEntrada($id);
			if ($detFactura->resultID->num_rows > 0) {
				foreach ($detFactura->getResult() as $row) {
					$tpldata['numregent']  = $row->numregent;
					$tpldata['numfac']     = $row->numfac;
					$tpldata['numrif']     = $row->numrif;
					$tpldata['provnom']    = $row->nomprov;
					$tpldata['fecfac']     = $this->formatearFecha($row->fecfac);
					$tpldata['fechent']     = $this->formatearFecha($row->fecent);
					$tpldata['provdir'] = $row->direccprov;
					$tpldata['provtel1']     = $row->telef1;
					$tpldata['provtel2']     = $row->telef2;
					$tpldata['provemail']      = $row->email;
					$tpldata['usupnom']    = $row->usupnom;
$tpldata['usupape']    = $row->usupape;
					$tpldata['entcoment'] = $row->entcoment ?? '';
				}
			} else {
				return redirect()->to('/404');
			}

			echo view('template/header');
			echo view('template/nav_bar');
			echo view('almacen/entradas/detalle_entrada', $tpldata);
			echo view('template/footer');
			echo view('almacen/entradas/footer');
		} else {
			return redirect()->to('/');
		}
	}

	//Metodo que refresca la pagina de el detalle del almacen

	public function obtenerDetalles()
	{
		if ($this->request->isAJAX() && $this->session->get('logged')) {
			$datos = json_decode(utf8_encode(base64_decode($this->request->getPost('data'))), TRUE);
			$model = new Almacen_model();
			$query = $model->getDetalles($datos['numregent']);
			$rows[] = array();
			$headings = array("Código de barras", "Descripcion", "Presentacion", "Costo Unitario", "N° de Unidades");
			if ($query->resultID->num_rows > 0) {
				foreach ($query->getResult() as $row) {
					$rows[] = array(
						trim(utf8_decode($row->codbar)),
						trim(utf8_decode($row->prodmodel)),
						trim(utf8_decode($row->prodpresent)),
						'Bs ' . $row->costuni,
						$row->numunid
					);
				}
			} else {
				$rows[] = array('<td colspan="5" class="text-center">Sin Registros</td>', "", "", "", "");
			}
			return $this->respond(array('message' => 'success', 'data' => $this->generarTabla($headings, $rows)), 200);
		} else {
			return redirect()->to('/');
		}
	}
	//Metodo para cargar la solicitud de despachos

	public function verDespacho($id = NULL)
	{
		$model = new Solicitudes_model();
		$almacenModel = new Almacen_model();
		$tpldata = array();
		$rows = array();
		$headings = array("Descripcion", "Unidades Solicitadas", "Unidades Aprobadas", "Presentacion");
		if ($this->session->get('logged') and $this->session->get('usurol') == 1 or $this->session->get('usurol') == 3) {
			$query = $model->obtenerSalida($id, "2");
			if ($query->resultID->num_rows > 0) {
				foreach ($query->getResult() as $row) {
					$rows[] = array(utf8_decode($row->prodmodel), $almacenModel->obtenerUnidadesSolicitadas($row->numorden, $row->codbar), $row->numuniap, ucwords($almacenModel->obtenerPresentacionProd($row->codbar)));
					$tpldata['deptid'] = $row->deptid;
					$tpldata['usupnom'] = utf8_decode($row->usupnom);
					$tpldata['usupape'] = utf8_decode($row->usupape);
					$tpldata['depnom'] = utf8_decode($row->depnom);
					$tpldata['dirnom'] = utf8_decode($row->dirnom);
					$tpldata['fecaprob'] = $this->formatearFecha($row->fecaprob);
					$tpldata['fecsol'] = $this->formatearFecha($row->fecsol);
					$tpldata['comentario'] = $row->comentario;
				}
			} else {
				return redirect()->to('/404');
			}
			//Se setean los valores para el comprobante
			$tpldata["numorden"] = $id;
			$tpldata["fecsal"] = 'Aún sin despachar';
			$tpldata["commsal"] = 'Aún sin despachar';
			$tpldata["datos"] = $id;
			$tpldata["status"] = "2";
			$tpldata['comentario'] = $row->comentario;
			$tpldata['tbody'] = $this->generarTabla($headings, $rows);
			echo view('template/header');
			echo view('template/nav_bar');
			echo view('almacen/salidas/ver_despacho', $tpldata);
			echo view('template/footer');
			echo view('almacen/salidas/footer');
		} else if ($this->session->get('usurol') == 2) {
			$query = $model->obtenerSalida($id, "2");
			if ($query->resultID->num_rows > 0) {
				foreach ($query->getResult() as $row) {
					$rows[] = array(utf8_decode($row->prodmodel), $row->numuniap, ucwords($row->prodpresent));
					$tpldata['deptid'] = $row->deptid;
					$tpldata['usupnom'] = utf8_decode($row->usupnom);
					$tpldata['usupape'] = utf8_decode($row->usupape);
					$tpldata['depnom'] = utf8_decode($row->depnom);
					$tpldata['dirnom'] = utf8_decode($row->dirnom);
					$tpldata['fecaprob'] = $this->formatearFecha($row->fecaprob);
					$tpldata['fecsol'] = $this->formatearFecha($row->fecsol);
				}
			} else {
				$rows[] = array('<td colspan="3">Sin Registros</td>', '', '');
			}
			//Se setean los valores para el comprobante
			$tpldata["numorden"] = $id;
			$tpldata["fecsal"] = 'Aún sin despachar';
			$tpldata["commsal"] = 'Aún sin despachar';
			$tpldata["datos"] = $id;
			$tpldata["status"] = "2";
			$tpldata['comentario'] = $row->comentario;
			$tpldata['tbody'] = $this->generarTabla($headings, $rows);
			var_dump($tpldata);
			die();
			echo view('template/header');
			echo view('template/nav_bar');
			echo view('almacen/salidas/ver_despacho_admin', $tpldata);
			echo view('template/footer');
			echo view('almacen/salidas/footer');
		} else {
			return redirect()->to('/403');
		}
	}

	//Metodo para registrar la salida del almacen por despacho

	public function registrarSalida()
	{
		$model = new Almacen_model();
		if ($this->request->isAJAX() && $this->session->get('logged')) {
			$datos = json_decode(utf8_encode(base64_decode($this->request->getPost('data'))), TRUE);
			//Añadimos los datos faltantes para armar el query
			$datos['usureg']   = $this->session->get('userid');
			$datos["fecsal"]   = date("Y-m-d");
			//Insertamos la salida
			$model->nuevoDespacho($datos);
			//cambiamos el estatus de la orden
			unset($model);
			$model = new Solicitudes_model();
			//Cambiamos el estatus de la preorden para que salga en el dashboard
			$model->cambiarStatusPreorden($datos["numorden"], 3);
			//Cambiamos el estatus de la orden
			$query = $model->cambiarStatusOrden($datos["numorden"], 3);
			if ($query) {
				return $this->respond(array("message" => "Despacho registrado exitosamente"), 200);
			} else {
				return $this->respond(array("message" => "Error en la insercion"), 500);
			}
		} else {
			return redirect()->to('/403');
		}
	}

	//Metodo para ver el detalle del despacho

	public function detalleDespacho($id = NULL)
	{
		$model = new Solicitudes_model();
		$almacenModel = new Almacen_model();
		$tpldata = array();
		$rows = array();
		$headings = array("Descripcion", "Unidades Solicitadas", "Unidades Aprobadas", "Presentacion");
		if ($this->session->get('logged') && $id != NULL) {
			$query = $model->obtenerSalida($id, "3");
			if ($query->resultID->num_rows > 0) {
				foreach ($query->getResult() as $row) {
					$rows[] = array(utf8_decode($row->prodmodel), $almacenModel->obtenerUnidadesSolicitadas($row->numorden, $row->codbar), $row->numuniap, ucwords($almacenModel->obtenerPresentacionProd($row->codbar)));
					$tpldata["fecsal"] = $this->formatearFecha($row->fecsal);
					$tpldata["salidaid"] = $row->salidaid;
					$tpldata['commsal'] = urldecode($row->commsal);
					$tpldata['numorden'] = $row->numorden;
					$tpldata['deptid'] = $row->deptid;
					$tpldata['usupnom'] = $row->usupnom;
					$tpldata['usupape'] = $row->usupape;
					$tpldata['depnom'] = $row->depnom;
					$tpldata['dirnom'] = $row->dirnom;
					$tpldata['fecaprob'] = $this->formatearFecha($row->fecaprob);
					$tpldata['fecsol'] = $this->formatearFecha($row->fecsol);
					$tpldata['comentario'] = urldecode($row->comentario);
				}
				$tpldata["tbody"] = $this->generarTabla($headings, $rows);
				$tpldata["datos"] = $id;
				$tpldata["status"] = "3";
				echo view('template/header');
				echo view('template/nav_bar');
				echo view('almacen/salidas/detalle_despacho', $tpldata);
				echo view('template/footer');
				echo view('almacen/salidas/footer');
			} else {
				return redirect()->to('/404');
			}
		} else {
			return redirect()->to('/403');
		}
	}

	//Metodo para cargar una tabla con las existencias
	public function cargarExistencias()
	{
		$model = new Almacen_model();
		$query = $model->obtenerExistencias();
		$rows = array();
		$headings = array("Código Barras", "Marca", "Descripcion", "Numero de unidades", "Acciones");

		if (empty($query)) {
			$rows[] = array('<td colspan="5"> Sin Registros</td>', '<td></td>', '<td></td>', '<td></td>', '<td></td>');
		} else {
			foreach ($query as $row) {
				$rows[] = array($row->codbar, utf8_decode($row->prodmar), utf8_decode($row->prodmodel), $row->numexis, '<button id="' . $row->codbar . '" class="btn btn-sm btn-primary actualizar"><i class="fas fa-plus"></i> Añadir</button>');
			}
		}

		$table = $this->generarTabla($headings, $rows);
		return $table;
	}

	//Metodo para actualizar el catalogo
	public function actualizarCatalogo()
	{
		if ($this->session->get('logged') && $this->request->isAJAX()) {
			$catalog = $this->cargarExistencias();
			return $this->respond(array("message" => "success", "data" => $catalog));
		} else {
			return redirect()->to('/403');
		}
	}

	//Metodo para ver la solicitud de despacho del requerimiento
	public function verSolDesReq($id = NULL)
	{
		$model = new Requerimientos_model();
		$tpldata = array();
		$rows = array();
		$heading = array(" ", "Marca", "Descripcion del Producto", "Unidades Aprobadas", "Codigo de Barras");
		if ($this->session->get('logged') && $this->session->get('usurol') == 1 || $this->session->get('usurol') == 3) {
			//Obtenemos los detalles del solicitante
			$datSol = $model->getDetailsByID('2', $id);
			if ($datSol->resultID->num_rows > 0) {
				foreach ($datSol->getResult() as $row) {
					$tpldata["fechasol"] = $this->formatearFecha($row->fechasol);
					$tpldata["fecapsol"] = $this->formatearFecha($row->fecapsol);
					$tpldata["usupnom"]  = utf8_decode($row->usupnom);
					$tpldata["usupape"]  = utf8_decode($row->usupape);
					$tpldata["dirnom"]   = utf8_decode($row->dirnom);
					$tpldata["depnom"]   = utf8_decode($row->depnom);
					$tpldata["reqid"]    = $row->reqid;
					$tpldata["ususol"]   = $row->ususol;
				}
				//Obtenemos los detalles de la solicitud
				$detSol = $model->getDetailReq($id);
				if ($detSol->resultID->num_rows > 0) {
					foreach ($detSol->getResult() as $row) {
						$rows[] = array(
							'<img style="max-height:4rem;" src="' . base_url() . '/img/' . $row->detimgref . '">',
							utf8_decode($row->detmar),
							utf8_decode($row->detmod),
							$row->detnumuniap,
							'<input class="form-control codbar" type="text" id="' . $row->detid . '" name="' . $row->detid . '">',
						);
					}
				} else {
					$rows[] = array('<td colspan="4">Esta solicitud no tiene registros</td>');
				}
				$tpldata["tbody"] = $this->generarTablaReporte($heading, $rows);
				//Generamos el comentario para la entrada de los productos
				$tpldata["entcomment"] = "Entrada al almacen para el requerimiento N° " . $tpldata["reqid"] . " de fecha " . $tpldata["fechasol"];
				//Usuario que va a registrar la entrada
				$tpldata["usureg"] = $this->session->get('userid');
				//inyectamos los datos en la vista
				echo view('template/header');
				echo view('template/nav_bar');
				echo view('requerimientos/despacho_requerimiento', $tpldata);
				echo view('template/footer');
				echo view('requerimientos/footer');
			} else {
				return redirect()->to('/404');
			}
		} else {
			return redirect()->to('/403');
		}
	}
	//Metodo para registrar el despacho del requerimiento
	public function registrarDespacho()
	{
		$model = new Almacen_model();
		$req_model = new Requerimientos_model();
		$prod_model = new Productos_model();
		$sol_model = new Solicitudes_model();
		//Armamos el arreglo para introducir los detalles de la orden
		$det_ord_sal = array();
		if ($this->session->get('logged') && $this->request->isAJAX() && $this->session->get('usurol') == 1 || $this->session->get('usurol') == 3) {
			$datos = json_decode(utf8_encode(base64_decode($this->request->getPost('data'))), TRUE);
			//Registramos los productos asociados al requerimiento en la tabla de productos
			foreach ($datos["items"] as $row) {
				//Consultamos los detalles de marca y descripcion en la tabla de detalles del requerimiento
				$det_prod = $req_model->getDetailReqByID($row["itemid"]);
				//Consultamos si el producto esta registrado previamente
				if (!$prod_model->isProductExists($row["codbar"])) {
					//Si no lo esta, lo registramos
					$q1 = $prod_model->newProd(
						[
							"codbar" => $row["codbar"],
							"prodmar" => utf8_encode($det_prod["detmar"]),
							"prodmodel" => utf8_encode($det_prod["detmod"])
						]
					);
				}
				//Poblamos el arreglo para el detalle de las salidas
				$det_ord_sal[] = array(
					"numorden"    => 100000000 + intval($datos["reqid"]),
					"codbar"      => $row["codbar"],
					"numuniap"    => intval($det_prod["detnumunisol"])
				);
				//Registramos el detalle en la tabla de las entradas
				$q2 = $model->registrarDetalle([
					"regent"      => $datos["numregent"],
					"prodpresent" => $row["prodpresent"],
					"numunid"     => $det_prod["detnumunisol"],
					"costuni"     => $row["costuni"],
					"codbar"      => $row["codbar"]
				]);
			}
			//Registramos la orden de salida
			$detalleReq = $req_model->getDetailsByID('2', $datos["reqid"])->getRowArray();
			$q3 = $sol_model->newOrden([
				//Al numero de orden le sumamos cien millones para diferenciarlos de las requisiciones 
				"numorden" => 100000000 + intval($datos["reqid"]),
				"fecaprob" => $detalleReq ? $detalleReq["fecapsol"] : null,
				"statusid" => 3,
				"usuaprob" => $this->session->get('userid'),
				"ususol"   => $detalleReq ? $detalleReq["ususol"] : null
			]);
			//Insertamos los detalles
			$q4 = $sol_model->insertarDetallesOrden($det_ord_sal);
			//Despues de lo anterior, podremos ahora si, cargar el despacho
			$q5 = $model->nuevoDespacho([
				"fecsal"   => date('Y-m-d'),
				"numorden" => 100000000 + intval($datos["reqid"]),
				"depdest"  => $detalleReq ? $detalleReq["depsol"] : null,
				"usureg"   => $this->session->get('userid'),
				"commsal"  => $datos["commsal"]
			]);
			//Recorremos nuevamente el arreglo para actualizar las existencias
			$q = '';
			foreach ($datos["items"] as $row) {
				$det = $req_model->getDetailReqByID($row["itemid"]);
				$q = $model->actualizaExistencias($row["codbar"], $det ? intval($det["detnumunisol"]) : 0, 2);
			}
			//Si todo esta bien, le cambiamos el estatus a despachado al requerimiento
			if ($q && $req_model->changeStatus("2", "3", $datos["reqid"])) {
				return $this->respond(["message" => "Despacho cargado exitosamente"], 200);
			} else {
				return $this->respond(["message" => "error en la insercion"], 500);
			}
		}
	}

	/*Metodo que muestra la vista para importar entradas desde Excel*/
	public function importarEntradas()
	{
		if ($this->session->get('logged') && $this->session->get('usurol') == 1 || $this->session->get('usurol') == 3) {
			echo view('template/header');
			echo view('template/nav_bar');
			echo view('almacen/entradas/importar_entradas');
			echo view('template/footer');
		} else {
			return redirect()->to('/');
		}
	}

	/*Metodo que procesa el archivo Excel y registra las entradas masivamente*/
	public function procesarExcel()
	{
		if (!$this->session->get('logged') || ($this->session->get('usurol') != 1 && $this->session->get('usurol') != 3)) {
			return $this->respond(['status' => 'error', 'message' => 'Acceso no autorizado'], 403);
		}

		$file = $this->request->getFile('archivoExcel');
		if (!$file || !$file->isValid()) {
			return $this->respond(['status' => 'error', 'message' => 'No se recibió ningún archivo o el archivo es inválido.'], 400);
		}

		$ext = strtolower($file->getClientExtension());
		if (!in_array($ext, ['xlsx', 'xls'])) {
			return $this->respond(['status' => 'error', 'message' => 'Solo se permiten archivos .xlsx o .xls'], 400);
		}

		try {
			$filePath = $file->getTempName();

			// Detectar tipo de archivo y cargar con la librería adecuada
			if ($ext === 'xlsx') {
				$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
			} else {
				$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
			}

			$spreadsheet = $reader->load($filePath);
			$worksheet = $spreadsheet->getActiveSheet();
			$rows = $worksheet->toArray();

			if (count($rows) < 2) {
				return $this->respond(['status' => 'error', 'message' => 'El archivo Excel está vacío o solo tiene encabezados.'], 400);
			}

			// La primera fila son los encabezados
			$headers = array_map('trim', array_map('strtolower', $rows[0]));

			// Mapear índices de columnas
			$colMap = [];
			$requiredCols = ['numfac', 'fecfac', 'fecent', 'provid', 'codbar', 'numunid', 'costuni', 'prodpresent'];
			foreach ($requiredCols as $col) {
				$index = array_search($col, $headers);
				if ($index === false) {
					return $this->respond(['status' => 'error', 'message' => "Falta la columna requerida: '$col' en el archivo Excel."], 400);
				}
				$colMap[$col] = $index;
			}
			// Columnas opcionales
			$colMap['entcoment']   = array_search('entcoment', $headers);
			$colMap['prodmar']     = array_search('prodmar', $headers);
			$colMap['prodmodel']   = array_search('prodmodel', $headers);
			$colMap['id_categoria'] = array_search('id_categoria', $headers);

			$model = new Almacen_model();
			$prodModel = new Productos_model();
			$userId = $this->session->get('userid');
			$entradasCreadas = 0;
			$detallesCreados = 0;
			$productosNuevos = 0;
			$errores = 0;
			$erroresDetalle = '';
			$productosExistentes = [];

			// Agrupar filas por número de factura
			$grupos = [];
			for ($i = 1; $i < count($rows); $i++) {
				$row = $rows[$i];
				$numfac = trim((string)($row[$colMap['numfac']] ?? ''));
				if (empty($numfac)) {
					$errores++;
					$erroresDetalle .= "Fila " . ($i + 1) . ": número de factura vacío.\n";
					continue;
				}
				$grupos[$numfac][] = ['row' => $row, 'line' => $i + 1];
			}

			// Cache de productos existentes para evitar consultas repetidas
			$productosExistentes = [];

			// Procesar cada grupo (cada factura = una entrada)
			foreach ($grupos as $numfac => $items) {
				$firstRow = $items[0]['row'];

				// Validar y parsear fechas
				$fecfacRaw = trim((string)($firstRow[$colMap['fecfac']] ?? ''));
				$fecentRaw = trim((string)($firstRow[$colMap['fecent']] ?? ''));
				$providRaw = trim((string)($firstRow[$colMap['provid']] ?? ''));
				$entcomentRaw = $colMap['entcoment'] !== false ? trim((string)($firstRow[$colMap['entcoment']] ?? '')) : '';

				$fecfac = $this->parseFecha($fecfacRaw);
				$fecent = $this->parseFecha($fecentRaw);

				if (!$fecfac || !$fecent) {
					$errores++;
					$erroresDetalle .= "Factura '$numfac': formato de fecha inválido (use YYYY-MM-DD o DD/MM/YYYY).\n";
					continue;
				}

				if (empty($providRaw) || !is_numeric($providRaw)) {
					$errores++;
					$erroresDetalle .= "Factura '$numfac': ID de proveedor inválido.\n";
					continue;
				}

				// Calcular siguiente ID de entrada
				$numregent = intval($model->getLastID()) + 1;

				// Registrar la entrada
				$entradaData = [
					'numregent' => $numregent,
					'numfac'    => $numfac,
					'provid'    => intval($providRaw),
					'fecfac'    => $fecfac,
					'fecent'    => $fecent,
					'usuregent' => $userId,
					'entcoment' => $entcomentRaw,
				];

				$resultEntrada = $model->registrarEntrada($entradaData);
				if (!$resultEntrada) {
					$errores++;
					$erroresDetalle .= "Factura '$numfac': error al registrar la entrada.\n";
					continue;
				}
				$entradasCreadas++;

				// Registrar cada detalle
				foreach ($items as $item) {
					$row = $item['row'];
					$codbarRaw = trim((string)($row[$colMap['codbar']] ?? ''));
					$numunidRaw = trim((string)($row[$colMap['numunid']] ?? ''));
					$costuniRaw = trim((string)($row[$colMap['costuni']] ?? ''));
					$prodpresentRaw = trim((string)($row[$colMap['prodpresent']] ?? ''));

					if (empty($codbarRaw) || empty($numunidRaw) || empty($prodpresentRaw)) {
						$errores++;
						$erroresDetalle .= "Factura '$numfac', fila " . $item['line'] . ": datos de producto incompletos.\n";
						continue;
					}

					if (!is_numeric($numunidRaw) || intval($numunidRaw) <= 0) {
						$errores++;
						$erroresDetalle .= "Factura '$numfac', fila " . $item['line'] . ": cantidad inválida '$numunidRaw'.\n";
						continue;
					}

					// ===== CREACIÓN DINÁMICA DE PRODUCTO SI NO EXISTE =====
					if (!isset($productosExistentes[$codbarRaw])) {
						$productoExistente = $prodModel->findProductoByCodbar($codbarRaw);
						$productosExistentes[$codbarRaw] = $productoExistente;
					}

					if (!$productosExistentes[$codbarRaw]) {
						// Producto nuevo: crearlo con datos del Excel
						$prodmarRaw   = $colMap['prodmar'] !== false ? trim((string)($row[$colMap['prodmar']] ?? '')) : '';
						$prodmodelRaw = $colMap['prodmodel'] !== false ? trim((string)($row[$colMap['prodmodel']] ?? '')) : '';
						$catidRaw     = $colMap['id_categoria'] !== false ? trim((string)($row[$colMap['id_categoria']] ?? '')) : '1';

						if (empty($prodmarRaw)) $prodmarRaw = 'SIN MARCA';
						if (empty($prodmodelRaw)) $prodmodelRaw = 'SIN DESCRIPCION';
						if (empty($catidRaw) || !is_numeric($catidRaw)) $catidRaw = '1';

						$nuevoProd = [
							'codbar'       => $codbarRaw,
							'prodmar'      => $prodmarRaw,
							'prodmodel'    => $prodmodelRaw,
							'id_categoria' => intval($catidRaw),
							'borrado'      => 0,
						];

						$creado = $prodModel->newProd($nuevoProd);
						if ($creado) {
							$productosExistentes[$codbarRaw] = true;
							$productosNuevos++;
						} else {
							$errores++;
							$erroresDetalle .= "Factura '$numfac', fila " . $item['line'] . ": no se pudo crear el producto '$codbarRaw'.\n";
							continue;
						}
					}

					$detalleData = [
						'regent'      => $numregent,
						'codbar'      => $codbarRaw,
						'numunid'     => intval($numunidRaw),
						'costuni'     => is_numeric($costuniRaw) ? $costuniRaw : '0.00',
						'prodpresent' => $prodpresentRaw,
					];

					$resultDetalle = $model->registrarDetalle($detalleData);
					if ($resultDetalle) {
						$detallesCreados++;
					} else {
						$errores++;
						$erroresDetalle .= "Factura '$numfac', fila " . $item['line'] . ": error al registrar detalle.\n";
					}
				}
			}

			return $this->respond([
				'status'          => 'success',
				'entradas'        => $entradasCreadas,
				'detalles'        => $detallesCreados,
				'productos_nuevos' => $productosNuevos,
				'errores'         => $errores,
				'detalle_errores' => $erroresDetalle ?: '',
				'message'         => "Importación completada: $entradasCreadas entradas, $detallesCreados detalles, $productosNuevos productos nuevos, $errores errores."
			], 200);

		} catch (\Exception $e) {
			log_message('error', 'Error en procesarExcel: ' . $e->getMessage());
			return $this->respond(['status' => 'error', 'message' => 'Error al procesar el archivo: ' . $e->getMessage()], 500);
		}
	}

	/*Metodo que genera y descarga la plantilla Excel para importar*/
	public function descargarPlantilla()
	{
		if (!$this->session->get('logged')) {
			return redirect()->to('/');
		}

		$spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();

		// Encabezados
		$headers = ['numfac', 'fecfac', 'fecent', 'provid', 'entcoment', 'codbar', 'prodmar', 'prodmodel', 'id_categoria', 'numunid', 'costuni', 'prodpresent'];
		$col = 'A';
		foreach ($headers as $header) {
			$sheet->setCellValue($col . '1', $header);
			$sheet->getStyle($col . '1')->getFont()->setBold(true);
			$sheet->getStyle($col . '1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
				->getStartColor()->setARGB('FF3C4E5E');
			$sheet->getStyle($col . '1')->getFont()->getColor()->setARGB('FFFFFFFF');
			$col++;
		}

		// Ejemplo 1: producto existente (codbar 45) + producto nuevo (codbar NUEVO-001)
		$sheet->setCellValue('A2', 'FAC-001');
		$sheet->setCellValue('B2', '2026-06-17');
		$sheet->setCellValue('C2', '2026-06-17');
		$sheet->setCellValue('D2', '1');
		$sheet->setCellValue('E2', 'Compra de material de oficina');
		$sheet->setCellValue('F2', '45');
		$sheet->setCellValue('G2', '');
		$sheet->setCellValue('H2', '');
		$sheet->setCellValue('I2', '');
		$sheet->setCellValue('J2', '100');
		$sheet->setCellValue('K2', '15.50');
		$sheet->setCellValue('L2', 'unidad');

		// Ejemplo 2: mismo factura, otro producto (NUEVO)
		$sheet->setCellValue('A3', 'FAC-001');
		$sheet->setCellValue('B3', '2026-06-17');
		$sheet->setCellValue('C3', '2026-06-17');
		$sheet->setCellValue('D3', '1');
		$sheet->setCellValue('E3', 'Compra de material de oficina');
		$sheet->setCellValue('F3', 'NUEVO-001');
		$sheet->setCellValue('G3', 'Samsung');
		$sheet->setCellValue('H3', 'Monitor LED 24 pulgadas');
		$sheet->setCellValue('I3', '1');
		$sheet->setCellValue('J3', '50');
		$sheet->setCellValue('K3', '120.00');
		$sheet->setCellValue('L3', 'caja');

		// Auto-width
		foreach (range('A', 'L') as $col) {
			$sheet->getColumnDimension($col)->setAutoSize(true);
		}

		$writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);

		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment; filename="plantilla_entradas.xlsx"');
		header('Cache-Control: max-age=0');
		$writer->save('php://output');
		exit;
	}

	/**
	 * Parsea una fecha en formato YYYY-MM-DD o DD/MM/YYYY
	 */
	private function parseFecha($fecha)
	{
		$fecha = trim($fecha);
		if (empty($fecha)) return null;

		// Intentar YYYY-MM-DD
		if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $fecha)) {
			$parts = explode('-', $fecha);
			if (checkdate(intval($parts[1]), intval($parts[2]), intval($parts[0]))) {
				return $fecha;
			}
		}

		// Intentar DD/MM/YYYY
		if (preg_match('/^\d{1,2}\/\d{1,2}\/\d{4}$/', $fecha)) {
			$parts = explode('/', $fecha);
			if (checkdate(intval($parts[1]), intval($parts[0]), intval($parts[2]))) {
				return $parts[2] . '-' . str_pad($parts[1], 2, '0', STR_PAD_LEFT) . '-' . str_pad($parts[0], 2, '0', STR_PAD_LEFT);
			}
		}

		return null;
	}
}
