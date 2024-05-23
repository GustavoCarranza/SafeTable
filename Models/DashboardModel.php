<?php

class DashboardModel extends Mysql
{
    public function __construct()
    {
        parent::__construct();
    }

    //Metodo para calcular "Destination con mas reservas"
    public function obtenerinfoDestinations()
    {
        $sql = "SELECT des.iddestinations, des.nombre, COUNT(r.idreservasD)  AS total_reservaciones FROM reservas_destinations r JOIN destinations des ON r.destinationid = des.iddestinations WHERE r. status != 0 GROUP BY des.iddestinations, des.nombre";
        $request = $this->select_All($sql);
        return $request;
    }

    public function obtenerComensalesR()
    {
        $sql = "SELECT res.idrestaurante, res.nombre, SUM(r.adultos + r.kids) AS total_comensales FROM reservas_restaurante r JOIN restaurantes res ON r.restauranteid = res.idrestaurante WHERE r.status != 0 AND fecha_reserva = CURDATE() GROUP BY res.idrestaurante, res.nombre;";
        $request = $this->select_All($sql);
        return $request;
    }

    public function obtenerComensalesD()
    {
        $sql = "SELECT dest.iddestinations, dest.nombre, SUM(r.adultos + r.kids) AS total_comensales FROM reservas_destinations r JOIN destinations dest ON r.destinationid = dest.iddestinations WHERE r.status != 0 AND fecha_reserva = CURDATE() GROUP BY dest.iddestinations, dest.nombre;";
        $request = $this->select_All($sql);
        return $request;
    }

    //Metodo para calcula la cantidad de usuarios
    public function selectContadoresUsuarios()
    {
        $sql = "SELECT COUNT(iduser) AS contadorUsuarios FROM `users` WHERE status = 1";
        $request = $this->select_All($sql);
        return $request;
    }

    //Metodo para calcular el total de reservas de R y D
    public function selectContadoresReservas()
    {
        $sql = "SELECT 
            (SELECT COUNT(idreservasR) FROM reservas_restaurante WHERE status = 1 AND fecha_reserva = CURDATE()) AS contadorR,
            (SELECT COUNT(idreservasD) FROM reservas_destinations WHERE status = 1 AND fecha_reserva = CURDATE()) AS contadorD";
        $request = $this->select_All($sql);
        return $request;   
    }

    //Metodo para calcular la cantidad de comensales
    public function selectContadoresComensales()
    {
        $sql =
            "SELECT 
                SUM(CASE WHEN combined.status = 1 AND DATE(combined.fecha_reserva) = CURDATE() THEN combined.kids + combined.adultos ELSE 0 END) AS total_restaurantes,
                SUM(CASE WHEN combined.status = 1 AND DATE(combined.fecha_reserva) = CURDATE() THEN combined.kids + combined.adultos ELSE 0 END) AS total_destinations,
                SUM(
                    CASE WHEN combined.status = 1 AND DATE(combined.fecha_reserva) = CURDATE() THEN combined.kids + combined.adultos ELSE 0 END
                    ) AS contadorComensales 
                FROM
                (
                    SELECT * FROM reservas_restaurante UNION ALL SELECT * FROM reservas_destinations
                ) AS combined";
        $request = $this->select_All($sql);
        return $request;
    }
}
