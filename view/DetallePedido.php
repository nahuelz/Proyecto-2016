<?php

class DetallePedido extends TwigView {

    public function show($detalle, $productos,  $args, $from) {
        $args = array_merge($args, ['from' => $from, 'isLogged'=> true, 'productos' => $productos, 'detalle' => $detalle]);
        echo self::getTwig()->render('detalle_pedido.html.twig', $args);

    }

}