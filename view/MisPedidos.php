<?php

class MisPedidos extends TwigView
{

    public function show($pedidos, $args, $vista, $fecha=null)
    {
        $args = array_merge($args, ['vista' => $vista, 'isLogged' => true, 'pedidos' => $pedidos, 'fecha' => $fecha]);
        echo self::getTwig()->render('mis_pedidos.html.twig', $args);

    }
}