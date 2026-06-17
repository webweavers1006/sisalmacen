<?php

namespace App\Models;

class Solicitudes_model extends BaseModel
{


	/*


	Metodos para cargar las preordenes del sistema

	*/

	//Metodo para obtener el numero de orden
	public function getNumOrden()
	{
		$builder = $this->dbconn('sta_preordenes');
		$query = $builder->get();
		$num_orden = $query->resultID->num_rows;
		while ($this->preordenExists($num_orden)) {
			$num_orden = $num_orden + 1;
		}
		return $num_orden;
	}

	//Validacion para la preorden, si existe el indice
	public function preordenExists($numorden)
	{
		$builder = $this->dbconn('sta_preordenes');
		$builder->where('numorden', $numorden);
		$query = $builder->get();
		if ($query->resultID->num_rows > 0) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
	//Metodo para añaidr el numero de orden
	public function addNumOrden(array $data)
	{
		$builder = $this->dbconn('sta_preordenes');
		$query = $builder->insert($data);
		return $query;
	}

	//Metodo para validar si existe un item dentro de la preorden
	public function itemExists(String $codbar, String $numorden)
	{
		$builder = $this->dbconn('sta_detalles_preordenes');
		$builder->where('codbar', $codbar);
		$builder->where('numorden', $numorden);
		$query = $builder->get();
		if ($query->resultID->num_rows > 0) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
	/*
	Metodo para actualizar el item si ya existe
	*/
	public function updateItem(array $data)
	{
		$builder = $this->dbconn('sta_detalles_preordenes');

		$builder->where('codbar',  $data['codbar']);

		$builder->where('numorden', $data['numorden']);

		$query = $builder->get()->getRowArray();

		$numuni = $query ? intval($query['numuni']) : 0;

		$builder->resetQuery();

		$builder->where('codbar', $data['codbar']);

		$builder->where('numorden', $data['numorden']);

		$query = $builder->update(array('numuni' => ($numuni + intval($data['numuni']))));

		return $query;
	}
	//Metodo que inserta un nuevo item
	public function addItem(array $data)
	{
		$builder = $this->dbconn('sta_detalles_preordenes');
		$query = $builder->insert($data);
		return $query;
	}

	//Metodo para obtener las preordenes

	public function getPreordenes($user, $mode)
	{
		$builder = $this->dbconn('sta_preordenes a');
		$builder->select('a.numorden, a.fecsol, a.ordstatus ,b.statusnom, a.usureg, c.usupnom, c.usupape,pre_or.comentario');
		$builder->join('sta_status b', 'a.ordstatus = b.statusid');
		$builder->join('sta_usuarios c', 'a.usureg = c.userid');
		$builder->join('sta_preordenes pre_or', 'a.numorden = pre_or.numorden');
		//Si el modo esta en 1, trae solo las que esta en tramite
		if ($mode == '1') {
			$builder->where('a.ordstatus', "1");
		}
		$builder->where('a.usureg', $user);
		$builder->orderBy("a.fecsol", "desc");
		$query = $builder->get();
		return $query;
	}

	//Metodo para obtener los detalles de las preordenes

	public function detallePreorden($id)
	{
		$builder = $this->dbconn('sta_detalles_preordenes a');
		$builder->select('a.detalleid, b.prodmar, b.prodmodel, a.numuni, a.codbar,pre_or.comentario');
		$builder->join('sta_productos b', 'a.codbar = b.codbar');
		$builder->join('sta_preordenes pre_or', 'a.numorden = pre_or.numorden');
		$builder->where('a.numorden', $id);
		$query = $builder->get();
		return $query;
	}

	//Metodo para eliminar las Preordenes

	public function deletePreorden($id)
	{
		$builder = $this->dbconn('sta_preordenes');
		$query = $builder->delete(['numorden' => $id]);
		return $query;
	}

	//Metodo para eliminar los detalles de las preordenes
	public function deleteItemPreorden($id)
	{
		$builder = $this->dbconn('sta_detalles_preordenes');
		$query = $builder->delete(['detalleid' => $id]);
		return $query;
	}

	//Metodo para cambiar las preordenes a estatus en Tramite

	public function confirmarPreorden($id, $comentario)
	{
		$builder = $this->dbconn('sta_preordenes');
		$builder->where('numorden', $id);
		$query = $builder->update(['ordstatus' => '1', 'comentario' => $comentario]);
		return $query;
	}

	//Metodo para traer los detalles generales de una preorden

	public function getDatosPreorden($id)
	{
		$builder = $this->dbconn('sta_preordenes a');
		$builder->select('a.numorden, a.fecsol, b.usupnom, b.usupape, c.depnom, e.dirnom');
		$builder->join('sta_usuarios b', 'a.usureg = b.userid');
		$builder->join('sta_departamentos c', 'b.deptid = c.deptid');
		$builder->join('sta_dep_dir d', 'c.deptid = d.depid');
		$builder->join('sta_direcciones e', 'd.dirid = e.dirid');
		$builder->where('a.numorden', $id);
		$query = $builder->get();
		return $query;
	}

	public function cambiarStatusPreorden(String $numorden, String $status)
	{
		$builder = $this->dbconn("sta_preordenes");
		$builder->where("numorden", $numorden);
		$query = $builder->update(['ordstatus' => $status]);
		return $query;
	}

	/*
	

	Metodos para las ordenes del sistema
	

	*/

	//Metodo para obtener las ordenes ya aprobadas

	public function getOrdenes($user)
	{
		$builder = $this->dbconn('sta_ordenes a');
		$builder->select('a.numorden, a.fecaprob, a.statusid, b.statusnom, c.usupnom, c.usupape, c.userid');
		$builder->join('sta_status b', 'a.statusid = b.statusid');
		$builder->join('sta_usuarios c', 'a.usuaprob = c.userid');
		$builder->where('a.ususol', $user);
		$query = $builder->get();
		return $query;
	}

	//Metodo para obtener las preordenes en Tramite

	public function obtenerEnTramite()
	{
		$builder = $this->dbconn('sta_preordenes a');
		$builder->select('a.numorden, a.fecsol, b.statusnom, c.usupnom, c.usupape');
		$builder->join('sta_status b', 'a.ordstatus = b.statusid');
		$builder->join('sta_usuarios c', 'a.usureg = c.userid');
		$builder->where('a.ordstatus', '1');
		$builder->orderBy("a.fecsol", "desc");
		// Agregar esta línea para ordenar por fecsol descendente
		$query = $builder->get();
		return $query;
	}

	//Metodo para obtener las existencias segun las preordenes

	public function comparaExistencia(String $numorden)
	{
		$builder = $this->dbconn('sta_detalles_preordenes a');
		$builder->select('a.detalleid, a.numorden, a.numuni, b.prodmar, b.prodmodel, c.numexis, d.numorden, a.codbar');
		$builder->join('sta_productos b', 'b.codbar = a.codbar');
		$builder->join('sta_existencias c', "a.codbar = c.codbar");
		$builder->join('sta_preordenes d', "a.numorden = d.numorden");
		$builder->where('a.numorden', $numorden);
		$query = $builder->get();
		return $query;
	}




	//Metodo para insertar una nueva orden 

	public function newOrden(array $numorden)
	{
		$builder = $this->dbconn("sta_ordenes");
		$query = $builder->insert($numorden);
		return $query;
	}

	//Metodo para buscar los detalles de un item en las preordenes

	public function findItemPreorden(String $itemid)
	{
		$builder = $this->dbconn("sta_detalles_preordenes");
		$builder->where("detalleid", $itemid);
		$query = $builder->get();
		return $query;
	}

	//Metodo para insertar los detalles de una orden

	public function insertarDetallesOrden(array $dataBatch)
	{
		$builder = $this->dbconn("sta_detalles_ordenes");
		$query = $builder->insertBatch($dataBatch);
		return $query;
	}

	//Metodos para los despachos

	public function obtenerAprobadas()

	{


		$builder = $this->dbconn("sta_ordenes a");
		$builder->select("a.numorden, a.fecaprob, b.statusid, b.statusnom, c.usupnom, c.usupape,pre_or.comentario");
		$builder->join("sta_status b", "a.statusid = b.statusid");
		$builder->join('sta_usuarios c', "a.ususol = c.userid");
		$builder->join('sta_preordenes pre_or', 'a.numorden = pre_or.numorden');
		$builder->where("a.statusid", "2");
		$builder->orWhere("a.statusid", "3");
		$builder->orderBy("a.fecaprob", "DESC");
		$query = $builder->get();
		return $query;
	}










	//Metodo que obtiene los detalles de la salida
	public function obtenerSalida($numorden, $status)
	{
		$builder = $this->dbconn("sta_ordenes a");
		$builder->select("a.numorden, a.fecaprob, b.fecsol, c.usupnom, c.usupape, d.deptid, d.depnom, f.dirnom, h.prodmar, h.prodmodel, g.numuniap, h.codbar,pre_or.comentario");
		$builder->join('sta_preordenes b', "a.numorden = b.numorden");
		$builder->join('sta_usuarios c', "a.ususol = c.userid");
		$builder->join("sta_departamentos d", "c.deptid = d.deptid");
		$builder->join('sta_dep_dir e', "d.deptid = e.depid");
		$builder->join('sta_direcciones f', "e.dirid = f.dirid");
		$builder->join('sta_detalles_ordenes g', "a.numorden = g.numorden");
		$builder->join("sta_productos h", "g.codbar = h.codbar");
		$builder->join('sta_preordenes pre_or', 'a.numorden = pre_or.numorden');
		if ($status == "3") {
			$builder->select("i.fecsal, i.salidaid, i.commsal,u.usupnom as nomb_despacho, u.usupape as ape_despacho,d2.depnom as dep_despacho, f2.dirnom as dir_despacho,");
			$builder->join("sta_almacen_salidas i", "a.numorden = i.numorden");
			$builder->join('sta_usuarios u', "i.usureg = u.userid");
			$builder->join("sta_departamentos d2", "u.deptid = d2.deptid");
			$builder->join('sta_dep_dir e2', "d2.deptid = e2.depid");
			$builder->join('sta_direcciones f2', "e2.dirid = f2.dirid");
			$builder->select("u2.usupnom as nomb_aprob, u2.usupape as ape_aprob, d3.deptid, d3.depnom as dep_aprob, f3.dirnom as dir_aprob");
			$builder->join('sta_ordenes a2', "a2.numorden = a.numorden");
			$builder->join('sta_usuarios u2', "a2.usuaprob = u2.userid");
			$builder->join("sta_departamentos d3", "u2.deptid = d3.deptid");
			$builder->join('sta_dep_dir e3', "d3.deptid = e3.depid");
			$builder->join('sta_direcciones f3', "e3.dirid = f3.dirid");
		}
		$builder->where("a.statusid", $status);
		$builder->where("a.numorden", $numorden);
		$query = $builder->get();
		return $query;
	}





	//Metodo para cambiar el estatus de una orden

	public function cambiarStatusOrden($numorden, $statusid)
	{
		$builder = $this->dbconn("sta_ordenes");
		$builder->where("numorden", $numorden);
		$query = $builder->update(["statusid" => $statusid]);
		return $query;
	}

	//Metodo para eliminar una orden
	public function eliminarOrden(String $numorden)
	{
		$builder = $this->dbconn("sta_ordenes");
		$builder->where("numorden", $numorden);
		$query = $builder->delete();
		return $query;
	}

	/*Metodo para consultar las solicitudes en el modulo de reportes*/
	public function consultaSolicitud(array $datos)
	{
		$builder = $this->dbconn("sta_ordenes a");
		$builder->select("a.numorden, a.fecaprob , b.fecsol, c.usupnom, c.usupape, e.dirnom, f.depnom, g.statusid, g.statusnom");
		$builder->join('sta_preordenes b', "a.numorden = b.numorden");
		$builder->join('sta_usuarios c', "a.ususol = c.userid");
		$builder->join("sta_dep_dir d", "c.deptid = d.depid");
		$builder->join('sta_direcciones e', "d.dirid = e.dirid");
		$builder->join("sta_departamentos f", "c.deptid = f.deptid");
		$builder->join("sta_status g", "a.statusid = g.statusid");
		$builder->where("a.fecaprob BETWEEN '" . $datos["fecaprob1"] . "' AND '" . $datos["fecaprob2"] . "'");
		if ($datos["dirid"] != '*' && $datos["deptid"] == "*") {
			$builder->where('e.dirid', $datos["dirid"]);
		} else if ($datos["dirid"] == '*' && $datos["deptid"] != '*') {
			$builder->where("d.depid", $datos["deptid"]);
		} else if ($datos["dirid"] == '*' and $datos["deptid"] != '*') {
			$builder->where('e.dirid', $datos["dirid"]);
			$builder->where('d.depid', $datos["deptid"]);
		}
		$builder->orderBy('a.numorden', 'ASC');
		$query = $builder->get();
		return $query;
	}

	//Metodo para consultar la solicitud
	public function consultarSolicitud(String $numorden)
	{
		$builder = $this->dbconn("sta_detalles_preordenes a");
		$builder->select("a.detalleid, b.prodmodel, a.numuni");
		$builder->join("sta_productos b", "a.codbar = b.codbar");
		$builder->where("a.numorden", $numorden);
		$query = $builder->get();
		return $query;
	}

	//Metodo para obtener los datos de la preorden
	public function datosPreorden(String $id)
	{
		$builder = $this->dbconn('sta_preordenes a');
		$builder->join('sta_usuarios b', "a.usureg = b.userid");
		$builder->join('sta_departamentos c', "b.deptid = c.deptid");
		$builder->join("sta_dep_dir d", "c.deptid = d.depid");
		$builder->join("sta_direcciones e", "d.dirid = e.dirid");
		$builder->where('a.numorden', $id);
		$query = $builder->get();
		return $query;
	}

	//Metodo para obtener los datos de una solicitud
	public function consultaOrden(String $numorden)
	{
		$builder = $this->dbconn('sta_ordenes a');
		$builder->join('sta_usuarios b', "a.ususol = b.userid");
		$builder->join('sta_departamentos c', "b.deptid = c.deptid");
		$builder->join("sta_dep_dir d", "c.deptid = d.depid");
		$builder->join("sta_direcciones e", "d.dirid = e.dirid");
		$builder->join('sta_preordenes f', "f.numorden = a.numorden");
		$builder->where('a.numorden', $numorden);
		$query = $builder->get();
		return $query;
	}
}
