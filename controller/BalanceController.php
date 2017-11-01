<?php

/*
**  Descripcion de BalaceController
**
*/

class BalanceController
{

    private static $instance;

    public static function getInstance()
    {

        if (!isset(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    private function __construct()
    {

    }

    public function home($args) {
        ResourceController::getInstance()->home($args);
    }

    /*
    ** BALANCE:
    */

    public function listarVentas($args = []){
        if (LoginSystem::getInstance()->isGestion() || LoginSystem::getInstance()->isAdmin()) {
            require('./configuracion.php');
            $args = array_merge($args,['titulo' => $titulo, 'sitio'=>$sitio, 'email' => $email, 'tipoUsuario' => UsuarioController::getInstance()->tipoUsuario() ]);

            if (isset($_POST['fechaInicio']) && isset($_POST['fechaFin'])) {
                $fechaInicio = $_POST['fechaInicio'];
                $fechaFin = $_POST['fechaFin'];
                $fechaInicio = strtotime($fechaInicio);
                $fechaFin = strtotime($fechaFin);

                $fechaFin = $fechaFin + 86400;
                $productos = Ingreso::getInstance()->productosEnFechas($_POST['fechaInicio'],date("Y-m-d", $fechaFin));
                $view = new BalanceVentas();
                $view->show($args, $productos, $_POST['fechaInicio'], $_POST['fechaFin']);
            }else{
                $productos = Ingreso::getInstance()->productosEnFechas(null, null);
                $view = new BalanceVentas();
                $view->show($args, $productos, null, null);
            }
        }else{
            ResourceController::getInstance()->home($args);
        }        
    }       

    public function listarGanancias($args = []){
        if (LoginSystem::getInstance()->isGestion() || LoginSystem::getInstance()->isAdmin()) {
            require('./configuracion.php');
            $args = array_merge($args,['titulo' => $titulo, 'sitio'=>$sitio, 'email' => $email, 'tipoUsuario' => UsuarioController::getInstance()->tipoUsuario() ]);

            if (isset($_POST['fechaInicio']) && isset($_POST['fechaFin'])) {
                $fechaInicio = $_POST['fechaInicio'];
                $fechaFin = $_POST['fechaFin'];
                $fechaInicio = strtotime($fechaInicio);
                $fechaFin = strtotime($fechaFin);

                for ($i = $fechaInicio; $i<=$fechaFin; $i+=86400){
                	$ingresos[date("Y-m-d", $i)] = 0 + number_format(Ingreso::getInstance()->getIngresosEnFecha(date("Y-m-d",$i))[0],2,'.','');
                	$egresos[date("Y-m-d", $i)] = 0 + number_format(Egreso::getInstance()->getEgresosEnFecha(date("Y-m-d", $i))[0],2,'.','');
                	$ganancias[date("Y-m-d", $i)] = array(date("Y-m-d", $i), $ingresos[date("Y-m-d", $i)] - $egresos[date("Y-m-d", $i)]);                	
                }
                $fechaFin = $fechaFin + 86400;
                $view = new BalanceGanancias();
	        	$view->show($args, $ganancias, $ingresos, $egresos, $_POST['fechaInicio'], $_POST['fechaFin']);
	        }else{
	        	$view = new BalanceGanancias();
	        	$view->show($args, null, null, null, null, null);
	        }
        }else{
        	ResourceController::getInstance()->home($args);
        }        
    }

}