<?php

class Login extends Controllers
{
    public function __construct()
    {
        //validar la variable de sesion esta creada, es decir que un usuario ya inicio sesion no permita regresar al login hasta que cierre sesion
        session_start();
        if (isset($_SESSION['login'])) {
            header('location: ' . Base_URL() . '/dashboard');
        }
        parent::__construct();
    }

    //Vista principal Home.php
    public function login()
    {
        $data['page_tag'] = "Login - SafeTable";
        $data['page_title'] = "Login - SafeTable";
        $data['page_name'] = "login";
        $data['page_functions_js'] = "functions_login.js";
        $this->views->getView($this, "login", $data);
    }

    //Metodo para validar datos en el login
    public function loginUser()
    {
        //Validamos que exista una peticion de tipo POST 
        if ($_POST) {
            //Validamos que los campos no vayan vacios
            if (empty($_POST['txtUser']) || empty($_POST['txtPassword'])) {
                $arrResponse = array('status' => false, 'msg' => 'Error de datos');
            } else {
                //Creamos variables para capturar los campos de los inputs en este caso los names y recordemos que tenemos usar hash para que cuando validemos las contraseña sea la misma encriptacion que tenemos en la base de datos 
                $strUsuario = strClean($_POST['txtUser']);
                $strPassword = hash("SHA256", $_POST['txtPassword']);
                $requestUser = $this->model->loginUser($strUsuario, $strPassword);
                //Validamos que la variable que tiene almacenada el metodo hacia el modelo no este vacia 
                if (empty($requestUser)) {
                    $arrResponse = array('status' => false, 'msg' => 'El usuario o la contraseña son incorrectos');
                } else {
                    //Devolvemos los 2 parametros que es el usuario y password
                    $arrData = $requestUser;
                    //Validamos que el arreglo de los parametros en el status sea uno, si es uno creamos las variables de sesion para utilizarlas 
                    if ($arrData['status'] == 1) {
                        $_SESSION['idUser'] = $arrData['iduser'];
                        $_SESSION['login'] = true;
                        $_SESSION['timeout'] = true;
                        $_SESSION['inicio'] = time();


                        //Creamos un arreglo de datos que sera igualado a lo que tegamos en el metodo creado en el modelo mandando la variable de sesion
                        $arrData = $this->model->sessionLogin($_SESSION['idUser']);
                        //Creamos otra variable de sesion y lo igualamos al arreglo de de datos creado esto lo hacemos para poder utilizar la informacion del usuario directamente en las vistas para cargar datos dinamicamente utilizando la variable de sesion userData
                        $_SESSION['UserData'] = $arrData;

                        $arrResponse = array('status' => true, 'msg' => 'ok');
                    } else {
                        $arrResponse = array('status' => false, 'msg' => 'El usuario esta inactivo');
                    }
                }
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }
}
