<?php namespace App\Libraries;

use CodeIgniter\Model;

class Watson{

	public function dbconn(){
		$db = \Config\Database::connect();
		$builder = $db->table('st_journal');
		return $builder;		
	}

	/*Metodo que registra las visitas a los modulos */

	public function request(Array $data){
		$builder = $this->dbconn();
		$datos = array();
		switch ($data['operation']) {
			/*Entrada al modulo */
			case 1:
				$datos['typeop'] = 'Entrada a Módulo';
				$datos['userip'] = $data['ip'];
				$datos['userid'] = $data['user'];
				$datos['commentop'] = 'Visita del usuario al modulo'.$data['route'];		
				break;
			/*Consultando datos*/
			case 2:
				$datos['typeop'] = 'Consulta de datos';
				$datos['userip'] = $data['ip'];
				$datos['userid'] = $data['user'];
				$datos['commentop'] = 'Consulta del usuario del dato'.$data['query'].' en el modulo'.$data['route'];
			/*Insertando registros*/
			case 3:
				$datos['typeop'] = 'Insertano registros';
				$datos['userip'] = $data['ip'];
				$datos['userid'] = $data['user'];
				$datos['commentop'] = 'Inserta el registro'.$data['query'].' en el modulo'.$data['route'];
			default:
				# code...
				break;
		}
		$builder->insert($datos);
		return TRUE;
	}



}