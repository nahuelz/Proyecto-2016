<?php

/*
 *
 *
 *
 */

class Categoria extends PDORepository {
    
    private static $instance;

    public static function getInstance() {

        if (!isset(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    private function __construct() {
        
    }


    public function getCategoria($idCategoria){
        $mapper = function($row){
            return $row;
        };
        return $this->queryList("SELECT * FROM categoria WHERE id=?", [$idCategoria], $mapper);
    }

    public function getCategoriaId($nombreCategoria){
        $mapper = function($row){
            return $row['id'];
        };
        return $this->queryList("SELECT * FROM categoria WHERE nombre=?", [$nombreCategoria], $mapper);
    }  

    public function listar_categorias() {
        $mapper = function($row) {
            return $row;
        };
        return $this->queryList("SELECT * FROM categoria", [], $mapper);
    }
}