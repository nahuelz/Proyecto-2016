<?php

/*
 *
 *
 *
 */

class Compra extends PDORepository {

    private static $instance;

    public static function getInstance() {

        if (!isset(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    private function __construct() {

    }

    private function altaCompra($proveedor, $cuit, $fecha){
        $sql = "INSERT INTO compra (proveedor, preveedor_cuit, fecha) VALUES (?, ?, ?)";
        $values = [$proveedor, $cuit, $fecha];

        $mapper=function($row){};
        $this->queryList($sql, $values, $mapper);

        $sql = "SELECT MAX(id) AS id FROM compra";
        return $this->ultimoId($sql);
    }

    private function actualizarStock($id, $stock){
        $sql = "UPDATE producto SET stock = ? WHERE id = ?";
        $values = [$stock, $id];

        $mapper=function($row){};
        return $this->queryList($sql, $values, $mapper);
    }

    private function altaEgresoDetalle($idCompra, $idProducto, $cantidad, $precio, $tipoEgreso, $fecha){
        $sql = "INSERT INTO egreso_detalle (compra_id, producto_id, cantidad, precio_unitario, egreso_tipo_id, fecha) VALUES (?, ?, ?, ?, ?, ?)";
        $values = [$idCompra, $idProducto, $cantidad, $precio, $tipoEgreso, $fecha];

        $mapper=function($row){};
        return $this->queryList($sql, $values, $mapper);
    }

    public function alta_compra($cant, $proveedor, $cuit, $productos) {
        $factura = null;
        $tipoEgreso = 1;
        date_default_timezone_set('America/Argentina/Buenos_Aires');
        $fecha = date("Y-n-j H:i:s");

        $idCompra = $this->altaCompra($proveedor, $cuit, $fecha);
        $idCompra = $idCompra[0];
        $error = false;
        for ($i = 1; $i <= $cant; $i++) {
    
            $nombreProducto = $productos['producto'.$i];
            $cantidad = $productos['cantidad'.$i];
            $precio = $productos['precio'.$i];
            
            $idProducto = null;
            $idProd = Producto::getInstance()->getIdByNombre($nombreProducto);
            if (isset($idProd[0][0])) {
               $idProducto = $idProd[0][0];

                $stockAct = Producto::getInstance()->getStockById($idProducto);
                $stock = $stockAct[0][0] + $cantidad;
                $this->actualizarStock($idProducto, $stock);

                $this->altaEgresoDetalle($idCompra, $idProducto, $cantidad, $precio, $tipoEgreso, $fecha);
                $types = array('image/jpg', 'image/jpeg', 'image/pjpeg', 'image/png');
                $nombre_archivo = $_FILES['factura']['name'];
                $tipo_archivo = $_FILES['factura']['type'];
                $tmp_name_file = $_FILES['factura']['tmp_name'];
                if(isset($_FILES) && isset($_FILES["factura"]) && !empty($_FILES["factura"]["name"]) && !empty($_FILES["factura"]["tmp_name"])){
                    if(!in_array($tipo_archivo, $types)){
                        return Message::getMessage(25);
                    }else{
                        if(is_uploaded_file($tmp_name_file)){
                            $destino =  "uploads/".$nombre_archivo;
                            if(!is_file($destino)){  
                                move_uploaded_file($tmp_name_file, $destino);
                                chmod($destino, 0777);
                            }else{
                                return ['message' => 'El archivo ya existe'];    
                            }
                        }else{
                            return ['message' => 'El archivo no está subido a la carpeta temporal'];
                        }
                    }
                }else{
                    return ['message' => 'No se recibio el fichero'];
                }                

            } else {
                $error = true;
            }
        }
        if ($error){
            return Message::getMessage(24);
        }else{
            return Message::getMessage(23);
        }
        
    }
}