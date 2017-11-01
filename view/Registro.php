<?php

class Registro extends TwigView {
    
    public function show($args) {
    	$args = array_merge($args, ['isLogged' => false]);
        echo self::getTwig()->render('registro.html.twig', $args);
        
    }
    
}