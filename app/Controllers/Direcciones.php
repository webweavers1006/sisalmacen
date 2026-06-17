<?php

namespace App\Controllers;

use App\Models\Direccion;

use CodeIgniter\RESTful\ResourceController;

class Direcciones extends ResourceController
{



	//Metodo queo obtiene las direcciones para el select al momento de editar un usuario
	public function listar_direcciones()
	{
		$model = new Direccion();
		$query = $model->listar_direcciones();
		if (empty($query)) {
			$direcciones = [];
		} else {
			$direcciones = $query;
		}
		echo json_encode($direcciones);
	}





	/*Metodo que extrae todos los registros de las direcciones  para los datatables*/
	public function index()
	{
		if ($this->request->isAJAX()) {
			$response = array();
			$model = new Direccion();
			$query = $model->get_all_data();
			$datos = array();
			if ($query->resultID->num_rows > 0) {
				foreach ($query->getResult() as $row) {
					$datos[] = array($row->dirid, $row->dirnom);
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
			return redirect()->to('/403');
		}
	}
	/*Metodo que registra y edita segun el caso las direcciones*/
	public function create()
	{
		if ($this->request->isAJAX()) {
			$response = array();
			$datos = json_decode(base64_decode($this->request->getPost('data')));
			$data = array();
			$model = new Direccion();
			if (strlen($datos->iddireccion) == 0) {
				$data['dirnom'] = $datos->nomdireccion;
				$query = $model->add($data);
				if ($query) {
					$response['status'] = 200;
					$response['message'] = 'Direccion registrada exitosamente';
				} else {
					$response['status'] = 500;
					$response['message'] = 'Error en la insercion del dato';
				}
			} else {
				$data['dirid'] = $datos->iddireccion;
				$data['dirnom'] = $datos->nomdireccion;
				$query = $model->edit($data);
				if ($query) {
					$response['status'] = 200;
					$response['message'] = 'Direccion registrada exitosamente';
				} else {
					$response['status'] = 500;
					$response['message'] = 'Error en la edicion del dato';
				}
			}
			echo json_encode($response);
		} else {
			return redirect()->to('/403');
		}
	}
	/*Metodo que consulta y devuelve solo un registro */
	public function show($id = null)
	{
		if ($this->request->isAJAX()) {
			$response = array();
			$data = array();
			$model = new Direccion();
			$query = $model->get_single_data($id);
			if ($query->resultID->num_rows > 0) {
				foreach ($query->getResult() as $row) {
					$data['dirid'] = $row->dirid;
					$data['dirnom'] = $row->dirnom;
				}
				$response['status'] = 200;
				$response['message'] = 'Consulta realizada exitosamente';
				$response['data'] = $data;
			} else {
				$response['status'] = 404;
				$response['message'] = 'Not Found';
			}
			echo json_encode($response);
		} else {
			return redirect()->to('/403');
		}
	}
	/*Metodo para eliminar un registro*/
	public function delete($id = null)
	{
		if ($this->request->isAJAX()) {
			$response = array();
			$model = new Direccion();
			$query = $model->deldir($id);
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
}
