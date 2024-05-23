<?php

class AddRestaurant extends Controllers{
    public function __construct()
    {
        parent::__construct();
        //validar la variable de sesion una vez logueados que esta creada en el controlador Login
        sessionStart();
        if(empty($_SESSION['login']))
        {
            header('location: ' . BASE_URL() . '/login');
        }
         //Esta funcion esta creada en el archivo de helpers el valor depende del modulo en el que estamos
         getPermisos(4);
    }

    public function addRestaurant()
    {
        if (empty($_SESSION['permisosModulo']['r'])) {
            header("Location:" . Base_URL() . '/dashboard');
        }
        $data['page_tag'] = "Agregar restaurant - SafeTable";
        $data['page_title'] = "Agregar restaurant - SafeTable";
        $data['page_name'] = "addRestaurant";
        $data['page_functions_js'] = "funciones_addrestaurantes.js";
        $this->views->getView($this, "addRestaurant", $data);
    }

    //Metodo para extraer los registros de la base de datos
    public function getRestaurantes()
    {
        if ($_SESSION['permisosModulo']['r']) {
            $arrData = $this->model->selectRestaurantes();
            for ($i = 0; $i < count($arrData); $i++) {
                $btnEdit = "";
                $btnDelete = "";
                 //Asignamos un estilo HTML segun el estado de cada elemento del array
                 if ($arrData[$i]['status'] == 1) {
                    $arrData[$i]['status'] = '<span class="bagde bg-success" style="color:#fff; padding:5px;"><i class="fas fa-check-circle"></i> Activo </span>';
                } else {
                    $arrData[$i]['status'] = '<span class="bagde bg-danger" style="color:#fff; padding:5px;"><i class="fas fa-times-circle"></i> Inactivo </span>';
                }

                //Si tiene permisos para editar mostramos el boton de editar
                if ($_SESSION['permisosModulo']['u']) {
                    $btnEdit = '<button class="btn btn-success btn-sm" onclick="btnUpdateRestaurante(this,' . $arrData[$i]['idrestaurante'] . ')" title = "Actualizar Restaurante"><i class="fas fa-edit"></i></button>';
                }
                //Si tiene permisos para eliminar mostrar el boton 
                if ($_SESSION['permisosModulo']['d']) {
                    $btnDelete = '<button class="btn btn-danger btn-sm" onclick="btnDeletedRestaurante(' . $arrData[$i]['idrestaurante'] . ')" title = "Eliminar Restaurante"><i class="fas fa-trash"></i></button>';
                }
                $arrData[$i]['options'] = '<div class="text-center">' . $btnEdit . ' ' . $btnDelete . '</div>';
            }
            echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    //Metodo para agregar restaurantes
    public function setRestaurantes()
    {
         //Validamos que haya una repuesta de tipo POST
         if ($_POST) {
            //Validamos que cada dato no se encuentre vacio 
            if (empty($_POST['txtNombre']) || empty($_POST['txtDescripcion']) || empty(['listStatus'])) {
                //Creamos una variable donde almacenamos un array con el estado y lo punteamos a false y agregamos un mensaje de error
                $arrReponse = array('status' => false, 'msg' => 'Datos incorrectos');
            } else {
                //Creamos las variables determinadamos de los names de los inputs de los formularios vamos utilizar un metodo que se encuentra en el helper (strClean) que nos permite limpiar cada campo por cuestion de seguridad y otras funciones de PHP como ucwords e intVal
                $strNombre = ucwords(strClean($_POST['txtNombre']));
                $strDescripcion = strClean($_POST['txtDescripcion']);
                $intStatus = strtolower(strClean($_POST['listStatus']));
                //Creamos la variable para acceder a la invocacion del metodo que sera creado en el modelo para ejecutar la consulta a la base de datos juntos con los parametros
                if ($_SESSION['permisosModulo']['w']) {
                    $request_user = $this->model->insertRestaurante($strNombre, $strDescripcion, $intStatus);
                    //Validamos la variable que request_user para los mensajes de error como usuario repetido o correo repetido
                }
                if ($request_user > 0) {
                    $arrReponse = array('status' => true, 'msg' => 'Datos guardados correctamente');
                } else {
                    $arrReponse = array('status' => false, 'msg' => '!Error¡ algo ha ocurrido en el envio de datos');
                }
            }
            echo json_encode($arrReponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    //Metodo para extraer la informacion del restaurante 
    public function getRestaurante($idrestaurante)
    {
        if ($_SESSION['permisosModulo']['r']) {
            //Creamos una variable en donde le alojamos el parametro que requerimos en este caso el id del usuario con la funcion intval convertimos ese valor en entero
            $id = intval($idrestaurante);
            //validamos si la variable es mayor a 0, es decir, si tiene algun valor creamos el arreglo de datos y accedemos al invocacion del metodo en el modelo y le pasamos el parametro del id 
            if ($id > 0) {
                $arrData = $this->model->selectRestaurante($id);
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

    //Metodo para actualizar la informacion del restaurante
    public function updateRestaurante($idrestaurante)
    {
        if ($_SESSION['permisosModulo']['u']) {
            $id = intval($idrestaurante);
            //Validamos que haya una repuesta de tipo POST
            if ($_POST && $id > 0) {
                //Validamos que cada dato no se encuentre vacio 
                if (empty($_POST['txtNombreEdit']) || empty($_POST['txtDescripcionEdit']) || empty($_POST['listStatusEdit'])) {
                    //Creamos una variable donde almacenamos un array con el estado y lo punteamos a false y agregamos un mensaje de error
                    $arrReponse = array('status' => false, 'msg' => 'Datos incorrectos');
                } else {
                    //Creamos las variables determinadamos de los names de los inputs de los formularios vamos utilizar un metodo que se encuentra en el helper (strClean) que nos permite limpiar cada campo por cuestion de seguridad y otras funciones de PHP como ucwords e intVal
                    $strNombre = ucwords(strClean($_POST['txtNombreEdit']));
                    $strDescripcion = ucwords(strClean($_POST['txtDescripcionEdit']));
                    $intStatus = intval(strClean($_POST['listStatusEdit']));
                    //Creamos la variable para acceder a la invocacion del metodo que sera creado en el modelo para ejecutar la consulta a la base de datos juntos con los parametros
                    $request_user = $this->model->EditRestaurante($id, $strNombre, $strDescripcion, $intStatus);
                    //Validamos la variable que request_user para los mensajes de error como usuario repetido o correo repetido
                    if ($request_user > 0) {
                        $arrReponse = array('status' => true, 'msg' => 'Datos actualizados correctamente');
                    } else {
                        $arrReponse = array('status' => false, 'msg' => '!Error¡ algo ha ocurrido en el envio de datos');
                    }
                }
                echo json_encode($arrReponse, JSON_UNESCAPED_UNICODE);
            }
        }
        die();
    }

    //Metodo para eliminar restaurantes
    public function deleteRestaurante()
    {
         //Validamos si existe una peticion de tipo POST 
        if ($_POST) {
            if ($_SESSION['permisosModulo']['d']) {
                //Creamo una variable para almacenar el id del registro
                $intId = intval($_POST['idrestaurante']);
                $request_Delete = $this->model->deleteRestaurant($intId);
                //Validamos si la variable es verdadera ejecutamos el mensaje de eliminacion
                if ($request_Delete == 'ok') {
                    $arrReponse = array('status' => true, 'msg' => 'Se ha eliminado el restaurante');
                } else {
                    $arrReponse = array('status' => false, 'msg' => 'No es posible eliminar el restaurante');
                }
                echo json_encode($arrReponse, JSON_UNESCAPED_UNICODE);
            }
        }
        die();
    }
}
?>