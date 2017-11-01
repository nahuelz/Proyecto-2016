<?php

/**
 *	Descripcion del Index
 *		Esta va a ser la primer pagina que se ejecute.
 *		Activa los errores para que se muestren en pantalla.
 *		Incluya todo lo necesario y le dice a ResourceController que es lo que tiene que ejecutar.
 */

ini_set('display_startup_errors',1);
ini_set('display_errors',1);
error_reporting(-1);

/* CONTROLLER */
require_once('controller/ResourceController.php');
require_once('controller/UsuarioController.php');
require_once('controller/ProductoController.php');
require_once('controller/CompraController.php');
require_once('controller/MenuController.php');
require_once('controller/PedidoController.php');
require_once('controller/BalanceController.php');

/* MODEL */
require_once('model/PDORepository.php');
require_once('model/Session.php');
require_once('model/Cookie.php');
require_once('model/LoginSystem.php');
require_once('model/Usuario.php');
require_once('model/Categoria.php');
require_once('model/Producto.php');
require_once('model/Rol.php');
require_once('model/Ingreso.php');
require_once('model/Egreso.php');
require_once('model/Message.php');
require_once('model/Categoria.php');
require_once('model/Venta.php');
require_once('model/Configuracion.php');
require_once('model/Compra.php');
require_once('model/Menu.php');
require_once('model/Pedido.php');
require_once('model/Bot.php');

/* VIEW */
require_once('view/TwigView.php');
require_once('view/Home.php');
require_once('view/Login.php');
require_once('view/AltaUsuario.php');
require_once('view/ListarUsuarios.php');
require_once('view/DatosUsuario.php');
require_once('view/AltaProducto.php');
require_once('view/ListarProductos.php');
require_once('view/AltaCompra.php');
require_once('view/DetalleProducto.php');
require_once('view/ModificarProducto.php');
require_once('view/ModificarUsuario.php');
require_once('view/AltaVenta.php');
require_once('view/DatosConfiguracion.php');
require_once('view/Registro.php');
require_once('view/ListarIngresos.php');
require_once('view/ListarProductosFaltantes.php');
require_once('view/ListarEgresos.php');
require_once('view/AltaMenu.php');
require_once('view/MenuDelDia.php');
require_once('view/ListarMenu.php');
require_once('view/MisPedidos.php');
require_once('view/DetallePedido.php');
require_once('view/CancelarPedido.php');
require_once('view/BalanceVentas.php');
require_once('view/BalanceGanancias.php');
require_once('functionesphp/funciones.php');


/* CONFIGURACION */
require_once('configuracion.php');

if (isset($_GET["action"])){
    switch($_GET['action']){

        /* LOGIN */
        case 'login': { ResourceController::getInstance()->login([]); break; }
        case 'login_system': { ResourceController::getInstance()->login_system(); break; }
        case 'logout': { ResourceController::getInstance()->logout_system(); break; }

        /* USUARIOS*/
        case 'registro': { UsuarioController::getInstance()->registro([]); break; }
        case 'alta_usuario' : { UsuarioController::getInstance()->alta_usuario([]); break; }
        case 'alta_usuario_system' : { UsuarioController::getInstance()->alta_usuario_system(); break; }
        case 'alta_usuario_online_system' : { UsuarioController::getInstance()->alta_usuario_online_system(); break; }
        case 'listar_usuarios': { UsuarioController::getInstance()->listar_usuarios([]); break; }
        case 'datos_usuario': { UsuarioController::getInstance()->datos_usuario($_GET["id"]); break; }
        case 'modificar_usuario': { UsuarioController::getInstance()->modificar_usuario($_GET['id']); break; }
        case 'modificar_usuario_system': { UsuarioController::getInstance()->modificar_usuario_system(); break; }
        case 'eliminar_usuario': { UsuarioController::getInstance()->eliminar_usuario($_GET['id']); break; }

        /* PRODUCTOS */
        case 'alta_producto': { ProductoController::getInstance()->alta_producto(); break; }
        case 'alta_producto_system': { ProductoController::getInstance()->alta_producto_system(); break; }
        case 'detalle_producto': {ProductoController::getInstance()->detalle_producto(); break; }
        case 'listar_productos': {ProductoController::getInstance()->listar_productos([]); break; }
        case 'modificar_producto': { ProductoController::getInstance()->modificar_producto(); break; }
        case 'modificar_producto_system': { ProductoController::getInstance()->modificar_producto_system(); break; }
        case 'eliminar_producto': { ProductoController::getInstance()->eliminar_producto($_GET['id']); break; }

        /* COMPRAS */
        case 'alta_compra': { CompraController::getInstance()->alta_compra(); break; }
        case 'alta_compra_system': { CompraController::getInstance()->alta_compra_system(); break; }
        case 'listar_egresos': {CompraController::getInstance()->listar_egresos([]); break; }
        case 'eliminar_egreso': { CompraController::getInstance()->eliminar_egreso($_GET['id']); break; }

        /* INGRESOS */
        case 'alta_venta': { CompraController::getInstance()->alta_venta(); break; }
        case 'alta_venta_system': { CompraController::getInstance()->alta_venta_system(); break; }
        case 'listar_ingresos': {CompraController::getInstance()->listar_ingresos([]); break; }
        case 'eliminar_ingreso': { CompraController::getInstance()->eliminar_ingreso($_GET['id']); break; }

        /* CONFIGURACION */
        case 'configuracion': { ResourceController::getInstance()->configuracion(); break; }
        case 'configuracion_system': { ResourceController::getInstance()->configuracion_system(); break; }

        /* LISTADOS*/

        case 'listar_productos_faltantes': {ProductoController::getInstance()->listar_productos_faltantes([]); break; }
        case 'listar_productos_stockMin': {ProductoController::getInstance()->listar_productos_stockMin([]); break; }

        /* MENU */

        case 'alta_menu': { MenuController::getInstance()->alta_menu(); break; }
        case 'alta_menu_system': {MenuController::getInstance()->alta_menu_system(); break; }
        case 'listar_menus': { MenuController::getInstance()->listar_menus([]); break;}
        case 'eliminar_menu': { MenuController::getInstance()->eliminar_menu(); break; }
        case 'detalle_menu': { MenuController::getInstance()->detalle_menu(); break;}

        /* PEDIDOS ONLINE */

        case 'menu_del_dia': { PedidoController::getInstance()->menu_del_dia(); break; }
        case 'alta_pedido_system': { PedidoController::getInstance()->alta_pedido_system(); break; }
        case 'mis_pedidos': { PedidoController::getInstance()->mis_pedidos(); break; }
        case 'detalle_pedido': { PedidoController::getInstance()->detalle_pedido(); break; }
        case 'pedidos': { PedidoController::getInstance()->processAction(); break; }

        /* BALANCE */

        case 'listarVentas': { BalanceController::getInstance()->listarVentas([]); break; }
        case 'listarGanancias': { BalanceController::getInstance()->listarGanancias([]); break; }

        /* BOT */
        case 'enviar_menu': { Bot::getInstance()->enviarMenu(); break; }

        default: { ResourceController::getInstance()->home([]); break; }
    }
} else {
    ResourceController::getInstance()->home([]);
}