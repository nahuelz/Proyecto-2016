<?php

class ModificarProducto extends TwigView {
    
    public function show($producto, $categorias, $args) {;
        $args = array_merge($args,['isLogged' => true, 'categorias' => $categorias, 'producto' => $producto]);
        echo self::getTwig()->render('modificar_producto.html.twig', $args);
        
    }
    
}