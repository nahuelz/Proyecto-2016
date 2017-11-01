<?php

class CancelarPedido extends TwigView {

    public function show($args, $pedidoId, $from) {
        $args = array_merge($args,['pedidoId' => $pedidoId, 'isLogged' => true, 'from' => $from]);
        echo self::getTwig()->render('cancelar_pedido.html.twig', $args);

    }

}