<?php

namespace App\Models;

class Departamento extends BaseModel
{


	public function listar_departamentos()
	{

		$db      = \Config\Database::connect();
		$strQuery = "SELECT  deptid,depnom ";
		$strQuery .= "FROM sta_departamentos ";
		$query = $db->query($strQuery);
		$resultado = $query->getResult();
		return $resultado;
	}





	/*Metodo que obtiene todos los datos*/
	public function get_all_data()
	{
		$builder = $this->dbconn('sta_departamentos a');
		$builder->select('a.deptid, a.depnom, c.dirnom');
		$builder->join('sta_dep_dir b', 'a.deptid = b.depid');
		$builder->join('sta_direcciones c', 'b.dirid = c.dirid');
		$query = $builder->get();
		return $query;
	}
	/*Metodo para obtener un id por su nombre*/
	public function get_id_by_nom(String $depnom)
	{
		$builder = $this->dbconn('sta_departamentos a');
		$builder->select('a.deptid');
		$builder->where('a.depnom', $depnom);
		$query = $builder->get();
		$row = $query->getRow();
		return $row ? $row->deptid : null;
	}
	/*Metodo para obtener un solo registro por su id*/
	public function get_single_data(String $id)
	{
		$builder = $this->dbconn('sta_departamentos a');
		$builder->select('a.deptid, a.depnom, c.dirid');
		$builder->join('sta_dep_dir b', 'a.deptid = b.depid');
		$builder->join('sta_direcciones c', 'b.dirid = c.dirid');
		$builder->where('a.deptid', $id);
		$query = $builder->get();
		return $query;
	}
	/*Metodo para añadir un nuevo registro */
	public function add_new(array $data)
	{
		$builder = $this->dbconn('sta_departamentos');
		/*Insercion en la primera tabla*/
		$builder->insert(['depnom' => $data['depnom']]);
		/*Insercion en la tabla de union*/
		$builder = $this->dbconn('sta_dep_dir');
		$query = $builder->insert(['depid' => $this->get_id_by_nom($data['depnom']), 'dirid' => $data['dirid']]);
		return $query;
	}
	/*Metodo para editar un registro */
	public function edit(array $data)
	{
		$builder = $this->dbconn('sta_departamentos');
		/*Actualizacion en la tabla maestra*/
		$builder->where('deptid', $data['deptid']);
		$builder->update(['depnom' => $data['depnom']]);
		/*Actualizacion en la tabla union*/
		$builder = $this->dbconn('sta_dep_dir');
		$builder->where('depid', $data['deptid']);
		$query = $builder->update(['dirid' => $data['dirid']]);
		return $query;
	}

	/*Metodo para borrar un registro*/
	public function borrar($id)
	{
		$builder = $this->dbconn('sta_departamentos');
		$query = $builder->delete(['deptid' => $id]);
		return $query;
	}
}
