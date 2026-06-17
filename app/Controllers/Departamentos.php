<?php

namespace App\Controllers;

use App\Models\Departamento;

use CodeIgniter\RESTful\ResourceController;

class Departamentos extends ResourceController
{


	//Metodo queo obtiene los departamentos para el select al momento de editar un usuario
	public function listar_departamentos()
	{
		$model = new Departamento();
		$query = $model->listar_departamentos();
		if (empty($query)) {
			$departamentos = [];
		} else {
			$departamentos = $query;
		}
		echo json_encode($departamentos);
	}

	/*Este metodo extrae todos los departamentos  para los datatables*/
	public function index()
	{
		if ($this->request->isAJAX()) {
			$response = array();
			$model = new Departamento();
			$query = $model->get_all_data();
			$datos = array();
			if ($query->resultID->num_rows > 0) {
				foreach ($query->getResult() as $row) {
					$datos[] = array($row->deptid, $row->depnom, $row->dirnom);
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

	public function create()
	{
		if ($this->request->isAJAX()) {
			$response = array();
			$datos = json_decode(base64_decode($this->request->getPost('data')));
			$model = new Departamento();
			$data = array();
			if (strlen($datos->depid) == 0) {
				$data['depnom'] = $datos->depnom;
				$data['dirid'] = $datos->dirid;
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
				$data['deptid'] = $datos->depid;
				$data['depnom'] = $datos->depnom;
				$data['dirid'] = $datos->dirid;
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

	public function show($id = null)
	{
		if ($this->request->isAJAX()) {
			$response = array();
			$data = array();
			$model = new Departamento();
			$query = $model->get_single_data($id);
			if ($query->resultID->num_rows > 0) {
				foreach ($query->getResult() as $row) {
					$data['depid'] = utf8_decode($row->deptid);
					$data['depnom'] = utf8_decode($row->depnom);
					$data['dirid'] = $row->dirid;
				}
				$response['status'] = 200;
				$response['message'] = 'Consulta realizada exitosamente';
				$response['data'] = $data;
			} else {
				$response['status'] = 404;
				$response['message'] = 'No encontrado';
			}
			echo json_encode($response);
		} else {
			return redirect()->to('/403');
		}
	}

	public function delete($id = null)
	{
		if ($this->request->isAJAX()) {
			$response = array();
			$model = new Departamento();
			$query = $model->borrar($id);
			if ($query) {
				$response['status'] = 200;
				$response['message'] = 'Opeacion realizada correctamente';
			} else {
				$response['status'] = 500;
				$response['message'] = 'Error al realizar la operacion';
			}
			return json_encode($response);
		} else {
			return redirect()->to('/403');
		}
	}
}
