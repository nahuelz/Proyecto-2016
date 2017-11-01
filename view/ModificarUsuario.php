<?php

class ModificarUsuario extends TwigView {
    
    public function show($datosUsuario, $roles, $token) {

        echo self::getTwig()->render('modificar_usuario.html.twig', ['isLogged' => true, 'token' => $token, 'roles' => $roles, 'datosUsuario' => $datosUsuario]);
        
    }
    
}