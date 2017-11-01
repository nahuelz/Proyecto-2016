<?php

class DetalleProducto extends TwigView {
    
    public function show($producto, $categorias, $args) {
        $args = array_merge($args, ['isLogged'=> true, 'producto' => $producto, 'categorias' => $categorias]);
        echo self::getTwig()->render('detalle_producto.html.twig', $args);
        
    }
    
}