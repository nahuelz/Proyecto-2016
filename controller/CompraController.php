<?php

/*
**  Descripcion de CompraController
**      
*/

class CompraController {
    
    private static $instance;

    public static function getInstance() {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }    
    private function __construct() {
        
    }

    // Retorna true si el usuario esta logeado, false en caso contrario.
    public function isLogged() {
        return LoginSystem::getInstance()->isLogged();
    }

    public function tipoUsuario(){
        if ($this->isAdmin()) {
            return "admin";
        }else if ($this->isGestion()) {
            return "gestion";
        }else{
            return "online";
        }
    }

    public function isAdmin() {
        return LoginSystem::getInstance()->isAdmin();
    }

    public function isGestion() {
        return LoginSystem::getInstance()->isGestion();
    }

    public function home($args) {
        ResourceController::getInstance()->home($args);
    }

/*
** COMPRAS:
*/

    public function eliminar_egreso($idEgreso) {
        if (LoginSystem::getInstance()->isLogged()) {
            if (LoginSystem::getInstance()->isGestion() || LoginSystem::getInstance()->isAdmin()) {
                $args = Egreso::getInstance()->eliminar_egreso($idEgreso);
                $this->listar_egresos($args);
            } else {
                $this->home(Message::getMessage(0));
            }
        } else {
            $this->home(Message::getMessage(0));
        }
    }
    
    public function alta_compra($args = null) {
        if (LoginSystem::getInstance()->isLogged()) {
            if (LoginSystem::getInstance()->isAdmin() || LoginSystem::getInstance()->isGestion()) {
                require('./configuracion.php');
                if ($args != null){
                    $args = array_merge($args, ['token' => $token, 'titulo' => $titulo, 'sitio'=>$sitio, 'email' => $email, 'tipoUsuario' => $this->tipoUsuario()]);
                }else{
                    $args = ['token' => $token, 'titulo' => $titulo, 'sitio'=>$sitio, 'email' => $email, 'tipoUsuario' => $this->tipoUsuario()];
                }

                $productos = Producto::getInstance()->listar_productos();
                $view = new AltaCompra();
                $view->show($productos,$args);
            } else {
                $this->home(Message::getMessage(0));
            }
        }else {
            $this->home(Message::getMessage(0));
        }
    }

    public function listar_egresos($args) {
        if (LoginSystem::getInstance()->isLogged()) {
            if (LoginSystem::getInstance()->isGestion() || LoginSystem::getInstance()->isAdmin()) {
                if (isset($_GET["pagina"])){
                    $pagina = $_GET["pagina"];
                } else {
                    $pagina = 1;
                }
                require('./configuracion.php');
                $args = array_merge($args,['titulo' => $titulo, 'sitio'=>$sitio, 'email' => $email, 'tipoUsuario' => $this->tipoUsuario()]);
                $egr = Egreso::getInstance()->listar_egresos($cant_elementos, $pagina);
                $cant_total_elementos = Egreso::getInstance()->cant_total_elementos();
                $view = new ListarEgresos();
                $egresos = Producto::getInstance()->getNombres($egr);
                $view->show($egresos, $args, $cant_total_elementos, $cant_elementos, $pagina);
            } else {
                $this->home(Message::getMessage(0));
            }
        }else{
            $this->home(Message::getMessage(0));
        }
    }

    public function alta_compra_system(){
        if (LoginSystem::getInstance()->isLogged()) {
            if (LoginSystem::getInstance()->isAdmin() || LoginSystem::getInstance()->isGestion()) {
                $token = $_POST['token'];
                if ($token == Session::getInstance()->token){
                    $cant = $_POST['cantProductos'];
                    $proveedor = $_POST['proveedor'];
                    $cuit = $_POST['cuit'];
                    $productos = [];
                    for ($i = 1; $i <= $cant; $i++) {
                        $productos['producto'.$i] = $_POST['producto'.$i];
                          $productos['cantidad'.$i] = $_POST['cantidad'.$i];
                            $productos['precio'.$i] = $_POST['precio'.$i];
                    }
                }
                else{
                    $this->home(Message::getMessage(37));
                }
                $args = Compra::getInstance()->alta_compra($cant, $proveedor, $cuit, $productos);
                $this->alta_compra($args);
            } else {
                $this->home(Message::getMessage(0));
            }
        }
    }

/*
** INGRESOS:
*/
    public function eliminar_ingreso($idIngreso) {
        if (LoginSystem::getInstance()->isLogged()) {
            if (LoginSystem::getInstance()->isGestion() || LoginSystem::getInstance()->isAdmin()) {
                $args = Ingreso::getInstance()->eliminar_ingreso($idIngreso);
                $this->listar_ingresos($args);
            } else {
                $this->home(Message::getMessage(0));
            }
        } else {
            $this->home(Message::getMessage(0));
        }
    }

    public function alta_venta($msj = null) {
        if (LoginSystem::getInstance()->isLogged()) {
            if (LoginSystem::getInstance()->isAdmin() || LoginSystem::getInstance()->isGestion()) {
                require('./configuracion.php');
                if ($msj == null){
                    $args = ['token' => $token, 'titulo' => $titulo, 'sitio'=>$sitio, 'email' => $email, 'tipoUsuario' => $this->tipoUsuario()];
                } else {
                    $args = ['token' => $token, 'mensaje' => $msj, 'titulo' => $titulo, 'sitio'=>$sitio, 'email' => $email, 'tipoUsuario' => $this->tipoUsuario()];
                }
                $productos = Producto::getInstance()->listar_productos();
                $ingresos = Ingreso::getInstance()->listar_tipos_ingresos();
                $view = new AltaVenta();
                $view->show($productos, $ingresos, $args);
            } else{
                $this->home(Message::getMessage(0));
            }
        } else {
            $this->home(Message::getMessage(0));
        }
    }

    public function alta_venta_system() {
        if (LoginSystem::getInstance()->isLogged()) {
            $token = $_POST['token'];
            if ($token == Session::getInstance()->token){
                $id = $_POST['id'];
                $cantidad = $_POST['cantidad'];
                $args = Venta::getInstance()->alta_venta($id, $cantidad);
                $this->alta_venta($args);
            }else{
                $this->home(Message::getMessage(37));
            }
        } else {
            $this->home(Message::getMessage(0));
        }
    }

    public function listar_ingresos($args) {
        if (LoginSystem::getInstance()->isLogged()) {
            if (LoginSystem::getInstance()->isGestion() || LoginSystem::getInstance()->isAdmin()) {
                if (isset($_GET["pagina"])){
                    $pagina = $_GET["pagina"];
                } else {
                    $pagina = 1;
                }
                require('./configuracion.php');
                $args = array_merge($args,['titulo' => $titulo, 'sitio'=>$sitio, 'email' => $email, 'tipoUsuario' => $this->tipoUsuario()]);
                $ingr = Ingreso::getInstance()->listar_ingresos($cant_elementos, $pagina);
                $cant_total_elementos = Ingreso::getInstance()->cant_total_elementos();
                $view = new ListarIngresos();
                $ingresos = Producto::getInstance()->getNombres($ingr);
                $view->show($ingresos, $args, $cant_total_elementos, $cant_elementos, $pagina);
            } else {
                $this->home(Message::getMessage(0));
            }
        }else{
            $this->home(Message::getMessage(0));
        }
    }

}