<?php

class RolesModel extends Mysql
{

    //Atributos o propiedades
    public $intIdRol;
    public $strRol;
    public $strDescripcion;
    public $intStatus;

    public function __construct()
    {
        parent::__construct();
    }

    //metodo de consulta para extraer los roles de la tabla 
    public function selectRoles()
    {
        $whereAdmin = "";
        if($_SESSION['idUser'] != 1){
            $whereAdmin = " AND idrol != 1";
        }
        //Consulta a la base de datospara extraer roles
        $sql = "SELECT * FROM roles WHERE status != 0 $whereAdmin";
        //creamos una variables donde accedemos a la invocacion del metodo select_All que se enceuntra en la clase heredad Mysql
        $request = $this->select_All($sql);
        //Retornamos la variable para que sea funcional en el controlador
        return $request;
    }

    //Metodo para extraer los registros para la tabla roles 
    public function extractRoles()
    {
        $sql = "SELECT r.idrol,r.nombre,r.descripcion,r.status,CONCAT(DAY(r.dateCreated), ' de ', 
            CASE MONTH(r.dateCreated)
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
            END, ' del ', YEAR(r.dateCreated)) AS fechaRegistro, DATE_FORMAT(r.dateCreated, '%h:%i:%s %p') AS horaRegistro FROM roles r WHERE r.status != 0";
        $request = $this->select_All($sql);
        return $request;
    }

    //Metodo para agregar roles a la base de datos 
    public function insertRol(string $Nombre, string $Descripcion, int $status)
    {
        //Asignamos los valores de los parametros a las propiedades 
        $this->strRol = $Nombre;
        $this->strDescripcion = $Descripcion;
        $this->intStatus = $status;
        $return = 0;
        //Creamos una variable donde le almacenamos el script de la consulta para verificar si el rol ya existe
        $sql = "SELECT * FROM roles WHERE nombre = '{$this->strRol}'";
        //Creamos una variables para acceder a la invocacion del metodo que pertenece a la clase heredada Mysql
        $request = $this->select_All($sql);
        //Validamos si la variable creada esta vacia entonces hacer la insertacion del rol
        if (empty($request)) {
            //creamos la variables con el script de la consulta para insertar el rol
            $query_insert = "INSERT INTO roles(nombre,descripcion,status) VALUES (?,?,?)";
            //creamos un arreglo para almacenar los valores de las propiedades 
            $arrData = array($this->strRol, $this->strDescripcion, $this->intStatus);
            //creamos una variable para acceder a la invocacion del metodo insert y le pasamos la variable de la consulta y la variable del arreglo
            $request_insert = $this->insert($query_insert, $arrData);
            $return =  $request_insert;
        } else {
            return 0;
        }
        return $return;
    }

    //Metodo para extraer la informacion del rol 
    public function selectRol(int $idrol)
    {
        //Asignamos el valor del parametro ala propiedad
        $this->intIdRol = $idrol;
        //Cremos la variable de consulta hacia la base 
        $sql = "SELECT idrol, nombre, descripcion, status FROM roles WHERE idrol = $this->intIdRol";
        $request = $this->select($sql);
        return $request;
    }

    //Metodo para actualizar la informacion del rol 
    public function updateRol(int $idrol, string $nombre, string $descri, int $status)
    {
        //Asignamos los valores de los parametos a las propiedades 
        $this->intIdRol = $idrol;
        $this->strRol = $nombre;
        $this->strDescripcion = $descri;
        $this->intStatus = $status;

        //Creamos una variable para almacenar una consulta a la base para comprobar que el rol con el mismo nombre no este almacenado en la base de datos y si el nombre del rol corresponde al id deje actualizar 
        $sql = "SELECT * FROM roles WHERE (nombre = '{$this->strRol}' AND idrol != $this->intIdRol)";
        $request = $this->select_All($sql);
        if (empty($request)) {
            //creamos la consulta ya para actualizar el registro en la base
            $sql = "UPDATE roles SET nombre = ?, descripcion = ?, status = ? WHERE idrol = $this->intIdRol";
            $arrData = array($this->strRol, $this->strDescripcion, $this->intStatus);
            $request = $this->update($sql, $arrData);
        } else {
            $request = 0;
        }
        return $request;
    }

    //Metodo para eliminar rol de la base 
    public function deleteRol(int $idRol)
    {
        //Asignamos el valor del paramentro a la propiedad
        $this->intIdRol = $idRol;

        //Creamos la variable que tendra el script de la consulta sql a la base de datos
        $sql = "UPDATE roles SET status = ? WHERE idrol = $this->intIdRol";
        //Creamos el arreglo de datos en 0 ya que solo vamos a actualizar el status en 0 para que no se muestre en la tabla de roles
        $arrData = array(0);
        //Creamo la variable que accede al metodo delete que se encuentra en la clase heredada Mysql  y le pasamos la consulta y el arreglo de datos
        $request = $this->update($sql, $arrData);
        //retornamos la variable para que se comunique con el controlador
        return $request;
    }
}
