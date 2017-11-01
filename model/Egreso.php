<?php

/*
 *
 *
 *
 */

class Egreso extends PDORepository
{

    private static $instance;

    public static function getInstance()
    {

        if (!isset(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    private function __construct()
    {

    }

    public function getEgresosEnFecha($fecha){
        return $this->query("SELECT SUM(cantidad*precio_unitario) FROM egreso_detalle WHERE fecha LIKE ?;", ["$fecha%"]);
    }

    public function getTotalEgreso($inicio = null, $fin = null)
    {
        $mapper = function ($row) {
            return $row['totalIngreso'];
        };
        if ($inicio == null) {
            return $this->queryList("SELECT SUM(cantidad*precio_unitario) as totalIngreso FROM egreso_detalle;", [], $mapper);
        }else{
            return $this->queryList("SELECT SUM(cantidad*precio_unitario) as totalIngreso FROM egreso_detalle WHERE fecha BETWEEN ? AND ?;", [$inicio, $fin], $mapper);
        }

    }

    public function getEgresos(){
        $mapper = function ($row){
            return $row;
        };
        return $this->queryList("SELECT CAST(fecha AS DATE) as dia, SUM(cantidad*precio_unitario) as egreso FROM egreso_detalle GROUP by CAST(fecha AS DATE);", [], $mapper);
    }

    public function getEgresosEntreFechas($inicio, $fin){
        $mapper = function($row){
            return $row;
        };
        return $this->queryList("SELECT CAST(fecha AS DATE) as dia, cantidad*precio_unitario as egreso FROM egreso_detalle WHERE fecha BETWEEN ? AND ? GROUP by CAST(fecha AS DATE);", [$inicio, $fin], $mapper);
    }


    public function cant_total_elementos() {
        $mapper = function($row){
            return $row['COUNT(id)'];
        };

        return $this->queryList("SELECT COUNT(id) FROM egreso_detalle", [], $mapper);
    }

    public function listar_egresos($cantElementos=null, $pagina=null) {
        $mapper = function($row) {
            return $row;
        };

        if ($cantElementos != null){
            $desde = ($pagina - 1) * $cantElementos;

            return $answer = $this->queryList("SELECT * FROM egreso_detalle LIMIT $desde,$cantElementos", [], $mapper);
        }else{
            return $answer = $this->queryList("SELECT * FROM egreso_detalle",[],$mapper);
        }
    }
    
    public function eliminar_egreso($egreso_id){
        $sql="DELETE FROM egreso_detalle WHERE id=?";
        $value=[$egreso_id];
        $mapper=function($row){};
        $this->queryList($sql,$value,$mapper);
        return Message::getMessage(13);
    }    

}