<?php

class RestaurantesModel extends Mysql
{
    //Propiedades
    private $intIdUser;
    private $intIdReservasR;
    private $intRestaurantId;
    private $strHuesped;
    private $strApellidos;
    private $intVilla;
    private $strHotel;
    private $intAdultos;
    private $intKids;
    private $strFecha;
    private $strHorario;
    private $strComentarios;
    private $intStatus;

    public function __construct()
    {
        parent::__construct();
    }


    //Funcion para extraer los registros de la base de datos
    public function selectReservas()
    {
        $sql = "SELECT r.idreservasR,r.restauranteid,r.huesped,r.apellidos,r.villa,r.hotel,r.adultos,r.kids,CONCAT(DAY(r.fecha_reserva), ' de ', 
        CASE MONTH(r.fecha_reserva)
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
        END, ' del ', YEAR(r.fecha_reserva)) AS fechaReserva,DATE_FORMAT(r.horario_reserva, '%h:%i:%s %p') AS horaReserva,r.comentarios,r.status,res.idrestaurante,res.nombre FROM reservas_restaurante r INNER JOIN restaurantes res ON r.restauranteid = res.idrestaurante WHERE r.status != 0";
        $request = $this->select_All($sql);
        return $request;
    }

    //Funcion para extraer los restuarantes de la BD 
    public function selectRestaurantes()
    {

        //Consulta a la base de datospara extraer roles
        $sql = "SELECT * FROM restaurantes WHERE status != 0";
        //creamos una variables donde accedemos a la invocacion del metodo select_All que se enceuntra en la clase heredad Mysql
        $request = $this->select_All($sql);
        //Retornamos la variable para que sea funcional en el controlador
        return $request;
    }

    //Metodo para insertar reservaciones a la bd
    public function insertReservas(string $iduser, int $restaurantTipo, string $huesped, string $apellidos, int $villa, string $hotel, int $adultos, int $kids, string $fecha, string $horario, string $comentarios)
    {
        //Asignamos el valore de los parametros a las propiedades
        $this->intRestaurantId = $restaurantTipo;
        $this->strHuesped = $huesped;
        $this->strApellidos = $apellidos;
        $this->intVilla = $villa;
        $this->strHotel = $hotel;
        $this->intAdultos = $adultos;
        $this->intKids = $kids;
        $this->strFecha = $fecha;
        $this->strHorario = $horario;
        $this->strComentarios = $comentarios;
        $this->intIdUser = $iduser;
        $dateUpdate = "";
        $dateDelete = "";

        //Creamos la consulta para inserta las reservas
        $sql = "INSERT INTO reservas_restaurante(restauranteid,huesped,apellidos,villa,hotel,adultos,kids,fecha_reserva,horario_reserva,comentarios,userCreate,dateUpdate,dateDelete) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)";
        $arrData = array($this->intRestaurantId, $this->strHuesped, $this->strApellidos, $this->intVilla, $this->strHotel, $this->intAdultos, $this->intKids, $this->strFecha, $this->strHorario, $this->strComentarios, $this->intIdUser, $dateUpdate, $dateDelete);
        $request_insert = $this->insert($sql, $arrData);
        return $request_insert;
    }

    //Metodo para extraer la informacion de la reservacion
    public function selectReserva(int $idreserva)
    {
        //Asignamos el valor del parametro a la propiedad
        $this->intIdReservasR = $idreserva;
        //Creamos la variable para almacenar la consulta a la base de datos
        $sql = "SELECT 
        r.idreservasR,
        r.restauranteid,
        r.huesped,
        r.apellidos,
        r.villa,
        r.hotel,
        r.adultos,
        r.kids,
        r.comentarios,
        r.userCreate,
        r.userUpdate,
        r.horario_reserva as HorarioEdit,
        r.fecha_reserva as FechaEdit,
        res.idrestaurante,
        res.nombre AS nombre_restaurante,
        CONCAT(
            DAY(r.fecha_reserva), 
            ' de ', 
            CASE MONTH(r.fecha_reserva)
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
            END, 
            ' del ', 
            YEAR(r.fecha_reserva)
        ) AS fecha_reserva,
        CONCAT(
            DAY(r.dateCreated), 
            ' de ', 
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
            END, 
            ' del ', 
            YEAR(r.dateCreated)
        ) AS fecha_creacion,
        CONCAT(
            DAY(r.dateUpdate), 
            ' de ', 
            CASE MONTH(r.dateUpdate)
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
            END, 
            ' del ', 
            YEAR(r.dateUpdate)
        ) AS fecha_actualizacion,
        DATE_FORMAT(r.horario_reserva, '%h:%i:%s %p') AS horario_reserva,
        DATE_FORMAT(r.dateCreated, '%h:%i:%s %p') AS horario_creacion,
        DATE_FORMAT(r.dateUpdate, '%h:%i:%s %p') AS horario_actualizacion FROM reservas_restaurante r INNER JOIN restaurantes res ON r.restauranteid = res.idrestaurante WHERE idreservasR = $this->intIdReservasR";
        $request = $this->select($sql);
        return $request;
    }

    //Metodo para actualizar la informacion de la reserva
    public function updateRerserva(int $idreserva, string $iduser, int $restaurantTipo, string $huesped, string $apellidos, int $villa, string $hotel, int $adultos, int $kids, string $fecha, string $horario, string $comentarios)
    {
        //Asignamos el valore de los parametros a las propiedades
        $this->intIdReservasR = $idreserva;
        $this->intRestaurantId = $restaurantTipo;
        $this->strHuesped = $huesped;
        $this->strApellidos = $apellidos;
        $this->intVilla = $villa;
        $this->strHotel = $hotel;
        $this->intAdultos = $adultos;
        $this->intKids = $kids;
        $this->strFecha = $fecha;
        $this->strHorario = $horario;
        $this->strComentarios = $comentarios;
        $this->intIdUser = $iduser;

         //Creamos la consulta para inserta las reservas
         $sql = "UPDATE reservas_restaurante SET restauranteid = ?, huesped = ?, apellidos = ?, villa = ?, hotel = ?, adultos = ?, kids = ?, fecha_reserva = ?, horario_reserva = ?, comentarios = ?, userUpdate = ?, dateUpdate = NOW() WHERE idreservasR = $this->intIdReservasR";
         $arrData = array($this->intRestaurantId, $this->strHuesped, $this->strApellidos, $this->intVilla, $this->strHotel, $this->intAdultos, $this->intKids, $this->strFecha, $this->strHorario, $this->strComentarios, $this->intIdUser);
         $request_insert = $this->update($sql, $arrData);
         return $request_insert;
    }

    //Metodo para eliminar la reservacion
    public function deleteReservacion(int $idreserva, string $iduser)
    {
        //Asignamos el valor del paramentro a la propiedad
        $this->intIdReservasR = $idreserva;
        $this->intIdUser = $iduser;

        //Creamos la variable que tendra el script de la consulta sql a la base de datos
        $sql = "UPDATE reservas_restaurante SET status = ?, userDelete = ?, dateDelete = NOW() WHERE idreservasR = $this->intIdReservasR";
        //Creamos el arreglo de datos en 0 ya que solo vamos a actualizar el status en 0 para que no se muestre en la tabla de usuarios 
        $arrData = array(0, $this->intIdUser);
        //Creamo la variable que accede al metodo delete que se encuentra en la clase heredada Mysql  y le pasamos la consulta y el arreglo de datos
        $request = $this->update($sql, $arrData);
        //retornamos la variable para que se comunique con el controlador
        return $request;
    }
}
