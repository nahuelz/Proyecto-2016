<?php

/*
**  Descripcion de CompraController
**
*/

class MenuController {

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
    ** MENU:
    */

    public function alta_menu() {
        if (LoginSystem::getInstance()->isLogged()) {
            if (LoginSystem::getInstance()->isGestion() || LoginSystem::getInstance()->isAdmin()) {
                require('./configuracion.php');
                $args = ['token' => $token, 'titulo' => $titulo, 'sitio'=>$sitio, 'email' => $email, 'tipoUsuario' => $this->tipoUsuario()];
                $productos = Producto::getInstance()->listar_productos_con_stock();
                $view = new AltaMenu();
                $fecha = null;
                if (isset($_GET['fecha'])){
                    $fecha = $_GET['fecha'];
                }
                $view->show($productos, $args, $fecha);
            }else{
                $this->home(Message::getMessage(0));
            }
        }else{
            $this->home(Message::getMessage(0));
        }
    }

    public function alta_menu_system(){
        if (LoginSystem::getInstance()->isLogged()) {
            $token = $_POST['token'];
            if ($token == Session::getInstance()->token){
                if (isset($_POST['fecha'])){
                    $fecha = $_POST['fecha'];
                    $cant = $_POST['cantProductos'];
                    $error = false;
                    for ($i=1; $i<= $cant; $i++){
                        if (isset($_POST['producto'.$i])) {
                            $nombreProducto = $_POST['producto'.$i];
                            $id = Producto::getInstance()->getIdByNombre($nombreProducto);
                            if (Menu::getInstance()->esValido($id, $fecha)){ // VALIDO QUE EL PRODUCTO EXISTA, TENGA STOCK Y QUE AUN NO ESTE EN EL MENU
                                $productoId = $id[0][0];
                                $habilitado = 'S';
                                Menu::getInstance()->alta_Menu($productoId, $fecha, $habilitado);
                            }else{
                                $error = true;
                            }
                        }
                    } if ($error){
                        $this->listar_menus(Message::getMessage(28));
                    }else{
                        $this->listar_menus(Message::getMessage(27));
                    }
                }else {
                    $this->home(Message::getMessage(18));
                }
            }
            else{
                $this->home(Message::getMessage(37));
            }
        }else{
            $this->home(Message::getMessage(0));
        }
    }

    public function listar_menus($args) {
        if (LoginSystem::getInstance()->isLogged()) {
            if (LoginSystem::getInstance()->isGestion() || LoginSystem::getInstance()->isAdmin()) {
                if (isset($_GET["pagina"])){
                    $pagina = $_GET["pagina"];
                } else {
                    $pagina = 1;
                }
                require('./configuracion.php');
                $args = array_merge($args,['titulo' => $titulo, 'sitio'=>$sitio, 'email' => $email, 'tipoUsuario' => $this->tipoUsuario()]);
                if (isset($_POST['fecha'])){
                    $fecha = $_POST['fecha'];
                }else{
                    date_default_timezone_set('America/Argentina/Buenos_Aires');
                    $fecha = date("Y-n-j");
                }
                $cant_total_elementos = Menu::getInstance()->cant_total_elementos($fecha);
                $egr = Menu::getInstance()->listar_menus($cant_elementos, $pagina, $fecha);
                $menus = Producto::getInstance()->getNombres($egr);
                $view = new ListarMenu();
                $view->show($menus, $args, $cant_total_elementos, $cant_elementos, $pagina, $fecha);
            } else {
                $this->home(Message::getMessage(0));
            }
        }else{
            $this->home(Message::getMessage(0));
        }
    }

    public function eliminar_menu(){
        if (isset($_GET['id'])){
            $id = $_GET['id'];
            Menu::getInstance()->eliminar($id);
            $msj = Message::getMessage(29);
        } else {
            $msj = Message::getMessage(18);
        }
        $this->listar_menus($msj);
    }

    public function detalle_menu() {
        if (LoginSystem::getInstance()->isLogged()) {
            if (isset($_GET['id'])) {
                $productoId = $_GET['id'];
                require('./configuracion.php');
                $args = ['online' => 1, 'titulo' => $titulo, 'sitio' => $sitio, 'email' => $email, 'tipoUsuario' => $this->tipoUsuario()];
                $producto = Producto::getInstance()->getProducto($productoId);
                $categorias = Categoria::getInstance()->listar_categorias();
                $view = new DetalleProducto();
                $view->show($producto, $categorias, $args);
            }else{
                $this->home(Message::getMessage(0));
            }
        } else{
            $this->home(Message::getMessage(0));
        }

    }
}