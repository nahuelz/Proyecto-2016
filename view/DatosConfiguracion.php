<?php

class DatosConfiguracion extends TwigView {
    
    public function show($msj=false, $configuracion, $args) {
        if ($msj){
            $args = array_merge($args,['mensaje' => $msj, 'isLogged' => true, 'configuracion' => $configuracion]);
        }else{
            $args = array_merge($args,['isLogged' => true, 'configuracion' => $configuracion]);
        }

        echo self::getTwig()->render('configuracion.html.twig', $args);
        
    }
    
}