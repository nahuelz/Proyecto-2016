<?php

/*
**  Descripcion de UsuarioController
**      
*/

class ProductoController {

    private static $instance;

    public static function getInstance() {

        if (!isset(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    private function __construct() {

    }

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
    ** PRODUCTOS:
    */
    public function alta_producto() {
        if (LoginSystem::getInstance()->isLogged()) {
            if (LoginSystem::getInstance()->isAdmin() || LoginSystem::getInstance()->isGestion()) {
                require('./configuracion.php');
                $args = ['token' => $token, 'titulo' => $titulo, 'sitio'=>$sitio, 'email' => $email, 'tipoUsuario' => $this->tipoUsuario()];
                $categorias = Categoria::getInstance()->listar_categorias();
                $view = new AltaProducto();
                $view->show($categorias, $args);
            }else{
                $this->home(Message::getMessage(0));
            }
        }else{
            $this->home(Message::getMessage(0));
        }
    }

    public function alta_producto_system() {
        if (LoginSystem::getInstance()->isLogged()) {
            
            if (isset($_POST['nombre'])) {
                $token = $_POST['token'];
                if ($token == Session::getInstance()->token){
                    $nombre = $_POST['nombre'];
                    $marca = $_POST['marca'];   
                    $codigo_barra = $_POST['codigo_barra'];
                    $stock = $_POST['cantidad_stock'];
                    $stock_minimo = $_POST['cantidad_minima_stock'];
                    $idCategoria = $_POST['categoria'];
                    $proveedor = $_POST['proveedor'];
                    $precio_venta_unitario = $_POST['precio_venta_unitario'];
                    $descripcion = NULL;
                    if(isset($_POST['descripcion'])){
                        $descripcion = $_POST['descripcion'];
                    }
                    date_default_timezone_set('America/Argentina/Buenos_Aires');
                    $fecha_alta = date("Y-n-j H:i:s");

                    $args = Producto::getInstance()->alta_producto($nombre, $marca, $codigo_barra, $stock, $stock_minimo, $idCategoria, $proveedor, $precio_venta_unitario, $descripcion, $fecha_alta);

                    $this->listar_productos($args);
                }else{
                    $this->home(Message::getMessage(37));
                }
            } else {
                $args = Message::getMessage(8);
                $this->listar_productos($args);
            }
        } else {
            $this->home(Message::getMessage(0));
        }
    }

    public function listar_productos($args) {
        if (LoginSystem::getInstance()->isLogged()) {
            if (LoginSystem::getInstance()->isGestion() || LoginSystem::getInstance()->isAdmin()) {
                if (isset($_GET["pagina"])){
                    $pagina = $_GET["pagina"];
                } else {
                    $pagina = 1;
                }
                require('./configuracion.php');
                $args = array_merge($args,['titulo' => $titulo, 'sitio'=>$sitio, 'email' => $email, 'tipoUsuario' => $this->tipoUsuario()]);
                $cant_total_elementos = Producto::getInstance()->cant_total_elementos();
                $productos = Producto::getInstance()->listar_productos($cant_elementos, $pagina);
                $view = new ListarProductos();
                $view->show($productos, $args, $cant_total_elementos, $cant_elementos, $pagina);
            } else {
                $this->home(Message::getMessage(0));
            }
        }else{
            $this->home(Message::getMessage(0));
        }
    }

    public function listar_productos_faltantes($args) {
        if (LoginSystem::getInstance()->isLogged()) {
            if (LoginSystem::getInstance()->isGestion()) {
                if (isset($_GET["pagina"])){
                    $pagina = $_GET["pagina"];
                } else {
                    $pagina = 1;
                }
                require('./configuracion.php');
                $args = array_merge($args,['titulo' => $titulo, 'sitio'=>$sitio, 'email' => $email, 'tipoUsuario' => $this->tipoUsuario()]);
                $cant_total_elementos = Producto::getInstance()->cant_total_elementos_faltantes();
                $productos = Producto::getInstance()->listar_productos_faltantes($cant_elementos, $pagina);
                $view = new ListarProductosFaltantes();
                $tipo = "faltantes";
                $view->show($productos, $tipo, $args, $cant_total_elementos, $cant_elementos, $pagina);
            } else {
                $this->home(Message::getMessage(0));
            }
        }else{
            $this->home(Message::getMessage(0));
        }
    }

    public function listar_productos_stockMin($args) {
        if (LoginSystem::getInstance()->isLogged()) {
            if (LoginSystem::getInstance()->isGestion()) {
                if (isset($_GET["pagina"])){
                    $pagina = $_GET["pagina"];
                } else {
                    $pagina = 1;
                }
                require('./configuracion.php');
                $args = array_merge($args,['titulo' => $titulo, 'sitio'=>$sitio, 'email' => $email, 'tipoUsuario' => $this->tipoUsuario()]);
                $cant_total_elementos = Producto::getInstance()->cant_total_elementos_stockMin();
                $productos = Producto::getInstance()->listar_productos_stockMin($cant_elementos, $pagina);
                $view = new ListarProductosFaltantes();
                $tipo= "con stock minimo";
                $view->show($productos, $tipo, $args, $cant_total_elementos, $cant_elementos, $pagina);
            } else {
                $this->home(Message::getMessage(0));
            }
        }else{
            $this->home(Message::getMessage(0));
        }
    }

    public function detalle_producto() {
        if (LoginSystem::getInstance()->isLogged()) {
            if (LoginSystem::getInstance()->isAdmin() || LoginSystem::getInstance()->isGestion()) {
                if (isset($_GET['id'])) {
                    $productoId = $_GET['id'];
                    require('./configuracion.php');
                    $args = ['online' => 0, 'titulo' => $titulo, 'sitio' => $sitio, 'email' => $email, 'tipoUsuario' => $this->tipoUsuario()];
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
        } else {
            $this->home(Message::getMessage(0));
        }

    }

    public function modificar_producto() {
        if (LoginSystem::getInstance()->isLogged()) {
            if (LoginSystem::getInstance()->isAdmin() || LoginSystem::getInstance()->isGestion()){
                if (isset($_GET['id'])) {
                    $productoId = $_GET['id'];
                    require('./configuracion.php');
                    $args = ['token' => $token, 'titulo' => $titulo, 'sitio' => $sitio, 'email' => $email, 'tipoUsuario' => $this->tipoUsuario()];
                    $categorias = Categoria::getInstance()->listar_categorias();
                    $producto = Producto::getInstance()->getProducto($productoId);
                    $view = new ModificarProducto();
                    $view->show($producto, $categorias, $args);
                }else{
                    $this->home(Message::getMessage(0));
                }
            } else{
                $this->home(Message::getMessage(0));
            }
        }else{
            $this->home(Message::getMessage(0));
        }
    }

    public function modificar_producto_system() {
        if (LoginSystem::getInstance()->isLogged()) {
            $token = $_POST['token'];
            if ($token == Session::getInstance()->token){
                if (isset($_POST['nombre'])) {
                    $id = $_POST['id'];
                    $nombre = $_POST['nombre'];
                    $marca = $_POST['marca'];   
                    $codigo_barra = $_POST['codigo_barra'];
                    $stock = $_POST['stock'];
                    $stock_minimo = $_POST['stock_minimo'];
                    $idCategoria = Categoria::getInstance()->getCategoriaId($_POST['categoria']);
                    $idCategoria = $idCategoria[0];
                    $proveedor = $_POST['proveedor'];
                    $precio_venta_unitario = $_POST['precio_venta_unitario'];
                    $descripcion = $_POST['descripcion'];

                    $args = Producto::getInstance()->modificar_producto($id, $nombre, $marca, $codigo_barra, $stock, $stock_minimo, $idCategoria, $proveedor, $precio_venta_unitario, $descripcion);
                    $this->listar_productos($args);
                } else {
                    $args = Message::getMessage(8);
                    $this->listar_productos($args);
                }
            }
            else{
                $this->home(Message::getMessage(37));
            }
        } else {
            $this->home(Message::getMessage(0));
        }
    }

    public function eliminar_producto($id) {
        if (LoginSystem::getInstance()->isLogged()) {
            if (LoginSystem::getInstance()->isAdmin() || LoginSystem::getInstance()->isGestion()) {
                if (Producto::getInstance()->verificarIntegridad($id)){
                    Producto::getInstance()->eliminar_producto($id);
                    $args = Message::getMessage(12);
                    $this->listar_productos($args);
                } else {
                    $args =  Message::getMessage(26);
                    $this->listar_productos($args);
                }
            } else{
                $this->home(Message::getMessage(0));
            }
        } else{
            $this->home(Message::getMessage(0));
        }
    }
}