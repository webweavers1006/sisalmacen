<?php

namespace App\Controllers;

use App\Models\Roles_model;

use CodeIgniter\RESTful\ResourceController;

class Roles extends ResourceController
{




	//Metodo queo obtiene los roles para el select al momento de editar un usuario
	public function listar_rol()
	{
		$model = new Roles_model();
		$query = $model->listar_rol();
		if (empty($query)) {
			$roles = [];
		} else {
			$roles = $query;
		}
		echo json_encode($roles);
	}






	/*Metodo que extrae todos los registros*/
	public function index()
	{
		if ($this->request->isAJAX()) {
			$response = array();
			$model = new Roles_model();
			$query = $model->get_all();
			$datos = array();
			if ($query->resultID->num_rows > 0) {
				foreach ($query->getResult() as $row) {
					$datos[] = array($row->idrol, $row->rolnom);
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
			$model = new Roles_model();
			if (strlen($datos->rolid) == 0) {
				$data['rolnom'] = $datos->rolnom;
				$query = $model->add($data);
				if ($query) {
					$response['status'] = 200;
					$response['message'] = 'Direccion registrada exitosamente';
				} else {
					$response['status'] = 500;
					$response['message'] = 'Error en la insercion del dato';
				}
			} else {
				$data['idrol'] = $datos->rolid;
				$data['rolnom'] = $datos->rolnom;
				$query = $model->edit($data);
				if ($query) {
					$response['status'] = 200;
					$response['message'] = 'Direccion registrada exitosamente';
				} else {
					$response['status'] = 500;
					$response['message'] = 'Error en la edicion del dato';
				}
			}
			return json_encode($response);
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
			$model = new Roles_model();
			$query = $model->get_single($id);
			if ($query->resultID->num_rows > 0) {
				foreach ($query->getResult() as $row) {
					$data['rolid'] = $row->idrol;
					$data['rolnom'] = $row->rolnom;
				}
				$response['status'] = 200;
				$response['message'] = 'Consulta realizada exitosamente';
				$response['data'] = $data;
			} else {
				$response['status'] = 404;
				$response['message'] = 'Not Found';
			}
			return json_encode($response);
		} else {
			return redirect()->to('/403');
		}
	}
	/*Metodo para eliminar un registro*/
	public function delete($id = null)
	{
		if ($this->request->isAJAX()) {
			$response = array();
			$model = new Roles_model();
			$query = $model->delete_rol($id);
			if ($query) {
				$response['status'] = 200;
				$response['message'] = 'Consulta realizada exitosamente';
			} else {
				$response['status'] = 500;
				$response['message'] = 'Error al eliminar';
			}
			return json_encode($response);
		} else {
			return redirect()->to('/');
		}
	}
}
