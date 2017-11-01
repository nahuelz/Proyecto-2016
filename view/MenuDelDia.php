<?php

class MenuDelDia extends TwigView
{

    public function show($productos, $menuDelDia, $args)
    {
        $args = array_merge($args, ['isLogged' => true, 'productos'=> $productos, 'menu' => $menuDelDia]);
        echo self::getTwig()->render('menu_del_dia.twig', $args);

    }
}