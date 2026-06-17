<?php

namespace App\Controllers;

require_once APPPATH . '/ThirdParty/dompdf/autoload.inc.php';
require_once APPPATH . '/ThirdParty/fpdf/fpdf.php';

use Dompdf\Dompdf;
use Dompdf\Options;
use App\Models\Solicitudes_model;
use App\Models\Almacen_model;
use CodeIgniter\API\ResponseTrait;
use App\Models\Requerimientos_model;
use App\Models\Usuarios_model;
use App\Models\Productos_model;
use App\Models\Proveedores_model;
use App\Models\Direccion;
use Fpdf;

class Reportes extends BaseController
{

	use ResponseTrait;
	//Metodo para cargar las vistas segun el tipo de reporte
	public function consultaReporte($id = NULL)
	{
		$usuarios = new Usuarios_model();
		$productos = new Productos_model();
		$proveedores = new Proveedores_model();
		$direccion = new Direccion();
		if ($this->session->get('logged')) {
			switch ($id) {
					//Vista para la generacion de reportes por Solicitud
				case 4:
					$selectDefault = '<option value="*" selected>Todos</option>';
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
					echo view("template/header");
					echo view("template/nav_bar");
					echo view("reportes/por_solicitud/content", $tpldata);
					echo view("template/footer");
					echo view("reportes/por_solicitud/footer");
					break;
					//Vista para la generacion de reportes de entradas y salidas
				case 6:
					$query = $usuarios->get_all();
					//Cargamos los Select para el filtrado
					$selectDefault = '<option value="*" selected>Todos</option>';
					$selectUsuarios = '';
					$selectProducto = '';
					$selectProveedor = '';
					//Cargamos las opciones para los usuarios
					if ($query) {
						$selectUsuarios .= $selectDefault;
						foreach ($query as $row) {
							$selectUsuarios .= '<option value="' . $row->userid . '">' . utf8_decode($row->usupnom) . ' ' . utf8_decode($row->usupape) . '</option>"';
						}
					} else {
						$selectUsuarios = $selectDefault;
					}
					//Cargamos las opciones de los productos
					unset($query);
					$query = $productos->getAllProd();
					if ($query->resultID->num_rows > 0) {
						$selectProducto .= $selectDefault;
						foreach ($query->getResult() as $row) {
							$selectProducto .= '<option value="' . $row->codbar . '">' . utf8_decode($row->prodmar) . ' - ' . utf8_decode($row->prodmodel) . '</option>';
						}
					} else {
						$selectProducto = $selectDefault;
					}
					//Cargamos las opciones de los proveedores
					unset($query);
					$query = $proveedores->getAll();
					if ($query->resultID->num_rows > 0) {
						$selectProveedor .= $selectDefault;
						foreach ($query->getResult() as $row) {
							$selectProveedor .= '<option value="' . $row->idprov . '">' . utf8_decode($row->nomprov) . '</option>';
						}
					} else {
						$selectProveedor = $selectDefault;
					}
					$tpldata = array(
						"selectUsuarios" => $selectUsuarios,
						"selectProveedor" => $selectProveedor,
						"selectProducto" => $selectProducto
					);
					echo view("template/header");
					echo view("template/nav_bar");
					echo view("reportes/entradas_salidas/entradas_salidas", $tpldata);
					echo view("template/footer");
					echo view("reportes/entradas_salidas/footer");
					break;
				default:
					return redirect()->to('/404');
					break;
			}
		} else {
			return redirect()->to("/403");
		}
	}
	public function generarReporte($id = NULL)
	{
		$solicitudes = new Solicitudes_model();
		$almacen = new Almacen_model();
		$requerimientos = new Requerimientos_model();
		if ($this->session->get('logged')) {
			switch ($id) {
				case 3:
					break;
					//Generacion de reportes de entradas y salidas por fecha
				case 6:
					$datos = json_decode(utf8_decode(base64_decode($this->request->getGet('q'))), TRUE);
					//Contador para mostrar solo 20 operaciones dentro del reporte
					$contador = 0;
					$htmlPDF = '';
					//Preguntamos por las entradas o las salidas
					if ($datos["modo"] == '1') {
						$entradas = $almacen->obtenerEntradaPorPeriodo($datos["fecha_inicio"], $datos["fecha_fin"], $datos["usuario-consulta"], $datos["producto-consulta"], $datos["proveedor-consulta"]);
						//Generamos la tabla de las entradas
						if ($entradas->resultID->num_rows > 0) {
							foreach ($entradas->getResult() as $row) {
								$data[] = array($row->numregent, $row->numfac, $this->formatearFecha($row->fecfac), $this->formatearFecha($row->fecent), utf8_decode($row->prodmar), utf8_decode($row->prodmodel), utf8_decode($row->prodpresent), $row->numunid, floatval($row->costuni), utf8_decode($row->entcoment));
							}
						$htmlPDF .= view("reportes/formatosPDF/entradas_salidas", array(
								"tabla" => $this->generarTabla(array("N° Entrada", "N° Factura", "Fecha Factura", "Fecha Entrada", "Marca", "Descripcion", "Presentacion", "N° Unidades", "Costo Unitario", "Comentario"), $data),
								"fechainicial" => $this->formatearFecha($datos["fecha_inicio"]),
								"fechafinal"   => $this->formatearFecha($datos["fecha_fin"]),
							));
							$dompdf = new Dompdf();
							$dompdf->loadHtml($htmlPDF);
							// (Optional) Setup the paper size and orientation
							$dompdf->setPaper('A4', 'landscape');
							// Render the HTML as PDF
							$dompdf->render();
							// Output the generated PDF to Browser
							$dompdf->stream("Reporte Entradas " . $this->formatearFecha($datos["fecha_inicio"]) . " al " . $this->formatearFecha($datos["fecha_fin"]));
						}
					} else {
						$salidas = $almacen->obtenerSalidaPorPeriodo($datos["fecha_inicio"], $datos["fecha_fin"], $datos["usuario-consulta"], $datos["producto-consulta"]);
						if ($salidas->resultID->num_rows > 0) {
							foreach ($salidas->getResult() as $row) {
								$data[] = array($row->numorden, $this->formatearFecha($row->fecsal), utf8_decode($row->prodmar), utf8_decode($row->prodmodel), utf8_decode($row->depnom), utf8_decode($row->usupnom . ' ' . $row->usupape), $row->numuniap);
							}
						}
						$htmlPDF .= view("reportes/formatosPDF/entradas_salidas", array(
							"tabla" => $this->generarTablaReporte(array("N° Salida", "Fecha de Salida", "Marca", "Descripcion", "Departamento Destino", "Usuario Solicitante", "N° Unidades Aprobadas", "Comentario"), $data),
							"fechainicial" => $this->formatearFecha($datos["fecha_inicio"]),
							"fechafinal"   => $this->formatearFecha($datos["fecha_fin"]),
						));
						$dompdf = new Dompdf();
						$dompdf->loadHtml($htmlPDF);
						// (Optional) Setup the paper size and orientation
						$dompdf->setPaper('A4', 'landscape');
						// Render the HTML as PDF
						$dompdf->render();
						// Output the generated PDF to Browser
						$dompdf->stream("Reporte Salidas " . $this->formatearFecha($datos["fecha_inicio"]) . " al " . $this->formatearFecha($datos["fecha_fin"]));
					}
					break;
				default:
					return redirect()->to('/404');
					break;
			}
		} else {
			return redirect()->to("/403");
		}
	}

