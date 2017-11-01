<?php

/*
 *
 *
 *
 */

class Producto extends PDORepository {
    
    private static $instance;

    public static function getInstance() {

        if (!isset(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    private function __construct() {
        
    }

    public function actualizar_stock($idProd, $stock){
        $sql = "UPDATE producto SET stock = ? WHERE id = ?";
        $values = [$stock, $idProd];
        $mapper = function($row){};
        $this->queryList($sql, $values, $mapper);

    }
    public function alta_producto($nombre, $marca, $codigo_barra, $stock, $stock_minimo, $idCategoria, $proveedor, $precio_venta_unitario, $descripcion, $fecha_alta){
        if(!$this->productExist($codigo_barra)){
            $sql = "INSERT INTO producto (nombre, marca, codigo_barra, stock, stock_minimo, categoria_id, proveedor, precio_venta_unitario, descripcion, fecha_alta) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $values = [$nombre, $marca, $codigo_barra, $stock, $stock_minimo, $idCategoria, $proveedor, $precio_venta_unitario, $descripcion, $fecha_alta];
            $mapper=function($row){};
            $this->queryList($sql, $values, $mapper);
            return Message::getMessage(6);
        }
        return Message::getMessage(7);
    }

    public function modificar_producto($id, $nombre, $marca, $codigo_barra, $stock, $stock_minimo, $idCategoria, $proveedor, $precio_venta_unitario, $descripcion){
        if(!$this->productExist($codigo_barra)){
            $sql = "UPDATE producto SET nombre = ?, marca = ?, codigo_barra = ?, stock = ?, stock_minimo = ?, categoria_id = ?, proveedor = ?, precio_venta_unitario = ?, descripcion = ? WHERE id = ?";
            $values = [$nombre, $marca, $codigo_barra, $stock, $stock_minimo, $idCategoria, $proveedor, $precio_venta_unitario, $descripcion, $id];
            $mapper=function($row){};
            $this->queryList($sql, $values, $mapper);
            return Message::getMessage(9);
        }
        return Message::getMessage(7);
    }

    public function getProducto($productoId){
        $mapper = function($row){
            return $row;
        };
        return $this->queryList("SELECT * FROM producto WHERE id=?", [$productoId], $mapper);
    }

    public function getProductByName($nombre){
        $mapper = function($row){
            return $row;
        };
        return $this->queryList("SELECT * FROM producto WHERE nombre=?", [$nombre], $mapper);
    }

    public function getId($cod){
        $mapper = function($row){
            return $row;
        };
        return $this->queryList("SELECT id FROM producto WHERE codigo_barra=?", [$cod], $mapper);
    }

    public function getStock($id){
        $mapper = function($row){
            return $row;
        };
        return $this->queryList("SELECT stock FROM producto WHERE id=?", [$id], $mapper);
    }

    public function getNombre($id){
        $mapper = function($row){
            return $row;
        };
        return $this->queryList("SELECT nombre FROM producto WHERE id=?", [$id], $mapper);
    }

    public function getPrecio($id){
        $mapper = function($row){
            return $row;
        };
        return $this->queryList("SELECT precio_venta_unitario FROM producto WHERE id=?", [$id], $mapper);
    }

    public function getCodigoBarra($id){
        $mapper = function($row){
            return $row;
        };
        return $this->queryList("SELECT codigo_barra FROM producto WHERE id=?", [$id], $mapper);
    }

    public function getStockById($id){
        $mapper = function($row){
            return $row;
        };
        return $this->queryList("SELECT stock FROM producto WHERE id=?", [$id], $mapper);
    }

    public function getIdByNombre($nombre){
        $mapper = function($row){
            return $row;
        };
        return $this->queryList("SELECT id FROM producto WHERE nombre=?", [$nombre], $mapper);
    }

    public function productExist($id) {
        $mapper = function($row) {
            return $row['nombre'];
        };
        
        $answer = $this->queryList("SELECT * FROM producto WHERE id=?", [$id], $mapper);
        
        return (count($answer) > 0);
    }

    public function productExistId($id) {
        $mapper = function($row) {};
        $answer = $this->queryList("SELECT * FROM producto WHERE id=?", [$id], $mapper);
        return (count($answer) > 0);
    }

    public function listar_productos($cantElementos=null, $pagina=null) {
        $mapper = function($row) {
            return $row;
        };
        if ($cantElementos != null){
            $desde = ($pagina - 1) * $cantElementos;

            return $answer = $this->queryList("SELECT * FROM producto LIMIT $desde,$cantElementos", [], $mapper);
        }else{
            return $answer = $this->queryList("SELECT * FROM producto",[],$mapper);
        }

    }

    public function listar_productos_con_stock() {
        $mapper = function($row) {
            return $row;
        };
        return $answer = $this->queryList("SELECT * FROM producto WHERE stock > stock_minimo",[],$mapper);

    }

    public function listar_productos_faltantes($cantElementos, $pagina) {
        $mapper = function($row) {
            return $row;
        };

        $desde = ($pagina - 1) * $cantElementos;
        
        return $answer = $this->queryList("SELECT * FROM producto WHERE stock = 0 LIMIT $desde,$cantElementos", [], $mapper);
    }

    public function listar_productos_stockMin($cantElementos, $pagina) {
        $mapper = function($row) {
            return $row;
        };

        $desde = ($pagina - 1) * $cantElementos;

        return $answer = $this->queryList("SELECT * FROM producto WHERE stock > 0 AND stock <= stock_minimo LIMIT $desde,$cantElementos", [], $mapper);
    }

    public function verificarIntegridad ($id){
        $sql="SELECT * FROM egreso_detalle WHERE producto_id = ?";
        $value=[$id];
        $mapper=function($row){};
        $answer = $this->queryList($sql,$value,$mapper);
        if (count ($answer) > 0 ){
            return false;
        }else{
            $sql="SELECT * FROM ingreso_detalle WHERE producto_id = ?";
            $value=[$id];
            $mapper=function($row){};
            $answer = $this->queryList($sql,$value,$mapper);
            if (count ($answer) > 0 ) {
                return false;
            }
        }
        return true;
    }

    public function eliminar_producto($id){
        $sql="DELETE FROM producto WHERE id=?";
        $value=[$id];
        $mapper=function($row){};
        $this->queryList($sql,$value,$mapper);
    }

    public function cant_total_elementos(){
        $mapper = function($row){
            return $row['COUNT(id)'];
        };

        return $this->queryList("SELECT COUNT(id) FROM producto", [], $mapper);
    }

    public function cant_total_elementos_faltantes(){
        $mapper = function($row){
            return $row['COUNT(id)'];
        };

        return $this->queryList("SELECT COUNT(id) FROM producto WHERE stock = 0", [], $mapper);
    }

    public function cant_total_elementos_stockMin(){
        $mapper = function($row){
            return $row['COUNT(id)'];
        };

        return $this->queryList("SELECT COUNT(id) FROM producto WHERE stock > 0 AND stock <= stock_minimo", [], $mapper);
    }
    
    public function getNombres($argumento){
        $productos = [];
        foreach ($argumento as $arg) {
            $id_prod = $arg["producto_id"];
            $prod_name = $this->getNombre($id_prod);
            $productos[] = ($prod_name);
        }       
        $long = count($argumento);
        for ($i=0; $i < $long; $i++) { 
            $argumento[$i]['nombreProducto'] = $productos[$i];

        }
        return $argumento;
    }


    public function stockDisponible($id){
        $mapper = function($row) {};
        $sql = "SELECT * FROM producto WHERE id = ? and stock > stock_minimo";
        $value = [$id];
        $answer = $this->queryList($sql, $value, $mapper);
        return (count($answer) > 0);

    }

    public function getAll(){
        $mapper = function($row) {return $row;};
        $sql = "SELECT * FROM proucto";
        return $this->queryList($sql,[],$mapper);
    }
}