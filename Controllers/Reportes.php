<?php
class Reportes extends Controllers
{
    public function __construct()
    {
        parent::__construct();
        //validar la variable de sesion una vez logueados que esta creada en el controlador Login
        sessionStart();
        if (empty($_SESSION['login'])) {
            header('location: ' . BASE_URL() . '/login');
        }
        //Esta funcion esta creada en el archivo de helpers el valor depende del modulo en el que estamos
        getPermisos(7);
    }

    public function reportes()
    {
        if (empty($_SESSION['permisosModulo']['r'])) {
            header("Location:" . Base_URL() . '/dashboard');
        }
        $data['page_tag'] = "Reportes - SafeTable";
        $data['page_title'] = "Reportes - SafeTable";
        $data['page_name'] = "reportes";
        $data['page_functions_js'] = "functions_reportes.js";
        $this->views->getView($this, "reportes", $data);
    }


    //Metodo para calcular "Restaurante con mas reservas"
    public function getRestaurantesMayor()
    {
        $restaurantes = $this->model->obtenerinfoRestaurantes();

        echo json_encode($restaurantes);
    }

    //Metodo para calcular "Restaurante mas popular"
    public function getRestaurantesPopular()
    {
        $restaurantes = $this->model->obtenerRestaurantePopular();

        echo json_encode($restaurantes);
    }

    //Metodo para calcular "Mes con mayor reservas"
    public function getMesMayor()
    {
        $restaurantes = $this->model->obtenerMesMayor();

        echo json_encode($restaurantes);
    }

    //metodo para generar reporte
    public function getReportes()
    {
        //Celdas es una funcion que esta en lo helper donde apunta al archivo que se encuentra en la libreria FPDF Y nos permite calcular el tamaño de celdas para que la informacion no se deforme de mas
        Celdas();
        //Verificamos si existe una peticion POST, si la hay continua con el proceso si no simplemente termina
        if ($_POST) {
            //validamos que los inptus no vayan vacios
            if (empty($_POST['txtFechaInicial']) || empty($_POST['txtFechaFinal'])) {
                echo "Error: Datos incorrectos";
            } else {
                // Obtener las fechas del formulario es decir los names
                $inicio = strClean($_POST['txtFechaInicial']);
                $final = strClean($_POST['txtFechaFinal']);
                // Crear un nuevo objeto FPDF esta clase la estamos obteniendo porque estamos invocando a la funcion Celdas
                $pdf = new PDF();
                // Establecer la fuente y el tamaño del texto
                $pdf->SetFont('Arial', 'B', 7.5);
                $pdf->AliasNbPages();
                // Creamos una variables y almacenamos un Array de nombres de restaurantes, recordemos que tenemos una relacion con la tabla restaurantes
                $restaurantes = ["Cello", "Copa", "Ember", "Oriente", "Tomahawk", "Saffron", "Sands"];
                // Iterar sobre los nombres de los restaurantes
                foreach ($restaurantes as $restaurante) {
                    //Crear una variable donde almacenamos la invocacion del metodo al controlador y le pasamos 3 parametros que es el restaurante, la fecha inicio y fecha final
                    $resultado = $this->model->selectReservas($restaurante, $inicio, $final);
                    // Verificar si se recibio respuesta por parte del modelo
                    if ($resultado) {
                        // Agregar una página al PDF
                        $pdf->AddPage();
                        // Configurar el encabezado de la tabla en el PDF
                        $pdf->CellHeader(0, 20, "Reservaciones para $restaurante", 0, 1, 'C');
                        // Configurar el ancho de las columnas
                        $pdf->SetWidths([17, 16, 15, 17, 17, 12, 8, 8, 10, 40, 25]);
                        // Definir los encabezados de la tabla
                        $tableHeaders = ['Restaurante', 'Fecha', 'Horario', 'Nombre', 'Apellidos', 'Adultos', 'Kids', 'Villa', 'Hotel', 'Comentarios', 'Responsable'];
                        // Agregar los encabezados al PDF con la funcion Row, se utiliza para dibujar una fila en una tabla 
                        $pdf->Row($tableHeaders);
                        // Iterar sobre los resultados y agregar filas al PDF
                        foreach ($resultado as $row) {
                            $dat = [
                                utf8_decode($row['nombre']),
                                utf8_decode($row['fecha_reserva']),
                                utf8_decode($row['horario_reserva']),
                                utf8_decode($row['huesped']),
                                utf8_decode($row['apellidos']),
                                utf8_decode($row['adultos']),
                                utf8_decode($row['kids']),
                                utf8_decode($row['villa']),
                                utf8_decode($row['hotel']),
                                utf8_decode($row['comentarios']),
                                utf8_decode($row['userCreate'])
                            ];
                            $pdf->Row($dat);
                        }
                    } else {
                        // Imprimir mensaje si no hay reservaciones para este restaurante
                        $pdf->AddPage();
                        $pdf->CellHeader(0, 20, "No hay reservaciones para $restaurante", 0, 1, 'C');
                    }
                }
                // Generar la salida del PDF
                $pdf->Output();
            }
        }
    }

