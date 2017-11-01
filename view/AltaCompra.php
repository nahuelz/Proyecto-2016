<?php

class AltaCompra extends TwigView {
    
    public function show($productos, $args) {
        $args = array_merge($args, ['isLogged' => true, 'products'=> $productos]);
        echo self::getTwig()->render('alta_compra.html.twig', $args);
        
    }
    
}