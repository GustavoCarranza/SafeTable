let divLoading = document.querySelector("#divLoading");
let tableRestaurantes;
let rowTable = "";

//Aqui se almacenan las funcion a ejecutar una vez que se recargue la pagina
document.addEventListener("DOMContentLoaded", () => {
  fntRegistrosReservas();
  fntAgregarReservas();
  validarCamposTexto();
  fntRestaurantes();
});

//Funciones para mostrar los registros de las reservas en la tabla
function fntRegistrosReservas() {
  tableRestaurantes = $("#tableRestaurantes").DataTable({
    processing: true,
    responsive: true,
    columnDefs: [
      {
        targets: -1, // Última columna (columna de acciones)
        responsivePriority: 1, // Asigna una prioridad alta para la última columna
      },
    ],
    destroy: true,
    lengthMenu: [5, 10, 25, 50],
    pageLength: 5,
    order: [[0, "asc"]],
    language: {
      url: "//cdn.datatables.net/plug-ins/1.12.1/i18n/es-ES.json",
    },
    ajax: {
      url: Base_URL + "/Restaurantes/getReservas",
      dataSrc: "",
    },
    columns: [
      { data: "idreservasR", className: "text-center" },
      { data: "nombre", className: "text-center" },
      { data: "fechaReserva", className: "text-center" },
      { data: "horaReserva", className: "text-center" },
      { data: "huesped", className: "text-center" },
      { data: "apellidos", className: "text-center" },
      { data: "villa", className: "text-center" },
      { data: "hotel", className: "text-center" },
      { data: "adultos", className: "text-center" },
      { data: "kids", className: "text-center" },
      { data: "comentarios", className: "text-center" },
      { data: "options", className: "text-center", orderable: false },
    ],
    dom: "lBfrtip",
    buttons: [
      {
        extend: "copyHtml5",
        text: "<i class='fas fa-copy'></i> Copiar",
        titleAttr: "Copiar",
        className: "btn btn-secondary col-12 col-sm-auto mb-2",
        exportOptions: {
          columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11], // Excluir la columna de acciones
        },
      },
      {
        extend: "excelHtml5",
        text: "<i class='fas fa-file-excel'></i> Excel",
        titleAttr: "Excel",
        className: "btn btn-success col-12 col-sm-auto mb-2",
        exportOptions: {
          columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11], // Excluir la columna de acciones
        },
      },
      {
        extend: "csvHtml5",
        text: "<i class='fas fa-file-csv'></i> CSV",
        titleAttr: "CSV",
        className: "btn btn-light col-12 col-sm-auto mb-2",
        exportOptions: {
          columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11], // Excluir la columna de acciones
        },
      },
    ],
  });
}

//Funcion para validar que en los inputs de tipo texto no se coloquen numeros
function validarCamposTexto() {
  const campos = document.querySelectorAll(".valid");
  campos.forEach((campo) => {
    campo.addEventListener("input", () => {
      const esCampoTexto = campo.classList.contains("validText");
      const esCampoNumero = campo.classList.contains("validNumber");

      if (esCampoTexto) {
        const contieneNumeros = /\d/.test(campo.value); // Verifica si contiene números
        const contieneEspeciales =
          /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]+/.test(campo.value); // Verifica si contiene caracteres especiales
        if (!contieneNumeros && !contieneEspeciales) {
          campo.classList.remove("is-invalid"); // Remover clase de estilo si es válido
        } else {
          campo.classList.add("is-invalid"); // Agregar clase de estilo si contiene números o caracteres especiales
        }
      }

      if (esCampoNumero) {
        const contieneLetras = /[a-zA-Z]/.test(campo.value); // Verifica si contiene letras
        const contieneEspeciales =
          /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]+/.test(campo.value); // Verifica si contiene caracteres especiales
        if (!contieneLetras && !contieneEspeciales) {
          campo.classList.remove("is-invalid"); // Remover clase de estilo si es válido
        } else {
          campo.classList.add("is-invalid"); // Agregar clase de estilo si contiene letras o caracteres especiales
        }
      }
    });
  });
}

