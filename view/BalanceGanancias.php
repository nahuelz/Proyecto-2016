<?php

class BalanceGanancias extends TwigView {
    
    public function show($args, $ganancias=null, $ingresos=null, $egresos=null, $fechaInicio=null, $fechaFin=null) {
    	if ($ganancias != null) {
    	    $dataGan = json_encode(convertirGanancias($ganancias));
    		$args = array_merge($args,['dataGan' => $dataGan, 'isLogged' => true, 'ganancias' => $ganancias, 'ingresos'=>$ingresos, 'egresos' => $egresos, 'fechaInicio' => $fechaInicio, 'fechaFin' => $fechaFin]);
        	echo self::getTwig()->render('balance_ganancias.html.twig', $args);
    	}else{
            $args = array_merge($args,['isLogged' => true, 'ganancias' => $ganancias, 'ingresos'=>$ingresos, 'egresos' => $egresos, 'fechaInicio' => $fechaInicio, 'fechaFin' => $fechaFin]);
            echo self::getTwig()->render('balance_ganancias.html.twig', $args);
        }
    }       
    
}
