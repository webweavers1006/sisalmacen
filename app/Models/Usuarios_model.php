<?php

namespace App\Models;

class Usuarios_model extends BaseModel
{



	public function get_all()
	{
		$db      = \Config\Database::connect();
		$strQuery = "SELECT  a.userid, a.usupnom,a.ususnom,a.usupape,a.ususape,a.usuemail,b.depnom,case when a.borrado='0' then 'Activo' else 'Inactivo' end as borrado ";
		$strQuery .= "FROM sta_usuarios a ";
		$strQuery .= " join sta_departamentos b on  a.deptid = b.deptid ";
		$query = $db->query($strQuery);
		$resultado = $query->getResult();
		return $resultado;
	}


	public function get_all_2()
	{
		$builder = $this->dbconn('sta_usuarios a');
		$builder->select('a.userid, a.usupnom,	a.ususnom , a.usupape , a.ususape , a.usuemail, b.depnom');
		$builder->join('sta_departamentos b', 'a.deptid = b.deptid');
		$query = $builder->get();
		return $query;
	}

	public function get_single(String $id)
	{
		$builder = $this->dbconn('sta_usuarios a');
		$builder->select('a.userid, a.usupnom,	a.ususnom , a.usupape , a.ususape , a.usuemail, a.usupass, a.deptid, a.idrol,a.borrado, c.dirid');
		$builder->join('sta_dep_dir b', 'a.deptid = b.depid');
		$builder->join('sta_direcciones c', 'b.dirid = c.dirid');
		$builder->where('a.userid', $id);
		$query = $builder->get();
		return $query;
	}
	public function login_user(array $data)
	{
		$builder = $this->dbconn('sta_usuarios');
		$builder->select('userid, usupnom, usupape, idrol, usuemail, deptid, usupass,borrado');
		$builder->where($data);
		$query = $builder->get();
		return $query;
	}

	public function getDepByDir(String $id)
	{
		$builder = $this->dbconn('sta_departamentos a');
		$builder->select('a.deptid, a.depnom');
		$builder->join('sta_dep_dir b', "b.depid = a.deptid ");
		$builder->join('sta_direcciones c', "b.dirid = c.dirid ");
		$builder->where('c.dirid', $id);
		$query = $builder->get();
		return $query;
	}

	public function add_new(array $data)
	{
		$builder = $this->dbconn('sta_usuarios');
		$query = $builder->insert($data);
		return $query;
	}

	public function edit(array $data)
	{
		$builder = $this->dbconn('sta_usuarios');
		$builder->where('userid', $data['userid']);
		$query = $builder->update($data);
		return $query;
	}

	public function delete_user(String $id)
	{
		$builder = $this->dbconn('sta_usuarios');
		$query = $builder->delete(['userid' => $id]);
		return $query;
	}

	public function getUserByMail(String $email)
	{
		$builder = $this->dbconn('sta_usuarios');
		$builder->where('usuemail', $email);
		$query = $builder->get();
		return $query;
	}

	public function setNewPassword(String $useremail, String $userpass)
	{
		$builder = $this->dbconn('sta_usuarios');
		$builder->where('usuemail', $useremail);
		$query = $builder->update(["usupass" => $userpass]);
		return $query;
	}
}
