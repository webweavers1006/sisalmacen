<?php namespace App\Models;

use CodeIgniter\Model;

class BaseModel extends Model{

	/*Metodo que conecta a una tabla*/
	public function dbconn(String $table){
		$db = \Config\Database::connect();
		$builder = $db->table($table);
		return $builder;
	}
	/*Metodo que registra en la tabla de auditoria*/
	public function recordlog($data){
		$builder = $this->dbconn('sta_log');
		$query = $builder->insert($data);
		return $query;
	}

	/*Metodo que registra los productos dentro de la tabla de las existencias*/
	public function registrarEnExistencias(String $codbar){
		$builder = $this->dbconn('sta_existencias');
		$query = $builder->insert(array('codbar' => $codbar, 'numexis' => 0));
		return $query;
	}

	/*Metodo que suma las entradas en la tabla de existencias*/
	public function actualizaExistencias($codbar, $numunid, $mode){
		$total = 0;	
		//Conectamos con la tabla de existencias
		$builder = $this->dbconn('sta_existencias');
		//Obtenemos la existencia actual
		$builder->select('numexis');
		$builder->where('codbar', $codbar);
		$query = $builder->get();
		//Convertimos a entero el resultado
		$row = $query->getRowArray();
		$existencias = $row ? intval($row['numexis']) : 0;
		if($mode == 1){
			//Sumamos
			$total = $numunid + $existencias;	
		}
		else{
			//Restamos
			$total = $existencias - $numunid;
		}
		//Reseteamos el builder
		$builder->resetQuery();
		//Armamos el query para actualizar
		$query = $builder->update(array('numexis' => $total), 'codbar = "'.$codbar.'"');
		return $query;
	}

}