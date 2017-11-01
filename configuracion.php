<?php 
	$config = Configuracion::getInstance()->obtenerConfiguracion();
	foreach($config as $c)
	{
		switch($c['clave']){
			case "titulo": $titulo = $c['valor']; break;
			case "descripcion": $descripcion = $c['valor']; break;
			case "email": $email = $c['valor']; break;
			case "cant_elementos": $cant_elementos = $c['valor']; break;
			case "sitio": $sitio = $c['valor']; break;
			case "mensaje": $mensajeDeshabilitado = $c['valor']; break;
			case "tiempoCancelacion": $tiempoCancelacion = $c['valor']; break;
		}	
	}
	$token = Session::getInstance()->token;
