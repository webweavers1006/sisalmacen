<?php

namespace App\Controllers;

use App\Models\Productos_model;
use CodeIgniter\API\ResponseTrait;

class Productos extends BaseController
{

	use ResponseTrait;
	/*Metodo que muestra una vista para registrar el producto*/
	public function registrar()
	{
		$model = new Productos_model();
		$data['next_codbar'] = $model->getNextCodbar();
		echo view('template/header', $data);
		echo view('template/nav_bar');
		echo view('productos/regprod', $data);
		echo view('template/footer');
		echo view('productos/footer');
		unset($model);
	}

	public function getNextCodbarAjax()
	{
		if ($this->request->isAJAX()) {
			$model = new Productos_model();
			$next = $model->getNextCodbar();
			return $this->respond(['next_codbar' => str_pad($next, 8, '0', STR_PAD_LEFT)]);
		}
		return $this->respond(['error' => 'Invalid request'], 400);
	}

	/*Metodo que registra un nuevo producto*/
	public function addProducto()
	{
		if ($this->request->isAJAX()) {
			$files = $this->request->getFiles();
			
			$formrequest = json_decode(utf8_encode(base64_decode($this->request->getPost('data'))));
			$codbar = $formrequest->codbar;
			$modform = $formrequest->modform ?? 1;
			// log_message('error', "addProducto START: codbar=$codbar, modform=$modform, files[imagen]=" . (isset($files['imagen']) ? $files['imagen']->getClientName() : 'NO') . ", isValid=" . (isset($files['imagen']) ? $files['imagen']->isValid() : 'NO'));	
			
			$prodimg = 'sin_img.png';
			
			// Para edición (modform=2), obtener imagen actual por defecto
			if ($modform == 2) {
				$model_temp = new Productos_model();
				$query_temp = $model_temp->getSingle((string)$codbar);
				// log_message('error', "addProducto edit query: rows=" . $query_temp->resultID->num_rows . ", codbar=$codbar");
				if ($query_temp->resultID->num_rows > 0) {
					foreach ($query_temp->getResult() as $row) {
						$prodimg = trim($row->prodimg ?? 'sin_img.png');
					}
				}
				unset($model_temp);
				// log_message('error', "addProducto edit set prodimg=$prodimg");
			}
			
			// Si hay nueva imagen válida, reemplazar
			if (isset($files['imagen']) && $files['imagen']->isValid() && !$files['imagen']->hasMoved()) {
				$file = $files['imagen'];
				$mime = $file->getClientMimeType();
				$ext = $file->getClientExtension();
				$size = $file->getSize();
				if ($size <= 5*1024*1024 && in_array($mime, ['image/jpeg', 'image/png', 'image/gif', 'image/webp']) && in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
					$codbar = $formrequest->codbar;
					if ($codbar) {
						$newname = $codbar . '.' . $ext;
						if ($file->move(WRITEPATH . '../public/documentos_productos/', $newname)) {
							$prodimg = $newname;
						}
					}
				}
			}

			$data = array(
				'codbar' => $codbar,
				'prodmar' => utf8_encode($formrequest->prodmar),
				'prodmodel' => utf8_encode($formrequest->prodmodel),
				'borrado' => utf8_encode($formrequest->borrado),
				'id_categoria' => utf8_encode($formrequest->id_categoria),
				'stock_minimo' => utf8_encode($formrequest->stock_min),
				'prodimg' => $prodimg,
			);
			// log_message('error', "addProducto FINAL prodimg=" . $data['prodimg']);

			$model = new Productos_model();
			if ($formrequest->modform == 1) {
				if (!$model->isProductExists($data['codbar'])) {
					$query = $model->newProd($data);
					if ($query) {
						return $this->respond(array('message' => 'Producto cargado exitosamente'), 200);
					} else {
						return $this->respond(array('message' => 'Producto ya registrado'), 500);
					}
				} else {
					return $this->respond(array('message' => 'Producto ya existe'), 403);
				}
			} else {
				$query = $model->updateProd($data);
				if ($query) {
					return $this->respond(array('message' => 'Producto actualizado exitosamente'), 200);
				} else {
					return $this->respond(array('message' => 'Error al actualizar'), 500);
				}
			}
		} else {
			return redirect()->to('/');
		}
	}

