<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

abstract class PDORepository {

    const USERNAME = "root";
    const PASSWORD = "";
	const HOST ="localhost";
	const DB = "grupo41";


    private function getConnection()
    {
        $u=self::USERNAME;
        $p=self::PASSWORD;
        $db=self::DB;
        $host=self::HOST;
        $connection = new PDO("mysql:dbname=$db;host=$host", $u, $p);
        return $connection;
    }

    protected function queryList($sql, $args, $mapper)
    {
        $connection = $this->getConnection();
        $stmt = $connection->prepare($sql);
        $stmt->execute($args);
        $list = [];
        while($element = $stmt->fetch()){
            $list[] = $mapper($element);
        }
        return $list;
    }

    protected function query ($sql, $args){
        $cn = $this->getConnection();
        $consulta = $cn->prepare($sql);
        $consulta->execute($args);
        $res= $consulta->fetch();
        return $res;
    }

    protected function ultimoId($sql)
    {
        $connection = $this->getConnection();
        $stmt = $connection->prepare($sql);
        $stmt->execute();
        return $stmt->fetch();
    }

}