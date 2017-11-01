<?php

/*
**  Descripcion de UsuarioController
**      
*/

class UsuarioController {
    
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
** USUARIOS:
*/
    
    public function registro($args) {
        if (!LoginSystem::getInstance()->isLogged()) {
            require('./configuracion.php');
            $args = array_merge($args, ['token' => $token, 'titulo' => $titulo, 'sitio'=>$sitio, 'email' => $email, 'tipoUsuario' => $this->tipoUsuario()]);
            $view = new Registro();
            $view->show($args);
        } else {
            $this->home([]);
        }
    }

    public function alta_usuario($args) {
        if (LoginSystem::getInstance()->isLogged()) {
            if (LoginSystem::getInstance()->isAdmin()) {
                require('./configuracion.php');
                $args = array_merge($args, ['token' => $token, 'titulo' => $titulo, 'sitio'=>$sitio, 'email' => $email, 'tipoUsuario' => $this->tipoUsuario()]);
                $view = new AltaUsuario();
                $view->show($args);
            } else {
                $this->home(Message::getMessage(0));
            }
        } else {
            $this->home(Message::getMessage(0));
        }
    }

    public function alta_usuario_system() {
        if (LoginSystem::getInstance()->isLogged()) {
            if (isset($_POST['user'])) {
                $token = $_POST['token'];
                if ($token == Session::getInstance()->token){
                    $usuario = ['user' => $_POST['user'], 'nombre' => $_POST['nombre'], 'apellido' => $_POST['apellido'], 'dni' => $_POST['dni'], 'acceso' => $_POST['acceso'], 'email' => $_POST['email'], 'password' => $_POST['password'], 'telefono' => $_POST['telefono'], 'rol' => $_POST['rol'], 'login' => $_POST['login'], 'nombre_trabajo' => '', 'descripcion_trabajo' => '', 'ubicacion_id' => 0];
                    if (isset($_POST['nombre_trabajo']) AND isset($_POST['descripcion_trabajo']) AND $_POST['rol'] == 3) {
                        $usuario['nombre_trabajo'] = $_POST['nombre_trabajo'];
                        $usuario['descripcion_trabajo'] = $_POST['descripcion_trabajo'];
                    }
                    $args = Usuario::getInstance()->alta_usuario($usuario);
                }else{
                    $this->home(Message::getMessage(37));
                }
            } else {
                $args = Message::getMessage(8);
            }
            $this->listar_usuarios($args);
        } else {
            $this->home(Message::getMessage(0));
        }
    }

    public function alta_usuario_online_system() {
        $token = $_POST['token'];
        if ($token == Session::getInstance()->token){
            $usuario = ['user' => $_POST['user'], 'nombre' => $_POST['nombre'], 'apellido' => $_POST['apellido'], 'dni' => $_POST['dni'], 'acceso' => $_POST['acceso'], 'email' => $_POST['email'], 'password' => $_POST['password'], 'telefono' => $_POST['telefono'], 'rol' => $_POST['rol'], 'nombre_trabajo' => '', 'descripcion_trabajo' => '', 'ubicacion_id' => 0];
            if (isset($_POST['nombre_trabajo']) AND isset($_POST['descripcion_trabajo']) AND $rol == 3) {
                $usuario['nombre_trabajo'] = $_POST['nombre_trabajo'];
                $usuario['descripcion_trabajo'] = $_POST['descripcion_trabajo'];
            }
        }else{
            $this->home(Message::getMessage(37));
        }

        $registro = Usuario::getInstance()->alta_usuario($usuario); 
        switch ($registro) {
            case "0": $this->home(Message::getMessage(21)); break;
            case "1": $this->registro(Message::getMessage(4)); break;
            case "2": $this->registro(Message::getMessage(22)); break;
            default : $this->home([]);;
        }
    }

    public function listar_usuarios($args) {
        if (LoginSystem::getInstance()->isLogged()) {
            if (LoginSystem::getInstance()->isAdmin()) {
                if (isset($_GET["pagina"])){
                    $pagina = $_GET["pagina"];
                } else {
                    $pagina = 1;
                }
                require('./configuracion.php');
                $args = array_merge($args,['titulo' => $titulo, 'sitio'=>$sitio, 'email' => $email, 'tipoUsuario' => $this->tipoUsuario()]);
                $usuarios = Usuario::getInstance()->listar_usuarios($cant_elementos, $pagina);
                $cant_total_elementos = Usuario::getInstance()->cant_total_elementos();
                $view = new ListarUsuarios();
                $view->show($usuarios, $args, $cant_total_elementos, $cant_elementos, $pagina);
            } else {
                $this->home(Message::getMessage(0));
            }
        } else {
            $this->home(Message::getMessage(0));
        }
        
    }

    public function datos_usuario($idUser) {
        if (LoginSystem::getInstance()->isLogged()) {
            if (LoginSystem::getInstance()->isAdmin()) {
                require('./configuracion.php');
                $args = ['titulo' => $titulo, 'sitio' => $sitio, 'email' => $email, 'tipoUsuario' => $this->tipoUsuario()];
                $usuario = Usuario::getInstance()->datos_usuario($idUser);
                $view = new DatosUsuario();
                $view->show($usuario, $args);
            } else {
                $this->home(Message::getMessage(0));
            }
        } else {
            $this->home(Message::getMessage(0));
        }
    }

    public function modificar_usuario($idUser) {
        if (LoginSystem::getInstance()->isLogged()) {
            if (LoginSystem::getInstance()->isAdmin()) {
                require('./configuracion.php');
                $usuario = Usuario::getInstance()->datos_usuario($idUser);
                $roles = Rol::getInstance()->listar_roles();
                $view = new ModificarUsuario();
                $view->show($usuario, $roles, $token);
            }else{
                $this->home(Message::getMessage(0));
            }
        } else{
            $this->home(Message::getMessage(0));
        }
    }

    public function modificar_usuario_system() {
        if (LoginSystem::getInstance()->isLogged()) {
            if (isset($_POST['nombre'])) {
                $token = $_POST['token'];
                if ($token == Session::getInstance()->token){
                    $usuario = ['nombre' => $_POST['nombre'], 'apellido' => $_POST['apellido'], 'dni' => $_POST['documento'], 'habilitado' => $_POST['habilitado'], 'email' => $_POST['email'], 'password' => $_POST['clave'], 'telefono' => $_POST['telefono'], 'rol' => $_POST['rol'], 'nombre_trabajo' => '', 'descripcion_trabajo' => '', 'ubicacion_id' => $_POST['ubicacion_id'], 'id' => $_POST['id']];

                    if (isset($_POST['nombre_trabajo']) AND isset($_POST['descripcion_trabajo']) AND $_POST['rol'] == 3) {
                        $usuario['nombre_trabajo'] = $_POST['nombre_trabajo'];
                        $usuario['descripcion_trabajo'] = $_POST['descripcion_trabajo'];
                    }

                    $args = Usuario::getInstance()->modificar_usuario($usuario);
                }else{
                    $this->home(Message::getMessage(37));
                }
            } else {
                $args = Message::getMessage(8);
            }
            $this->listar_usuarios($args);
        } else {
            $this->home(Message::getMessage(0));
        }
    }

    public function eliminar_usuario($idUser) {
        if (LoginSystem::getInstance()->isLogged()) {
            if (LoginSystem::getInstance()->isAdmin()) {
                $args = Usuario::getInstance()->eliminar_usuario($idUser);
                $this->listar_usuarios($args);
            } else {
                $this->home(Message::getMessage(0));
            }
        } else {
            $this->home(Message::getMessage(0));
        }
    }
}