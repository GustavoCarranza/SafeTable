let divLoading = document.querySelector("#divLoading");
let tableDestinations;
let rowTable = "";

//Aqui se ejecutan todas las funciones que se le agreguen
document.addEventListener("DOMContentLoaded", () => {
  fntRegistrosDestinations();
  validarCamposTexto();
  fntAgregarDestinations();
});

//Funcion para mostrar los registros en la tabla
function fntRegistrosDestinations() {
  tableDestinations = $("#tableDestinations").DataTable({
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
      url: Base_URL + "/AddDestination/getDestinations",
      dataSrc: "",
    },
    columns: [
      { data: "iddestinations", className: "text-center" },
      { data: "nombre", className: "text-center" },
      { data: "descripcion", className: "text-center" },
      { data: "status", className: "text-center" },
      { data: "fecha", className: "text-center" },
      { data: "hora", className: "text-center" },
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
          columns: [0, 1, 2, 3, 4], // Excluir la columna de acciones
        },
      },
      {
        extend: "excelHtml5",
        text: "<i class='fas fa-file-excel'></i> Excel",
        titleAttr: "Excel",
        className: "btn btn-success col-12 col-sm-auto mb-2",
        exportOptions: {
          columns: [0, 1, 2, 3, 4], // Excluir la columna de acciones
        },
      },
      {
        extend: "csvHtml5",
        text: "<i class='fas fa-file-csv'></i> CSV",
        titleAttr: "CSV",
        className: "btn btn-light col-12 col-sm-auto mb-2",
        exportOptions: {
          columns: [0, 1, 2, 3, 4], // Excluir la columna de acciones
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

//Funcion para agregar destinations a la BD
function fntAgregarDestinations() {
  const btnModal = document.getElementById("btnAgregarDestination");
  btnModal.addEventListener("click", () => {
    $("#modalAgregar").modal("show");
    document.querySelector("#formDestination").reset();

    const FormDestination = document.querySelector("#formDestination");
    FormDestination.onsubmit = (e) => {
      e.preventDefault();
      //Creamos variables y capturamos el id de los inputs
      const strNombre = document.querySelector("#txtNombre");
      const strDescripcion = document.querySelector("#txtDescripcion");
      const intStatus = document.querySelector("#listStatus");
      //Validar que los campos no vayan vacios
      if (strNombre == "" || strDescripcion == "" || intStatus == "") {
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
      let ajaxUrl = Base_URL + "/AddDestination/setDestinations";
      let formData = new FormData(FormDestination);
      request.open("POST", ajaxUrl, true);
      request.send(formData);
      //con la variable request agregamos un evento para monitorear el progreso de la solicitud XMLHttpRequest y manejar la respuesta recibida del servidor
      request.onreadystatechange = () => {
        if (request.readyState == 4 && request.status == 200) {
          //creamos una varible donde tendremos almacenada el objeto que nos arroje la respuesta request, en primera nos mandara una cadena en formato JSON lo que hacemos es que la respuesta la convertimos en un objeto para acceder a los elementos del mismo
          let objData = JSON.parse(request.responseText);
          //Validamos si el objeto que estamos obteniendo de la respuesta es verdadera mandaremos la alerta de succes y recargamos la tabla para que se muestre el registro
          if (objData.status) {
            intStatus == 1
              ? '<span class="badge bg-success" style="color:#fff;">Activo</span>'
              : '<span class="badge bg-danger" style="color:#fff;">Inactivo</span>';

            $("#modalAgregar").modal("hide");
            FormDestination.reset();
            Swal.fire({
              title: "Destinations",
              text: objData.msg,
              icon: "success",
              confirmButtonText: "Aceptar",
            });
            tableDestinations.ajax.reload();
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

//Function para editar la informacion del destination
function btnUpdateDestination(element, iddestinations) {
  rowTable = element.parentNode.parentNode.parentNode;
  var request = window.XMLHttpRequest
    ? new XMLHttpRequest()
    : new ActiveXObject("Microsoft.XMLHTTP");
  var ajaxUrl = Base_URL + "/AddDestination/getDestination/" + iddestinations;
  request.open("GET", ajaxUrl, true);
  request.send();
  request.onreadystatechange = () => {
    if (request.readyState == 4 && request.status == 200) {
      var objData = JSON.parse(request.responseText);
      if (objData.status) {
        document.querySelector("#iddestination").value =
          objData.data.iddestinations;
        document.querySelector("#txtNombreEdit").value = objData.data.nombre;
        document.querySelector("#txtDescripcionEdit").value =
          objData.data.descripcion;

        if (objData.data.status == 1) {
          document.querySelector("#listStatusEdit").value = 1;
        } else {
          document.querySelector("#listStatusEdit").value = 2;
        }
      }
    }
    $("#modalEditar").modal("show");
  };
  //Crear una variable donde seleccionamos el id del formulario (form) y le agregamos un evento submit
  const formDestinationUpdate = document.querySelector("#formDestinationsEdit");
  formDestinationUpdate.onsubmit = (e) => {
    e.preventDefault();
    //Creamos variables y capturamos el id de los inputs
    const strNombre = document.querySelector("#txtNombreEdit").value;
    const strDescripcion = document.querySelector("#txtDescripcionEdit").value;
    const intStatus = document.querySelector("#listStatusEdit").value;
    //Validamos que los campos no vayan vacios
    if (strNombre == "" || strDescripcion == "") {
      Swal.fire({
        title: "¡Atención!",
        text: "Todos los campos son requeridos",
        icon: "error",
        confirmButtonText: "Aceptar",
      });
      return false;
    }
    // Verificar si hay campos que contienen números o símbolos
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

    //Agregar un loading
    divLoading.style.display = "flex";
    //cremos un objeto XMLHttpRequest de forma segura esto nos sirve para haver solicitudes HTTP desde un navegador web
    var request = window.XMLHttpRequest
      ? new XMLHttpRequest()
      : new ActiveXObject("Microsoft.XMLHTTP");
    //creamos una variable en donde le almacenamos y concatenamos la ruta de nuestro proyecto que esta creada en los helpers + el controlador que estamos ocupando y el metodo a crear
    var ajaxUrl =
      Base_URL + "/AddDestination/updateDestination/" + iddestinations;
    var formData = new FormData(formDestinationUpdate);
    request.open("POST", ajaxUrl, true);
    request.send(formData);

    //con la variable request agregamos un evento para monitorear el progreso de la solicitud XMLHttpRequest y manejar la respuesta recibida del servidor
    request.onreadystatechange = () => {
      if (request.readyState == 4 && request.status == 200) {
        //aqui creamos una variable en donde la respuesta que recibamos del servidor en caso de ser verdadera nos devolvera un String de tipo JSON, entonces lo que hacemos es convertir esa cadena en un objeto con JSON.parse. "Esto nos puede servir para poder acceder a los datos del objeto"
        var objData = JSON.parse(request.responseText);
        if (objData.status) {
          if (rowTable == "") {
            tableDestinations.ajax.reload();
          } else {
            htmlStatus =
              intStatus == 1
                ? '<span class="badge bg-success" style="color:#fff; padding:5px;"> <i class="fas fa-check-circle"></i> Activo </span>'
                : '<span class="badge bg-danger" style="color:#fff; padding:5px;"> <i class="fas fa-times-circle"></i> Inactivo </span>';

            rowTable.cells[1].textContent = strNombre;
            rowTable.cells[2].textContent = strDescripcion;
            rowTable.cells[3].innerHTML = htmlStatus;
          }
          $("#modalEditar").modal("hide");
          formDestinationUpdate.reset();
          Swal.fire({
            title: "Reservaciones",
            text: objData.msg,
            icon: "success",
            confirmButtonText: "aceptar",
          });
        } else {
          Swal.fire({
            title: "Error",
            text: objData.msg,
            icon: "error",
            confirmButtonText: "aceptar",
          });
        }
      } else {
        Swal.fire({
          title: "¡Atención!",
          text: "Algo ha ocurrido durante el proceso",
          icon: "error",
          confirmButtonText: "Aceptar",
        });
      }
      divLoading.style.display = "none";
      return false;
    };
  };
}

//Funcion para eliminar los destinations
function btnDeletedDestination(iddestinations){
    Swal.fire({
        title: "Eliminar destination dining",
        text: "¿Realmente quieres eliminar el destination?",
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
          var ajaxUrl = Base_URL + "/AddDestination/deleteDestination/";
          var strData = "iddestinations=" + iddestinations;
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
                tableDestinations.ajax.reload();
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
