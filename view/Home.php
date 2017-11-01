<?php

class Home extends TwigView {
    
    public function show($args) {

        echo self::getTwig()->render('home.html.twig', $args);
        
    }
    
}
