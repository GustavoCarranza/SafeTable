<?php

class AddRestaurantModel extends Mysql
{
    //Propiedades 
    private $intidRestaurante;
    private $strNombre;
    private $strDescripcion;
    private $intStatus;

    public function __construct()
    {
        parent::__construct();
    }

    //Metodo para extraer los registros de la base de datos 
    public function selectRestaurantes()
    {
        $sql = "SELECT idrestaurante,nombre,descripcion,status,CONCAT(DAY(dateCreated), ' de ', 
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
        END, ' del ', YEAR(dateCreated)) AS fecha,DATE_FORMAT(dateCreated, '%h:%i:%s %p') AS hora FROM restaurantes WHERE status != 0";
        $request = $this->select_All($sql);
        return $request;
    }

    //Metodo para agregar restaurantes a la BD 
    public function insertRestaurante(string $nombre, string $descripcion, int $status)
    {
        //Asignamos los valores de los parametros a las propiedes 
        $this->strNombre = $nombre;
        $this->strDescripcion = $descripcion;
        $this->intStatus = $status;

        //creamos la variables con el script de la consulta para insertar el restaurante
        $query_insert = "INSERT INTO restaurantes(nombre,descripcion,status) VALUES (?,?,?)";
        //creamos un arreglo para almacenar los valores de las propiedades 
        $arrData = array($this->strNombre, $this->strDescripcion, $this->intStatus);
        //creamos una variable para acceder a la invocacion del metodo insert y le pasamos la variable de la consulta y la variable del arreglo
        $request_insert = $this->insert($query_insert, $arrData);
        return $request_insert;
    }

    //Metodo para extraer la informacion del restaurante 
    public function selectRestaurante(int $idRestaurante)
    {
        //Asignamos el valor del parametro a la propiedad
        $this->intidRestaurante = $idRestaurante;

        //Creamo la variable que tendran el script de la consulta a la BD 
        $sql = "SELECT idrestaurante,nombre,descripcion,status FROM restaurantes WHERE idrestaurante = $this->intidRestaurante";
        $request = $this->select($sql);
        return $request;
    }

    //Metodo para editar la informacion del restaurante 
    public function EditRestaurante(int $idRestaurante, string $nombre, string $descripcion, int $status)
    {
        //Asignamos los valores de los parametros a las propiedades
        $this->intidRestaurante = $idRestaurante;
        $this->strNombre = $nombre;
        $this->strDescripcion = $descripcion;
        $this->intStatus = $status;

         //creamos la consulta ya para actualizar el registro en la base
         $sql = "UPDATE restaurantes SET nombre = ?, descripcion = ?, status = ? WHERE idrestaurante = $this->intidRestaurante";
         $arrData = array($this->strNombre, $this->strDescripcion, $this->intStatus);
         $request = $this->update($sql, $arrData);
         return $request;
    }

    //Metodo para eliminar restaurante
    public function deleteRestaurant(int $idRestaurante)
    {
        //Asginamos valor del parametro a la propiedad
        $this->intidRestaurante = $idRestaurante;

        $sql = "UPDATE restaurantes SET status = ? WHERE idrestaurante = $this->intidRestaurante";
        $arrData = array(0);
        $request = $this->update($sql, $arrData);
        return $request;
    }
}
