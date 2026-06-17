<?php
namespace App\Models;

class Proveedores_model extends BaseModel{

    public function getAll(){
        $builder = $this->dbconn('sta_proveedores');
        $query = $builder->get();
        return $query;
    }

    public function nuevoProveedor(array $data){
        $builder = $this->dbconn('sta_proveedores');
        $query = $builder->insert($data);
        return $query;
    }

    public function getSingle(string $id){
        $builder = $this->dbconn('sta_proveedores');
        // CORRECCIÓN: getWhere está siendo deprecado en algunas versiones, 
        // usamos where()->get() para máxima estabilidad.
        $query = $builder->where('idprov', $id)->get();
        return $query;
    }

    public function buscarPorRif(string $RIF){
        $builder = $this->dbconn('sta_proveedores');

        // CORRECCIÓN PARA PHP 8.4 Y BÚSQUEDA FLEXIBLE:
        // Limpiamos el RIF de entrada de cualquier guion
        $rifLimpio = str_replace('-', '', $RIF);

        // Comparamos contra la base de datos eliminando los guiones también en la consulta
        // Esto permite encontrar "V-19933177" aunque busques "V19933177"
        $query = $builder->where("REPLACE(numrif, '-', '') =", $rifLimpio)->get();
        
        return $query;
    }

    //Metodo para actualizar un proveedor
    public function actualizaProveedor(array $data){
        $builder = $this->dbconn('sta_proveedores');
        
        // CORRECCIÓN: Estructura de actualización limpia para PHP 8.4
        $builder->set([
            "numrif"      => $data["numrif"],
            "nomprov"     => $data["nomprov"],
            "direccprov"  => $data["direccprov"],
            "telef1"      => $data["telef1"],
            "telef2"      => $data["telef2"],
            "email"       => $data["email"]
        ]);
        $builder->where("idprov", $data["idprov"]);
        
        $query = $builder->update();
        return $query;
    }
}