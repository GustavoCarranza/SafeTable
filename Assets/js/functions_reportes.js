document.addEventListener("DOMContentLoaded", () => {
  graficaRestaurantMayor();
  graficaRestaurantPopular();
  graficaMesMayor();
  fntReportes();
  fntReportesDestinations();
});

function graficaRestaurantMayor() {
  const ctx = document.getElementById("RestauranteMayor"); // Obtiene el contexto del canvas
  const myChart = new Chart(ctx, {
    // Crea una instancia de Chart.js
    type: "bar", // Tipo de gráfico: barras
    data: {
      labels: [], // Etiquetas de los restaurantes
      datasets: [
        {
          label: "Restaurantes con mayor reservas", // Etiqueta de la barra
          backgroundColor: [
            // Colores de las barras
            "rgba(255, 99, 132, 0.2)",
            "rgba(255, 159, 64, 0.2)",
            "rgba(255, 205, 86, 0.2)",
            "rgba(75, 192, 192, 0.2)",
            "rgba(54, 162, 235, 0.2)",
            "rgba(153, 102, 255, 0.2)",
            "rgba(201, 203, 207, 0.2)",
          ],
          borderColor: [
            "rgb(255, 99, 132)",
            "rgb(255, 159, 64)",
            "rgb(255, 205, 86)",
            "rgb(75, 192, 192)",
            "rgb(54, 162, 235)",
            "rgb(153, 102, 255)",
            "rgb(201, 203, 207)",
          ],
          borderWidth: 1, // Ancho del borde de las barras
          data: [], // Aquí se almacenarán los datos de las reservas por restaurante
        },
      ],
    },
    options: {
      scales: {
        y: {
          beginAtZero: true, // Comienza en cero en el eje Y
        },
      },
    },
  });

  // Realiza una solicitud HTTP para obtener los datos de los restaurantes y sus reservas
  fetch(Base_URL + "/Reportes/getRestaurantesMayor")
    .then((response) => response.json()) // Convierte la respuesta a JSON
    .then((data) => {
      // Cuando los datos se reciben correctamente, se actualiza la gráfica
      data.forEach((restaurante) => {
        // Agrega el nombre del restaurante a las etiquetas de la gráfica
        myChart.data.labels.push(restaurante.nombre);
        // Agrega la cantidad de reservas del restaurante a los datos de la gráfica
        myChart.data.datasets[0].data.push(restaurante.total_reservaciones);
      });
      // Actualiza la gráfica con los nuevos datos
      myChart.update();
    })
    .catch((error) => console.error(error)); // Maneja cualquier error que pueda ocurrir
}

function graficaRestaurantPopular() {
  const grafica = document.getElementById("RestaurantePopular");
  const myChart = new Chart(grafica, {
    // Crea una instancia de Chart.js
    type: "doughnut", // Tipo de gráfico: barras
    data: {
      labels: [], // Etiquetas de los restaurantes
      datasets: [
        {
          label: "Restaurantes con mayor reservas", // Etiqueta de la barra
          backgroundColor: [
            // Colores de las barras
            "rgba(255, 99, 132, 0.2)",
            "rgba(255, 159, 64, 0.2)",
            "rgba(255, 205, 86, 0.2)",
          ],
          borderColor: [
            "rgb(255, 99, 132)",
            "rgb(255, 159, 64)",
            "rgb(255, 205, 86)",
          ],
          hoverOffset: 4,
          borderWidth: 1, // Ancho del borde de las barras
          data: [], // Aquí se almacenarán los datos de las reservas por restaurante
        },
      ],
    },
  });

  // Realiza una solicitud HTTP para obtener los datos de los restaurantes y sus reservas
  fetch(Base_URL + "/Reportes/getRestaurantesPopular")
    .then((response) => response.json()) // Convierte la respuesta a JSON
    .then((data) => {
      // Cuando los datos se reciben correctamente, se actualiza la gráfica
      data.forEach((restaurante) => {
        // Agrega el nombre del restaurante a las etiquetas de la gráfica
        myChart.data.labels.push(restaurante.nombre);
        // Agrega la cantidad de reservas del restaurante a los datos de la gráfica
        myChart.data.datasets[0].data.push(restaurante.total_reservaciones);
      });
      // Actualiza la gráfica con los nuevos datos
      myChart.update();
    })
    .catch((error) => console.error(error)); // Maneja cualquier error que pueda ocurrir
}

function graficaMesMayor() {
  const ctx = document.getElementById("MesMayor"); // Obtiene el contexto del canvas
  const myChart = new Chart(ctx, {
    // Crea una instancia de Chart.js
    type: "line", // Tipo de gráfico: línea
    data: {
      labels: [
        "Enero",
        "Febrero",
        "Marzo",
        "Abril",
        "Mayo",
        "Junio",
        "Julio",
        "Agosto",
        "Septiembre",
        "Octubre",
        "Noviembre",
        "Diciembre",
      ], // Usa los nombres de los meses en español como etiquetas
      datasets: [
        {
          label: "Total de reservas por mes", // Etiqueta del conjunto de datos
          backgroundColor: "rgba(54, 162, 235, 0.2)", // Color de fondo del área bajo la línea
          borderColor: "rgb(54, 162, 235)", // Color de la línea
          borderWidth: 1, // Ancho del borde de la línea
          data: [], // Aquí se almacenarán los datos del total de reservas por mes
        },
      ],
    },
    options: {
      scales: {
        y: {
          beginAtZero: true, // Comienza en cero en el eje Y
        },
      },
    },
  });

  // Realiza una solicitud HTTP para obtener los datos del total de reservas por mes
  fetch(Base_URL + "/Reportes/getMesMayor")
    .then((response) => response.json()) // Convierte la respuesta a JSON
    .then((data) => {
      // Cuando los datos se reciben correctamente, se actualiza la gráfica
      data.forEach((meses) => {
        // Agrega el total de reservas del mes a los datos de la gráfica
        myChart.data.datasets[0].data.push(meses.total_reservaciones);
      });
      // Actualiza la gráfica con los nuevos datos
      myChart.update();
    })
    .catch((error) => console.error(error)); // Maneja cualquier error que pueda ocurrir
}

