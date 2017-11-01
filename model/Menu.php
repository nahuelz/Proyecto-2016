<?php

/*
 *
 *
 *
 */

class Menu extends PDORepository
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

    public function getMenu($fecha){
        $sql = "SELECT * FROM menu_del_dia WHERE fecha = ?";
        $values = [$fecha];
        $mapper = function($row) {
            return $row;
        };
        return $this->queryList($sql, $values, $mapper);
    }
    public function eliminar($id)
    {
        $sql = "DELETE FROM menu_del_dia WHERE id=?";
        $value = [$id];
        $this->queryList($sql, $value, []);
    }

    public function alta_menu($productoId, $fecha, $habilitado)
    {
        $sql = "INSERT INTO menu_del_dia (producto_id, fecha, habilitado) VALUES (?,?,?)";
        $value = [$productoId, $fecha, $habilitado];
        $this->queryList($sql, $value, []);

    }

    public function esValido($id, $fecha)
    {
        if ($id!= null) {
            $produtoId = $id[0][0];
            if (Producto::getInstance()->productExistId($produtoId)) {
                if (!$this->estaEnElMenu($produtoId, $fecha)) {
                    if (Producto::getInstance()->stockDisponible($produtoId)) {
                        return true;
                    }
                }
            }
        }
        return false;
    }

    public function estaEnElMenu($productoId, $fecha)
    {
        $mapper = function($row) {};
        $answer = $this->queryList("SELECT * FROM menu_del_dia WHERE fecha=? AND producto_id=?", [$fecha, $productoId], $mapper);
        return (count($answer) > 0);
    }

    public function cant_total_elementos($fecha)
    {
        $mapper = function ($row) {
            return $row['COUNT(id)'];
        };

        return $this->queryList("SELECT COUNT(id) FROM menu_del_dia WHERE fecha=?", [$fecha], $mapper);
    }

    public function listar_menus($cantElementos = null, $pagina = null, $fecha)
    {
        $mapper = function ($row) {
            return $row;
        };
        if ($cantElementos != null) {
            $desde = ($pagina - 1) * $cantElementos;

            return $answer = $this->queryList("SELECT * FROM menu_del_dia WHERE fecha = ? ORDER BY fecha DESC LIMIT $desde,$cantElementos", [$fecha], $mapper);
        } else {
            return $answer = $this->queryList("SELECT * FROM menu_del_dia WHERE fecha = ? ORDER BY fecha DESC", [$fecha], $mapper);
        }
    }

    public function menuDelDia(){
        date_default_timezone_set('America/Argentina/Buenos_Aires');
        $fecha = date("Y-n-j");
        $mapper = function ($row) {
            return $row['producto_id'];
        };
        $productos = $this->queryList("SELECT producto_id FROM menu_del_dia WHERE fecha = ?", [$fecha], $mapper);
        if ((count($productos) > 0)){
            $result = '';
            foreach ($productos as &$prodId) {
                $nombre = Producto::getInstance()->getNombre($prodId);
                $precio = Producto::getInstance()->getPrecio($prodId);
                $result = $result . ' - ' . $nombre[0][0] . ' $' . $precio[0][0];
            }

            return ('Los productos del menu del dia son: ' .$result);
        }else{
            return 'Lo sentimos, aun no se selecciono el menu para el dia de hoy.';
        }
    }

    public function menuDelDiaMañana(){
        date_default_timezone_set('America/Argentina/Buenos_Aires');
        $fecha = date('Y-m-j');
        $nuevafecha = strtotime ( '+1 day' , strtotime ( $fecha ) ) ;
        $fecha = date ( 'Y-m-j' , $nuevafecha );
        $mapper = function ($row) {
            return $row['producto_id'];
        };
        $productos = $this->queryList("SELECT producto_id FROM menu_del_dia WHERE fecha = ?", [$fecha], $mapper);
        if ((count($productos) > 0)){
            $result = '';
            foreach ($productos as &$prodId) {
                $nombre = Producto::getInstance()->getNombre($prodId);
                $precio = Producto::getInstance()->getPrecio($prodId);
                $result = $result . ' - ' . $nombre[0][0] . ' $' . $precio[0][0];
            }

            return ('Los productos del menu del dia de manana son: ' .$result);
        }else{
            return 'Lo sentimos, aun no se selecciono el menu para el dia de manana.';
        }
    }


}