	//Metodo para la consulta por rango de fecha

	public function consultarPorFecha($id_categoria=null)
	{
		
		$almacen = new Almacen_model();
		if ($this->request->isAJAX() && $this->session->get('logged')) {
			$data = array();
			$tpldata = array();
			$datos = json_decode(utf8_encode(base64_decode($this->request->getPost("data"))), TRUE);
			//Preguntamos por las entradas o las salidas
			if ($datos["modo"] == '1') {
				$entradas = $almacen->obtenerEntradaPorPeriodo($id_categoria,$datos["fecha_inicio"], $datos["fecha_fin"], $datos["usuario-consulta"], $datos["producto-consulta"], $datos["proveedor-consulta"]);
				//Generamos la tabla de las entradas
				if ($entradas->resultID->num_rows > 0) {
					foreach ($entradas->getResult() as $row) {
$data[] = array($row->numregent, $row->numfac, $this->formatearFecha($row->fecfac), $this->formatearFecha($row->fecent), utf8_decode($row->prodmar), utf8_decode($row->prodmodel), utf8_decode($row->prodpresent), $row->numunid, $row->costuni, utf8_decode($row->entcoment));
					}
				} else {
					$data[] = array('Sin Registros');
				}
				$tpldata["tabla"] = base64_encode(utf8_decode($this->generarTabla(array("N° Entrada", "N° Factura", "Fecha de Factura", "Fecha de Entrada", "Marca", "Descripcion", "Presentacion", "N° Unidades", "Costo Unitario", "Comentario"), $data)));
			} else {
				$salidas = $almacen->obtenerSalidaPorPeriodo($id_categoria,$datos["fecha_inicio"], $datos["fecha_fin"], $datos["usuario-consulta"], $datos["producto-consulta"]);
				if ($salidas->resultID->num_rows > 0) {
					foreach ($salidas->getResult() as $row) {
						$data[] = array($row->numorden, $this->formatearFecha($row->fecsal), utf8_decode($row->prodmar), utf8_decode($row->prodmodel), utf8_decode($row->depnom), utf8_decode($row->usupnom . ' ' . $row->usupape), $row->numuniap, utf8_decode($row->commsal));
					}
				} else {
					$data[] = array("Sin Registros");
				}
$tpldata["tabla"] = base64_encode(utf8_decode($this->generarTabla(array("N° Salida", "Fecha de Salida", "Marca", "Descripcion", "Departamento Destino", "Usuario Solicitante", "N° Unidades Aprobadas", "Comentario"), $data)));
			}
			//Respuesta en formato JSON
			return $this->respond(array("message" => "success", "data" => $tpldata), 200);
		} else {
			return redirect()->to('/403');
		}
	}

