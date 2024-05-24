<?php

class UsuariosModel extends Mysql
{

    //propiedades o atributos 
    private $intIdUsuario;
    private $strNombres;
    private $strApellidos;
    private $strCorreo;
    private $strUsuario;
    private $strPassword;
    private $strPasswordNew;
    private $intTipoId;
    private $intStatus;

    public function __construct()
    {
        parent::__construct();
    }

    //Metodo para insertar un usuario a la base
    public function insertUsuario(string $nombres, string $apellidos, string $correo, string $usuario, string $password, int $tipoid, int $status)
    {
        //asignamos los valores de los parametros a las propiedades
        $this->strNombres = $nombres;
        $this->strApellidos = $apellidos;
        $this->strCorreo = $correo;
        $this->strUsuario = $usuario;
        $this->strPassword = $password;
        $this->intTipoId = $tipoid;
        $this->intStatus = $status;
        $return = 0;
        //Creamos una variable donde le almacenamos el script de la consulta para verificar si un usuario o correo ya existe
        $sql = "SELECT * FROM users WHERE correo = '{$this->strCorreo}' or usuario = '{$this->strUsuario}'";
        //Creamos una variables para acceder a la invocacion del metodo que pertenece a la clase heredada Mysql
        $request = $this->select_All($sql);
        //Validamos si la variable creada esta vacia entonces hacer la insertacion del usuario
        if (empty($request)) {
            //creamos la variables con el script de la consulta para insertar el usuario
            $query_insert = "INSERT INTO users(nombres,apellidos,correo,usuario,password,rolid,status) VALUES (?,?,?,?,?,?,?)";
            //creamos un arreglo para almacenar los valores de las propiedades 
            $arrData = array($this->strNombres, $this->strApellidos, $this->strCorreo, $this->strUsuario, $this->strPassword, $this->intTipoId, $this->intStatus);
            //creamos una variable para acceder a la invocacion del metodo insert y le pasamos la variable de la consulta y la variable del arreglo
            $request_insert = $this->insert($query_insert, $arrData);
            $return =  $request_insert;
        } else {
            return 0;
        }
        return $return;
    }

    //Metodo para extraer los usuarios de la base para la tabla users
    public function selectUsuarios()
    {
        $whereAdmin = "";
        // Si el usuario actual no es el super administrador, aplicamos la restricción
        if ($_SESSION['idUser'] != 1) {
            $whereAdmin = "AND u.iduser != 1";
        }

        $sql = "SELECT u.iduser,u.nombres,u.apellidos,u.correo,u.usuario,u.rolid,u.status,r.idrol,r.nombre FROM users u INNER JOIN roles r ON u.rolid = r.idrol WHERE u.status != 0 $whereAdmin";
        $request = $this->select_All($sql);
        return $request;
    }

