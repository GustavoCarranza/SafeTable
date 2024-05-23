<?php

class Destinations extends Controllers
{
    public function __construct()
    {
        parent::__construct();
        //validar la variable de sesion una vez logueados que esta creada en el controlador Login
        sessionStart();
        if (empty($_SESSION['login'])) {
            header('location: ' . BASE_URL() . '/login');
        }
        //Esta funcion esta creada en el archivo de helpers el valor depende del modulo en el que estamos
        getPermisos(5);
    }

    public function destinations()
    {
        if (empty($_SESSION['permisosModulo']['r'])) {
            header("Location:" . Base_URL() . '/dashboard');
        }
        $data['page_tag'] = "Destinations - SafeTable";
        $data['page_title'] = "Destinations - SafeTable";
        $data['page_name'] = "destinations";
        $data['page_functions_js'] = "funciones_destinations.js";
        $this->views->getView($this, "destinations", $data);
    }

    //Metodo para mostrar los registros en la tabla 
    public function getReservas()
    {
        if ($_SESSION['permisosModulo']['r']) {
            $arrData = $this->model->selectReservas();
            for ($i = 0; $i < count($arrData); $i++) {
                $btnView = "";
                $btnEdit = "";
                $btnDelete = "";

                //Si tiene permisos de lectura habilitamos el boton de ver informacion
                if ($_SESSION['permisosModulo']['r']) {
                    $btnView = '<button class="btn btn-secondary btn-sm" onclick="btnViewReserva(' . $arrData[$i]['idreservasD'] . ')" title = "Ver Reservacion"><i class="fas fa-eye"></i></button>';
                }
                //Si tiene permisos para editar mostramos el boton de editar
                if ($_SESSION['permisosModulo']['u']) {
                    $btnEdit = '<button class="btn btn-success btn-sm" onclick="btnUpdateReserva(this,' . $arrData[$i]['idreservasD'] . ')" title = "Actualizar Reservacion"><i class="fas fa-edit"></i></button>';
                }
                //Si tiene permisos para eliminar mostrar el boton 
                if ($_SESSION['permisosModulo']['d']) {
                    $btnDelete = '<button class="btn btn-danger btn-sm" onclick="btnDeletedReserva(' . $arrData[$i]['idreservasD'] . ')" title = "Eliminar Reservacion"><i class="fas fa-trash"></i></button>';
                }
                $arrData[$i]['options'] = '<div class="text-center"> ' . $btnView . ' ' . $btnEdit . ' ' . $btnDelete . '</div>';
            }
            echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    //Metodo para extraer los destinations al select 
    public function getSelectDestinations()
    {
        //creamos una variable como una cadena vacia, la utilizaremo para las opciones HMTL dinamicamente
        $htmlOptions = "";
        //Creamos una variable donde accedemos a la invocacion del modelo a crear que nos servira de consulta a la base de datos
        $arrData = $this->model->selectDestinations();
        //Realizmaos una validacion para comprobar si hay elementos en el arreglo 
        if (count($arrData) > 0) {
            //con el ciclo for y con la validacion if validamos si el estado "status" de cada rol es igual a 1, esto porque pueden estar inactivos dentro de la base 
            for ($i = 0; $i < count($arrData); $i++) {
                if ($arrData[$i]['status'] == 1) {
                    //Aqui con la variables que creamos al principio que fue una cadena vacia cambiamos el valor con etiqueta HTML en los opcion y concatenamos el arreglo y la variable inicializada en el for para que recorra cada uno de los elementos junto con el id y el nombre del rol
                    $htmlOptions .= '<option value="' . $arrData[$i]['iddestinations'] . '">' . $arrData[$i]['nombre'] . '</option>';
                }
            }
        }
        //imprimimos la variable para invocarla
        echo $htmlOptions;
        die();
    }

    //Metodo para agregar reservaciones
    public function setDestinations()
    {
        if ($_SESSION['permisosModulo']['w']) {
            //Validamos si existe una peticion de tipo post 
            if ($_POST) {
                //Creamos variables donde almacenamos en cada una el name del input
                $idusuario = $_SESSION['UserData']['usuario'];
                $listDestinations = intval($_POST['listDestinations']);
                $strHuesped = ucwords(strClean($_POST['txtHuesped']));
                $strApellidos = ucwords(strClean($_POST['txtApellidos']));
                $intVilla = intval($_POST['txtVilla']);
                $strHotel = strtoupper(strClean($_POST['txtHotel']));
                $intAdultos = intval($_POST['txtAdultos']);
                $intKids = intval($_POST['txtKids']);
                $strFecha = strClean($_POST['txtFecha']);
                $strHorario = strClean($_POST['txtHorario']);
                $strComentarios = strClean($_POST['txtComentarios']);

                //Creamos variable para almacenar la invocacion al metodo en el modelo 
                $request_rest = $this->model->insertReservas($idusuario, $listDestinations, $strHuesped, $strApellidos, $intVilla, $strHotel, $intAdultos, $intKids, $strFecha, $strHorario, $strComentarios);
                //Validamos la variable 
                if ($request_rest > 0) {
                    $arrResponse = array('status' => true, 'msg' => 'Reservación creada correctamente');
                } else {
                    $arrResponse = array('status' => false, 'msg' => 'No es posible crear la reservación');
                }
                echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
            }
        }
        die();
    }

    //Metodo para extraer la informacion de la reserva 
    public function getReserva($idreservasD)
    {
        if ($_SESSION['permisosModulo']['r']) {
            //Creamos una variable en donde le alojamos el parametro que requerimos en este caso el id del usuario con la funcion intval convertimos ese valor en entero
            $idReserva = intval($idreservasD);
            //validamos si la variable es mayor a 0, es decir, si tiene algun valor creamos el arreglo de datos y accedemos al invocacion del metodo en el modelo y le pasamos el parametro del id 
            if ($idReserva > 0) {
                $arrData = $this->model->selectReserva($idReserva);
                //Si el arreglo esta vacio mostrara un msj de error
                if (empty($arrData)) {
                    $arrReponse = array('status' => false, 'msg' => 'Datos no encontrados');
                    //En caso contrario imprimira el arreglo de datos
                } else {
                    $arrReponse = array('status' => true, 'data' => $arrData);
                }
                echo json_encode($arrReponse, JSON_UNESCAPED_UNICODE);
            }
        }
        die();
    }

    //Metodo para editar la informacion de la reserva 
    public function updateRerserva($idReserva)
    {
        if ($_SESSION['permisosModulo']['u']) {
            $idreserva = intval($idReserva);
            //Validamos si hay una solicitud POST y el id del registro
            if ($_POST && $idreserva > 0) {
                //Creamos las variables donde almacenamos el name del input
                $idusuario = $_SESSION['UserData']['usuario'];
                $listDestination = intval($_POST['listDestinationsEdit']);
                $strHuesped = ucwords(strClean($_POST['txtHuespedEdit']));
                $strApellidos = ucwords(strClean($_POST['txtApellidosEdit']));
                $intVilla = intval($_POST['txtVillaEdit']);
                $strHotel = strtoupper(strClean($_POST['txtHotelEdit']));
                $intAdultos = intval($_POST['txtAdultosEdit']);
                $intKids = intval($_POST['txtKidsEdit']);
                $strFecha = strClean($_POST['txtFechaEdit']);
                $strHorario = strClean($_POST['txtHorarioEdit']);
                $strComentarios = strClean($_POST['txtComentariosEdit']);

                $request_rest = $this->model->updateRerserva($idreserva, $idusuario, $listDestination, $strHuesped, $strApellidos, $intVilla, $strHotel, $intAdultos, $intKids, $strFecha, $strHorario, $strComentarios);

                if ($request_rest > 0) {
                    $arrReponse = array('status' => true, 'msg' => 'Información actualizada correctamente');
                } else {
                    $arrResponse = array('status' => false, 'msg' => 'No es posible actualizar la información');
                }
                echo json_encode($arrReponse, JSON_UNESCAPED_UNICODE);
            }
        }
        die();
    }

    //Metodo para eliminar la reservacion
    public function deleteReserva()
    {
        //Validamos si existe una peticion de tipo POST 
        if ($_POST) {
            if ($_SESSION['permisosModulo']['d']) {
                //Creamo una variable para almacenar el id del registro
                $intId = intval($_POST['idreservasD']);
                $idusuario = $_SESSION['UserData']['usuario'];
                $request_Delete = $this->model->deleteReservacion($intId, $idusuario);
                //Validamos si la variable es verdadera ejecutamos el mensaje de eliminacion
                if ($request_Delete == 'ok') {
                    $arrReponse = array('status' => true, 'msg' => 'Se ha eliminado la reservación');
                } else {
                    $arrReponse = array('status' => false, 'msg' => 'No es posible eliminar la reservación');
                }
                echo json_encode($arrReponse, JSON_UNESCAPED_UNICODE);
            }
        }
        die();
    }
}
