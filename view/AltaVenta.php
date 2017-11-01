<?php

class AltaVenta extends TwigView {

    public function show($productos, $ingresos, $args) {
        $args = array_merge($args,['productos' => $productos, 'isLogged' => true, 'ingresos' => $ingresos]);
        echo self::getTwig()->render('altaVenta.html.twig', $args);
        
    }
    
}