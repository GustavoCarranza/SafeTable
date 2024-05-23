document.addEventListener("DOMContentLoaded", () => {
  graficaDestinationMayor();
  graficaComensalesR();
  graficaComensalesD();
  fntContadoresUsuarios();
  fntContadoresReservas();
  fntContadoresComensales();
});

//funcion para calcular destination con mayor reservas
function graficaDestinationMayor() {
  const ctx = document.getElementById("DestinationMayor"); // Obtiene el contexto del canvas
  const myChart = new Chart(ctx, {
    // Crea una instancia de Chart.js
    type: "bar", // Tipo de gráfico: barras
    data: {
      labels: [], // Etiquetas de los restaurantes
      datasets: [
        {
          label: "Total de reservas", // Etiqueta de la barra
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

  // Realiza una solicitud HTTP para obtener los datos de los destinations y sus reservas
  fetch(Base_URL + "/Dashboard/getDashboardMayor")
    .then((response) => response.json()) // Convierte la respuesta a JSON
    .then((data) => {
      // Cuando los datos se reciben correctamente, se actualiza la gráfica
      data.forEach((dash) => {
        // Agrega el nombre del destination a las etiquetas de la gráfica
        myChart.data.labels.push(dash.nombre);
        // Agrega la cantidad de reservas del destination a los datos de la gráfica
        myChart.data.datasets[0].data.push(dash.total_reservaciones);
      });
      // Actualiza la gráfica con los nuevos datos
      myChart.update();
    })
    .catch((error) => console.error(error)); // Maneja cualquier error que pueda ocurrir
}

function graficaComensalesD() {
  const grafica = document.getElementById("ComensalesD");
  const myChart = new Chart(grafica, {
    // Crea una instancia de Chart.js
    type: "pie", // Tipo de gráfico: pastel
    data: {
      labels: [], // Etiquetas de los restaurantes
      datasets: [
        {
          label: "Cantidad de comensales", // Etiqueta de la pastel
          backgroundColor: [
            // Colores de las barras
            "rgba(2, 99, 132, 0.2)",
            "rgba(25, 19, 64, 0.2)",
            "rgba(180, 65, 86, 0.2)",
          ],
          borderColor: [
            "rgb(2, 99, 132)",
            "rgb(25, 19, 64)",
            "rgb(810, 65, 86)",
          ],
          hoverOffset: 4,
          borderWidth: 1, // Ancho del borde de las barras
          data: [], // Aquí se almacenarán los datos de las reservas por restaurante
        },
      ],
    },
  });

  // Realiza una solicitud HTTP para obtener los datos de los Destinations y sus reservas
  fetch(Base_URL + "/Dashboard/getComensalesD")
    .then((response) => response.json()) // Convierte la respuesta a JSON
    .then((data) => {
      // Cuando los datos se reciben correctamente, se actualiza la gráfica
      data.forEach((des) => {
        // Agrega el nombre del destinations a las etiquetas de la gráfica
        myChart.data.labels.push(des.nombre);
        // Agrega la cantidad de reservas del destinations a los datos de la gráfica
        myChart.data.datasets[0].data.push(des.total_comensales);
      });
      // Actualiza la gráfica con los nuevos datos
      myChart.update();
    })
    .catch((error) => console.error(error)); // Maneja cualquier error que pueda ocurrir
}

//Funcion para calcular comensales por restaurante
function graficaComensalesR() {
  const ctx = document.getElementById("ComensalesR"); // Obtiene el contexto del canvas
  const myChart = new Chart(ctx, {
    // Crea una instancia de Chart.js
    type: "bar", // Tipo de gráfico: barras
    data: {
      labels: [], // Etiquetas de los restaurantes
      datasets: [
        {
          label: "Total de comensales", // Etiqueta de la barra
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
  fetch(Base_URL + "/Dashboard/getComensalesR")
    .then((response) => response.json()) // Convierte la respuesta a JSON
    .then((data) => {
      // Cuando los datos se reciben correctamente, se actualiza la gráfica
      data.forEach((dash) => {
        // Agrega el nombre del restaurante a las etiquetas de la gráfica
        myChart.data.labels.push(dash.nombre);
        // Agrega la cantidad de reservas del restaurante a los datos de la gráfica
        myChart.data.datasets[0].data.push(dash.total_comensales);
      });
      // Actualiza la gráfica con los nuevos datos
      myChart.update();
    })
    .catch((error) => console.error(error)); // Maneja cualquier error que pueda ocurrir
}

//Funcion para los contadores de usuarios
function fntContadoresUsuarios() {
  //Creamos una variable para identificar a la etiqueta div a traves de su id
  const usuarios = document.getElementById("usuarios");
  //Creamos un fetch para enviar solicitudes de tipo HTTP, request al servidor web y nos devuelva una respuesta, le estamos almacenando la ruta del metodo del controlador
  fetch(Base_URL + "/Dashboard/getContadoresUsuarios")
    //Aqui esta encadenando una funcion de devolucion, es decir un callback a la promesa devuelta por el fetch, entonces esto se ejecuta cuando la promesa se resuelva
    .then((response) => {
      //Validamos si la respuesta es false no devuelve un error
      if (!response.ok) {
        throw new Error("Respuesta del servidor no recibida");
      }
      //si la respuesta resulta ser true invocamos al metodo json para que la respuesta la devuela en formato JSON
      return response.json();
    })
    //Aqui lo que hacemos es encadenar y añadir otra funcion callback cuando la respuesta fue exitosa y recibimos los datos
    .then((data) => {
      //validamos si la respuesta es true y la cantidad de datos es mayor a 0 es decir contienen elementos vamos a seguir con el proceso
      if (data.status && data.data.length > 0) {
        //Creamos una constante donde accedemos a los datos y al primer elemento del array data y a la propiedad contadorUsuarios que es el alias del calculo
        const contadorUsuarios = data.data[0].contadorUsuarios;
        //Y aqui simplemente mandamos a llamar la variable que contiene el id del div le concatenamos un textContent para que agregue un texto y lo igualamos a la variable que contiene el elemento del objeto
        usuarios.textContent = contadorUsuarios;
      } else {
        throw new Error(
          "No se encontraron datos o el formato de los datos es incorrecto"
        );
      }
    })
    .catch(() => {
      Swal.fire({
        title: "!Atencion",
        text: "Algo paso en el proceso, revisar código",
        icon: "error",
        confirmButtonText: "Aceptar",
      });
    });
}

//Funciones para los contadores de las reservaciones de R Y D
function fntContadoresReservas() {
    //Creamos una variable para identificar a la etiqueta div a traves de su id
  const reservasR = document.getElementById("reservasR");
  const reservasD = document.getElementById("reservasD");
  //Creamos un fetch para enviar solicitudes de tipo HTTP, request al servidor web y nos devuelva una respuesta, le estamos almacenando la ruta del metodo del controlador
  fetch(Base_URL + "/Dashboard/getContadoresReservas")
    //Aqui esta encadenando una funcion de devolucion, es decir un callback a la promesa devuelta por el fetch, entonces esto se ejecuta cuando la promesa se resuelva
    .then((response) => {
      //Validamos si la respuesta es false no devuelve un error
      if (!response.ok) {
        throw new Error("Respuesta del servidor no recibida");
      }
      //si la respuesta resulta ser true invocamos al metodo json para que la respuesta la devuela en formato JSON
      return response.json();
    })
    //Aqui lo que hacemos es encadenar y añadir otra funcion callback cuando la respuesta fue exitosa y recibimos los datos
    .then((data) => {
      //validamos si la respuesta es true y la cantidad de datos es mayor a 0 es decir contienen elementos vamos a seguir con el proceso
      if (data.status && data.data.length > 0) {
        //Creamos una constante donde accedemos a los datos y al primer elemento del array data y a la propiedad contadorComensales que es el alias del calculo
        const contadorReservasR = data.data[0].contadorR;
        const contadorReservasD = data.data[0].contadorD;
        //Y aqui simplemente mandamos a llamar la variable que contiene el id del div le concatenamos un textContent para que agregue un texto y lo igualamos a la variable que contiene el elemento del objeto
        reservasD.textContent = contadorReservasR;
        reservasR.textContent = contadorReservasD;
      } else {
        throw new Error(
          "No se encontraron datos o el formato de los datos es incorrecto"
        );
      }
    })
    .catch(() => {
      Swal.fire({
        title: "!Atencion",
        text: "Algo paso en el proceso, revisar código",
        icon: "error",
        confirmButtonText: "Aceptar",
      });
    });
}

//Funcion para los contadores de comensales
function fntContadoresComensales() {
  //Creamos una variable para identificar a la etiqueta div a traves de su id
  const comensales = document.getElementById("comensales");
  //Creamos un fetch para enviar solicitudes de tipo HTTP, request al servidor web y nos devuelva una respuesta, le estamos almacenando la ruta del metodo del controlador
  fetch(Base_URL + "/Dashboard/getContadoresComensales")
    //Aqui esta encadenando una funcion de devolucion, es decir un callback a la promesa devuelta por el fetch, entonces esto se ejecuta cuando la promesa se resuelva
    .then((response) => {
      //Validamos si la respuesta es false no devuelve un error
      if (!response.ok) {
        throw new Error("Respuesta del servidor no recibida");
      }
      //si la respuesta resulta ser true invocamos al metodo json para que la respuesta la devuela en formato JSON
      return response.json();
    })
    //Aqui lo que hacemos es encadenar y añadir otra funcion callback cuando la respuesta fue exitosa y recibimos los datos
    .then((data) => {
      //validamos si la respuesta es true y la cantidad de datos es mayor a 0 es decir contienen elementos vamos a seguir con el proceso
      if (data.status && data.data.length > 0) {
        //Creamos una constante donde accedemos a los datos y al primer elemento del array data y a la propiedad contadorComensales que es el alias del calculo
        const contadorComensales = data.data[0].contadorComensales;
        //Y aqui simplemente mandamos a llamar la variable que contiene el id del div le concatenamos un textContent para que agregue un texto y lo igualamos a la variable que contiene el elemento del objeto
        comensales.textContent = contadorComensales;
      } else {
        throw new Error(
          "No se encontraron datos o el formato de los datos es incorrecto"
        );
      }
    })
    .catch((error) => {
      console.error("Error fetching data:", error);
      Swal.fire({
        title: "!Atencion",
        text: "Algo paso en el proceso, revisar código: " + error.message,
        icon: "error",
        confirmButtonText: "Aceptar",
      });
    });
}
