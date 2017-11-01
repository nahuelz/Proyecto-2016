<?php

class AltaProducto extends TwigView {
    
    public function show($categorias, $args) {
        $args = array_merge($args,['isLogged' => true, 'categorias'=>$categorias]);
        echo self::getTwig()->render('alta_producto.html.twig', $args);
        
    }
    
}