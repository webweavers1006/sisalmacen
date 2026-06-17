<?php

namespace App\Models;

class Direccion extends BaseModel
{




	public function listar_direcciones()
	{

		$db      = \Config\Database::connect();
		$strQuery = "SELECT  dirid,dirnom ";
		$strQuery .= "FROM sta_direcciones ";
		$query = $db->query($strQuery);
		$resultado = $query->getResult();
		return $resultado;
	}




	public function get_all_data()
	{
		$builder = $this->dbconn('sta_direcciones');
		$query = $builder->get();
		return $query;
	}

	public function get_single_data($id)
	{
		$builder = $this->dbconn('sta_direcciones');
		$builder->where('dirid', $id);
		$query = $builder->get();
		return $query;
	}

	public function add(array $data)
	{
		$builder = $this->dbconn('sta_direcciones');
		$query = $builder->insert($data);
		return $query;
	}

	public function edit(array $data)
	{
		$builder = $this->dbconn('sta_direcciones');
		$builder->where('dirid', $data['dirid']);
		$query = $builder->update($data);
		return $query;
	}

	public function deldir($id)
	{
		$builder = $this->dbconn('sta_direcciones');
		$query = $builder->delete(['dirid' => $id]);
		return $query;
	}
}