//Funcion para reporte
function fntReportes() {
  const btnReportes = document.getElementById("btnModalReportes");
  btnReportes.addEventListener("click", () => {
    $("#modalReporte").modal("show");
    document.querySelector("#formReporte").reset();

    const FormReporte = document.querySelector("#formReporte");
    FormReporte.onsubmit = (e) => {
      e.preventDefault();
      //Creamos variables y capturamos el id de los inputs
      const strFechaInicial = document.querySelector("#txtFechaInicial");
      const strFechaFinal = document.querySelector("#txtFechaFinal");
      //Validamos que los campos no vayan vacios
      if (strFechaInicial == "" || strFechaFinal == "") {
        Swal.fire({
          title: "¡Atención!",
          text: "Los campos son requeridos",
          icon: "error",
          confirmButtonText: "Aceptar",
        });
        return false;
      }

      //Nos permite mandar solicitudes HTTP, request al servidor y nos devuelve una respuesta
      fetch(Base_URL + "/Reportes/getReportes", {
        method: "POST", // Método HTTP a utilizar en este caso es un tipo POST
        body: new FormData(FormReporte), // Datos del formulario a enviar
      })
        //Cuando la solicitud se completa le invocamos el metodo blob lo que hace es la respuesta nos la convierte en un objeto que representa datos binarios
        .then((response) => response.blob())
        //Y cuando se ha obtenido de manera correcta el blob sin marcar errores se ejecuta en el bloque del codigo
        .then((blob) => {
          //Creamos una variable y almacenamos un URL de objeto para el blob del pdf, estamos utilizando la funcion createObjectURL y le pasamos el blob, esta URL es temporal y se utilizara para crear el enlace de descarga
          const pdfUrl = URL.createObjectURL(blob);
          //Crear una constante y se almacena un nueveo elemento de tipo a en el DOM
          const link = document.createElement("a");
          link.href = pdfUrl;
          link.download = "Reporte de reservaciones de restaurantes.pdf"; // Nombre del archivo PDF al descargar
          // Agregar el enlace al documento y hacer clic en él para iniciar la descarga, la funcion appendchild lo que hace es agregar un nodo hijo al final de la lista, en este caso lo estamos utilizando para agregar el enlace recien creado al cuerpo del documento HTML
          document.body.appendChild(link);
          //Finalmente se simula un click en el enlace y procede a la descarga
          link.click();
          $("#modalReporte").modal("hide");
        })
        .catch((error) => {
          // Manejar errores de red u otros errores del servidor
          console.error("Error:", error);
        });
    };
  });
}

//Funcion de reporte de destinations
function fntReportesDestinations() {
  //Creamos una variable para almacenar el id del boton y agregar un evento de tipo click
  const btnReportes = document.getElementById("ModalDestinations");
  btnReportes.addEventListener("click", () => {
    $("#modalReporteDestinations").modal("show");
    document.querySelector("#formReporteDestinations").reset();
    
    const FormReporte = document.querySelector("#formReporteDestinations");
    FormReporte.onsubmit = (e) => {
      e.preventDefault();
      //Creamos variables y capturamos el id de los inputs
      const strFechaInicial = document.querySelector("#txtFechaInicialD");
      const strFechaFinal = document.querySelector("#txtFechaFinalD");
      //Validamos que los campos no vayan vacios
      if (strFechaInicial == "" || strFechaFinal == "") {
        Swal.fire({
          title: "¡Atención!",
          text: "Los campos son requeridos",
          icon: "error",
          confirmButtonText: "Aceptar",
        });
        return false;
      }

      //Nos permite mandar solicitudes HTTP, request al servidor y nos devuelve una respuesta
      fetch(Base_URL + "/Reportes/getReportesDestinations", {
        method: "POST", // Método HTTP a utilizar en este caso es un tipo POST
        body: new FormData(FormReporte), // Datos del formulario a enviar
      })
        //Cuando la solicitud se completa le invocamos el metodo blob lo que hace es la respuesta nos la convierte en un objeto que representa datos binarios
        .then((response) => response.blob())
        //Y cuando se ha obtenido de manera correcta el blob sin marcar errores se ejecuta en el bloque del codigo
        .then((blob) => {
          //Creamos una variable y almacenamos un URL de objeto para el blob del pdf, estamos utilizando la funcion createObjectURL y le pasamos el blob, esta URL es temporal y se utilizara para crear el enlace de descarga
          const pdfUrl = URL.createObjectURL(blob);
          //Crear una constante y se almacena un nueveo elemento de tipo a en el DOM
          const link = document.createElement("a");
          link.href = pdfUrl;
          link.download = "Reporte de reservaciones de destinations.pdf"; // Nombre del archivo PDF al descargar
          // Agregar el enlace al documento y hacer clic en él para iniciar la descarga, la funcion appendchild lo que hace es agregar un nodo hijo al final de la lista, en este caso lo estamos utilizando para agregar el enlace recien creado al cuerpo del documento HTML
          document.body.appendChild(link);
          //Finalmente se simula un click en el enlace y procede a la descarga
          link.click();
          $("#modalReporteDestinations").modal("hide");
        })
        .catch((error) => {
          // Manejar errores de red u otros errores del servidor
          console.error("Error:", error);
        });
    };
  });
}
