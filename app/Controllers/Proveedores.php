<?php namespace App\Controllers;

use App\Models\Proveedores_model;
use CodeIgniter\API\ResponseTrait;

class Proveedores extends BaseController{

    use ResponseTrait;

    public function nuevo(){
        if($this->request->isAJAX() && $this->session->get('logged')){
            $datos = json_decode(base64_decode($this->request->getPost('data')), TRUE);
            $model = new Proveedores_model();
            $query = $model->nuevoProveedor($datos);
            if($query){
                return $this->respond(array('message' => 'registrado exitosamente'), 200);
            }
            else{
                return $this->respond(array('message' => 'ha ocurrido un error'), 500);
            }
        }
        else{
            return redirect()->to('/403');
        }
    }

    public function consulta(){
        if($this->session->get('logged')){
            $model = new Proveedores_model();
            $query = $model->getAll();
            $rows = array();
            $headings = array("Nº", "RIF", "Nombre", "Telefono Principal", "Telefono Secundario", "Acciones");
            
            // CAMBIO: Usamos count() sobre el resultado para evitar el error de método indefinido
            $resultados = $query->getResult();
            if(count($resultados) > 0){
                foreach($resultados as $row){
                    $rows[] = array($row->idprov, $row->numrif, $row->nomprov, $row->telef1, $row->telef2, '<button class="btn btn-sm detalles btn-light" id="'.$row->idprov.'">Detalles</button><button class="btn btn-sm editar btn-primary" id="'.$row->idprov.'">Editar</button>');
                }
            }
            else{
                $rows[] = array('<td colspan="6">Sin registros</td>','','','','','');
            }
            $tabla = base64_encode($this->generarTabla($headings, $rows));
            echo view('template/header');
            echo view('template/nav_bar');
            echo view('proveedores/all_provider', array('tbody' => $tabla));
            echo view('template/footer');
            echo view('proveedores/footer');
        }
        else{
            return redirect()->to('/403');
        }
    }

    public function detalleProveedor(){
        if($this->request->isAJAX() && $this->session->get('logged')){
            $id = $this->request->getPost('data');
            $model = new Proveedores_model();
            $query = $model->getSingle($id);
            
            // CAMBIO: Verificación simplificada para PHP 8.4
            if($row = $query->getRow()){
                $data = array(
                    'idprov'     => $row->idprov,
                    'nomprov'    => $row->nomprov,
                    'telef1'     => $row->telef1,
                    'telef2'     => $row->telef2,
                    'direccprov' => $row->direccprov,
                    'contemail'  => $row->email,
                    'rifprov'    => $row->numrif
                );
                return $this->respond(array('message' => 'success', 'data' => $data), 200);
            }
            else{
                return $this->respond(array('message' => 'not found'), 404);    
            }
        }
        else{
            return redirect()->to('/403');
        }
    }

    public function buscarProveedor(){
        if($this->request->isAJAX()){
            $dataRaw = $this->request->getPost('data');
            $datos = json_decode(base64_decode($dataRaw), TRUE);
            $model = new Proveedores_model();
            $query = $model->buscarPorRif($datos['rif']);
            
            // CAMBIO: Usamos getRow() directamente. Si es null, no encontró nada.
            if ($result = $query->getRowArray()) {
                return $this->respond(array('message' => 'success', 'data' => $result), 200);
            } else {
                return $this->respond(array('message' => 'not found'), 404);    
            }           
        }
        return redirect()->to('/403');
    }

    public function editarProveedor(){
        $model = new Proveedores_model();
        if($this->session->get('logged') && $this->request->isAJAX()){
            $datos = json_decode(base64_decode($this->request->getPost('data')), TRUE);
            $query = $model->actualizaProveedor($datos);
            if($query){
                return $this->respond(array("message" => "success"), 200);
            }
            else{
                return $this->respond(array("message" => "not found"), 404);
            }
        }
        else{
            return redirect()->to('/403');
        }
    }

    public function reloadProveedores(){
        $model = new Proveedores_model();
        $rows = array();
        $headings = array("Nº", "RIF", "Nombre", "Telefono Principal", "Telefono Secundario", "Acciones");
        if($this->session->get('logged') && $this->request->isAJAX()){
            $query = $model->getAll();
            $resultados = $query->getResult();
            
            if(count($resultados) > 0){
                foreach($resultados as $row){
                    $rows[] = array($row->idprov, $row->numrif, $row->nomprov, $row->telef1, $row->telef2, '<button class="btn btn-sm detalles btn-light" id="'.$row->idprov.'">Detalles</button><button class="btn btn-sm editar btn-primary" id="'.$row->idprov.'">Editar</button>');
                }
            }
            else{
                $rows[] = array('<td colspan="6">Sin registros</td>','','','','','');
            }
            $tabla = base64_encode($this->generarTabla($headings, $rows));
            return $this->respond(array('message' => 'success', 'data' => $tabla), 200);
        }
        else{
            return redirect()->to('/403');
        }
    }
}