    //Metodo para generar reporte de destinations
    public function getReportesDestinations()
    {
        //Celdas es una funcion que esta en lo helper donde apunta al archivo que se encuentra en la libreria FPDF Y nos permite calcular el tamaño de celdas para que la informacion no se deforme de mas
        Celdas();
        //Verificamos si existe una peticion POST, si la hay continua con el proceso si no simplemente termina
        if ($_POST) {
            //validamos que los inptus no vayan vacios
            if (empty($_POST['txtFechaInicialD']) || empty($_POST['txtFechaFinalD'])) {
                echo "Error: Datos incorrectos";
            } else {
                // Obtener las fechas del formulario es decir los names
                $inicio = strClean($_POST['txtFechaInicialD']);
                $final = strClean($_POST['txtFechaFinalD']);
                // Crear un nuevo objeto FPDF esta clase la estamos obteniendo porque estamos invocando a la funcion Celdas
                $pdf = new PDF();
                // Establecer la fuente y el tamaño del texto
                $pdf->SetFont('Arial', 'B', 7.5);
                $pdf->AliasNbPages();
                // Creamos una variables y almacenamos un Array de nombres de restaurantes, recordemos que tenemos una relacion con la tabla restaurantes
                $destinations = ["Haab", "Noche Mexicana", "Latin BBQ"];
                // Iterar sobre los nombres de los restaurantes
                foreach ($destinations as $destination) {
                    //Crear una variable donde almacenamos la invocacion del metodo al controlador y le pasamos 3 parametros que es el restaurante, la fecha inicio y fecha final
                    $resultado = $this->model->selectReservasDestinations($destination, $inicio, $final);
                    // Verificar si se recibio respuesta por parte del modelo
                    if ($resultado) {
                        // Agregar una página al PDF
                        $pdf->AddPage();
                        // Configurar el encabezado de la tabla en el PDF
                        $pdf->CellHeader(0, 20, "Reservaciones para $destination", 0, 1, 'C');
                        // Configurar el ancho de las columnas
                        $pdf->SetWidths([17, 16, 15, 17, 17, 12, 8, 8, 10, 40, 25]);
                        // Definir los encabezados de la tabla
                        $tableHeaders = ['Destination', 'Fecha', 'Horario', 'Nombre', 'Apellidos', 'Adultos', 'Kids', 'Villa', 'Hotel', 'Comentarios', 'Responsable'];
                        // Agregar los encabezados al PDF con la funcion Row, se utiliza para dibujar una fila en una tabla 
                        $pdf->Row($tableHeaders);
                        // Iterar sobre los resultados y agregar filas al PDF
                        foreach ($resultado as $row) {
                            $dat = [
                                utf8_decode($row['nombre']),
                                utf8_decode($row['fecha_reserva']),
                                utf8_decode($row['horario_reserva']),
                                utf8_decode($row['huesped']),
                                utf8_decode($row['apellidos']),
                                utf8_decode($row['adultos']),
                                utf8_decode($row['kids']),
                                utf8_decode($row['villa']),
                                utf8_decode($row['hotel']),
                                utf8_decode($row['comentarios']),
                                utf8_decode($row['userCreate'])
                            ];
                            $pdf->Row($dat);
                        }
                    } else {
                        // Imprimir mensaje si no hay reservaciones para este restaurante
                        $pdf->AddPage();
                        $pdf->CellHeader(0, 20, "No hay reservaciones para $destination", 0, 1, 'C');
                    }
                }
                // Generar la salida del PDF
                $pdf->Output();
            }
        }
    }
}
