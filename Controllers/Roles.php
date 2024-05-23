<?php

class Roles extends Controllers
{
    public function __construct()
    {
        parent::__construct();
        //validar la variable de sesion una vez logueados que esta creada en el controlador Login
        session_start();
        if (empty($_SESSION['login'])) {
            header('location: ' . Base_URL() . '/login');
        }
        getPermisos(2);
    }

    public function roles()
    {
        if (empty($_SESSION['permisosModulo']['r'])) {
            header("Location:" . Base_URL() . '/dashboard');
        }
        $data['page_tag'] = "Roles - SafeTable";
        $data['page_title'] = "Roles - SafeTable";
        $data['page_name'] = "roles";
        $data['page_functions_js'] = "funciones_roles.js";
        $this->views->getView($this, "roles", $data);
    }

    //Metodo para extraer los roles
    public function getSelectRoles()
    {
        //creamos una variable como una cadena vacia, la utilizaremo para las opciones HMTL dinamicamente
        $htmlOptions = "";
        //Creamos una variable donde accedemos a la invocacion del modelo a crear que nos servira de consulta a la base de datos
        $arrData = $this->model->selectRoles();
        //Realizmaos una validacion para comprobar si hay elementos en el arreglo 
        if (count($arrData) > 0) {
            //con el ciclo for y con la validacion if validamos si el estado "status" de cada rol es igual a 1, esto porque pueden estar inactivos dentro de la base 
            for ($i = 0; $i < count($arrData); $i++) {
                if ($arrData[$i]['status'] == 1) {
                    //Aqui con la variables que creamos al principio que fue una cadena vacia cambiamos el valor con etiqueta HTML en los opcion y concatenamos el arreglo y la variable inicializada en el for para que recorra cada uno de los elementos junto con el id y el nombre del rol
                    $htmlOptions .= '<option value="' . $arrData[$i]['idrol'] . '">' . $arrData[$i]['nombre'] . '</option>';
                }
            }
        }
        //imprimimos la variable para invocarla
        echo $htmlOptions;
        die();
    }

