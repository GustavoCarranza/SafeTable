<?php

class Dashboard extends Controllers
{
    public function __construct()
    {
        sessionStart();
        parent::__construct();
        //validar la variable de sesion una vez logueados que esta creada en el controlador Login
        //session_start();
        if (empty($_SESSION['login'])) {
            header('location: ' . BASE_URL() . '/login');
        }
        //Esta funcion esta creada en el archivo de helpers el valor depende del modulo en el que estamos
        getPermisos(1);
    }

    public function dashboard()
    {
        $data['page_tag'] = "Dashboard - SafeTable";
        $data['page_title'] = "Dashboard - SafeTable";
        $data['page_name'] = "dashboard";
        $data['page_functions_js'] = "funciones_dashboard.js";
        $this->views->getView($this, "dashboard", $data);
    }

    //Metodo para calcular "Destination con mas reservas"
    public function getDashboardMayor()
    {
        $destinations = $this->model->obtenerinfoDestinations();

        echo json_encode($destinations);
    }

    public function getComensalesR()
    {
        $comensales = $this->model->obtenerComensalesR();

        echo json_encode($comensales);
    }

    public function getComensalesD()
    {
        $comensales = $this->model->obtenerComensalesD();

        echo json_encode($comensales);
    }

    //Contador para la cantidad de usuarios
    public function getContadoresUsuarios()
    {
        if ($_SESSION['permisosModulo']['r']) {
            //Creamos una variable en donde le alojamos el parametro que requerimos en este caso el id del usuario con la funcion intval convertimos ese valor en entero
            $arrData = $this->model->selectContadoresUsuarios();
            //Si el arreglo esta vacio mostrara un msj de error
            if (empty($arrData)) {
                $arrReponse = array('status' => false, 'msg' => 'Datos no encontrados');
                //En caso contrario imprimira el arreglo de datos
            } else {
                $arrReponse = array('status' => true, 'data' => $arrData);
            }
            echo json_encode($arrReponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    //metodo para la cantidad de reservas de R y D
    public function getContadoresReservas()
    {
        if ($_SESSION['permisosModulo']['r']) {
            //Creamos una variable en donde le alojamos el parametro que requerimos en este caso el id del usuario con la funcion intval convertimos ese valor en entero
            $arrData = $this->model->selectContadoresReservas();
            //Si el arreglo esta vacio mostrara un msj de error
            if (empty($arrData)) {
                $arrReponse = array('status' => false, 'msg' => 'Datos no encontrados');
                //En caso contrario imprimira el arreglo de datos
            } else {
                $arrReponse = array('status' => true, 'data' => $arrData);
            }
            echo json_encode($arrReponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    //Contador para la cantidad de comensales
    public function getContadoresComensales()
    {
        if ($_SESSION['permisosModulo']['r']) {
            //Creamos una variable en donde le alojamos el parametro que requerimos en este caso el id del usuario con la funcion intval convertimos ese valor en entero
            $arrData = $this->model->selectContadoresComensales();
            //Si el arreglo esta vacio mostrara un msj de error
            if (empty($arrData)) {
                $arrReponse = array('status' => false, 'msg' => 'Datos no encontrados');
                //En caso contrario imprimira el arreglo de datos
            } else {
                $arrReponse = array('status' => true, 'data' => $arrData);
            }
            echo json_encode($arrReponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

}
