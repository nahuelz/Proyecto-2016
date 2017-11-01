<?php

class AltaUsuario extends TwigView {
    
    public function show($args) {
    	$args = array_merge($args, ['isLogged' => true]);
        echo self::getTwig()->render('alta_usuario.html.twig', $args);
        
    }
    
}