<?php

class AddDestinationModel extends Mysql
{
    //Propiedades 
    private $intidDestination;
    private $strNombre;
    private $strDescripcion;
    private $intStatus;

    public function __construct()
    {
        parent::__construct();
    }

    //Metodo para extraer los registros de la base de datos 
    public function selectDestinations()
    {
        $sql = "SELECT iddestinations,nombre,descripcion,status,CONCAT(DAY(dateCreated), ' de ', 
         CASE MONTH(dateCreated)
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
         END, ' del ', YEAR(dateCreated)) AS fecha,DATE_FORMAT(dateCreated, '%h:%i:%s %p') AS hora FROM destinations WHERE status != 0";
        $request = $this->select_All($sql);
        return $request;
    }

    //Metodo para insertar destination a la bd 
    public function insertDestination(string $nombre, string $descripcion, int $status)
    {

        //Asignamos los valores de los parametros a las propiedes 
        $this->strNombre = $nombre;
        $this->strDescripcion = $descripcion;
        $this->intStatus = $status;

        //creamos la variables con el script de la consulta para insertar el restaurante
        $query_insert = "INSERT INTO destinations(nombre,descripcion,status) VALUES (?,?,?)";
        //creamos un arreglo para almacenar los valores de las propiedades 
        $arrData = array($this->strNombre, $this->strDescripcion, $this->intStatus);
        //creamos una variable para acceder a la invocacion del metodo insert y le pasamos la variable de la consulta y la variable del arreglo
        $request_insert = $this->insert($query_insert, $arrData);
        return $request_insert;
    }

    //Metodo para extraer la informacion del destination
    public function selectDestination(int $idDestination)
    {
        //Asignamos el valor del parametro a la propiedad
        $this->intidDestination = $idDestination;

        //Creamo la variable que tendran el script de la consulta a la BD 
        $sql = "SELECT iddestinations,nombre,descripcion,status FROM destinations WHERE iddestinations = $this->intidDestination";
        $request = $this->select($sql);
        return $request;
    }

    //Metodo para editar la informacion del destination
    public function EditDestination(int $idDestination, string $nombre, string $descripcion, int $status)
    {
        //Asignamos los valores de los parametros a las propiedades
        $this->intidDestination = $idDestination;
        $this->strNombre = $nombre;
        $this->strDescripcion = $descripcion;
        $this->intStatus = $status;

        //creamos la consulta ya para actualizar el registro en la base
        $sql = "UPDATE destinations SET nombre = ?, descripcion = ?, status = ? WHERE iddestinations = $this->intidDestination";
        $arrData = array($this->strNombre, $this->strDescripcion, $this->intStatus);
        $request = $this->update($sql, $arrData);
        return $request;
    }

    //Metodo para eliminar destinations
    public function deleteDestination(int $idDestination)
    {
        //Asginamos valor del parametro a la propiedad
        $this->intidDestination = $idDestination;

        $sql = "UPDATE destinations SET status = ? WHERE iddestinations = $this->intidDestination";
        $arrData = array(0);
        $request = $this->update($sql, $arrData);
        return $request;
    }
}