	public function updateImagen($codbar = null)
	{
		if ($this->request->isAJAX()) {
			if ($codbar === null || $codbar === '') {
				return $this->respond(['error' => 'Codbar inválido: ' . ($codbar ?? 'null')], 400);
			}
			$codbar = (string)$codbar; // Ensure string for DB
			$model = new Productos_model();
			$files = $this->request->getFiles();
			$action = $this->request->getPost('action'); // 'delete' or 'upload'
			if ($action == 'delete') {
				// Obtener img actual
				$query = $model->getSingle($codbar);
				if ($query->resultID->num_rows > 0) {
					foreach ($query->getResult() as $row) {
						$oldimg = trim($row->prodimg);
						if ($oldimg && $oldimg != 'sin_img.png') {
							$oldimg_path = WRITEPATH . '../public/documentos_productos/' . $oldimg;
							if (file_exists($oldimg_path)) {
								unlink($oldimg_path);
							}
						}
					}
					$data = ['codbar' => $codbar, 'prodimg' => 'sin_img.png'];
					$model->updateProd($data);
					return $this->respond(['message' => 'Imagen eliminada'], 200);
				}
			} elseif (isset($files['imagen']) && $files['imagen']->isValid() && !$files['imagen']->hasMoved()) {
				$file = $files['imagen'];
				$mime = $file->getClientMimeType();
				$ext = $file->getClientExtension();
				$size = $file->getSize();
				if ($size <= 5*1024*1024 && in_array($mime, ['image/jpeg', 'image/png', 'image/gif', 'image/webp']) && in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
					$newname = $codbar . '.' . $ext;
					// Borrar vieja si existe
					$query = $model->getSingle($codbar);
					if ($query->resultID->num_rows > 0) {
						foreach ($query->getResult() as $row) {
							$oldimg = trim($row->prodimg);
							if ($oldimg && $oldimg != 'sin_img.png') {
								$oldimg_path = WRITEPATH . '../public/documentos_productos/' . $oldimg;
								if (file_exists($oldimg_path)) {
									unlink($oldimg_path);
								}
							}
						}
					}
					if ($file->move(WRITEPATH . '../public/documentos_productos/', $newname)) {
						$data = ['codbar' => $codbar, 'prodimg' => $newname];
						$model->updateProd($data);
						return $this->respond(['message' => 'Imagen actualizada', 'img' => $newname], 200);
					}
				}
			}
			return $this->respond(['error' => 'Archivo inválido o movimiento falló'], 400);
		}
		return $this->respond(['message' => 'Invalid request'], 400);
	}

	/*Metodo que muestra la vista para la consulta*/
	public function consutaProducto()
	{
		$model = new Productos_model();
		$tabla = '';
		$query = $model->getAllProd();
		if ($query->resultID->num_rows > 0) {


			foreach ($query->getResult() as $row) {
				if ($row->borrado == "ACTIVO") {
					$tabla .= '<tr><td>' . trim($row->codbar) . '</td><td>' . trim(utf8_decode($row->prodmar)) . '</td><td>' . utf8_decode(trim($row->prodmodel)) . '</td><td >'.($row->descripcion_p). '</td><td >' .trim($row->stock_minimo)  . '</td><td style="color: green;">' .trim($row->borrado)  . '</td><td><a href="/editarproducto/' . trim($row->codbar) . '" class="btn-edit-circle" title="Editar producto"><i class="fas fa-edit"></i></a></td></tr>';
				} else {
					$tabla .= '<tr><td>' . trim($row->codbar) . '</td><td>' . trim(utf8_decode($row->prodmar)) . '</td><td>' . utf8_decode(trim($row->prodmodel)) . '</td><td >' . ($row->descripcion_p).'</td><td >' .trim($row->stock_minimo)  . '</td><td style="color: red;">'.trim($row->borrado)  . '</td><td><a href="/editarproducto/' . trim($row->codbar) . '" class="btn-edit-circle" title="Editar producto"><i class="fas fa-edit"></i></a></td></tr>';
				}
			}
		} else {
			$tabla .= '<tr><td class="text-center" colspan="4">Sin Registros</td></tr>';
		}
		echo view('template/header');
		echo view('template/nav_bar');
		echo view('productos/content', array('tbody' => $tabla));
		echo view('template/footer');
		echo view('productos/footer');
		unset($model);
	}

	/*Metodo que permite editar un producto*/
	public function show($id = null)
	{
		$model = new Productos_model();
		$query = $model->getSingle($id);
		$data = array();
		if ($query->resultID->num_rows > 0) {
			foreach ($query->getResult() as $row) {
				$data['codbar'] = trim($row->codbar);
				$data['prodmar'] = utf8_decode(trim($row->prodmar));
				$data['prodmodel'] = utf8_decode(trim($row->prodmodel));
				$data['prodimg'] = trim($row->prodimg ?? 'sin_img.png');
				$data['borrado'] = utf8_decode(trim($row->borrado));
				$data['id_categoria'] = utf8_decode(trim($row->id_categoria));
				$data['stock_minimo'] = utf8_decode(trim($row->stock_minimo));
			}
			$data['modform'] = 2;
			echo view('template/header');
			echo view('template/nav_bar');
			echo view('productos/editprod', $data);
			echo view('template/footer');
			echo view('productos/footer');
		} else {
			return redirect()->to('/404');
		}
	}


	//Metodo queo obtiene  los Ultimos_Casos  disponibles
	public function listar_categoria()
	{
		
		$model = new Productos_model();
		$query = $model->listar_categoria();
		if (empty($query)) {
			$categoria = [];
		} else {
			$categoria = $query;
		}
		echo json_encode($categoria);
	}





	public function searchByCodbar()
	{
		if ($this->request->isAJAX() && $this->session->get('logged')) {
			$datos = json_decode(utf8_decode(base64_decode($this->request->getPost('data'))), TRUE);
			$model = new Productos_model();
			$query = $model->getSingle($datos['data']);
			$data = array();
			if ($query->resultID->num_rows > 0) {
				foreach ($query->getResult() as $row) {
					$data["codbar"] = trim($row->codbar);
					$data["prodmar"] = trim(utf8_decode($row->prodmar));
					$data["prodmodel"] = trim(utf8_decode($row->prodmodel));
				}
				return $this->respond(array('message' => 'success', 'data' => $data), 200);
			} else {
				return $this->respond(array('message' => 'not found'), 404);
			}
		}
	}
}
?>

