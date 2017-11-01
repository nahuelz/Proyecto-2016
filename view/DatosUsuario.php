<?php

class DatosUsuario extends TwigView {
    
    public function show($datosUsuario, $args) {
        $args = array_merge($args,['isLogged' => true, 'datosUsuario'=>$datosUsuario]);
        echo self::getTwig()->render('datos_usuario.html.twig', $args);
        
    }
    
}