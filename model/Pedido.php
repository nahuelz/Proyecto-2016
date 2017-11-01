<?php

class Pedido extends PDORepository
{

    private static $instance;

    public static function getInstance()
    {

        if (!isset(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    private function __construct(){

    }


    public function setEstado ($estado, $id){
        $sql = 'UPDATE pedido SET estado_id = ? WHERE id = ?';
        $values = [$estado, $id];
        $mapper = function($row){};
        $this->queryList($sql, $values,$mapper);
    }
    public function setMotivo($motivo_cacelacion, $perdidoId){
        $sql = 'UPDATE pedido SET motivo_cancelacion = ? WHERE id = ?';
        $values = [$motivo_cacelacion, $perdidoId];
        $mapper = function($row){};
        $this->queryList($sql, $values,$mapper);
    }
    public function esMiPedido($userId, $pedidoId){
        $sql = 'SELECT * FROM pedido WHERE usuario_id=? AND id = ?';
        $values = [$userId, $pedidoId];
        $mapper = function($row){
            return $row;
        };
        $answer = $this->queryList($sql, $values,$mapper);
        return (count ($answer>0));
    }
    public function getHora($pedidoId){
        $sql = "SELECT fecha_alta FROM pedido WHERE id = ?";
        $values = [$pedidoId];
        $mapper = function ($row){
          return $row['fecha_alta'];
        };

        return $this->queryList($sql, $values, $mapper);
    }

    public function obtenerDetalle($id){
        $sql = "SELECT * FROM pedido_detalle WHERE pedido_id=?";
        $values = [$id];
        $mapper = function ($row){
            return $row;
        };

        return $this->queryList($sql, $values, $mapper);
    }

    public function obtenerMisPedidos($id){
        $sql = "SELECT * FROM pedido WHERE usuario_id=? ORDER BY fecha_alta DESC";
        $values = [$id];
        $mapper = function($row){
            return $row;
        };
        return $this->queryList($sql, $values, $mapper);
    }

    public function obtenerPedidos(){
        $sql = "SELECT * FROM pedido ORDER BY fecha_alta DESC";
        $mapper = function($row){
            return $row;
        };
        return $this->queryList($sql, [], $mapper);
    }

    public function obtenerMisPedidosPorFecha($id, $fecha){
        $sql = "SELECT * FROM pedido WHERE usuario_id=? AND fecha_alta LIKE ? ORDER BY fecha_alta DESC";
        $fecha = $fecha.'%';
        $values = [$id, $fecha];
        $mapper = function($row){
            return $row;
        };
        return $this->queryList($sql, $values, $mapper);
    }
    public function eliminar($id){
        $sql = "DELETE FROM pedido WHERE id = ?";
        $value = [$id];

        $this->queryList($sql, $value, []);
    }

    public function cancelar($id){
        $sql = "UPDATE pedido SET estado_id = ? WHERE id= ?";
        $values = [1, $id];
        $mapper = function($row){};

        $this->queryList($sql, $values, $mapper);

    }

    public function altaPedidoDetalle($pedidoId, $productoId, $cantidad){
        $sql = "INSERT INTO pedido_detalle (producto_id, cantidad, pedido_id) VALUES (?, ?, ?)";
        $values = [$productoId, $cantidad, $pedidoId];

        $this->queryList($sql, $values, []);


    }

    public function altaPedido ($estadoId, $fecha, $usuarioId, $observacion)
    {
        $sql = "INSERT INTO pedido (estado_id, fecha_alta, usuario_id, observacion) VALUES (?, ?, ?, ?)";
        $values = [$estadoId, $fecha, $usuarioId, $observacion];
        $mapper=function($row){};
        $this->queryList($sql, $values, $mapper);
    }

    public function ultimoPedido (){
        $sql = "SELECT MAX(id) AS id FROM pedido";
        return $this->ultimoId($sql);
    }
}