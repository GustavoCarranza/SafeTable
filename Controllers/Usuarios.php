<?php

class Usuarios extends Controllers
{
    public function __construct()
    {
        parent::__construct();
        //validar la variable de sesion una vez logueados que esta creada en el controlador Login
        sessionStart();
        session_regenerate_id(true);
        if (empty($_SESSION['login'])) {
            header('location: ' . BASE_URL() . '/login');
        }
        getPermisos(2);
    }

    public function usuarios()
    {
        if (empty($_SESSION['permisosModulo']['r'])) {
            header("Location:" . Base_URL() . '/dashboard');
        }
        $data['page_tag'] = "Usuarios - SafeTable";
        $data['page_title'] = "Usuarios - SafeTable";
        $data['page_name'] = "usuarios";
        $data['page_functions_js'] = "funciones_usuarios.js";
        $this->views->getView($this, "usuarios", $data);
    }

    //Metodo para agregar y  actualizar usuarios a la base de datos
    public function setUsuario()
    {
        //Validamos que haya una repuesta de tipo POST
        if ($_POST) {
            //Validamos que cada dato no se encuentre vacio 
            if (empty($_POST['txtNombres']) || empty($_POST['txtApellidos']) || empty($_POST['txtCorreo']) || empty($_POST['txtUsuario']) || empty($_POST['txtPassword']) || empty($_POST['txtPasswordConfirm']) || empty($_POST['listRolid']) || empty(['listStatus'])) {
                //Creamos una variable donde almacenamos un array con el estado y lo punteamos a false y agregamos un mensaje de error
                $arrReponse = array('status' => false, 'msg' => 'Datos incorrectos');
            } else {
                //Creamos las variables determinadamos de los names de los inputs de los formularios vamos utilizar un metodo que se encuentra en el helper (strClean) que nos permite limpiar cada campo por cuestion de seguridad y otras funciones de PHP como ucwords e intVal
                $strNombres = ucwords(strClean($_POST['txtNombres']));
                $strApellidos = ucwords(strClean($_POST['txtApellidos']));
                $strCorreo = strtolower(strClean($_POST['txtCorreo']));
                $strUsuario = strClean($_POST['txtUsuario']);
                $intTipoid = intval(strClean($_POST['listRolid']));
                $intStatus = intval(strClean($_POST['listStatus']));
                $request_user = "";
                //Creamos la variable para el password y lo encriptamos 
                $strPassword = hash("SHA256", $_POST['txtPassword']);
                //Creamos la variable para acceder a la invocacion del metodo que sera creado en el modelo para ejecutar la consulta a la base de datos juntos con los parametros
                if ($_SESSION['permisosModulo']['w']) {
                    $request_user = $this->model->insertUsuario($strNombres, $strApellidos, $strCorreo, $strUsuario, $strPassword, $intTipoid, $intStatus);
                    //Validamos la variable que request_user para los mensajes de error como usuario repetido o correo repetido
                }
                if ($request_user > 0) {
                    $arrReponse = array('status' => true, 'msg' => 'Datos guardados correctamente');
                } else if ($request_user == 0) {
                    $arrReponse = array('status' => false, 'msg' => '!Atención¡ el usuario o el correo ya existen, prueba con otro');
                } else {
                    $arrReponse = array('status' => false, 'msg' => '!Error¡ algo ha ocurrido en el envio de datos');
                }
            }
            echo json_encode($arrReponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    //Metodo para extraer los registros de la tabla usuarios
    public function getUsuarios()
    {
        if ($_SESSION['permisosModulo']['r']) {
            //Creamos un variable para acceder a la invocacion del metodo a crear
            $arrData = $this->model->selectUsuarios();
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
                if ($_SESSION['permisosModulo']['r']) {
                    $btnView = ' 
                    <button class="btn btn-secondary btn-sm" onclick="btnViewUsuario(' . $arrData[$i]['iduser'] . ')" title = "Ver usuario"><i class="fas fa-eye"></i></button>';
                }
                if ($_SESSION['permisosModulo']['u']) {
                    //Aqui validamos si el usuario es 1 o sea el super admin y aparte ese usuario tiene rol 1 es decir el administrador
                    if (($_SESSION['idUser'] == 1 and $_SESSION['UserData']['idrol'] == 1) ||
                        ($_SESSION['UserData']['idrol'] == 1 and $arrData[$i]['idrol'] != 1)
                    ) {

                        $btnUpdate = '
                    <button class="btn btn-sm" style="background: #015D80; color:#fff;" onclick="btnUpdatePass(' . $arrData[$i]['iduser'] . ')" title = "Cambiar password a usuario"><i class="fas fa-lock"></i></button>
                    <button class="btn btn-success btn-sm" onclick="btnUpdateUser(this,' . $arrData[$i]['iduser'] . ')" title = "Actualizar usuario"><i class="fas fa-edit"></i></button>';
                    } else {
                        $btnUpdate = '
                    <button class="btn btn-sm" style="background: #015D80; color:#fff;" disabled><i class="fas fa-lock"></i></button>
                    <button class="btn btn-success btn-sm" disabled><i class="fas fa-edit"></i></button>';
                    }
                }
                if ($_SESSION['permisosModulo']['d']) {
                    if (($_SESSION['idUser'] == 1 and $_SESSION['UserData']['idrol'] == 1) ||
                        ($_SESSION['UserData']['idrol'] == 1 and $arrData[$i]['idrol'] != 1) and
                        ($_SESSION['UserData']['iduser'] != $arrData[$i]['iduser'])
                    ) {
                        $btnDelete = '
                    <button class="btn btn-danger btn-sm" onclick="btnDeletedUser(' . $arrData[$i]['iduser'] . ')" title = "Eliminar usuario"><i class="fas fa-trash"></i></button>';
                    } else {
                        $btnDelete = '
                    <button class="btn btn-danger btn-sm" disabled><i class="fas fa-trash"></i></button>';
                    }
                }
                //Con el array le asignamos un elemento 'options' que ese elemento esta declarado en la funcion de js para identificar los botones y le creamos el HTML para los botones 
                $arrData[$i]['options'] = '<div class="text-center">'
                    . $btnView . ' ' . $btnUpdate . ' ' . $btnDelete . ' </div>';
            }
            echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        }

        die();
    }

    //Metodo para extraer la informacion del usuario 
    public function getUsuario($iduser)
    {
        if ($_SESSION['permisosModulo']['r']) {
            //Creamos una variable en donde le alojamos el parametro que requerimos en este caso el id del usuario con la funcion intval convertimos ese valor en entero
            $idusuario = intval($iduser);
            //validamos si la variable es mayor a 0, es decir, si tiene algun valor creamos el arreglo de datos y accedemos al invocacion del metodo en el modelo y le pasamos el parametro del id 
            if ($idusuario > 0) {
                $arrData = $this->model->selectUsuario($idusuario);
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

    //Metodo para cambiar la contraseña del usuario
    public function updatePass($iduser)
    {
        if ($_SESSION['permisosModulo']['u']) {
            $idusuario = intval($iduser);
            if ($_POST && $idusuario > 0) {
                // Verificar si los campos de contraseña no están vacíos
                if (empty($_POST['txtUpdatePassword']) || empty($_POST['txtUpdatePasswordConfirm'])) {
                    $arrReponse = array('status' => false, 'msg' => 'Datos incorrectos');
                } else {
                    $strPassword = strClean($_POST['txtUpdatePassword']);
                    $request_user = "";
                    // Hash de la contraseña
                    $strPasswordHashed = hash("SHA256", $strPassword);
                    if ($_SESSION['permisosModulo']['u']) {
                        // Llamar al método updatePassword del modelo para cambiar la contraseña
                        $request_user = $this->model->updatePassword($idusuario, $strPasswordHashed);
                    }
                    if ($request_user) {
                        $arrReponse = array('status' => true, 'msg' => 'Contraseña actualizada correctamente');
                    } else {
                        $arrReponse = array('status' => false, 'msg' => 'No es posible actualizar la contraseña');
                    }
                }
                echo json_encode($arrReponse, JSON_UNESCAPED_UNICODE);
            }
        }
        die();
    }

    //Metodo para actualizar informacion del usuario
    public function updateUsuario($iduser)
    {
        if ($_SESSION['permisosModulo']['u']) {
            $idusuario = intval($iduser);
            //Validamos que haya una repuesta de tipo POST
            if ($_POST && $idusuario > 0) {
                //Validamos que cada dato no se encuentre vacio 
                if (empty($_POST['txtNombresUpdate']) || empty($_POST['txtApellidosUpdate']) || empty($_POST['txtCorreoUpdate']) || empty($_POST['txtUsuarioUpdate']) || empty($_POST['listRolidUpdate']) || empty($_POST['listStatusUpdate'])) {
                    //Creamos una variable donde almacenamos un array con el estado y lo punteamos a false y agregamos un mensaje de error
                    $arrReponse = array('status' => false, 'msg' => 'Datos incorrectos');
                } else {
                    //Creamos las variables determinadamos de los names de los inputs de los formularios vamos utilizar un metodo que se encuentra en el helper (strClean) que nos permite limpiar cada campo por cuestion de seguridad y otras funciones de PHP como ucwords e intVal
                    $strNombres = ucwords(strClean($_POST['txtNombresUpdate']));
                    $strApellidos = ucwords(strClean($_POST['txtApellidosUpdate']));
                    $strCorreo = strtolower(strClean($_POST['txtCorreoUpdate']));
                    $strUsuario = strClean($_POST['txtUsuarioUpdate']);
                    $intTipoid = intval(strClean($_POST['listRolidUpdate']));
                    $intStatus = intval(strClean($_POST['listStatusUpdate']));
                    $request_user = "";
                    //Creamos la variable para acceder a la invocacion del metodo que sera creado en el modelo para ejecutar la consulta a la base de datos juntos con los parametros
                    $request_user = $this->model->updateUsuario($idusuario, $strNombres, $strApellidos, $strCorreo, $strUsuario, $intTipoid, $intStatus);
                    //Validamos la variable que request_user para los mensajes de error como usuario repetido o correo repetido
                    if ($request_user > 0) {
                        $arrReponse = array('status' => true, 'msg' => 'Datos actualizados correctamente');
                    } else if ($request_user == 0) {
                        $arrReponse = array('status' => false, 'msg' => '!Atención¡ el usuario o el correo ya existen, prueba con otro');
                    } else {
                        $arrReponse = array('status' => false, 'msg' => '!Error¡ algo ha ocurrido en el envio de datos');
                    }
                }
                echo json_encode($arrReponse, JSON_UNESCAPED_UNICODE);
            }
        }
        die();
    }

    //Metodo para eliminar usuario
    public function deleteUsuario()
    {
        //Validamos si existe una peticion de tipo POST 
        if ($_POST) {
            if ($_SESSION['permisosModulo']['d']) {
                //Creamo una variable para almacenar el id del registro
                $intId = intval($_POST['iduser']);
                $request_Delete = $this->model->deleteUsuario($intId);
                //Validamos si la variable es verdadera ejecutamos el mensaje de eliminacion
                if ($request_Delete == 'ok') {
                    $arrReponse = array('status' => true, 'msg' => 'Se ha eliminado el usuario');
                } else {
                    $arrReponse = array('status' => false, 'msg' => 'No es posible eliminar el usuario');
                }
                echo json_encode($arrReponse, JSON_UNESCAPED_UNICODE);
            }
        }
        die();
    }

    //Vista perfil de usuario 
    public function perfil()
    {
        if (empty($_SESSION['permisosModulo']['r'])) {
            header("Location:" . Base_URL() . '/dashboard');
        }
        $data['page_tag'] = "Perfil - SafeTable";
        $data['page_title'] = "Perfil - SafeTable";
        $data['page_name'] = "perfil";
        $data['page_functions_js'] = "function_perfil.js";
        $this->views->getView($this, "perfil", $data);
    }

    //Metodo para actualizar la informacion del perfil del usuario
    public function putPerfil()
    {
        //Validamos que haya una repuesta de tipo POST
        if ($_POST) {
            //Validamos que cada dato no se encuentre vacio 
            if (empty($_POST['txtNombresUpdate']) || empty($_POST['txtApellidosUpdate']) || empty($_POST['txtCorreoUpdate']) || empty($_POST['txtUsuarioUpdate'])) {
                //Creamos una variable donde almacenamos un array con el estado y lo punteamos a false y agregamos un mensaje de error
                $arrReponse = array('status' => false, 'msg' => 'Datos incorrectos');
            } else {
                //Creamos las variables determinadamos de los names de los inputs de los formularios vamos utilizar un metodo que se encuentra en el helper (strClean) que nos permite limpiar cada campo por cuestion de seguridad y otras funciones de PHP como ucwords e intVal
                $idusuario = $_SESSION['idUser'];
                $strNombres = ucwords(strClean($_POST['txtNombresUpdate']));
                $strApellidos = ucwords(strClean($_POST['txtApellidosUpdate']));
                $strCorreo = strtolower(strClean($_POST['txtCorreoUpdate']));
                $strUsuario = strClean($_POST['txtUsuarioUpdate']);
                //Creamos la variable para acceder a la invocacion del metodo que sera creado en el modelo para ejecutar la consulta a la base de datos juntos con los parametros
                $request_user = $this->model->updatePerfil($idusuario, $strNombres, $strApellidos, $strCorreo, $strUsuario);
                //Validamos la variable que request_user para los mensajes de error como usuario repetido o correo repetido
                if ($request_user > 0) {
                    sessionUser($_SESSION['idUser']);
                    $arrReponse = array('status' => true, 'msg' => 'Datos actualizados correctamente');
                } else if ($request_user == 0) {
                    $arrReponse = array('status' => false, 'msg' => '!Atención¡ el usuario o el correo ya existen, prueba con otro');
                } else {
                    $arrReponse = array('status' => false, 'msg' => '!Error¡ algo ha ocurrido en el envio de datos');
                }
            }
            echo json_encode($arrReponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    //Metodo para cambiar la contraseña del perfil del usuario 
    public function updatePassPerfil()
    {
        if ($_POST) {
            if (empty($_POST['txtPasswordActual']) || empty($_POST['txtPasswordNew']) || empty($_POST['txtPasswordNewConfirm'])) {
                $arrReponse = array('status' => false, 'msg' => 'Datos incorrectos');
            } else {
                $idUsuario = $_SESSION['idUser'];
                $strPasswordActual = strClean($_POST['txtPasswordActual']);
                $strPasswordHashed = hash("SHA256", $strPasswordActual);
                $strPasswordNew = strClean($_POST['txtPasswordNew']);
                $strPasswordHashedNew = hash("SHA256", $strPasswordNew);

                // Verificar si la contraseña actual coincide con la almacenada en la base de datos
                $request_user = $this->model->checkPasswordPerfil($idUsuario, $strPasswordHashed);

                if ($request_user > 0) {
                    // Llamar al método updatePassword del modelo solo si la contraseña actual es correcta
                    $request_update = $this->model->updatePasswordPerfil($idUsuario, $strPasswordHashed, $strPasswordHashedNew);

                    if ($request_update > 0) {
                        $arrReponse = array('status' => true, 'msg' => 'Contraseña cambiada correctamente');
                    } else {
                        $arrReponse = array('status' => false, 'msg' => '!Error¡ Algo ha ocurrido en el proceso de actualización de contraseña');
                    }
                } else {
                    $arrReponse = array('status' => false, 'msg' => '!Atención¡ La contraseña actual es incorrecta');
                }
            }
            echo json_encode($arrReponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }
}
