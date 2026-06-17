<?php

namespace App\Models;

class Almacen_model extends BaseModel
{

	/*Metodo que obtiene las existencias dentro del almacen*/
	public function obtenerExistencias($id_categoria=null)
	{
		$db      = \Config\Database::connect();
		$strQuery = "SELECT  distinct a.itemid, a.numexis,b.prodmar, b.prodmodel, b.codbar,b.stock_minimo, b.prodimg, b.id_categoria, c.descripcion as cat_nombre ";
		$strQuery .= "FROM sta_existencias a ";
		$strQuery .= " join sta_productos b on a.codbar = b.codbar  ";
		$strQuery .= " join sta_categoria_producto c on b.id_categoria = c.id ";
		$strQuery .= " WHERE b.borrado='0'  ";
		if ($id_categoria!=0) {
			$strQuery .= " and b.id_categoria='$id_categoria'  ";
		}
		$query = $db->query($strQuery);
		$resultado = $query->getResult();
		return $resultado;
	}

	public function obtenerExistenciasConImagen($id_categoria=null)
	{
		return $this->obtenerExistencias($id_categoria);
	}

	/*Metodo que obtiene las existencias dentro del almacen para el stock MINIMO*/
	public function obtenerExistencias_Stock_Minimo()
{
    $db = \Config\Database::connect();
    $strQuery = "SELECT distinct a.itemid, a.numexis, b.prodmar, b.prodmodel, b.codbar, b.stock_minimo ";
    $strQuery .= "FROM sta_existencias a ";
    $strQuery .= "JOIN sta_productos b ON a.codbar = b.codbar ";
    $strQuery .= "WHERE b.borrado = '0' AND a.numexis <= b.stock_minimo";
    $query = $db->query($strQuery);
    $resultado = $query->getResult();
    return $resultado;
}


	

	public function buscar_producto_existencias($buscar_codbar = null)
	{
		$db      = \Config\Database::connect();
		$strQuery = "SELECT  distinct a.itemid, a.numexis, b.prodmar, b.prodmodel, b.codbar ";
		$strQuery .= "FROM sta_existencias a ";
		$strQuery .= " join sta_productos b on a.codbar = b.codbar  ";
		$strQuery .= " WHERE b.codbar= '$buscar_codbar'";
		$query = $db->query($strQuery);
		$resultado = $query->getResult();
		return $resultado;
	}
	/*Metodo que muestra el catalogo de productos  para cargar un requerimiento*/
	public function mostrarCatologo()
	{
		$builder = $this->dbconn('sta_existencias a');
		$builder->select('a.itemid, a.numexis, b.prodmar, b.prodmodel, b.codbar');
		$builder->distinct();
		$builder->join('sta_productos b', 'a.codbar = b.codbar');
		$builder->where(['b.borrado' => 0]);
		$query = $builder->get();
		return $query;
	}
	/*Metodo que obtiene las salidas dentro del almacen*/

	public function obtenerSalidas()
	{
		$builder = $this->dbconn('sta_almacen_salidas a');
		$builder->select('a.salidaid , a.fecsal, a.numorden, b.depnom, c.usupnom , c.usupape, a.commsal,pre_or.comentario');
		$builder->join('sta_departamentos b', 'a.depdest = b.deptid');
		$builder->join('sta_usuarios c', 'a.usureg = c.userid');
		$builder->join('sta_preordenes pre_or', 'a.numorden = pre_or.numorden');
		$query = $builder->get();
		return $query;
	}
	/*Metodo que obtiene todas las entradas dentro del almacen*/
	public function obtenerEntradas()
	{
		$builder = $this->dbconn('sta_almacen_entradas a');
		$builder->select('a.numregent, a.numfac , a.provid , b.nomprov, a.fecfac, a.fecent, a.entcoment, c.usupnom, c.usupape');
		$builder->join('sta_proveedores b', 'a.provid = b.idprov');
		$builder->join('sta_usuarios c', 'a.usuregent = c.userid');
		$builder->orderBy("a.numregent", "desc");
		$query = $builder->get();
		return $query;
	}

