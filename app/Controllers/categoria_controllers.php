<?php

namespace App\Controllers;

use App\Models\categoria_Model;
//use App\Models\Auditoria_sistema_Model;
use CodeIgniter\API\ResponseTrait;

use CodeIgniter\RESTful\ResourceController;

class categoria_controllers extends BaseController
{
	use ResponseTrait;

	//Metodo que muestra la vista de las direcciones 
	public function categorias()
	{
		if ($this->session->get('logged')) {
			echo view('template/header');
			echo view('template/nav_bar');
			echo view('categoria/content.php');
			echo view('template/footer');
			echo view('categoria/footer_categorias.php');

		} else {
			return redirect()->to('/');
		}
	}
	public function listar_categorias()
	{

		$model = new categoria_Model();
		$query = $model->listar_categorias();

		if (empty($query)) {
			$categorias = [];
		} else {
			$categorias = $query;
		}
		echo json_encode($categorias);

	}

	public function listar_categorias_sin_filtro()
	{

		$model = new categoria_Model();
		$query = $model->listar_categorias_sin_filtro();
		if (empty($query)) {
			$categorias = [];
		} else {
			$categorias = $query;
		}
		echo json_encode($categorias);

	}


	//Metodo para añadir Categorias
	public function add_categoria()
	{
		$model = new categoria_Model();
		if ($this->session->get('logged') and $this->request->isAJAX()) {
			//Obtenemos los datos del formulario
			$datos = json_decode(utf8_encode(base64_decode($this->request->getPost('data'))), TRUE);
			//llenamos los datos iniciales de las Direccion
			$categorias["descripcion"]     = $datos["descripcion"];
			//Realizamos la insercion en la tabla
			$query_insertar_caso = $model->add_categoria($categorias);
			if (isset($query_insertar_caso)) {
				$repuesta['mensaje']      = 1;
				return json_encode($repuesta);
			} else {
				$repuesta['mensaje']      = 2;
				return json_encode($repuesta);
			}
		} else {
			return redirect()->to('/');
		}
	}

	//Metodo para ACTUALIZAR Categorias
	public function editCategoria()
	{
		$model = new categoria_Model();
		//$model_Auditoria_sistema_Model = new Auditoria_sistema_Model();
		if ($this->session->get('logged') and $this->request->isAJAX()) {
			//Obtenemos los datos del formulario
			$datos = json_decode(utf8_encode(base64_decode($this->request->getPost('data'))), TRUE);
			//llenamos los datos iniciales de las Direccion
			$categorias["descripcion"]     = $datos["descripcion"];
			$categorias["borrado"]     = $datos["borrado"];
			$categorias["id"]     = $datos["id"];
			//Realizamos la actualizacion en la tabla
			$query_editar_caso = $model->editCategoria($categorias);
			if (isset($query_editar_caso)) {
				$mensaje = 1;
				return json_encode($mensaje);
			} else {
				$mensaje = 2;
				return json_encode($mensaje);
			}
		} else {
			return redirect()->to('/');
		}
	}
}
