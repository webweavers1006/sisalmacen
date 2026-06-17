<?php

namespace App\Models;

class Roles_model extends BaseModel
{




	public function listar_rol()
	{
		$db      = \Config\Database::connect();
		$strQuery = "SELECT  idrol,rolnom ";
		$strQuery .= "FROM sta_roles ";
		$query = $db->query($strQuery);
		$resultado = $query->getResult();
		return $resultado;
	}




	public function get_all()
	{
		$builder = $this->dbconn('sta_roles');
		$query = $builder->get();
		return $query;
	}

	public function add(array $data)
	{
		$builder = $this->dbconn('sta_roles');
		$query = $builder->insert($data);
		return $query;
	}

	public function get_single(String $id)
	{
		$builder = $this->dbconn('sta_roles');
		$builder->where('idrol', $id);
		$query = $builder->get();
		return $query;
	}

	public function edit(array $data)
	{
		$builder = $this->dbconn('sta_roles');
		$builder->where('idrol', $data['idrol']);
		$query = $builder->update(['nomrol' => $data['nomrol']]);
		return $query;
	}
	public function delete_rol(String $id)
	{
		$builder = $this->dbconn('sta_roles');
		$query = $builder->delete(['idrol' => $id]);
		return $query;
	}
}
