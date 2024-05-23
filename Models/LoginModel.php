<?php

class LoginModel extends Mysql
{
    //Propiedades
    private $intIdUsuario;
    private $strUsuario;
    private $strPassword;

    public function __construct()
    {
        parent::__construct();
    }

    //Metodo para el funcionamiento del login 
    public function loginUser(string $usuario, string $password)
    {
        //Asignamos los valores de los parametros a las propiedades 
        $this->strUsuario = $usuario;
        $this->strPassword = $password;
        //Creamos la variable para almacenar la consulta en la base de datos
        $sql = "SELECT * FROM users WHERE usuario = '$this->strUsuario' AND password = '$this->strPassword' AND status != 0";
        $request = $this->select($sql);
        return $request;
    }

    //Metodo para extraer la informacion del usuario logueado
    public function sessionLogin(int $iduser)
    {
        // Asignamos el valor del id de usuario
        $this->intIdUsuario = $iduser;
        // Construimos la consulta SQL
        $sql = "SELECT u.iduser, u.nombres, u.apellidos, u.correo, u.usuario, u.status, r.idrol, r.nombre 
            FROM users u 
            INNER JOIN roles r ON u.rolid = r.idrol 
            WHERE u.iduser = $this->intIdUsuario";
        $request = $this->select($sql);
        $_SESSION['UserData'] = $request;
        return $request;
    }
}