	/*Metodo que obtiene el ultimo id de registro*/
	public function getLastID()
	{
		$builder = $this->dbconn('sta_almacen_entradas');
		$builder->selectCount('numregent');
		$query = $builder->get();
		$row = $query->getRow();
		return $row ? $row->numregent : 0;
	}
	/*Metodo que registra la entrada del almacen*/
	public function registrarEntrada(array $data)
	{
		/*Registramos la entrada*/
		$builder = $this->dbconn('sta_almacen_entradas');
		$query = $builder->insert($data);
		return $query;
	}
	/*Metodo que registra del detalle de la entrada*/
	public function registrarDetalle(array $data)
	{
		$builder = $this->dbconn('sta_entradas_detalles');
		$builder->insert($data);
		//Actualizamos las existencias
		$query = $this->actualizaExistencias($data['codbar'], intval($data['numunid']), 1);
		return $query;
	}

	// Metodo para obtener los detalles de la factura
	public function getDetalles(String $numregent)
	{
		$builder = $this->dbconn('sta_entradas_detalles a');
		$builder->select('b.prodmar, b.prodmodel, a.prodpresent, a.numunid, a.costuni, a.codbar');
		$builder->join('sta_productos b', 'a.codbar = b.codbar');
		$builder->where('regent', $numregent);
		$query = $builder->get();
		return $query;
	}

	/*Metodo que obtiene todas las entradas segun la operacion*/
	public function getDetalleEntrada(String $numregent)
	{
		$builder = $this->dbconn('sta_almacen_entradas a');
		$builder->select('a.numregent, a.numfac, b.numrif, b.nomprov, a.fecfac, a.fecent, a.entcoment, b.direccprov, b.telef1, b.telef2, b.email, c.usupnom, c.usupape');
		$builder->join('sta_proveedores b', "a.provid = b.idprov");
		$builder->join('sta_usuarios c', "a.usuregent = c.userid");
		$builder->where('a.numregent', $numregent);
		$query = $builder->get();
		return $query;
	}
	//Metodo para registrar la salida del almacen
	public function nuevoDespacho(array $data)
	{
		$builder = $this->dbconn('sta_almacen_salidas');
		$query = $builder->insert($data);
		return $query;
	}

	//Metodo para obtener solo una salida (para los reportes)
	public function getSalida(String $numorden)
	{
		$builder = $this->dbconn('sta_almacen_salidas a');
		$builder->select('a.salidaid , a.fecsal, a.numorden, b.depnom, c.usupnom , c.usupape, a.commsal');
		$builder->join('sta_departamentos b', 'a.depdest = b.deptid');
		$builder->join('sta_usuarios c', 'a.usureg = c.userid');
		$builder->where("a.numorden", $numorden);
		$query = $builder->get();
		return $query;
	}

