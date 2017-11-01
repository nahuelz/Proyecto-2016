<?php

/*
**  Descripcion de Message
**      
*/

class Message {

    public static function getMessage($message,$tiempoCancelacion=null) {
        switch ($message) {
            case 0:
                return ['message' => 'Ups! No tiene permiso para acceder a ese lugar.'];
            case 1:
                return ['message' => 'El usuario o la contraseña son incorrectas.'];
            case 2:
                return ['message' => 'Se ha iniciado sesion exitosamente.'];
            case 3:
                return ['message' => 'Se ha agregado el usuario exitosamente.'];
            case 4:
                return ['message' => 'Ese nombre de usuario ya esta siendo utilizado. Por favor utilice otro.'];
            case 5:
                return ['message' => 'Se ha cerrado sesion exitosamente.'];
            case 6:
                return ['message' => 'El producto se agregó exitosamente.'];
            case 7:
                return ['message' => 'El codigo de producto ya está registrado.'];
            case 8:
                return ['message' => 'Faltan completar datos.'];
            case 9:
                return ['message' => 'Se ha modificado el producto exitosamente.'];
            case 10:
                return ['message' => 'Se ha modificado el usuario exitosamente'];
            case 11:
                return ['message' => 'El nombre de usuario ya esta siendo utilizado'];
            case 12:
                return ['message' => 'El producto se ha eliminado exitosamente.'];
            case 13:
                return ['message' => 'Se ha eliminado exitosamente.'];
            case 14:
                return ['message' => 'La configuración se ha modificado exitosamente.'];
            case 15:
                return ['message' => 'Ups! Los Usuarios Online deben ingresar el lugar de trabajo.'];
            case 16:
                return ['message' => 'La venta se registro exitosamente.'];
            case 17:
                return ['message' => 'No hay stock suficiente!.'];
            case 18:
                return ['message' => 'Se produjo un error, vuelve a intentarlo.'];
            case 19:
                return ['message' => 'Web desabilitada. Solo el administrador puede logearse.'];
            case 20:
                return ['message' => 'La cuenta se encuentra deshabilitada.'];
            case 21:
                return ['message' => 'Cuenta registrada. Espere la habilitacion del administrador.'];
            case 22:
                return ['message' => 'Hubo un error en el registro, intentelo nuevamente.'];
            case 23:
                return ['message' => 'La compra se registro exitosamente'];
            case 24:
                return ['message' => 'Algunos de los productos seleccionados no existen.'];
            case 25:
                return ['message' => 'Solo se permiten archivos con extension JPG, JPEG, PNG, PJPEG.'];
            case 26:
                return ['message' => 'No se puede borrar este producto'];
            case 27:
                return ['message' => 'El menu se dio de alta exitosamente'];
            case 28:
                return ['message' => 'Algunos productos no pudieron agregarse al menu. Esto puede deberse a 1) El producto ya se encuentra en el menu. 2) El producto no tiene sotck suficiente. 3) El producto no existe'];
            case 29:
                return ['message' => 'El producto se borro del menu correctamente'];
            case 30:
                return ['message' => 'No se ingreso una cantidad de productos'];
            case 31:
                return ['message' => 'El pedido se registro exitosamente'];
            case 32:
                return ['message' => 'El pedido se cancelo'];
            case 33:
                return ['message' => 'Lo sentimos el pedido solo se puede cancelar antes de los '.$tiempoCancelacion.' minutos posteriores de solicitarlo'];
            case 34:
                return ['message' => 'No tienes permiso para cancelar este pedido'];
            case 35:
                return ['message' => 'No se pudo aceptar el pedido ya que no hay stock suficiente'];
            case 36:
                return ['message' => 'El menu del dia se envio correcamente a los usuarios suscriptios.'];
            case 37:
                return ['message' => 'Vulnerabilidad CSRF detectada'];
            default:
                return ['message' => 'Ups! No tiene permiso para acceder a ese lugar.'];
        }
    }

}