	//Metodo para consutar los datos por solicitud

	public function consultaSolicitud()
	{
		$model = new Solicitudes_model();
		$heading = array("N° de orden", "Fecha de Solicitud", "Fecha de Aprobacion", "Usuario", "Direccion", "Departamento", "Estatus", "Acciones");
		$rows = array();
		$datos = json_decode(utf8_decode(base64_decode($this->request->getPost('data'))), TRUE);
		if ($this->request->isAJAX() && $this->session->get('logged') && $this->session->get('usurol') == 1 || $this->session->get('usurol') == 2 || $this->session->get('usurol') == 3) {
			//Verificamos que el numero de solicitud este vacio, si no, se busca directamente la solicitud
			if ($datos["num_solicitud"] == '') {
				$query = $model->consultaSolicitud(["fecaprob1" => $datos["fecha_inicio"], "fecaprob2" => $datos["fecha_fin"], "dirid" => $datos["direccion"], "deptid" => $datos["departamento"]]);
				if ($query->resultID->num_rows > 0) {
					foreach ($query->getResult() as $row) {
						if (intval($row->statusid) == 3) {
							$rows[] = array(
								$row->numorden,
								$this->formatearFecha($row->fecsol),
								$this->formatearFecha($row->fecaprob),
								utf8_decode($row->usupnom) . " " . utf8_decode($row->usupape),
								utf8_decode($row->dirnom),
								utf8_decode($row->depnom),
								utf8_decode($row->statusnom),
								'<a class="btn btn-primary detalles" href="/detalledespacho/' . $row->numorden . '">Detalles</a>'
							);
						} else {
							$rows[] = array(
								$row->numorden,
								$this->formatearFecha($row->fecsol),
								$this->formatearFecha($row->fecaprob),
								utf8_decode($row->usupnom) . " " . utf8_decode($row->usupape),
								utf8_decode($row->dirnom),
								utf8_decode($row->depnom),
								utf8_decode($row->statusnom),
								'<a class="btn btn-primary detalles" href="/verdespacho/' . $row->numorden . '">Detalles</a>'
							);
						}
					}
				} else {
					$rows[] = array('<td colspan="7" class="text-center">Sin Resultados</td>');
				}
			}
			//De lo contrario, buscamos solo la solicitud
			else if ($datos["num_solicitud"] != '') {
				$query = $model->consultaOrden($datos["num_solicitud"]);
				if ($query->resultID->num_rows > 0) {
					foreach ($query->getResult() as $row) {
						$rows[] = array($row->numorden, $row->fecsol, $row->fecaprob, ucwords($row->usupnom) . ' ' . ucwords($row->usupape), $row->dirnom, $row->depnom, '', '');
					}
				} else {
					$rows[] = array('<td colspan="8" class="text-center">Sin registros</td>', '', '', '', '', '', '', '');
				}
			} else if ($datos["direccion"] != '' && $datos["departamento"]) {
			}
			//Imprimimos el resultado
			return $this->respond(["message" => "success", "data" => $this->generarTabla($heading, $rows)], 200);
		} else {
			return redirect()->to('/403');
		}
	}
	//Metodo para generar los reportes 
	public function index()
	{
		$dompdf = new Dompdf();
		$dompdf->loadHtml('hello world');
		// (Optional) Setup the paper size and orientation
		$dompdf->setPaper('A4', 'landscape');
		// Render the HTML as PDF
		$dompdf->render();
		// Output the generated PDF to Browser
		echo $dompdf->stream();
	}

