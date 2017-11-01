<?php

/*
 *
 *
 *
 */

class Configuracion extends PDORepository {
    
    private static $instance;

    public static function getInstance() {

        if (!isset(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    private function __construct() {
        
    }

    public function modificar_configuracion($titulo, $descripcion, $email, $cant_elementos, $tiempoCancelacion, $sitio, $mensaje){
        $mapper=function($row){};
        $config = $this->obtenerConfiguracion();
        foreach ($config as $c) {
            switch ($c['clave']) {
                case 'titulo':
                    $sql = "UPDATE configuracion SET valor = ? WHERE clave= ?";
                    $this->queryList($sql, [$titulo, $c['clave']], $mapper);
                    break;
                case 'descripcion':
                    $sql = "UPDATE configuracion SET valor = ? WHERE clave= ?";
                    $this->queryList($sql, [$descripcion, $c['clave']], $mapper);
                    break;
                case 'email':
                    $sql = "UPDATE configuracion SET valor = ? WHERE clave= ?";
                    $this->queryList($sql, [$email, $c['clave']], $mapper);
                    break;
                case 'cant_elementos':
                    $sql = "UPDATE configuracion SET valor = ? WHERE clave= ?";
                    $this->queryList($sql, [$cant_elementos, $c['clave']], $mapper);
                    break;
                case 'sitio':
                    $sql = "UPDATE configuracion SET valor = ? WHERE clave= ?";
                    $this->queryList($sql, [$sitio, $c['clave']], $mapper);
                    break;
                case 'mensaje':
                    $sql = "UPDATE configuracion SET valor = ? WHERE clave= ?";
                    $this->queryList($sql, [$mensaje, $c['clave']], $mapper);
                    break;
                case 'tiempoCancelacion':
                    $sql = "UPDATE configuracion SET valor = ? WHERE clave= ?";
                    $this->queryList($sql, [$tiempoCancelacion, $c['clave']], $mapper);
                    break;
            }
        }
        return Message::getMessage(14);
    }


    public function obtenerConfiguracion(){
        $mapper = function($row){
            return $row;
        };
        return $this->queryList("SELECT * FROM configuracion", [], $mapper);
    }
}