<?php

/*
**  Descripcion de ResourceController
**      
*/

class ResourceController {
    
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

/*
** HOME:
*/
    public function home($args) {
        require('./configuracion.php');
        $view = new Home();
        $menu = Menu::getInstance()->menuDelDia();
        $args = array_merge($args, ['menu' => $menu, 'isLogged' => $this->isLogged(), 'tipoUsuario'=> $this->tipoUsuario(), 'titulo' => $titulo, 'user' => $_SESSION, 'descripcion' => $descripcion, 'sitio'=>$sitio, 'mensajeDeshabilitado'=>$mensajeDeshabilitado, 'email'=>$email]);
        $view->show($args);
    }
    
/*
** LOGIN:
*/
    public function login($args) {
        require('./configuracion.php');
        if (!LoginSystem::getInstance()->isLogged()) {
            $view = new Login();
            $args = array_merge($args, ['titulo' => $titulo, 'sitio'=>$sitio, 'email' => $email]);
            $view->show($args);
        } else {
            $this->home([]);
        }
    }


    public function login_system() {
        if (!LoginSystem::getInstance()->isLogged()) {
            if (isset($_POST['username']) AND isset($_POST['password'])) {
                $user = $_POST['username'];
                $pass = $_POST['password'];
                $habilitado = $_POST['habilitado'];

                $login = LoginSystem::getInstance()->login($user, $pass, $habilitado);
            } else {
                $this->login(Message::getMessage(1));
            }
            switch ($login) {
                case "1": $this->home(Message::getMessage(2)); break;
                case "2": $this->login(Message::getMessage(1)); break;
                case "3": $this->login(Message::getMessage(19)); break;
                case "4": $this->login(Message::getMessage(20)); break;
                default : $this->home([]);;
            }
        }
    }

    public function logout_system() {
        LoginSystem::getInstance()->logout();
        $this->home(Message::getMessage(5));
    }

/*
** CONFIGURACION
*/
    public function configuracion(){
        if (LoginSystem::getInstance()->isLogged()) {
            if (LoginSystem::getInstance()->isAdmin()) {
                require('./configuracion.php');
                $args = ['token' => $token, 'titulo' => $titulo, 'sitio'=>$sitio, 'email' => $email, 'tipoUsuario' => $this->tipoUsuario()];
                $configuracion = Configuracion::getInstance()->obtenerConfiguracion();
                $view = new DatosConfiguracion();
                $view->show([], $configuracion, $args);
            } else {
                $this->home(Message::getMessage(0));
            }
        } else {
            $this->home(Message::getMessage(0));
        }

    }

    public function configuracion_system() {
        if (LoginSystem::getInstance()->isLogged()) {
            require('./configuracion.php');
            $args = ['titulo' => $titulo, 'sitio'=>$sitio, 'email' => $email, 'tipoUsuario' => $this->tipoUsuario()];
            if((isset($_POST['titulo'])) && (isset($_POST['descripcion'])) && (isset($_POST['email'])) && (isset($_POST['cant_elementos'])) && (isset($_POST['sitio'])) && (isset($_POST['mensaje']))){
                $token = $_POST['token'];
                if ($token == Session::getInstance()->token){
                    $titulo = $_POST['titulo'];
                    $descripcion = $_POST['descripcion'];
                    $email = $_POST['email'];
                    $cant_elementos = $_POST['cant_elementos'];
                    $tiempoCancelacion = $_POST['tiempoCancelacion'];
                    $sitio = $_POST['sitio'];
                    $mensaje = $_POST['mensaje'];
                    $msj = Configuracion::getInstance()->modificar_configuracion($titulo, $descripcion, $email, $cant_elementos, $tiempoCancelacion, $sitio, $mensaje);
                }else{
                    $this->home(Message::getMessage(37));
                }
            } else {
                $msj = Message::getMessage(8);
            }
            $configuracion = Configuracion::getInstance()->obtenerConfiguracion();
            $view = new DatosConfiguracion();
            $view->show($msj, $configuracion, $args);
        } else {
            $this->home(Message::getMessage(0));
        }
    }

    public function webhook(){
        $view = new WebHook();
        $view->show();
    }


}