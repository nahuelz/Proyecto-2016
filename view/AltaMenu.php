<?php

class AltaMenu extends TwigView
{

    public function show($productos, $args, $fecha)
    {
        $args = array_merge($args, ['isLogged' => true, 'products'=> $productos, 'fecha' => $fecha]);
        echo self::getTwig()->render('alta_menu.html.twig', $args);

    }
}