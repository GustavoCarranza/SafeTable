var divLoading = document.querySelector("#divLoading");
var tableRoles;

//Aqui se ejecutan las funciones que se le agreguen al recargar la pagina
document.addEventListener("DOMContentLoaded", () => {
  registrosTableRoles();
  validarCamposTexto();
  fntAgregaRoles();
});

//Funcion para mostrar registros en la tabla Roles
function registrosTableRoles() {
  tableRoles = $("#tableRoles   ").DataTable({
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
      url: Base_URL + "/Roles/getRoles",
      dataSrc: "",
    },
    columns: [
      { data: "idrol", className: "text-center" },
      { data: "nombre", className: "text-center" },
      { data: "descripcion", className: "text-center" },
      { data: "status", className: "text-center" },
      { data: "fechaRegistro", className: "text-center" },
      { data: "horaRegistro", className: "text-center" },
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
          columns: [0, 1, 2, 3, 4, 5], // Excluir la columna de acciones
        },
      },
      {
        extend: "excelHtml5",
        text: "<i class='fas fa-file-excel'></i> Excel",
        titleAttr: "Excel",
        className: "btn btn-success col-12 col-sm-auto mb-2",
        exportOptions: {
          columns: [0, 1, 2, 3, 4, 5], // Excluir la columna de acciones
        },
      },
      {
        extend: "csvHtml5",
        text: "<i class='fas fa-file-csv'></i> CSV",
        titleAttr: "CSV",
        className: "btn btn-light col-12 col-sm-auto mb-2",
        exportOptions: {
          columns: [0, 1, 2, 3, 4, 5], // Excluir la columna de acciones
        },
      },
    ],
  });
}

//Funcion para validar que en los inputs de tipo texto no se coloquen numeros
function validarCamposTexto() {
  const camposTexto = document.querySelectorAll(".valid.validText");
  camposTexto.forEach((campo) => {
    campo.addEventListener("input", () => {
      const contieneNumeros = /\d/.test(campo.value); // Verifica si contiene números
      const contieneEspeciales = /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]+/.test(
        campo.value
      ); // Verifica si contiene caracteres especiales
      if (contieneNumeros || contieneEspeciales) {
        campo.classList.add("is-invalid"); // Agregar clase de estilo si contiene números o caracteres especiales
      } else {
        campo.classList.remove("is-invalid"); // Remover clase de estilo si no contiene números ni caracteres especiales
      }
    });
  });
}

