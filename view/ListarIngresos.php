<?php

class ListarIngresos extends TwigView {
    
    public function show($ingresos, $args, $cant_total_elementos, $cant_elementos, $pagina) {

    	$args = array_merge($args, ['isLogged' => true]);
    	$args = array_merge($args, ['ingresos' => $ingresos]);
    	$args = array_merge($args, ['cant_total_elementos' => $cant_total_elementos[0]]);
    	$args = array_merge($args, ['cant_elementos' => $cant_elementos]);
    	$args = array_merge($args, ['pagina' => $pagina]);
        echo self::getTwig()->render('listar_ingresos.html.twig', $args);
        
    }
    
}