	//Metodo para imprimir los comprobantes de despacho

	public function comprobanteDespacho($id = NULL, $estatus = NULL)
	{
		$model = new Solicitudes_model();
		$almacenModel = new Almacen_model();
		$tpldata = array();
		$tbody = '';
		if ($this->session->get('logged') && $id != NULL && $estatus != NULL) {
			$query = $model->obtenerSalida($id, $estatus);
			if ($estatus == '2') {
				$query = $model->obtenerSalida($id, "2");
				if ($query->resultID->num_rows > 0) {
					foreach ($query->getResult() as $row) {
						$tbody .= '
							<tr class="text-center">
							<td>' . utf8_decode($row->prodmodel) . '</td>
							<td>' . $almacenModel->obtenerUnidadesSolicitadas($row->numorden, $row->codbar) . '</td>
							<td>' . $row->numuniap . '</td>
							</tr>
						';
						$tpldata['numorden'] = $row->numorden;
						$tpldata['deptid'] = $row->deptid;
						$tpldata['usupnom'] = utf8_decode($row->usupnom);
						$tpldata['usupape'] = utf8_decode($row->usupape);
						$tpldata['depnom'] = utf8_decode($row->depnom);
						$tpldata['dirnom'] = utf8_decode($row->dirnom);
						$tpldata['fecaprob'] = $this->formatearFecha($row->fecaprob);
						$tpldata['fecsol'] = $this->formatearFecha($row->fecsol);
						///los datos del almacenista son incorpotados en al reporte
						$tpldata['nomb_despacho'] = $row->nomb_despacho;
						$tpldata['ape_despacho'] = $row->ape_despacho;
						$tpldata['dep_despacho'] = $row->dep_despacho;
						$tpldata['dir_despacho'] = $row->dir_despacho;
						//los datos de la persona que aprueba  son incorpotados en al reporte
						$tpldata['nomb_aprob'] = $row->nomb_aprob;
						$tpldata['ape_aprob'] = $row->ape_aprob;
						$tpldata['dep_aprob'] = $row->dep_aprob;
						$tpldata['dir_aprob'] = $row->dir_aprob;
						$tpldata['comentario'] = urldecode($row->comentario);
					}
				} else {
					$tbody .= '<tr class="text-center"><td colspan="3">Sin Registros</tr>';
				}
				//Se setean los valores para el comprobante
				$tpldata["tabla"] = base64_encode($tbody);
				$tpldata["fecsal"] = 'Aún sin despachar';
				$tpldata["commsal"] = 'Aún sin despachar';
			} else if ($estatus == '3') {
				if ($query->resultID->num_rows > 0) {
					foreach ($query->getResult() as $row) {
						$tbody .= '
							<tr class="text-center">
							<td>' . utf8_decode($row->prodmodel) . '</td>
							<td>' . $almacenModel->obtenerUnidadesSolicitadas($row->numorden, $row->codbar) . '</td>
							<td>' . $row->numuniap . '</td>
							</tr>
						';
						$tpldata["fecsal"] = $this->formatearFecha($row->fecsal);
						$tpldata["salidaid"] = $row->salidaid;
						$tpldata["commsal"] = $row->commsal;
						$tpldata['numorden'] = $row->numorden;
						$tpldata['deptid'] = $row->deptid;
						$tpldata['usupnom'] = $row->usupnom;
						$tpldata['usupape'] = $row->usupape;
						$tpldata['depnom'] = $row->depnom;
						$tpldata['dirnom'] = $row->dirnom;
						$tpldata['fecaprob'] = $this->formatearFecha($row->fecaprob);
						$tpldata['fecsol'] = $this->formatearFecha($row->fecsol);
						///los datos del almacenista son incorpotados en al reporte
						$tpldata['nomb_despacho'] = $row->nomb_despacho;
						$tpldata['ape_despacho'] = $row->ape_despacho;
						$tpldata['dep_despacho'] = $row->dep_despacho;
						$tpldata['dir_despacho'] = $row->dir_despacho;
						//los datos de la persona que aprueba  son incorpotados en al reporte
						$tpldata['nomb_aprob'] = $row->nomb_aprob;
						$tpldata['ape_aprob'] = $row->ape_aprob;
						$tpldata['dep_aprob'] = $row->dep_aprob;
						$tpldata['dir_aprob'] = $row->dir_aprob;
						$tpldata['comentario'] = urldecode($row->comentario);
					}
					$tpldata["tabla"] = base64_encode($tbody);
				}
			}
			echo view('reportes/comprobantes/despacho', $tpldata);
		} else {
			return redirect()->to('/404');
		}
	}

