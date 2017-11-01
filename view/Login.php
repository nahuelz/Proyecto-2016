<?php

class Login extends TwigView {
    
    public function show($args) {
    	$args = array_merge($args, ['isLogged' => false]);
        echo self::getTwig()->render('login.html.twig', $args);
        
    }
    
}