	//Metodo para obtener las entradas por fecha
	public function obtenerEntradaPorPeriodo(String  $id_categoria,$fechainicio, String $fechafin, String $usuario, String $producto, String $proveedor)
	{
		;
		$builder = $this->dbconn("sta_almacen_entradas a");
		$builder->select("a.numregent, a.numfac, b.numrif, b.nomprov, a.fecfac, a.fecent, c.usupnom, c.usupape, a.entcoment, d.prodpresent, d.numunid, d.costuni, e.prodmar, e.prodmodel");
		$builder->join("sta_proveedores b", "a.provid = b.idprov");
		$builder->join("sta_usuarios c", "a.usuregent = c.userid");
		$builder->join("sta_entradas_detalles d", "a.numregent = d.regent");
		$builder->join("sta_productos e", "d.codbar = e.codbar");
		$builder->where("a.fecent >=", $fechainicio);
		$builder->where("a.fecent <=", $fechafin);
		if ($id_categoria!=0) {
			$builder->where('e.id_categoria', $id_categoria);
		}
		if ($usuario == '*' && $proveedor == "*" && $producto == "*") {
			$builder->orderBy("a.numregent", "ASC");
			$query = $builder->get();
			return $query;
		} else if ($usuario != '*' && $proveedor == '*' && $producto == "*") {
			$builder->where("a.usuregent", $usuario);
		} else if ($usuario == '*' && $proveedor != '*' && $producto == "*") {
			$builder->where("b.idprov", $proveedor);
		} else if ($usuario == "*" && $proveedor == "*" && $producto != "*") {
			$builder->where("e.codbar", $producto);
		} else if ($usuario != "*" && $proveedor != "*" && $producto == "*") {
			$builder->where("a.usuregent", $usuario);
			$builder->where("b.idprov", $proveedor);
		} else if ($usuario != "*" && $proveedor == "*" && $producto != "*") {
			$builder->where("a.usuregent", $usuario);
			$builder->where("e.codbar", $producto);
		} else if ($usuario == "*" && $proveedor != '*' && $producto != "*") {
			$builder->where("e.codbar", $producto);
			$builder->where("b.idprov", $proveedor);
		} else {
			$builder->where("e.codbar", $producto);
			$builder->where('b.idprov', $proveedor);
			$builder->where('a.usuregent', $usuario);
		}
		$builder->orderBy("a.numregent", "ASC");
		$query = $builder->get();
		return $query;
	}
	//Metodo para obtener las salidas por fecha
	public function obtenerSalidaPorPeriodo(String $id_categoria,$fechainicio, String $fechafin, String $usuario, String $producto)
	{
		
		$builder = $this->dbconn("sta_almacen_salidas a");
		$builder->select("a.salidaid, a.fecsal, a.numorden, b.depnom, d.usupnom, d.usupape, a.commsal, e.numuniap, f.prodmar, f.prodmodel");
		$builder->join("sta_departamentos b", "a.depdest = b.deptid");
		$builder->join("sta_ordenes c", "a.numorden = c.numorden");
		$builder->join("sta_usuarios d", "c.ususol = d.userid");
		$builder->join("sta_detalles_ordenes e", "a.numorden = e.numorden");
		$builder->join("sta_productos f", "e.codbar = f.codbar");
		$builder->where("a.fecsal >=", $fechainicio);
		$builder->where("a.fecsal <=", $fechafin);
		if ($id_categoria!=0) {
			$builder->where('f.id_categoria', $id_categoria);
		}
		if ($usuario == "*" && $producto == "*") {
			$builder->orderBy("a.numorden", "ASC");
			$query = $builder->get();
			return $query;
		} else if ($usuario != "*" && $producto == "*") {
			$builder->where("a.usureg", $usuario);
		} else if ($usuario == "*" && $producto != "*") {
			$builder->where("e.codbar", $producto);
		} else {
			$builder->where("e.codbar", $producto);
			$builder->where('a.usureg', $usuario);
		}
		$builder->orderBy("a.numorden", "ASC");
		$query = $builder->get();
		return $query;
	}

	//Metodo para el detalle de las ordenes
	public function detalleOrden(String $numorden)
	{
		$builder = $this->dbconn('sta_detalles_orden a');
		$builder->join('sta_productos b', 'a.codbar = b.codbar');
		$builder->where('a.numorden', $numorden);
		$query = $builder->get();
		return $query;
	}

	//Metodo para obtener la presentacion del producto
	public function obtenerPresentacionProd(String $codbar)
	{
		$builder = $this->dbconn('sta_entradas_detalles a');
		$builder->select('a.prodpresent');
		$builder->distinct();
		$builder->where('a.codbar', $codbar);
		$query = $builder->get();
		$row = $query->getLastRow('array');
		return $row ? $row['prodpresent'] : null;
	}

	//Metodo para obtener las unidades solicitadas en los productos
	public function obtenerUnidadesSolicitadas(String $numorden, String $codbar)
	{
		$builder = $this->dbconn('sta_detalles_preordenes');
		$builder->select('numuni');
		$builder->where('numorden', $numorden);
		$builder->where('codbar', $codbar);
		$query = $builder->get();
		$row = $query->getRowArray();
		return $row ? $row['numuni'] : null;
	}

	//Metodo para obtener el consolidado de los items solicitados en un rango de tiempo dado

