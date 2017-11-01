<?php

class ListarUsuarios extends TwigView {
    
    public function show($usuarios, $args, $cant_total_elementos, $cant_elementos, $pagina) {

    	$args = array_merge($args, ['isLogged' => true]);
    	$args = array_merge($args, ['usuarios' => $usuarios]);
    	$args = array_merge($args, ['cant_total_elementos' => $cant_total_elementos[0]]);
    	$args = array_merge($args, ['cant_elementos' => $cant_elementos]);
    	$args = array_merge($args, ['pagina' => $pagina]);
        echo self::getTwig()->render('listar_usuarios.html.twig', $args);
        
    }
    
}