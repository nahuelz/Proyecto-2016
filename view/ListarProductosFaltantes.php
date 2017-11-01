<?php

class ListarProductosFaltantes extends TwigView {
    
    public function show($productos, $tipo, $args, $cant_total_elementos, $cant_elementos, $pagina) {

    	$args = array_merge($args, ['isLogged' => true]);
    	$args = array_merge($args, ['productos' => $productos, 'tipo' => $tipo]);
    	$args = array_merge($args, ['cant_total_elementos' => $cant_total_elementos[0]]);
    	$args = array_merge($args, ['cant_elementos' => $cant_elementos]);
    	$args = array_merge($args, ['pagina' => $pagina]);

        echo self::getTwig()->render('listar_productos_faltantes.html.twig', $args);
        
    }
    
}