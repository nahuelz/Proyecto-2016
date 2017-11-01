<?php

/*
 *
 *
 *
 */

class Ingreso extends PDORepository {
    
    private static $instance;

    public static function getInstance() {

        if (!isset(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    private function __construct() {
        
    }

    public function getIngresosEnFecha($fecha){
        return $this->query("SELECT SUM(cantidad*precio_unitario) FROM ingreso_detalle WHERE fecha LIKE ?;", ["$fecha%"]);
    }

    public function productosEnFechas ($fechaInicio, $fechaFin){
        $mapper = function ($row){
            return $row;
        };

        if ($fechaInicio != null){
            return $this->queryList("SELECT SUM(cantidad) as cantidad, nombre
                                    FROM ingreso_detalle
                                    INNER JOIN producto
                                    ON ingreso_detalle.producto_id = producto.id 
                                    WHERE ingreso_detalle.fecha 
                                    BETWEEN ? AND ?
                                    GROUP BY ingreso_detalle.producto_id;", [$fechaInicio, $fechaFin], $mapper);
        }else{
             return $this->queryList("SELECT SUM(cantidad),nombre
                                    FROM ingreso_detalle
                                    INNER JOIN producto
                                    ON ingreso_detalle.producto_id = producto.id
                                    GROUP BY ingreso_detalle.producto_id;", [], $mapper);
        }
    }

    public function getIngresos(){
        $mapper = function ($row){
            return $row;
        };
        return $this->queryList("SELECT CAST(fecha AS DATE) as dia, SUM(cantidad*precio_unitario) as ingreso FROM ingreso_detalle GROUP by CAST(fecha AS DATE);", [], $mapper);
    }

    public function getTotalIngreso($inicio = null, $fin = null)
    {
        $mapper = function ($row) {
            return $row['totalIngreso'];
        };
        if ($inicio == null) {
            return $this->queryList("SELECT SUM(cantidad*precio_unitario) as totalIngreso FROM ingreso_detalle;", [], $mapper);
        }else{
            return $this->queryList("SELECT SUM(cantidad*precio_unitario) as totalIngreso FROM ingreso_detalle WHERE fecha BETWEEN ? AND ?;", [$inicio, $fin], $mapper);
        }

    }

    public function getIngreso($nombre){
        $mapper = function($row){
            return $row['id'];
        };
        return $this->queryList("SELECT * FROM ingreso_tipo WHERE nombre=?", [$nombre], $mapper);
    }

    public function getIngresosEntreFechas($inicio, $fin){
        $mapper = function($row){
            return $row;
        };
        return $this->queryList("SELECT CAST(fecha AS DATE) as dia, SUM(cantidad*precio_unitario) as ingreso FROM ingreso_detalle WHERE fecha BETWEEN ? AND ? GROUP by CAST(fecha AS DATE);", [$inicio, $fin], $mapper);
    }

    public function eliminar_ingreso($ingreso_id){
        $sql="DELETE FROM ingreso_detalle WHERE id=?";
        $value=[$ingreso_id];
        $mapper=function($row){};
        $this->queryList($sql,$value,$mapper);
        return Message::getMessage(13);
    }

    public function listar_tipos_ingresos() {
        $mapper = function($row) {
            return $row;
        };
        return $this->queryList("SELECT * FROM ingreso_tipo", [], $mapper);
    }


    public function listar_ingresos($cantElementos=null, $pagina=null) {
        $mapper = function($row) {
            return $row;
        };

        if ($cantElementos != null){
            $desde = ($pagina - 1) * $cantElementos;

            return $answer = $this->queryList("SELECT * FROM ingreso_detalle ORDER BY fecha DESC LIMIT $desde,$cantElementos", [], $mapper);
        }else{
            return $answer = $this->queryList("SELECT * FROM ingreso_detalle ORDER BY fecha DESC",[],$mapper);
        }
    }



    public function alta_ingreso($id, $cantida, $precio){
        $id_tipo_ingreso = 1;
        $producto_id = $id;
        $precio_unitario = $precio;
        $cantidad = $cantida;
        $descripcion = "";
        
        date_default_timezone_set('America/Argentina/Buenos_Aires');
        $fecha = date("Y-n-j H:i:s"); 
        
        $mapper = function($row){};
        $sql = "INSERT INTO ingreso_detalle (ingreso_tipo_id, producto_id, cantidad, precio_unitario, descripcion, fecha) VALUES (?, ?, ?, ?, ?, ?)";
        $values = [$id_tipo_ingreso, $producto_id, $cantidad, $precio_unitario, $descripcion, $fecha];
        $this->queryList($sql, $values, $mapper);
        return Message::getMessage(3);
    }

    public function cant_total_elementos() {
        $mapper = function($row){
            return $row['COUNT(id)'];
        };

        return $this->queryList("SELECT COUNT(id) FROM ingreso_detalle", [], $mapper);
    }

    public function getVentas($cantElementos=null, $pagina=null) {
        $mapper = function($row) {
            return $row;
        };

        if ($cantElementos != null){
            $desde = ($pagina - 1) * $cantElementos;

            return $answer = $this->queryList("SELECT producto_id, SUM(cantidad) FROM ingreso_detalle  GROUP BY producto_id", [], $mapper);
        }else{
            return $answer = $this->queryList("SELECT producto_id, SUM(cantidad) FROM ingreso_detalle GROUP BY producto_id",[],$mapper);
        }
    }

    public function getVentasEntreFechas($cantElementos=null, $pagina=null, $fechaInicio, $fechaFin) {
        $mapper = function($row) {
            return $row;
        };
        $values = [$fechaInicio, $fechaFin];
        if ($cantElementos != null){
            $desde = ($pagina - 1) * $cantElementos;
            
            return $answer = $this->queryList("SELECT producto_id, SUM(cantidad) FROM ingreso_detalle WHERE fecha BETWEEN ? AND ? GROUP BY producto_id", $values, $mapper);
        }else{
            return $answer = $this->queryList("SELECT producto_id, SUM(cantidad) FROM ingreso_detalle WHERE fecha BETWEEN ? AND ? GROUP BY producto_id", $values, $mapper);
        }
    }

    public function getPrimerFechaVenta(){
        $mapper = function($row){
            return $row['fecha'];
        };

        return $this->queryList("SELECT fecha, MIN(fecha) FROM ingreso_detalle", [], $mapper);        
    }
}