	public function consolidadoPorFecha(String $id_categoria=null, $fecha_inicio, String $fecha_fin, String $tipo_consulta)
	{
		
		if ($tipo_consulta == '1') {
			$builder = $this->dbconn('sta_entradas_detalles a');
			$builder->select('cp.descripcion,a.codbar, c.prodmodel, SUM(a.numunid) AS numunid');
			$builder->join("sta_almacen_entradas b", "a.regent = b.numregent");
			$builder->join('sta_productos c', "a.codbar = c.codbar");
			$builder->join('sta_categoria_producto cp', "c.id_categoria = cp.id");
			$builder->where("b.fecent BETWEEN '" . $fecha_inicio . "' AND '" . $fecha_fin . "'");
			if ($id_categoria!=0) 
			{
			 $builder->where('c.id_categoria', $id_categoria);
			}
			$builder->groupBy("a.codbar");
			$builder->orderBy("c.prodmodel", "DESC");
			$query = $builder->get();
			return $query;
		} else if ($tipo_consulta == '2') {
			$builder = $this->dbconn('sta_detalles_ordenes a');
			$builder->select('cp.descripcion,a.codbar ,c.prodmodel, SUM(a.numuniap) AS numunid');
			$builder->join('sta_ordenes b', "a.numorden = b.numorden");
			$builder->join('sta_productos c', "a.codbar = c.codbar");
			$builder->join('sta_categoria_producto cp', "c.id_categoria = cp.id");
			$builder->where("b.fecaprob BETWEEN '" . $fecha_inicio . "' AND '" . $fecha_fin . "'");
			if ($id_categoria!=0) 
			{
			 $builder->where('c.id_categoria', $id_categoria);
			}
			$builder->groupBy("a.codbar");
			$builder->orderBy("c.prodmodel", "DESC");
			$query = $builder->get();
			return $query;
		} else if ($tipo_consulta == '3') {
			$db = \Config\Database::connect();		
			$strQuery ="";
			$strQuery .= "SELECT cp.descripcion,p.id_categoria,p.codbar,p.prodmodel,COALESCE(e.entradas,0) entradas,COALESCE(s.salidas,0) salidas ";
			$strQuery .= "FROM ";
			$strQuery .= "sta_productos p ";
			$strQuery .= "LEFT JOIN ";
			$strQuery .= "( ";
			$strQuery .= "SELECT ";
			$strQuery .= " c.id_categoria,a.codbar,c.prodmodel,SUM(a.numunid) AS entradas ";
			$strQuery .= "FROM ";
			$strQuery .= "sta_entradas_detalles a "; 
			$strQuery .= "JOIN ";
			$strQuery .= "sta_productos c ON a.codbar = c.codbar ";
			$strQuery .= "JOIN ";
			$strQuery .= "sta_almacen_entradas b ON a.regent = b.numregent ";
			$strQuery .= "WHERE b.fecent BETWEEN  '$fecha_inicio' AND  '$fecha_fin'  ";
			$strQuery .= "GROUP BY ";
			$strQuery .= "a.codbar ";
			$strQuery .= " HAVING entradas <> 0   ";
			$strQuery .= "ORDER BY c.prodmodel DESC ";
			$strQuery .= ") as e ON p.codbar=e.codbar ";
			$strQuery .= "LEFT JOIN ";
			$strQuery .= "( ";
			$strQuery .= "SELECT ";
			$strQuery .= " c.id_categoria,a.codbar,c.prodmodel,SUM(a.numuniap) AS salidas ";
			$strQuery .= "FROM ";
			$strQuery .= "sta_detalles_ordenes a "; 
			$strQuery .= "JOIN ";
			$strQuery .= "sta_ordenes b ON a.numorden = b.numorden ";
			$strQuery .= "JOIN ";
			$strQuery .= "sta_productos c ON a.codbar = c.codbar ";
			$strQuery .= "WHERE b.fecaprob BETWEEN  '$fecha_inicio' AND  '$fecha_fin'  ";
			$strQuery .= "GROUP BY ";
			$strQuery .= "a.codbar ";
			$strQuery .= " HAVING salidas <> 0 ";
			$strQuery .= "ORDER BY c.prodmodel DESC ";
			$strQuery .= ") AS s ON p.codbar=s.codbar ";
			$strQuery .= "JOIN ";
			$strQuery .= "sta_categoria_producto cp ON p.id_categoria = cp.id ";
			if ($id_categoria!=0) 
			{
			 $strQuery .= " and p.id_categoria= ' $id_categoria' ";
			}
			$query = $db->query($strQuery);
	    	$resultado=$query->getResult();
	    	return $resultado;	  
								
		}
		
	}

