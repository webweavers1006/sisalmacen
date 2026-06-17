<?php

namespace App\Models;

class Productos_model extends BaseModel
{

	/*Metodo que registra nuevos productos*/
	public function newProd(array $data)
	{

		$builder = $this->dbconn('sta_productos');
		$query = $builder->insert($data);
		$query2 = $this->registrarEnExistencias($data['codbar']);
		return $query2;
	}

	/*Metodo que verifica (recursivamente) si un producto existe o no*/
	public function isProductExists(String $id)
	{
		$query = $this->getSingle($id);
		if ($query->resultID->num_rows > 0) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

	/*Metodo que obtiene todos los productos*/

	public function getAllProd()
	{

		$builder = $this->dbconn('sta_productos as p');
		$builder->select(
			" c.descripcion as descripcion_p,p.id_categoria,p.stock_minimo,p.codbar,p.prodmar,p.prodmodel,case when p.borrado=0 then'ACTIVO' else 'INACTIVO ' end as borrado"
		);
		$builder->join('sta_categoria_producto c', 'c.id = p.id_categoria');
		//$builder->where(['p.borrado' => 0]);
		$query = $builder->get();
		return $query;
	}

	/*Metodo que permite obtener un solo producto*/

	public function getSingle($id)
	{
		$builder = $this->dbconn('sta_productos');
		$query = $builder->getWhere(array('codbar' => $id));
		return $query;
	}
	/*Metodo que actualiza la informacion registrada*/

	public function updateProd(array $data)
	{
		$builder = $this->dbconn('sta_productos');
		$builder->where('codbar', $data['codbar']);
		$query = $builder->update($data);
		return $query;
	}




 //Metodo para consultar los ultimos veinte casos por usuario
 public function listar_categoria()
 {
	 $db      = \Config\Database::connect();
	 $strQuery = "SELECT c.id,c.descripcion ";
	 $strQuery .= "FROM sta_categoria_producto c ";
	// $strQuery .= "where c.id= $id_categoria ";
	 $query = $db->query($strQuery);
	 $resultado = $query->getResult();
	 return $resultado;
 }

	public function getNextCodbar()
	{
		$builder = $this->dbconn('sta_productos');
		$builder->select('COALESCE(MAX(CAST(codbar AS UNSIGNED)), 0) + 1 AS next_codbar');
		$builder->where('borrado', 0);
		$query = $builder->get();
		$result = $query->getRowArray();
		return $result ? (int)$result['next_codbar'] : 1;
	}

	/**
	 * Busca un producto por su código de barras.
	 * Retorna true si existe, false si no.
	 */
	public function findProductoByCodbar(String $codbar): bool
	{
		$builder = $this->dbconn('sta_productos');
		$builder->where('codbar', $codbar);
		$builder->where('borrado', 0);
		$query = $builder->get();
		return ($query->resultID->num_rows > 0);
	}

}