//Funcion para agregar roles
function fntAgregaRoles() {
  const modalRoles = document.getElementById("btnModalRoles");
  modalRoles.addEventListener("click", () => {
    $("#modalRoles").modal("show");
    document.querySelector("#formRoles").reset();

    //Crear una variable donde seleccionamos el id del formulario (form) y le agregamos un evento submit
    const formRoles = document.querySelector("#formRoles");
    formRoles.onsubmit = (e) => {
      e.preventDefault();
      //Creamos variables y capturamos el id de los inputs
      const strNombre = document.querySelector("#txtNombre");
      const strDescripcion = document.querySelector("#txtDescripcion");
      const intStatus = document.querySelector("#listStatus");
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
        return; // Detener el proceso
      }
      //Agregar un loading
      divLoading.style.display = "flex";
      //cremos un objeto XMLHttpRequest de forma segura esto nos sirve para haver solicitudes HTTP desde un navegador web
      var request = window.XMLHttpRequest
        ? new XMLHttpRequest()
        : new ActiveXObject("Microsoft.XMLHTTP");
      //creamos una variable en donde le almacenamos y concatenamos la ruta de nuestro proyecto que esta creada en los helpers + el controlador que estamos ocupando y el metodo a crear
      var ajaxUrl = Base_URL + "/Roles/setRol";
      var formData = new FormData(formRoles);
      request.open("POST", ajaxUrl, true);
      request.send(formData);

      //con la variable request agregamos un evento para monitorear el progreso de la solicitud XMLHttpRequest y manejar la respuesta recibida del servidor
      request.onreadystatechange = () => {
        if (request.readyState == 4 && request.status == 200) {
          //aqui creamos una variable en donde la respuesta que recibamos del servidor en caso de ser verdadera nos devolvera un String de tipo JSON, entonces lo que hacemos es convertir esa cadena en un objeto con JSON.parse. "Esto nos puede servir para poder acceder a los datos del objeto"
          var objData = JSON.parse(request.responseText);
          if (objData.status) {
            intStatus == 1
              ? '<span class="badge bg-success" style="color:#fff;">Activo</span>'
              : '<span class="badge bg-danger" style="color:#fff;">Inactivo</span>';

            $("#modalRoles").modal("hide");
            formRoles.reset();
            Swal.fire({
              title: "Roles",
              text: objData.msg,
              icon: "success",
              confirmButtonText: "aceptar",
            });
            tableRoles.ajax.reload();
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
  });
}

//Funcion para dar permisos a los roles
function btnPermisosRol(idrol) {
  //cremos un objeto XMLHttpRequest de forma segura esto nos sirve para haver solicitudes HTTP desde un navegador web
  var request = window.XMLHttpRequest
    ? new XMLHttpRequest()
    : new ActiveXObject("Microsoft.XMLHTTP");
  //creamos una variable en donde le almacenamos y concatenamos la ruta de nuestro proyecto que esta creada en los helpers + el controlador que estamos ocupando y el metodo a crear
  var ajaxUrl = Base_URL + "/Permisos/getPermisosRol/" + idrol;
  request.open("GET", ajaxUrl, true);
  request.send();
  //con la variable request agregamos un evento para monitorear el progreso de la solicitud XMLHttpRequest y manejar la respuesta recibida del servidor
  request.onreadystatechange = () => {
    if (request.readyState == 4 && request.status == 200) {
      document.querySelector("#contentAjax").innerHTML = request.responseText;
      $("#modalPermisos").modal("show");

      document
        .querySelector("#formPermisos")
        .addEventListener("submit", fntSavePermisos, false);
    }
  };
}

//funcion para guardar los permisos al rol correspondiente
function fntSavePermisos(event) {
  event.preventDefault();
  var request = window.XMLHttpRequest
    ? new XMLHttpRequest()
    : new ActiveXObject("Microsoft.XMLHTTP");
  var ajaxUrl = Base_URL + "/Permisos/setPermisos";
  var formElement = document.querySelector("#formPermisos");
  var formData = new FormData(formElement);
  request.open("POST", ajaxUrl, true);
  request.send(formData);

  request.onreadystatechange = function () {
    if (request.readyState == 4 && request.status == 200) {
      var objData = JSON.parse(request.responseText);
      if (objData.status) {
        Swal.fire({
          title: "Permisos Otorgados",
          text: objData.msg,
          icon: "success",
          confirmButtonText: "Aceptar",
        });
        $("#modalPermisos").modal("hide");
      } else {
        Swal.fire({
          title: "Error",
          text: objData.msg,
          icon: "error",
          confirmButtonText: "Aceptar",
        });
      }
    } else {
      Swal.fire({
        title: "Error",
        text: "Algo ha ocurrido durante el proceso, revisar código",
        icon: "error",
        confirmButtonText: "Aceptar",
      });
    }
  };
}

//Funcion para editar Roles
function btnUpdateRol(idrol) {
  //cremos un objeto XMLHttpRequest de forma segura esto nos sirve para haver solicitudes HTTP desde un navegador web
  var request = window.XMLHttpRequest
    ? new XMLHttpRequest()
    : new ActiveXObject("Microsoft.XMLHTTP");
  //Creamos la variable de ruta hacia el controlador y metodo a crear y concatenamos el id del registro
  var ajaxUrl = Base_URL + "/Roles/getRol/" + idrol;
  request.open("GET", ajaxUrl, true);
  request.send();
  //con la variable request agregamos un evento para monitorear el progreso de la solicitud XMLHttpRequest y manejar la respuesta recibida del servidor
  request.onreadystatechange = () => {
    if (request.readyState == 4 && request.status == 200) {
      //Si la respuesta es verdades crearemos una varaibla donde pasaremos el request ya que nos devolvera una cadena de caracteres en formato JSON  y lo que hacemos es convertir esa cadena aun objeto para poder acceder a los elementos
      var objData = JSON.parse(request.responseText);
      if (objData.status) {
        document.querySelector("#idRol").value = objData.data.idrol;
        document.querySelector("#txtNombreUpdate").value = objData.data.nombre;
        document.querySelector("#txtDescripcionUpdate").value =
          objData.data.descripcion;

        if (objData.data.status == 1) {
          document.querySelector("#listStatusUpdate").value = 1;
        } else {
          document.querySelector("#listStatusUpdate").value = 2;
        }
      }
    }
    $("#modalUpdateRoles").modal("show");
  };

  //Actualizar la informacion del rol

  //Crear una variable donde seleccionamos el id del formulario (form) y le agregamos un evento submit
  const formRolesUpdate = document.querySelector("#formRolesUpdate");
  formRolesUpdate.onsubmit = (e) => {
    e.preventDefault();
    //Creamos variables y capturamos el id de los inputs
    const strNombre = document.querySelector("#txtNombreUpdate").value;
    const strDescripcion = document.querySelector(
      "#txtDescripcionUpdate"
    ).value;
    const intStatus = document.querySelector("#listStatusUpdate").value;
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
      return; // Detener el proceso
    }

    //Agregar un loading
    divLoading.style.display = "flex";
    //cremos un objeto XMLHttpRequest de forma segura esto nos sirve para haver solicitudes HTTP desde un navegador web
    var request = window.XMLHttpRequest
      ? new XMLHttpRequest()
      : new ActiveXObject("Microsoft.XMLHTTP");
    //creamos una variable en donde le almacenamos y concatenamos la ruta de nuestro proyecto que esta creada en los helpers + el controlador que estamos ocupando y el metodo a crear
    var ajaxUrl = Base_URL + "/Roles/updateRol/" + idrol;
    var formData = new FormData(formRolesUpdate);
    request.open("POST", ajaxUrl, true);
    request.send(formData);

    //con la variable request agregamos un evento para monitorear el progreso de la solicitud XMLHttpRequest y manejar la respuesta recibida del servidor
    request.onreadystatechange = () => {
      if (request.readyState == 4 && request.status == 200) {
        //aqui creamos una variable en donde la respuesta que recibamos del servidor en caso de ser verdadera nos devolvera un String de tipo JSON, entonces lo que hacemos es convertir esa cadena en un objeto con JSON.parse. "Esto nos puede servir para poder acceder a los datos del objeto"
        var objData = JSON.parse(request.responseText);
        if (objData.status) {
          intStatus == 1
            ? '<span class="badge bg-success" style="color:#fff;">Activo</span>'
            : '<span class="badge bg-danger" style="color:#fff;">Inactivo</span>';

          $("#modalUpdateRoles").modal("hide");
          formRolesUpdate.reset();
          Swal.fire({
            title: "Roles",
            text: objData.msg,
            icon: "success",
            confirmButtonText: "aceptar",
          });
          tableRoles.ajax.reload();
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
          text: "Algo ha ocurrido durante el proceso, verificar codigo",
          icon: "error",
          confirmButtonText: "Aceptar",
        });
      }
      divLoading.style.display = "none";
      return false;
    };
  };
}

//Funcion para eliminar Roles
function btnDeletedRol(idrol) {
  Swal.fire({
    title: "Eliminar Rol",
    text: "¿Realmente quieres eliminar el rol?",
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
      var ajaxUrl = Base_URL + "/Roles/deleteRol/";
      var strData = "idrol=" + idrol;
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
            tableRoles.ajax.reload();
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