    //Metodo para extraer los registros para la tabla de roles 
    public function getRoles()
    {
        if ($_SESSION['permisosModulo']['r']) {
            //Creamos un variable para acceder a la invocacion del metodo a crear
            $arrData = $this->model->extractRoles();
            for ($i = 0; $i < count($arrData); $i++) {
                //Creamos 3 variables para los botones y aplicar las restricciones 
                $btnView = "";
                $btnUpdate = "";
                $btnDelete = "";
                //Asignamos un estilo HTML segun el estado de cada elemento del array
                if ($arrData[$i]['status'] == 1) {
                    $arrData[$i]['status'] = '<span class="bagde bg-success" style="color:#fff; padding:5px;"><i class="fas fa-check-circle"></i> Activo </span>';
                } else {
                    $arrData[$i]['status'] = '<span class="bagde bg-danger" style="color:#fff; padding:5px;"><i class="fas fa-times-circle"></i> Inactivo </span>';
                }
                //Creamos las validaciones a los botones segun el permiso asignado 
                if ($_SESSION['permisosModulo']['u']) {

                    $btnView = '<button class="btn btn-dark btn-sm" onclick="btnPermisosRol(' . $arrData[$i]['idrol'] . ')" title = "Otorgar permisos"><i class="fas fa-key"></i></button>';

                    $btnUpdate = '<button class="btn btn-success btn-sm" onclick="btnUpdateRol(' . $arrData[$i]['idrol'] . ')" title = "Actualizar Rol"><i class="fas fa-edit"></i></button>
                ';
                }
                if ($_SESSION['permisosModulo']['d']) {
                    $btnDelete = '<button class="btn btn-danger btn-sm" onclick="btnDeletedRol(' . $arrData[$i]['idrol'] . ')" title = "Eliminar Rol"><i class="fas fa-trash"></i></button>';
                }
                //Con el array le asignamos un elemento 'options' que ese elemento esta declarado en la funcion de js para identificar los botones y le creamos el HTML para los botones 
                $arrData[$i]['options'] = '<div class="text-center">'
                    . $btnView . ' ' . $btnUpdate . ' ' . $btnDelete . ' </div>';
            }
            echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    //Metodo para agregar roles a la base de datos 
    public function setRol()
    {
        if ($_SESSION['permisosModulo']['w']) {
            //Validamos que haya una repuesta de tipo POST
            if ($_POST) {
                //Validamos que cada dato no se encuentre vacio 
                if (empty($_POST['txtNombre']) || empty($_POST['txtDescripcion']) || empty(['listStatus'])) {
                    //Creamos una variable donde almacenamos un array con el estado y lo punteamos a false y agregamos un mensaje de error
                    $arrReponse = array('status' => false, 'msg' => 'Datos incorrectos');
                } else {
                    //Creamos las variables determinadamos de los names de los inputs de los formularios vamos utilizar un metodo que se encuentra en el helper (strClean) que nos permite limpiar cada campo por cuestion de seguridad y otras funciones de PHP como ucwords e intVal
                    $strNombre = ucwords(strClean($_POST['txtNombre']));
                    $strDescripcion = ucwords(strClean($_POST['txtDescripcion']));
                    $intStatus = intval(strClean($_POST['listStatus']));
                    //Creamos la variable para acceder a la invocacion del metodo que sera creado en el modelo para ejecutar la consulta a la base de datos juntos con los parametros
                    $request_user = $this->model->insertRol($strNombre, $strDescripcion, $intStatus);
                    //Validamos la variable que request_user para los mensajes de error como usuario repetido o correo repetido
                    if ($request_user > 0) {
                        $arrReponse = array('status' => true, 'msg' => 'Datos guardados correctamente');
                    } else if ($request_user == 0) {
                        $arrReponse = array('status' => false, 'msg' => '!Atención¡ ya existe un rol con ese nombre, prueba con otro');
                    } else {
                        $arrReponse = array('status' => false, 'msg' => '!Error¡ algo ha ocurrido en el envio de datos');
                    }
                }
                echo json_encode($arrReponse, JSON_UNESCAPED_UNICODE);
            }
        }
        die();
    }

    //Metodo para extraer la informacion del rol 
    public function getRol($idrol)
    {
        if ($_SESSION['permisosModulo']['r']) {
            $intRolid = intval($idrol);
            //validamos si la variable es mayor a 0, es decir, si tiene algun valor creamos el arreglo de datos y accedemos al invocacion del metodo en el modelo y le pasamos el parametro del id 
            if ($intRolid > 0) {
                $arrData = $this->model->selectRol($intRolid);
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

    //Metodo para actualizar la informacion de los roles 
    public function updateRol($idrol)
    {
        if ($_SESSION['permisosModulo']['u']) {
            $intRolid = intval($idrol);
            //Validamos que haya una repuesta de tipo POST y validamos la variable que tiene el id del registro sea mayor a 0 
            if ($_POST && $intRolid > 0) {
                //Validamos que cada dato no se encuentre vacio 
                if (empty($_POST['txtNombreUpdate']) || empty($_POST['txtDescripcionUpdate']) || empty($_POST['listStatusUpdate'])) {
                    //Creamos una variable donde almacenamos un array con el estado y lo punteamos a false y agregamos un mensaje de error
                    $arrReponse = array('status' => false, 'msg' => 'Datos incorrectos');
                } else {
                    //Creamos las variables determinadamos de los names de los inputs de los formularios vamos utilizar un metodo que se encuentra en el helper (strClean) que nos permite limpiar cada campo por cuestion de seguridad y otras funciones de PHP como ucwords e intVal
                    $strNombre = ucwords(strClean($_POST['txtNombreUpdate']));
                    $strDescripcion = strClean($_POST['txtDescripcionUpdate']);
                    $intStatus = intval(strClean($_POST['listStatusUpdate']));
                    //Creamos la variable para acceder a la invocacion del metodo que sera creado en el modelo para ejecutar la consulta a la base de datos juntos con los parametros
                    $request_user = $this->model->updateRol($intRolid, $strNombre, $strDescripcion, $intStatus);
                    //Validamos la variable que request_user para los mensajes de error como usuario repetido o correo repetido
                    if ($request_user > 0) {
                        $arrReponse = array('status' => true, 'msg' => 'Datos actualizados correctamente');
                    } else if ($request_user == 0) {
                        $arrReponse = array('status' => false, 'msg' => '!Atención¡ ya existe un rol con este nombre, prueba con otro');
                    } else {
                        $arrReponse = array('status' => false, 'msg' => '!Error¡ algo ha ocurrido en el envio de datos');
                    }
                }
                echo json_encode($arrReponse, JSON_UNESCAPED_UNICODE);
            }
        }
        die();
    }

    //Metodo para eliminar roles
    public function deleteRol()
    {
        if ($_SESSION['permisosModulo']['d']) {
            //Validamos si existe una peticion de tipo POST 
            if ($_POST) {
                //Creamo una variable para almacenar el id del registro
                $intId = intval($_POST['idrol']);
                $request_Delete = $this->model->deleteRol($intId);
                //Validamos si la variable es verdadera ejecutamos el mensaje de eliminacion
                if ($request_Delete == 'ok') {
                    $arrReponse = array('status' => true, 'msg' => 'Se ha eliminado el Rol');
                } else {
                    $arrReponse = array('status' => false, 'msg' => 'No es posible eliminar el rol');
                }
                echo json_encode($arrReponse, JSON_UNESCAPED_UNICODE);
            }
        }
        die();
    }
}