	//Metodo para obtener el consolidado de los productos en un tiempo dado
	public function obtenerConsolidadoPorDepartamento(String $fecha_inicio, String $fecha_fin, String $direccion, String $departamento)
	{
		$builder = $this->dbconn('sta_detalles_ordenes a');
		$builder->select('a.codbar ,c.prodmodel, SUM(a.numuniap) AS numunid');
		$builder->join('sta_ordenes b', "a.numorden = b.numorden");
		$builder->join('sta_productos c', "a.codbar = c.codbar");
		//Casos en el cual se puede solicitar datos
		//Si son todas las direcciones y departamentos
		if ($direccion == '*' and $departamento == '*') {
			$builder->where("b.fecaprob BETWEEN '" . $fecha_inicio . "' AND '" . $fecha_fin . "'");
			$builder->groupBy("a.codbar");
			$builder->orderBy("c.prodmodel", "DESC");
			$query = $builder->get();
			return $query;
		}
		//Si solo es la direccion con todos sus departamentos
		else if ($direccion != '*' and $departamento == '*') {
			$builder->join('sta_usuarios d', "b.ususol = d.userid");
			$builder->join("sta_dep_dir e", "d.deptid = e.depid");
			$builder->join("sta_direcciones f", "e.dirid = f.dirid");
			$builder->where("b.fecaprob BETWEEN '" . $fecha_inicio . "' AND '" . $fecha_fin . "'");
			$builder->where('f.dirid', $direccion);
			$builder->groupBy("a.codbar");
			$builder->orderBy("c.prodmodel", "DESC");
			$query = $builder->get();
			return $query;
		}
		//Si es la direccion con un departamento en especifico
		else if ($direccion != '*' and $departamento != '*') {
			$builder->join('sta_usuarios d', "b.ususol = d.userid");
			$builder->join("sta_dep_dir e", "d.deptid = e.depid");
			$builder->join("sta_direcciones f", "e.dirid = f.dirid");
			$builder->join('sta_departamentos g', "e.depid = g.deptid");
			$builder->where("b.fecaprob BETWEEN '" . $fecha_inicio . "' AND '" . $fecha_fin . "'");
			$builder->where('f.dirid', $direccion);
			$builder->where('g.deptid', $departamento);
			$builder->groupBy("a.codbar");
			$builder->orderBy("c.prodmodel", "DESC");
			$query = $builder->get();
			return $query;
		}
	}



/*Metodo que obtiene  los despachos del almacen*/
public function listar_reporte_despachos($desde=null,$hasta=null,$direccion=null)
{

$db = \Config\Database::connect();
$strQuery = " SELECT o.numorden, o.statusid, o.ususol, dire.dirnom, e.statusnom, s.fecsal , ";
$strQuery .= "DATE_FORMAT(s.fecsal, '%d/%m/%Y') AS fecsalidas, ";
$strQuery .= "CONCAT(u.usupnom,'',u.ususnom,'',u.usupape,'',u.ususape) AS nombre ";
$strQuery .= "FROM sta_ordenes AS o ";
$strQuery .= "JOIN sta_almacen_salidas AS s ON o.numorden = s.numorden ";
$strQuery .= "JOIN sta_status AS e ON e.statusid = o.statusid  ";
$strQuery .= "JOIN sta_usuarios AS u ON u.userid = o.ususol ";
$strQuery .= "JOIN sta_dep_dir AS d ON d.depid = u.deptid  ";
$strQuery .= "JOIN sta_direcciones AS dire ON dire.dirid = d.dirid ";
$strQuery .= "WHERE o.statusid = '3' ";
if ($desde!='null' and $hasta!='null' ) {
    $strQuery .= " AND s.fecsal  BETWEEN '$desde' AND '$hasta'";
}
if ($direccion!='null' and $direccion!=0 ) {
    $strQuery .= " AND dire.dirid= '$direccion'";
}


$query = $db->query($strQuery);
$resultado=$query->getResult();
return $resultado;	  
}








}
