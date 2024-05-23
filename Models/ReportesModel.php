<?php

class ReportesModel extends Mysql
{
    //Propiedades
    private $intRestaurante;
    private $strFechaInicial;
    private $strFechaFinal;

    public function __construct()
    {
        parent::__construct();
    }

    //Metodo para calcular "Restaurante con mas reservas"
    public function obtenerinfoRestaurantes()
    {
        $sql = "SELECT res.idrestaurante, res.nombre, COUNT(r.idreservasR)  AS total_reservaciones 
            FROM reservas_restaurante r JOIN restaurantes res ON r.restauranteid = res.idrestaurante WHERE r. status != 0 GROUP BY res.idrestaurante, res.nombre";
        $request = $this->select_All($sql);
        return $request;
    }

    //Metodo para calcular "Restaurante mas popular"
    public function obtenerRestaurantePopular()
    {
        $sql = "SELECT res.idrestaurante, res.nombre, COUNT(r.idreservasR) AS total_reservaciones FROM reservas_restaurante r JOIN restaurantes res ON r.restauranteid = res.idrestaurante WHERE r.status != 0 GROUP BY res.idrestaurante, res.nombre ORDER BY total_reservaciones DESC LIMIT 3";
        $request = $this->select_All($sql);
        return $request;
    }

    //Metodo para calcular "Mes con mayor reservas"
    public function obtenerMesMayor()
    {
        $sql = "SELECT MONTH(fecha_reserva) AS mes,COUNT(idreservasR) AS total_reservaciones FROM reservas_restaurante WHERE status != 0 GROUP BY MONTH(fecha_reserva) ORDER BY mes;";
        $request = $this->select_All($sql);
        return $request;
    }

    public function selectReservas($restaurante, $inicio, $final)
    {
        // asignamos los valores de los parametros a las propiedades 
        $this->intRestaurante = $restaurante;
        $this->strFechaInicial = $inicio;
        $this->strFechaFinal = $final;

        // Construir la consulta SQL
        $sql = "SELECT rr.restauranteid,r.idrestaurante,r.nombre, rr.huesped, rr.apellidos, rr.villa, rr.hotel, rr.adultos, rr.kids, rr.fecha_reserva, rr.horario_reserva, rr.comentarios, rr.userCreate FROM reservas_restaurante rr INNER JOIN restaurantes r ON rr.restauranteid = r.idrestaurante WHERE r.nombre = '$this->intRestaurante' AND rr.fecha_reserva BETWEEN '$this->strFechaInicial' AND '$this->strFechaFinal' AND rr.status = 1 ORDER BY rr.fecha_reserva";
        $request = $this->select_All($sql);
        return $request;
    }
}
