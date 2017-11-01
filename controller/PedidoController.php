<?php

/*
**  Descripcion de UsuarioController
**
*/

class PedidoController
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


    public function home($args)
    {
        ResourceController::getInstance()->home($args);
    }


    public function processAction($args=[]){
        require('./configuracion.php');
        $args = array_merge($args,['titulo' => $titulo, 'sitio' => $sitio, 'email' => $email, 'tipoUsuario' => UsuarioController::getInstance()->tipoUsuario()]);
        $user = Session::getInstance()->user;
        $rol = Usuario::getInstance()->getRolUser($user);
        if (!isset($rol[0][0])){
            $rol[0][0] = 0;  // Usuario visitante
        }
        if (isset($_GET['function'])) {
            switch ($_GET['function']) {
                case 'gestionar_pedidos': {
                    $this->gestionar_pedidos($args, $rol[0][0]);
                    break;
                }
                case 'cancelar_pedido': {
                    $this->cancer_pedido($args);
                    break;
                }
                case 'cancelar_pedido_system': {
                    $this->cancelar_pedido_system();
                    break;
                }
                case 'aceptar_pedido': {
                    $this->aceptar_pedido($args, $rol[0][0]);
                    break;
                }
                default: {
                    ResourceController::getInstance()->home([]);
                    break;
                }
            }
        }else {
            ResourceController::getInstance()->home([]);
        }

    }

    /*
    ** PEDIDO:
    */
    public function detalle_pedido () {
        if (LoginSystem::getInstance()->isLogged()) {
            if (isset($_GET['id'])) {
                $pedidoId = $_GET['id'];
                $from = $_GET['from'];
                require('./configuracion.php');
                $args = ['online' => 1, 'titulo' => $titulo, 'sitio' => $sitio, 'email' => $email, 'tipoUsuario' => UsuarioController::getInstance()->tipoUsuario()];
                $detalle = Pedido::getInstance()->obtenerDetalle($pedidoId);
                $productos = Producto::getInstance()->listar_productos();
                $view = new DetallePedido();
                $view->show($detalle, $productos, $args, $from);
            }else{
                $this->home(Message::getMessage(0));
            }
        } else{
            $this->home(Message::getMessage(0));
        }
    }
    public function menu_del_dia($args = null) {
        if (LoginSystem::getInstance()->isLogged()) {
            require('./configuracion.php');
            if ($args == null) {
                $args = ['titulo' => $titulo, 'sitio' => $sitio, 'email' => $email, 'tipoUsuario' => UsuarioController::getInstance()->tipoUsuario()];
            }else{
                $args = array_merge($args,['titulo' => $titulo, 'sitio' => $sitio, 'email' => $email, 'tipoUsuario' => UsuarioController::getInstance()->tipoUsuario()]);
            }
            date_default_timezone_set('America/Argentina/Buenos_Aires');
            $fecha = date("Y-n-j");
            $menuDelDia = Menu::getInstance()->getMenu($fecha);
            $productos = Producto::getInstance()->listar_productos();
            $view = new MenuDelDia();
            $view->show($productos, $menuDelDia, $args);
        }else{
            $this->home(Message::getMessage(0));
        }
    }

    public function alta_pedido_system()
    {
        if (LoginSystem::getInstance()->isLogged()) {
            if (isset($_POST['cantProductos'])) {
                $error = true;
                $cantProd = $_POST['cantProductos'];
                $user = Session::getInstance()->user;
                $userId = Usuario::getInstance()->getId($user);
                $estado = 0;
                date_default_timezone_set('America/Argentina/Buenos_Aires');
                $fecha = date("Y-n-j H:i:s");
                $observacion = $_POST['observacion'];
                Pedido::getInstance()->altaPedido($estado, $fecha, $userId[0], $observacion);
                $pedidoId = Pedido::getInstance()->ultimoPedido();
                for ($i = 1; $i <= $cantProd; $i++) {
                    $cant = $_POST['cantidad' . $i];
                    if ($cant != 0) {
                        $error = false;
                        $prodId = $_POST['id' . $i];
                        Pedido::getInstance()->altaPedidoDetalle($pedidoId[0], $prodId, $cant);
                    }
                }
                if ($error) {
                    Pedido::getInstance()->eliminar($pedidoId[0]);
                    $this->menu_del_dia(Message::getMessage(30));
                } else {
                    $this->mis_pedidos(Message::getMessage(31));
                }
            } else{
                $this->menu_del_dia(Message::getMessage(30));
            }
        }else{
            $this->home(Message::getMessage(0));
        }
    }

    public function mis_pedidos($args = []){
        if (LoginSystem::getInstance()->isOnline()){
            require('./configuracion.php');
            $args = array_merge($args,['titulo' => $titulo, 'sitio' => $sitio, 'email' => $email, 'tipoUsuario' => UsuarioController::getInstance()->tipoUsuario()]);
            $user = Session::getInstance()->user;
            $userId = Usuario::getInstance()->getId($user);
            if (isset($_POST['fecha'])){
                $fecha = $_POST['fecha'];
                $pedidos = Pedido::getInstance()->obtenerMisPedidosPorFecha($userId[0], $fecha);
            }else{
                date_default_timezone_set('America/Argentina/Buenos_Aires');
                $fecha = date("Y-n-j");
                $pedidos = Pedido::getInstance()->obtenerMisPedidos($userId[0]);
            }
            $view = new MisPedidos();
            $view->show($pedidos, $args,'online', $fecha);

        } else{
            $this->home(Message::getMessage(0));
        }

    }

    public function cancer_pedido($args = []){
        if (LoginSystem::getInstance()->isLogged()) {
            if (isset($_GET['id']) && isset($_GET['from'])) {
                $pedidoId = $_GET['id'];
                $from = $_GET['from'];
                $view = new CancelarPedido();
                $view->show($args, $pedidoId, $from);
            }
        }
    }
    public function cancelar_pedido_system()
    {
        if (LoginSystem::getInstance()->isLogged()) {
            if (isset($_POST['pedidoId']) && isset($_POST['motivo']) && isset($_POST['from'])) {
                require('./configuracion.php');
                $motivo_cancelacion = $_POST['motivo'];
                $pedidoId = $_POST['pedidoId'];
                $from = $_POST['from'];
                if ($from == 'gestion'){
                    Pedido::getInstance()->setMotivo($motivo_cancelacion, $pedidoId);
                    Pedido::getInstance()->cancelar($pedidoId);
                    $_GET['function'] = 'gestionar_pedidos';
                    $this->getInstance()->processAction(Message::getMessage(32));
                }else{
                    $user = Session::getInstance()->user;
                    $userId = Usuario::getInstance()->getId($user);
                    if (Pedido::getInstance()->esMiPedido($userId[0], $pedidoId)) {
                        $fecha = Pedido::getInstance()->getHora($pedidoId);
                        date_default_timezone_set('America/Argentina/Buenos_Aires');
                        $fecha_actual = date("Y-n-j H:i:s");
                        if (isset($fecha[0])) {
                            $dateActual = new dateTime($fecha_actual);
                            $date = new dateTime($fecha[0]);
                            $dif = date_diff($dateActual, $date);
                            if (($dif->y == 0) && ($dif->d == 0) && ($dif->h == 0) && ($dif->i <= $tiempoCancelacion)) {
                                Pedido::getInstance()->setMotivo($motivo_cancelacion, $pedidoId);
                                Pedido::getInstance()->cancelar($pedidoId);
                                $this->mis_pedidos(Message::getMessage(32));
                            } else {
                                $this->mis_pedidos(Message::getMessage(33, $tiempoCancelacion));
                            }
                        } else {
                            $this->mis_pedidos(Message::getMessage(18));
                        }
                    } else {
                        $this->mis_pedidos(Message::getMessage(34));
                    }
                }
            } else {
                $this->mis_pedidos(Message::getMessage(18));
            }
        } else {
            $this->mis_pedidos(Message::getMessage(0));
        }
    }


    public function gestionar_pedidos($args = [], $rol){
        if (Usuario::getInstance()->isGestion($rol) || Usuario::getInstance()->isAdmin($rol)){
            $pedidos = Pedido::getInstance()->obtenerPedidos();
            $view = new MisPedidos();
            $vista = 'gestion';
            $view->show($pedidos, $args, $vista);
        } else{
            $this->home(Message::getMessage(0));
        }
    }

    public function aceptar_pedido($args, $rol){
        if (Usuario::getInstance()->isAdmin($rol) || Usuario::getInstance()->isGestion($rol)){
            if ($_GET['pedidoId']){
                $pedidoId = $_GET['pedidoId'];
                $detalle = Pedido::getInstance()->obtenerDetalle($pedidoId);
                $error = false;
                foreach ($detalle as &$prod){
                    $producto_id = $prod['producto_id'];
                    $cantidad = $prod['cantidad'];
                    $stockAct = Producto::getInstance()->getStock($producto_id);
                    if (($stockAct[0][0] - $cantidad) < 0){
                        $error = true;
                    }
                }
                if (!$error){
                    Pedido::getInstance()->setEstado(2, $pedidoId);
                    foreach ($detalle as &$prod){
                        $producto_id = $prod['producto_id'];
                        $cantidad = $prod['cantidad'];
                        Venta::getInstance()->alta_venta($producto_id, $cantidad);
                    }
                    $args = array_merge($args,[Message::getMessage(16)]);
                    $this->gestionar_pedidos($args, $rol);
                }else{
                    $args = array_merge($args,[Message::getMessage(35)]);
                    $this->gestionar_pedidos($args,$rol);
                }
            }
        }else{
            $args = array_merge($args,[Message::getMessage(18)]);
            $this->gestionar_pedidos($args,$rol);
        }
    }
}