	//Metodo para la consulta de consolidado de solicitudes por fecha
	public function consultaConsolidado($id_categoria=null)
	{
		
		$model = new Almacen_model();
		$dataSet = array();
		$labelChart = array();
		$rows = array();
		if ($this->session->get('logged') and $this->request->isAJAX()) {
			$datos = json_decode(utf8_encode(base64_decode($this->request->getPost('data'))), TRUE);
			$tableHeadings = array("Código de barras", "Descripcion de Producto", "Nº de unidades");
			if (is_null($datos)) {
				return $this->respond(["message" => "La consulta no puede estar vacia"], 400);
			} else if($datos["mode"]=='3'){
				$tableHeadings = array("Código de barras", "Descripcion de Producto", "Categoria", "Entradas","Salidas");
				$query = $model->consolidadoPorFecha($id_categoria,$datos["date_init"], $datos["date_end"], $datos["mode"]);

				if (isset($query)) {
					foreach ($query as $row) {
						$labelChart[] = $row->prodmodel;
						//PARA PRODUCCION
						$rows[] = array($row->codbar, utf8_decode($row->prodmodel),utf8_decode($row->descripcion),$row->entradas,$row->salidas,);
						
						//PARA DESARROLLO
						//$rows[] = array($row->codbar, $row->prodmodel, $row->descripcion,$row->entradas,$row->salidas,);
						
						$dataSet[] = intval($row->entradas);
					}
					//Generamos la tabla y mandamos a la vista
					return $this->respond([
						"message" => "success",
						"tabla"   => $this->generarTabla($tableHeadings, $rows),
						"modo"=>'0',
						"dataset" => [
							"label" => $labelChart,
							"data"  => $dataSet
						]
					], 200);
				} else {
					return $this->respond(["message" => "Sin registros"], 404);
				}
			}else{
				$tableHeadings = array("Código de barras", "Descripcion de Producto","Categoria", "Nº de unidades");
				$query = $model->consolidadoPorFecha($id_categoria,$datos["date_init"], $datos["date_end"], $datos["mode"]);
				if (isset($query)) {
					foreach ($query->getResult() as $row) {
						$labelChart[] = $row->prodmodel;
						//PARA PRODUCCION
						$rows[] = array($row->codbar, utf8_decode($row->prodmodel),utf8_decode($row->descripcion), $row->numunid,);

						//PARA DESARROLLO
						//$rows[] = array($row->codbar, $row->prodmodel,$row->descripcion, $row->numunid,);
						$dataSet[] = intval($row->numunid);
					}
					//Generamos la tabla y mandamos a la vista
					return $this->respond([
						"message" => "success",
						"tabla"   => $this->generarTabla($tableHeadings, $rows),
						"dataset" => [
							"label" => $labelChart,
							"data"  => $dataSet
						]
					], 200);
				} else {
					return $this->respond(["message" => "Sin registros"], 404);
				}
			}
		} else {
			return redirect()->to('/403');
		}
	}

