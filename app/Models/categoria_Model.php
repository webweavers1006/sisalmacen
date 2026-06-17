<?php

namespace App\Models;

use CodeIgniter\Model;

class categoria_Model extends BaseModel
{
	// //Metodo para insertar una Categoria
	public function add_categoria($categorias)
	{
		$builder = $this->dbconn("sta_categoria_producto");
		$query = $builder->insert($categorias);
		return $query;
	}

	//Metodo para actualizar una Direccion Administrativa
	public function editCategoria($categorias)
	{
		$builder = $this->dbconn("sta_categoria_producto");
		$query = $builder->update($categorias, 'id = ' . $categorias["id"]);
		return $query;
	}

	

	public function listar_categorias()
	{
 
	   //$builder = $this->dbconn('historial_clinico.consultas as hc');
	   $db      = \Config\Database::connect();
	   $strQuery ="";
	   $strQuery .="SELECT";
	   $strQuery .=" cp.id,cp.descripcion,case when cp.borrado='0' then 'Activo' else 'Inactivo' end as borrado ";  
	   $strQuery .="FROM ";
	   $strQuery .="  sta_categoria_producto as cp ";
	   $strQuery  =$strQuery . " where cp.borrado=0";
	   $query = $db->query($strQuery);
	   $resultado=$query->getResult(); 
	   return $resultado;
	   //return  $strQuery;
	}

	public function listar_categorias_sin_filtro()
	{
 
	   //$builder = $this->dbconn('historial_clinico.consultas as hc');
	   $db      = \Config\Database::connect();
	   $strQuery ="";
	   $strQuery .="SELECT";
	   $strQuery .=" cp.id,cp.descripcion,case when cp.borrado='0' then 'Activo' else 'Inactivo' end as borrado ";  
	   $strQuery .="FROM ";
	   $strQuery .="  sta_categoria_producto as cp ";
	   $query = $db->query($strQuery);
	   $resultado=$query->getResult(); 
	   return $resultado;
	   //return  $strQuery;
	}



}
