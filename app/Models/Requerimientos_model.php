<?php

namespace App\Models;

class Requerimientos_model extends BaseModel
{

	//Metodo para buscar un nuevo ID
	public function getID()
	{
		$builder = $this->dbconn('sta_pre_requerimientos');
		$query = $builder->get();
		switch (intval($query->resultID->num_rows)) {
			case 0:
				return 1;
				break;
			default:
				if ($this->isIDExists(intval($query->resultID->num_rows))) {
					return (intval($query->resultID->num_rows) + 1);
				} else {
					return intval($query->resultID->num_rows);
				}
				break;
		}
	}

	//Metodo para buscar los requerimientos por usuario
	public function getAllByUser($userid)
	{
		$builder = $this->dbconn("sta_pre_requerimientos a");
		$builder->select();
	}

	//Metodo para verificar si existe el requerimiento
	public function isIDExists($id)
	{
		$builder = $this->dbconn('sta_pre_requerimientos');
		$builder->where('prereqid', $id);
		$query = $builder->get();
		if ($query->resultID->num_rows > 0) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

	//Metodo para añadir un nuevo requerimiento
	public function newPreReq(array $data)
	{

		//reqususol"]=> string(3) "119" ["prereqfecsol"]=> string(10) "2023-10-03" ["prereqstat"]=> int(4) ["prereqdepsol"]=> string(1) "1" } 
		$builder = $this->dbconn('sta_pre_requerimientos');
		$query = $builder->insert($data);
		return $query;
	}

	//Metodo para añadir detalles al prerequerimiento

	public function addDetailPreReq(array $data)
	{
		$builder = $this->dbconn('sta_detalles_pre_requerimientos');
		$query = $builder->insert($data);
		return $query;
	}

	//Metodo para obtener los detalles de un prerequerimiento
	public function getDetailPreReq($id)
	{
		$builder = $this->dbconn("sta_detalles_pre_requerimientos");
		$builder->where('prereqid', $id);
		$query = $builder->get();
		return $query;
	}

	//Metodo para obtener el registro de un detalle por su id
	public function getDetailByID($id)
	{
		$builder = $this->dbconn("sta_detalles_pre_requerimientos");
		$builder->where("detid", $id);
		$query = $builder->get()->getRowArray();
		return $query;
	}

	//Metodo para eliminar un item de la solicitud de prerequerimiento
	public function deleteItemPreReq(array $data)
	{
		$builder = $this->dbconn('sta_detalles_pre_requerimientos');
		$query = $builder->delete($data);
		return $query;
	}

	//Metodo para obtener los requerimientos por aprobar
	public function listReqByAp()
	{
		$builder = $this->dbconn('sta_pre_requerimientos a');
		$builder->join('sta_usuarios b', "b.userid = a.prereqususol");
		$builder->join('sta_departamentos c', "c.deptid = a.prereqdepsol");
		$builder->where('prereqstat', 1);
		$query = $builder->get();
		return $query;
	}

	//Metodo para eliminar un pre requerimiento
	public function delPreReq($id)
	{
		$builder = $this->dbconn("sta_pre_requerimientos");
		$query = $builder->delete(["prereqid" => $id]);
		return $query;
	}

	//Metodo para cambiar el estatus de un pre requerimiento o un requerimiento
	public function changeStatus($type, $status, $id)
	{
		$builder;
		//El tipo 1 actualiza la tabla de los prerequermientos
		if ($type == '1') {
			$builder = $this->dbconn("sta_pre_requerimientos");
			$query = $builder->update(["prereqstat" => $status], ["prereqid" => $id]);
			return $query;
		}
		// el tipo 2 actualiza la de los requerimientos
		else {
			$builder = $this->dbconn('sta_requerimientos');
			$query = $builder->update(["statussol" => $status], ["reqid" => $id]);
			return $query;
		}
	}

	//Metodo para obtener los detalles del pre requerimiento o del requerimiento
	public function getDetailsByID($type, $id)
	{

		if ($type == '1') {
			$builder = $this->dbconn('sta_pre_requerimientos a');
			$builder->join('sta_usuarios b', "b.userid = a.prereqususol");
			$builder->join('sta_departamentos c', "c.deptid = a.prereqdepsol");
			$builder->join("sta_dep_dir d", "c.deptid = d.depid");
			$builder->join("sta_direcciones e", "d.dirid = e.dirid");
			$builder->where('prereqid', $id);
			$query = $builder->get();
			return $query;
		} else {
			$builder = $this->dbconn('sta_requerimientos a');
			$builder->join("sta_usuarios b", "b.userid = a.ususol");
			$builder->join("sta_departamentos c", "c.deptid = a.depsol");
			$builder->join("sta_dep_dir d", "c.deptid = d.depid");
			$builder->join("sta_direcciones e", "d.dirid = e.dirid");
			$builder->where("a.reqid", $id);
			$query = $builder->get();
			return $query;
		}
	}

	//Metodo para añadir un nuevo requerimiento
	public function newReq(array $detSol, array $itemsSol)
	{
		$builder = $this->dbconn('sta_requerimientos');
		$query = $builder->insert($detSol);
		if ($query->connID->affected_rows == 1) {
			//Reseteamos el builder
			$builder->resetQuery();
			unset($builder);
			$builder = $this->dbconn('sta_detalles_requerimientos');
			$query = $builder->insertBatch($itemsSol);
			return $query;
		}
	}

	//Metodo que trae todos los requerimientos aprobados y despachados
	public function getAllReqAp()
	{
		$builder = $this->dbconn("sta_requerimientos a");
		$builder->join("sta_usuarios b", "b.userid = a.ususol");
		$builder->join("sta_departamentos c", "c.deptid = a.depsol");
		$builder->orderBy("a.fechasol", "DESC");
		$builder->where("a.statussol", '2');
		$builder->orWhere("a.statussol", "3");
		$query = $builder->get();
		return $query;
	}

	//Metodo para traer los detalles de los requerimientos
	public function getDetailReq($id)
	{
		$builder = $this->dbconn('sta_detalles_requerimientos');
		$builder->where("reqid", $id);
		$query = $builder->get();
		return $query;
	}

	//Metodo para obtener los detalles de los requerimientos
	public function getDetailReqByID($id)
	{
		$builder = $this->dbconn('sta_detalles_requerimientos');
		$builder->where('detid', $id);
		$query = $builder->get()->getRowArray();
		return $query;
	}

	//Metodo que trae los requerimientos por usuario
	public function getReqByUser(String $id)
	{
		$builder = $this->dbconn('sta_pre_requerimientos a');
		$builder->join('sta_status b', "a.prereqstat = b.statusid");
		$builder->where('a.prereqususol', $id);
		$query = $builder->get();
		return $query;
	}
}