	//Metodo para generar archivos csv
	public function generarConsolidadoExcel($fecha_inicio = NULL, $fecha_fin = NULL, $modo = NULL)
	{
		//Inicializamos
		$model = new Almacen_model();
		$csv = '';
		$fields = array("Código de barras", "Descripcion de Producto", "Nº de unidades");
		$delimiter = ";";
		//El archivo se abre en memoria
		$f = fopen("php://memory", "w");
		//Cargamos las cabeceras
		fputcsv($f, $fields, $delimiter);
		//Hacemos validacion para enlaces no vacios
		if ($this->session->get('logged') and !is_null($fecha_inicio) or !is_null($fecha_fin) or !is_null($modo)) {
			$query = $model->consolidadoPorFecha($fecha_inicio, $fecha_fin, $modo);
			//Si tenemos datos, los escribimos, si no, le escribimos 0
			if (isset($query)) {
				foreach ($query->getResult() as $row) {
					fputcsv($f, array($row->codbar, utf8_decode($row->prodmodel), $row->numunid), $delimiter);
				}
			} else {
				fputcsv($f, array(0, 0, 0), $delimiter);
			}
			fseek($f, 0);
			//seteamos cabeceras
			header('Content-Type: text/csv');
			//Generamos el archivo csv con su nombre
			if ($modo == '1') {
				header('Content-Disposition: attachment; filename="Reporte de entrada de items desde ' . $this->formatearFecha($fecha_inicio) . ' hasta ' . $this->formatearFecha($fecha_fin) . '";');
			} else {
				header('Content-Disposition: attachment; filename="Reporte de salida de items desde ' . $this->formatearFecha($fecha_inicio) . ' hasta ' . $this->formatearFecha($fecha_fin) . '";');
			}
			//imprimimos el archivo
			fpassthru($f);
			//salimos
			exit;
		} else {
			return redirect()->to('/403');
		}
	}

	//Metodo para obtener los articulos solicitados por departamentos
	public function consultaPorDepartamentos()
	{
		$model = new Almacen_model();
		$labelChart = array();
		$dataSet = array();
		$rows = array();
		$headings = array("Código de barras", "Descripcion de Producto", "Nº de unidades");
		if ($this->session->get('logged') and $this->request->isAJAX()) {
			$datos = json_decode(utf8_encode(base64_decode($this->request->getPost('data'))), TRUE);
			if (is_null($datos)) {
				return $this->respond(["message" => "Solicitud sin contenido"], 204);
			} else {
				$query = $model->obtenerConsolidadoPorDepartamento($datos["date_init"], $datos["date_end"], $datos["direccion"], $datos["departamento"]);
				if (isset($query)) {
					//Generamos el detallado
					foreach ($query->getResult() as $row) {
						$labelChart[] = utf8_decode($row->prodmodel);
						$rows[] = array($row->codbar, utf8_decode($row->prodmodel), $row->numunid);
						$dataSet[] = intval($row->numunid);
					}
					//devolvemos los datos a la vista
					return $this->respond([
						"message" => "success",
						"tabla"   => $this->generarTabla($headings, $rows),
						"dataset" => [
							"label" => $labelChart,
							"data"  => $dataSet
						]
					], 200);
				} else {
					return $this->respond(["message" => "no encontrado"], 404);
				}
			}
		} else {
			return redirect()->to('/403');
		}
	}

	//metodo para generar el consolidado por departamentos en excel
	public function generarPorDepartamentosEx($data = NULL)
	{
		//Inicializamos
		$model = new Almacen_model();
		$csv = '';
		$fields = array("Código de barras", "Descripcion de Producto", "Nº de unidades");
		$delimiter = ";";
		//El archivo se abre en memoria
		$f = fopen("php://memory", "w");
		//Cargamos las cabeceras
		fputcsv($f, $fields, $delimiter);
		$datos = json_decode(utf8_encode(base64_decode($data)), TRUE);
		//Hacemos validacion para enlaces no vacios
		if ($this->session->get('logged') and !is_null($datos)) {
			$query = $model->obtenerConsolidadoPorDepartamento($datos["date_init"], $datos["date_end"], $datos["direccion"], $datos["departamento"]);
			if (isset($query)) {
				foreach ($query->getResult() as $row) {
					fputcsv($f, array($row->codbar, utf8_decode($row->prodmodel), $row->numunid), $delimiter);
				}
			} else {
				fputcsv($f, array(0, 0, 0), $delimiter);
			}
			fseek($f, 0);
			//seteamos cabeceras
			header('Content-Type: text/csv');
			//Generamos el archivo csv con su nombre
			header('Content-Disposition: attachment; filename="Reporte de salida de items por departamentos desde ' . $this->formatearFecha($fecha_inicio) . ' hasta ' . $this->formatearFecha($fecha_fin) . '";');
			//imprimimos el archivo
			fpassthru($f);
			//salimos
			exit;
		} else {
			return redirect()->to('/403');
		}
	}
}