    //Metodo para extraer la informacion del usuario de la tabla users 
    public function selectUsuario(int $idUsuario)
    {
        //asignamos el valor del parametro a la propiedad necesaria 
        $this->intIdUsuario = $idUsuario;
        //Creamo la variable que tendran el script de la consulta a la BD 
        $sql = "SELECT u.iduser, u.nombres, u.apellidos, u.correo, u.usuario, u.rolid, u.status, r.idrol, r.nombre, CONCAT(DAY(u.dateCreated), ' de ', 
            CASE MONTH(u.dateCreated)
                WHEN 1 THEN 'enero'
                WHEN 2 THEN 'febrero'
                WHEN 3 THEN 'marzo'
                WHEN 4 THEN 'abril'
                WHEN 5 THEN 'mayo'
                WHEN 6 THEN 'junio'
                WHEN 7 THEN 'julio'
                WHEN 8 THEN 'agosto'
                WHEN 9 THEN 'septiembre'
                WHEN 10 THEN 'octubre'
                WHEN 11 THEN 'noviembre'
                WHEN 12 THEN 'diciembre'
            END, ' del ', YEAR(u.dateCreated)) AS fechaRegistro, DATE_FORMAT(u.dateCreated, '%h:%i:%s %p') AS horaRegistro FROM users u  INNER JOIN roles r ON u.rolid = r.idrol WHERE u.iduser = $this->intIdUsuario";
        $request = $this->select($sql);
        return $request;
    }

    //Metodo para cambio de contraseña del usuario
    public function updatePassword(int $idUsuario, string $password)
    {
        $this->intIdUsuario = $idUsuario;
        $this->strPassword = $password;

        $sql = "UPDATE users SET password = ? WHERE iduser = $this->intIdUsuario";
        $arrData = array($this->strPassword);
        $request = $this->update($sql, $arrData);
        return $request;
    }

    //Metodo para actualizar el usuario 
    public function updateUsuario(int $idusuario, string $nombres, string $apellidos, string $correo, string $usuario, int $tipoid, int $status)
    {
        //Asignamos los valores de los parametros a las propiedades 
        $this->intIdUsuario = $idusuario;
        $this->strNombres = $nombres;
        $this->strApellidos = $apellidos;
        $this->strCorreo = $correo;
        $this->strUsuario = $usuario;
        $this->intTipoId = $tipoid;
        $this->intStatus = $status;
        //Creamos una variable para almacenar una consulta a la base para comprobar que el usuario y correo si los tiene un usuario que no es el mismo marque error pero si es el mismo id permita actualizar 
        $sql = "SELECT * FROM users WHERE (correo = '{$this->strCorreo}' AND iduser != $this->intIdUsuario) OR (usuario = '{$this->strUsuario}' AND iduser != $this->intIdUsuario)";
        $request = $this->select_All($sql);

        if (empty($request)) {
            //creamos la consulta ya para actualizar el registro en la base
            $sql = "UPDATE users SET nombres = ?, apellidos = ?, correo = ?, usuario = ?, rolid = ?, status = ? WHERE iduser = $this->intIdUsuario";
            $arrData = array($this->strNombres, $this->strApellidos, $this->strCorreo, $this->strUsuario, $this->intTipoId, $this->intStatus);
            $request = $this->update($sql, $arrData);
        } else {
            $request = 0;
        }
        return $request;
    }

    //Metodo para eliminar usuario
    public function deleteUsuario(int $idUsuario)
    {
        //Asignamos el valor del paramentro a la propiedad
        $this->intIdUsuario = $idUsuario;

        //Creamos la variable que tendra el script de la consulta sql a la base de datos
        $sql = "UPDATE users SET status = ? WHERE iduser = $this->intIdUsuario";
        //Creamos el arreglo de datos en 0 ya que solo vamos a actualizar el status en 0 para que no se muestre en la tabla de usuarios 
        $arrData = array(0);
        //Creamo la variable que accede al metodo delete que se encuentra en la clase heredada Mysql  y le pasamos la consulta y el arreglo de datos
        $request = $this->update($sql, $arrData);
        //retornamos la variable para que se comunique con el controlador
        return $request;
    }

    //Metodo para exportar usuarios
    public function usuariosReporte()
    {
        $sql = "SELECT u.iduser,u.nombres,u.apellidos,u.correo,u.usuario,u.rolid,u.status,r.idrol,r.nombre as nombreRol,
        CONCAT(DAY(u.dateCreated), ' de ', 
        CASE MONTH(u.dateCreated)
            WHEN 1 THEN 'enero'
            WHEN 2 THEN 'febrero'
            WHEN 3 THEN 'marzo'
            WHEN 4 THEN 'abril'
            WHEN 5 THEN 'mayo'
            WHEN 6 THEN 'junio'
            WHEN 7 THEN 'julio'
            WHEN 8 THEN 'agosto'
            WHEN 9 THEN 'septiembre'
            WHEN 10 THEN 'octubre'
            WHEN 11 THEN 'noviembre'
            WHEN 12 THEN 'diciembre'
        END, ' del ', YEAR(u.dateCreated)) AS fechaCreacion,DATE_FORMAT(u.dateCreated, '%h:%i:%s %p') AS horaCreacion FROM users u INNER JOIN roles r ON u.rolid = r.idrol WHERE u.status != 0";
        $request = $this->select_All($sql);
        return $request;
    }

    //Metodo para actualizar la informacion del perfil del usuario 
    public function updatePerfil(int $idusuario, string $nombre, string $apellidos, string $correo, string $usuario)
    {

        //Asginamos los valores de los parametros a las propiedades 
        $this->intIdUsuario = $idusuario;
        $this->strNombres = $nombre;
        $this->strApellidos = $apellidos;
        $this->strCorreo = $correo;
        $this->strUsuario = $usuario;
        //Creamos una variable para almacenar una consulta a la base para comprobar que el usuario y correo si los tiene un usuario que no es el mismo marque error pero si es el mismo id permita actualizar 
        $sql = "SELECT * FROM users WHERE (correo = '{$this->strCorreo}' AND iduser != $this->intIdUsuario) OR (usuario = '{$this->strUsuario}' AND iduser != $this->intIdUsuario)";
        $request = $this->select_All($sql);
        if (empty($request)) {
            //creamos la consulta ya para actualizar el registro en la base
            $sql = "UPDATE users SET nombres = ?, apellidos = ?, correo = ?, usuario = ? WHERE iduser = $this->intIdUsuario";
            $arrData = array($this->strNombres, $this->strApellidos, $this->strCorreo, $this->strUsuario);
            $request = $this->update($sql, $arrData);
        } else {
            $request = 0;
        }
        return $request;
    }

    //Metodo para verificar que la contraseña actual coincida con la que se ingresa en el input
    public function checkPasswordPerfil(int $idUsuario, string $password)
    {
        $this->intIdUsuario = $idUsuario;
        $this->strPassword = $password;

        $sql = "SELECT * FROM users WHERE iduser = '{$this->intIdUsuario}' AND password = '{$this->strPassword}'";
        $request = $this->select_All($sql);
        return $request ? 1 : 0;
    }

    //Metodo para cambiarla contraseña del perfil de usuario 
    public function updatePasswordPerfil(int $idUsuario, string $passActual, string $passNew)
    {
        $this->intIdUsuario = $idUsuario;
        $this->strPassword = $passActual;
        $this->strPasswordNew = $passNew;

        // Verificar si la contraseña actual coincide con la almacenada en la base de datos
        $sql = "SELECT * FROM users WHERE iduser = $this->intIdUsuario AND password = '{$this->strPassword}'";
        $request = $this->select_All($sql);

        if ($request) {
            // La contraseña actual es correcta, entonces procedemos a actualizarla
            $sql = "UPDATE users SET password = ? WHERE iduser = ?";
            $arrData = array($this->strPasswordNew, $this->intIdUsuario);
            $request = $this->update($sql, $arrData);
            return $request;
        } else {
            // La contraseña actual no coincide con la almacenada en la base de datos
            return 0;
        }
    }
}
