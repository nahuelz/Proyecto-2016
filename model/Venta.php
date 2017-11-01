<?php

/*
 *
 *
 *
 */

class Venta extends PDORepository {
    
    private static $instance;

    public static function getInstance() {

        if (!isset(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    private function __construct() {
        
    }

    public function alta_venta($id, $cantidad) {
            // RESTAR STOCKS
            if (Producto::getInstance()->productExist($id)) {
            	$stockAct = Producto::getInstance()->getStock($id);
                $precio = Producto::getInstance()->getPrecio($id);
            	if ($stockAct[0][0] >= $cantidad){
            		$stock = $stockAct[0][0] - $cantidad;
            		Producto::getInstance()->actualizar_stock($id,$stock);
                    Ingreso::getInstance()->alta_ingreso($id, $cantidad, $precio[0][0]);
                	return Message::getMessage(16);
            	} else {
            		return Message::getMessage(17);
            	}
            } else {
            	return Message::getMessage(18);
            }
    }
}