//Funcion para extraer los restaurantes de la BD
function fntRestaurantes() {
  //cremos un objeto XMLHttpRequest de forma segura esto nos sirve para haver solicitudes HTTP desde un navegador web
  var request = window.XMLHttpRequest
    ? new XMLHttpRequest()
    : new ActiveXObject("Microsoft.XMLHTTP");
  //Creamos una varaible donde le almacenados el metodo del helper donde esta la ruta raiz del proyecto y le concatenamos el controlador a ocupar y el metodo a crear
  var ajaxUrl = Base_URL + "/Restaurantes/getSelectRestaurantes";
  request.open("GET", ajaxUrl, true);
  request.send();
  //con la variable request agregamos un evento para monitorear el progreso de la solicitud XMLHttpRequest y manejar la respuesta recibida del servidor
  request.onreadystatechange = function () {
    if (request.readyState == 4 && request.status == 200) {
      document.querySelector("#listRestaurantes").innerHTML =
        request.responseText;
      document.querySelector("#listRestaurantes").value = 1;
      document.querySelector("#listRestaurantesEdit").innerHTML =
        request.responseText;
      document.querySelector("#listRestaurantesEdit").value = 1;
    }
  };
}

//Funcion para agregar reservaciones
function fntAgregarReservas() {
  const modalReservas = document.getElementById("btnAgregarRerservas");
  modalReservas.addEventListener("click", () => {
    $("#modalRestaurantes").modal("show");
    document.querySelector("#formReserva").reset();

    const FormReserva = document.querySelector("#formReserva");
    FormReserva.onsubmit = (e) => {
      e.preventDefault();
      //Creamos variables y capturamos el id de los inputs
      const listRestaurante = document.querySelector("#listRestaurantes");
      const strHuesped = document.querySelector("#txtHuesped");
      const strApellidos = document.querySelector("#txtApellidos");
      const intVilla = document.querySelector("#txtVilla");
      const strHotel = document.querySelector("#txtHotel");
      const strAdultos = document.querySelector("#txtAdultos");
      const strKids = document.querySelector("#txtKids");
      const strFecha = document.querySelector("#txtFecha");
      const strHorario = document.querySelector("#txtHorario");
      const strComentarios = document.querySelector("#txtComentarios");

      //Validar que los campos no vayan vacios
      if (
        listRestaurante == "" ||
        strHuesped == "" ||
        strApellidos == "" ||
        intVilla == "" ||
        strHotel == "" ||
        strAdultos == "" ||
        strKids == "" ||
        strFecha == "" ||
        strHorario == "" ||
        strComentarios == ""
      ) {
        Swal.fire({
          title: "¡Atención!",
          text: "Todos los campos son requeridos",
          icon: "error",
          confirmButtonText: "Aceptar",
        });
        return false;
      }
      //Validar si que los campos tipos text no incluyan numero ni simbolos
      const camposTexto = document.querySelectorAll(".valid.validText");
      let contieneNumerosOSimbolos = false;
      camposTexto.forEach((campo) => {
        if (/[0-9!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/.test(campo.value)) {
          contieneNumerosOSimbolos = true;
          campo.classList.add("is-invalid"); // Agregar clase de Bootstrap para resaltar el campo
        }
      });
      // Mostrar alerta si hay campos con números o símbolos
      if (contieneNumerosOSimbolos) {
        Swal.fire({
          title: "¡Atención!",
          text: "Corrija los campos que contienen números o símbolos",
          icon: "error",
          confirmButtonText: "Aceptar",
        });
        return false; // Detener el proceso
      }

      // Verificar que los campos de tipo number no incluyan letras o simbolos
      const camposNumeros = document.querySelectorAll(".valid.validNumber");
      let contieneLetrasOSimbolos = false;
      camposNumeros.forEach((campo) => {
        if (/[a-zA-Z]/.test(campo.value)) {
          contieneLetrasOSimbolos = true;
          campo.classList.add("is-invalid"); // Agregar clase de Bootstrap para resaltar el campo
        }
      });
      // Mostrar alerta si hay campos con letras o símbolos
      if (contieneLetrasOSimbolos) {
        Swal.fire({
          title: "¡Atención!",
          text: "Corrija los campos donde solo son válidos los números",
          icon: "error",
          confirmButtonText: "Aceptar",
        });
        return false; // Detener el proceso
      }

      //Agregar un loading
      divLoading.style.display = "flex";
      //Creamos una variable donde almacenamos la creacion de un objeto xmlhttprequest, esto permite realizas solicitudes HTTP desde un navegador web
      let request = XMLHttpRequest
        ? new XMLHttpRequest()
        : new ActiveXObject("Microsoft.XMLHTTP");
      //creamos una variable para la ruta hacia el metodo del controlador
      let ajaxUrl = Base_URL + "/Restaurantes/setRestaurantes";
      let formData = new FormData(FormReserva);
      request.open("POST", ajaxUrl, true);
      request.send(formData);
      //con la variable request agregamos un evento para monitorear el progreso de la solicitud XMLHttpRequest y manejar la respuesta recibida del servidor
      request.onreadystatechange = () => {
        if (request.readyState == 4 && request.status == 200) {
          //creamos una varible donde tendremos almacenada el objeto que nos arroje la respuesta request, en primera nos mandara una cadena en formato JSON lo que hacemos es que la respuesta la convertimos en un objeto para acceder a los elementos del mismo
          let objData = JSON.parse(request.responseText);
          //Validamos si el objeto que estamos obteniendo de la respuesta es verdadera mandaremos la alerta de succes y recargamos la tabla para que se muestre el registro
          if (objData.status) {
            $("#modalRestaurantes").modal("hide");
            FormReserva.reset();
            Swal.fire({
              title: "Reservaciones",
              text: objData.msg,
              icon: "success",
              confirmButtonText: "Aceptar",
            });
            tableRestaurantes.ajax.reload();
          } else {
            //Si la respuesta es falsa mandaremos respuesta de error
            Swal.fire({
              title: "Error",
              text: objData.msg,
              icon: "error",
              confirmButtonText: "Aceptar",
            });
          }
        } else {
          //En dado caso que algo falle en el proceso retorna a este error para revisar el codigo
          Swal.fire({
            title: "Error",
            text: "Ocurrio algo en el proceso, revisar código",
            icon: "error",
            confirmButtonText: "Aceptar",
          });
        }
        divLoading.style.display = "none";
        return false;
      };
    };
  });
}

//Funcion para Visualizar informacion
function btnViewReserva(idreservasR) {
  let request = window.XMLHttpRequest
    ? new XMLHttpRequest()
    : new ActiveXObject("Microsoft.XMLHTTP");
  let ajaxUrl = Base_URL + "/Restaurantes/getReserva/" + idreservasR;
  request.open("GET", ajaxUrl, true);
  request.send();
  request.onreadystatechange = () => {
    if (request.readyState == 4 && request.status == 200) {
      try {
        let objData = JSON.parse(request.responseText);
        if (objData.status) {
          $("#modalViewReserva").modal("show");
          document.querySelector("#cellRestaurante").innerHTML =
            objData.data.nombre_restaurante;
          document.querySelector("#cellHuesped").innerHTML =
            objData.data.huesped;
          document.querySelector("#cellApellidos").innerHTML =
            objData.data.apellidos;
          document.querySelector("#cellVilla").innerHTML = objData.data.villa;
          document.querySelector("#cellHotel").innerHTML = objData.data.huesped;
          document.querySelector("#cellAdultos").innerHTML =
            objData.data.adultos;
          document.querySelector("#cellKids").innerHTML = objData.data.kids;
          document.querySelector("#cellFechaReserva").innerHTML =
            objData.data.fecha_reserva;
          document.querySelector("#cellHoraReserva").innerHTML =
            objData.data.horario_reserva;
          document.querySelector("#cellComentarios").innerHTML =
            objData.data.comentarios;
          document.querySelector("#cellFechaCreacion").innerHTML =
            objData.data.fecha_creacion;
          document.querySelector("#cellHoraCreacion").innerHTML =
            objData.data.horario_creacion;
          document.querySelector("#cellUsuarioCreacion").innerHTML =
            objData.data.userCreate;
          document.querySelector("#cellFechaEdicion").innerHTML =
            objData.data.fecha_actualizacion;
          document.querySelector("#cellHoraEdicion").innerHTML =
            objData.data.horario_actualizacion;
          document.querySelector("#cellUsuarioEdicion").innerHTML =
            objData.data.userUpdate;
        } else {
          Swal.fire({
            title: "¡Atención!",
            text: objData.msg,
            icon: "error",
            confirmButtonText: "Aceptar",
          });
        }
      } catch (e) {
        console.error("Error al analizar la respuesta JSON:", e);
        Swal.fire({
          title: "¡Atención!",
          text: "Error al analizar la respuesta JSON",
          icon: "error",
          confirmButtonText: "Aceptar",
        });
      }
    } else if (request.readyState == 4) {
      console.error("Error de solicitud: " + request.status);
      Swal.fire({
        title: "¡Atención!",
        text: "Error de solicitud: " + request.status,
        icon: "error",
        confirmButtonText: "Aceptar",
      });
    }
  };
}

//Funcion para editar las reservaciones
function btnUpdateReserva(element, idreservasR) {
  rowTable = element.parentNode.parentNode.parentNode;
  //Capturar la informacion del registros en los inputs
  //Creamos una variable donde almacenamos un objeto XMLHTTP el cual nos sirve para realizar solicitudes HTTP
  let request = window.XMLHttpRequest
    ? new XMLHttpRequest()
    : new ActiveXObject("Microsoft.XMLHTTP");
  //Creamos una varibale de ruta apuntando al controlador del modelo y concatenamos el id del registro
  let ajaxURL = Base_URL + "/Restaurantes/getReserva/" + idreservasR;
  request.open("GET", ajaxURL, true);
  request.send();
  //Mandamos a traer a la variable request y le agregamos un evento, esto no permite monitorear el proceso de las solicitudes que vayamos enviado y tengamos un enfasis mas detallado
  request.onreadystatechange = () => {
    //Realizamos una validacion a la variable request para comprobar que estado de la solicitud se ha completado y la respuesta esta lista y aparte veriicamos el codigo de estado HTTP lo que indica que ha tenido exito
    if (request.readyState == 4 && request.status == 200) {
      //Si la respuesta es true nos va a devolver una cadena de caracteres en formato JSON y lo que vamos a hacer es convertir esa cadena a un objeto para que podamos acceder a los elementos de ese objeto
      let objData = JSON.parse(request.responseText);
      //validamos la variable objData, si es true en este caso capturamos los campos de la base de datos a los campos inputs
      if (objData.status) {
        document.querySelector("#idreserva").value = objData.data.idreservasR;
        document.querySelector("#listRestaurantesEdit").value =
          objData.data.idrestaurante;
        document.querySelector("#txtHuespedEdit").value = objData.data.huesped;
        document.querySelector("#txtApellidosEdit").value =
          objData.data.apellidos;
        document.querySelector("#txtVillaEdit").value = objData.data.villa;
        document.querySelector("#txtHotelEdit").value = objData.data.hotel;
        document.querySelector("#txtAdultosEdit").value = objData.data.adultos;
        document.querySelector("#txtKidsEdit").value = objData.data.kids;
        document.querySelector("#txtFechaEdit").value = objData.data.FechaEdit;
        document.querySelector("#txtHorarioEdit").value =
          objData.data.HorarioEdit;
        document.querySelector("#txtComentariosEdit").value =
          objData.data.comentarios;
      } else {
      }
    }
    $("#modalEditReservas").modal("show");
  };

  //Editar la informacion de las reservaciones
  const FormReservaEdit = document.querySelector("#formReservaEdit");
  FormReservaEdit.onsubmit = (e) => {
    e.preventDefault();
    //Creamos variables donde capturar los id de los inputs
    const listRestauranteEdit = document.querySelector(
      "#listRestaurantesEdit"
    ).value;
    const strHuespedEdit = document.querySelector("#txtHuespedEdit").value;
    const strApellidosEdit = document.querySelector("#txtApellidosEdit").value;
    const intVillaEdit = document.querySelector("#txtVillaEdit").value;
    const strHotelEdit = document.querySelector("#txtHotelEdit").value;
    const intAdultosEdit = document.querySelector("#txtAdultosEdit").value;
    const intKidsEdit = document.querySelector("#txtKidsEdit").value;
    const strFechaEdit = document.querySelector("#txtFechaEdit").value;
    const strHorarioEdit = document.querySelector("#txtHorarioEdit").value;
    const strComentariosEdit = document.querySelector(
      "#txtComentariosEdit"
    ).value;
    //Validamos que los campos no vayan vacios
    if (
      listRestauranteEdit == "" ||
      strHuespedEdit == "" ||
      strApellidosEdit == "" ||
      intVillaEdit == "" ||
      strHotelEdit == "" ||
      intAdultosEdit == "" ||
      intKidsEdit == "" ||
      strFechaEdit == "" ||
      strHorarioEdit == "" ||
      strComentariosEdit == ""
    ) {
      Swal.fire({
        title: "!Atención¡",
        text: "Todos los campos son requeridos",
        icon: "error",
        confirmButtonText: "Aceptar",
      });
      return false;
    }
    //Validar si que los campos tipos text no incluyan numero ni simbolos
    const camposTexto = document.querySelectorAll(".valid.validText");
    let contieneNumerosOSimbolos = false;
    camposTexto.forEach((campo) => {
      if (/[0-9!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/.test(campo.value)) {
        contieneNumerosOSimbolos = true;
        campo.classList.add("is-invalid"); // Agregar clase de Bootstrap para resaltar el campo
      }
    });
    // Mostrar alerta si hay campos con números o símbolos
    if (contieneNumerosOSimbolos) {
      Swal.fire({
        title: "¡Atención!",
        text: "Corrija los campos que contienen números o símbolos",
        icon: "error",
        confirmButtonText: "Aceptar",
      });
      return false; // Detener el proceso
    }

    // Verificar que los campos de tipo number no incluyan letras o simbolos
    const camposNumeros = document.querySelectorAll(".valid.validNumber");
    let contieneLetrasOSimbolos = false;
    camposNumeros.forEach((campo) => {
      if (/[a-zA-Z]/.test(campo.value)) {
        contieneLetrasOSimbolos = true;
        campo.classList.add("is-invalid"); // Agregar clase de Bootstrap para resaltar el campo
      }
    });
    // Mostrar alerta si hay campos con letras o símbolos
    if (contieneLetrasOSimbolos) {
      Swal.fire({
        title: "¡Atención!",
        text: "Corrija los campos donde solo son válidos los números",
        icon: "error",
        confirmButtonText: "Aceptar",
      });
      return false; // Detener el proceso
    }

    divLoading.style.display = "flex";
    //Creamos la variable para crear el objeto XMLHTTP para realizar peticions de tipo HTTP y manejar la respuesta delservidor
    let request = window.XMLHttpRequest
      ? new XMLHttpRequest()
      : new ActiveXObject("Microsoft.XMLHTTP");
    //creamos variable de ruta hacie el metodo del controlador
    let ajaxURL = Base_URL + "/Restaurantes/updateRerserva/" + idreservasR;
    let formData = new FormData(FormReservaEdit);
    request.open("POST", ajaxURL, true);
    request.send(formData);
    //A la variable request le agregamos el evento para monitorear la respuesta que mande el servidor
    request.onreadystatechange = () => {
      //Realizamos una validacion a la variable request para comprobar que estado de la solicitud se ha completado y la respuesta esta lista y aparte veriicamos el codigo de estado HTTP lo que indica que ha tenido exito
      if (request.readyState == 4 && request.status == 200) {
        //Si la solicitud resulta ser verdadera o con exito vamos a crear una variable donde vamos a convertir la respuesta en un objeto ya que el servidor nos devolvera en formato JSON y para acceder a la informacion tenemos que convertir a un objeto
        let objData = JSON.parse(request.responseText);
        //Realizamos la validacion al objeto
        if (objData.status) {
          if (rowTable == "") {
            tableRestaurantes.ajax.reload();
          } else {
            rowTable.cells[1].textContent = document.querySelector(
              "#listRestaurantesEdit"
            ).selectedOptions[0].text;
            rowTable.cells[2].textContent = strFechaEdit;
            rowTable.cells[3].textContent = strHorarioEdit;
            rowTable.cells[4].textContent = strHuespedEdit;
            rowTable.cells[5].textContent = strApellidosEdit;
            rowTable.cells[6].textContent = intVillaEdit;
            rowTable.cells[7].textContent = strHotelEdit;
            rowTable.cells[8].textContent = intAdultosEdit;
            rowTable.cells[9].textContent = intKidsEdit;
            rowTable.cells[10].textContent = strComentariosEdit;
            tableRestaurantes.ajax.reload();
          }
          $("#modalEditReservas").modal("hide");
          FormReservaEdit.reset();
          Swal.fire({
            title: "Reservaciones",
            text: objData.msg,
            icon: "success",
            confirmButtonText: "aceptar",
          });
        } else {
          Swal.fire({
            title: "Reservaciones",
            text: objData.msg,
            icon: "error",
            confirmButtonText: "aceptar",
          });
        }
      } else {
        Swal.fire({
          title: "Reservaciones",
          text: "Algo ocurrio durante el proceso, revisar código",
          icon: "error",
          confirmButtonText: "aceptar",
        });
      }
      divLoading.style.display = "none";
      return false;
    };
  };
}

//Funcion para eliminar reservaciones
function btnDeletedReserva(idreservasR) {
  Swal.fire({
    title: "Eliminar reservación",
    text: "¿Realmente quieres eliminar la reservación?",
    icon: "warning",
    showCancelButton: true,
    confirmButtonText: "Si, eliminar",
    cancelButtonText: "No, cancelar",
    reverseButtons: true, // Cambia el orden de los botones (confirmar y cancelar)
  }).then((result) => {
    if (result.isConfirmed) {
          // Crear una instancia de XMLHttpRequest
      var request = window.XMLHttpRequest
      ? new XMLHttpRequest()
      : new ActiveXObject("Microsoft.XMLHTTP");
    //Creamos la variable que tiene almacenada la ruta del controlador y el metodo a crear
    var ajaxUrl = Base_URL + "/Restaurantes/deleteReserva/";
    var strData = "idreservasR=" + idreservasR;
    request.open("POST", ajaxUrl, true);
    //Aqui utilizaos la funcion setRequestHeader para asegurar de que la solicitud se realice y siga las convenciones adecuadas para el envio de datos codificados como formularios
    request.setRequestHeader(
      "Content-type",
      "application/x-www-form-urlencoded"
    );
    request.send(strData);
    //con la variable request agregamos un evento para monitorear el progreso de la solicitud XMLHttpRequest y manejar la respuesta recibida del servidor
    request.onreadystatechange = () => {
      if (request.readyState == 4 && request.status == 200) {
        //aqui creamos una variable en donde la respuesta que recibamos del servidor en caso de ser verdadera nos devolvera un String de tipo JSON, entonces lo que hacemos es convertir esa cadena en un objeto con JSON.parse. "Esto nos puede servir para poder acceder a los datos del objeto"
        var objData = JSON.parse(request.responseText);
        //Validamos si el objeto es true devuelve el mensaje de success
        if (objData.status) {
          Swal.fire({
            title: "Eliminado",
            text: objData.msg,
            icon: "success",
            confirmButtonText: "aceptar",
          });
          tableRestaurantes.ajax.reload();
        } else {
          Swal.fire({
            title: "Atención",
            text: objData.msg,
            icon: "error",
            confirmButtonText: "aceptar",
          });
        }
      } else {
        Swal.fire({
          title: "Error",
          text: "Algo a ocurrido durante el proceso, revisar codigo.",
          icon: "error",
          confirmButtonText: "aceptar",
        });
      }
    };
    }
  });
}
