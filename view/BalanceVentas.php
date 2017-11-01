<?php

class BalanceVentas extends TwigView {
    
    public function show($args, $productos, $fechaInicio=null, $fechaFin=null) {
    	if ($productos != null) {
    		$dataProd = json_encode(convertirProductos($productos),JSON_NUMERIC_CHECK);
    		$args = array_merge($args,['dataprod' => $dataProd, 'ventas' => $productos, 'isLogged' => true, 'fechaInicio' => $fechaInicio, 'fechaFin' => $fechaFin]);
        	echo self::getTwig()->render('balance_ventas.html.twig', $args);
    	}else{
            $args = array_merge($args,['isLogged' => true, 'fechaInicio' => $fechaInicio, 'fechaFin' => $fechaFin]);
            echo self::getTwig()->render('balance_ventas.html.twig', $args);
        }
    }       
    
}
