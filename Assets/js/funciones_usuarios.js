var divLoading = document.querySelector("#divLoading");
var tableUsuarios;
var rowTable = "";

//Al recargar la pagina se ejecutaran las funciones que se le agreguen
document.addEventListener("DOMContentLoaded", () => {
  registrosUsuarios();
  fntAgregarUsuarios();
  validarCamposTexto();
  fntRolesUsuario();
});

//Funcion para los registros de la tabla usuarios
function registrosUsuarios() {
  tableUsuarios = $("#tableUsers").DataTable({
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
      url: Base_URL + "/Usuarios/getUsuarios",
      dataSrc: "",
    },
    columns: [
      { data: "iduser", className: "text-center" },
      { data: "nombres", className: "text-center" },
      { data: "apellidos", className: "text-center" },
      { data: "correo", className: "text-center" },
      { data: "usuario", className: "text-center" },
      { data: "nombre", className: "text-center" },
      { data: "status", className: "text-center" },
      { data: "options", className: "text-center", orderable: false },
    ],
    dom:
    "<'row'<'col-12 mb-3'B>>" + // Botones de exportación
    "<'row'<'col-12 mb-2'<<'col-12 mb-2'l> <<'col-12'f>>>>" + // Selector de longitud y cuadro de búsqueda
    "<'row'<'col-12 mb-4'tr>>" + // Tabla
    "<'row'<'col-12'p>>", // Paginación
    buttons: [
      {
        extend: "copyHtml5",
        text: "<i class='fas fa-copy'></i> Copiar",
        titleAttr: "Copiar",
        className: "btn btn-secondary col-12 col-sm-auto mb-2",
        exportOptions: {
          columns: [0, 1, 2, 3, 4, 5, 6], // Excluir la columna de acciones
        },
      },
      {
        extend: "excelHtml5",
        text: "<i class='fas fa-file-excel'></i> Excel",
        titleAttr: "Excel",
        className: "btn btn-success col-12 col-sm-auto mb-2",
        exportOptions: {
          columns: [0, 1, 2, 3, 4, 5, 6], // Excluir la columna de acciones
        },
      },
      {
        extend: "csvHtml5",
        text: "<i class='fas fa-file-csv'></i> CSV",
        titleAttr: "CSV",
        className: "btn btn-light col-12 col-sm-auto mb-2",
        exportOptions: {
          columns: [0, 1, 2, 3, 4, 5, 6], // Excluir la columna de acciones
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

//funcion para obtener los roles de la tabla de la BD
function fntRolesUsuario() {
  //cremos un objeto XMLHttpRequest de forma segura esto nos sirve para haver solicitudes HTTP desde un navegador web
  var request = window.XMLHttpRequest
    ? new XMLHttpRequest()
    : new ActiveXObject("Microsoft.XMLHTTP");
  //Creamos una varaible donde le almacenados el metodo del helper donde esta la ruta raiz del proyecto y le concatenamos el controlador a ocupar y el metodo a crear
  var ajaxUrl = Base_URL + "/Roles/getSelectRoles";
  request.open("GET", ajaxUrl, true);
  request.send();
  //con la variable request agregamos un evento para monitorear el progreso de la solicitud XMLHttpRequest y manejar la respuesta recibida del servidor
  request.onreadystatechange = function () {
    if (request.readyState == 4 && request.status == 200) {
      document.querySelector("#listRolid").innerHTML = request.responseText;
      document.querySelector("#listRolid").value = 1;
      document.querySelector("#listRolidUpdate").innerHTML =
        request.responseText;
      document.querySelector("#listRolidUpdate").value = 1;
    }
  };
}

//Funcion para agregar usuarios
function fntAgregarUsuarios() {
  const ModalUsers = document.getElementById("btnModalUsuarios");
  ModalUsers.addEventListener("click", () => {
    document.querySelector("#formUsuario").reset();
    //Crear una variable donde seleccionamos el id del formulario (form) y le agregamos un evento submit
    const formUsuario = document.querySelector("#formUsuario");
    formUsuario.onsubmit = (e) => {
      e.preventDefault();
      //Creamos variables y capturamos el id de los inputs
      const strNombre = document.querySelector("#txtNombres");
      const strApellido = document.querySelector("#txtApellidos");
      const strEmail = document.querySelector("#txtCorreo");
      const strUsuario = document.querySelector("#txtUsuario");
      const strPassword = document.querySelector("#txtPassword");
      const strPasswordConfirm = document.querySelector("#txtPasswordConfirm");
      const intTipoUsuario = document.querySelector("#listRolid");
      const intStatus = document.querySelector("#listStatus");
      //Validamos que los campos no vayan vacios
      if (
        strNombre == "" ||
        strApellido == "" ||
        strEmail == "" ||
        strUsuario == "" ||
        strPassword == "" ||
        strPasswordConfirm == "" ||
        intTipoUsuario == ""
      ) {
        Swal.fire({
          title: "¡Atención!",
          text: "Todos los campos son requeridos",
          icon: "error",
          confirmButtonText: "Aceptar",
        });
        return false;
      }
      //Validamos que las contraseñas sean iguales
      if (strPassword.value !== strPasswordConfirm.value) {
        Swal.fire({
          title: "¡Atención!",
          text: "Las contraseñas no coinciden",
          icon: "info",
          confirmButtonText: "Aceptar",
        });
        return false;
      }
      //Validamos que la contraseña contengan al menos 5 caracteres
      if (strPassword.value.length < 5) {
        Swal.fire({
          title: "¡Atención!",
          text: "Las contraseñas debe contener almenos 5 caracteres",
          icon: "info",
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
      var ajaxUrl = Base_URL + "/Usuarios/setUsuario";
      var formData = new FormData(formUsuario);
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

            $("#modalUsuarios").modal("hide");
            formUsuario.reset();
            Swal.fire({
              title: "Usuarios",
              text: objData.msg,
              icon: "success",
              confirmButtonText: "aceptar",
            });
            tableUsuarios.ajax.reload();
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

//Funcion para visualizar la informacion del usuario
function btnViewUsuario(iduser) {
  var request = window.XMLHttpRequest
    ? new XMLHttpRequest()
    : new ActiveXObject("Microsoft.XMLHTTP");
  var ajaxUrl = Base_URL + "/Usuarios/getUsuario/" + iduser;
  request.open("GET", ajaxUrl, true);
  request.send();
  request.onreadystatechange = function () {
    if (request.readyState == 4) {
      if (request.status == 200) {
        try {
          var objData = JSON.parse(request.responseText);
          if (objData.status) {
            var estadoUsuario =
              objData.data.status == 1
                ? '<span class="bagde bg-success" style="color:#fff;padding:5px;"><i class="fas fa-check-circle"></i> Activo </span>'
                : '<span class="bagde bg-danger" style="color:#fff;padding:5px;"><i class="fas fa-times-circle"></i> Inactivo </span>';
            document.querySelector("#cellNombres").innerHTML =
              objData.data.nombres;
            document.querySelector("#cellApellidos").innerHTML =
              objData.data.apellidos;
            document.querySelector("#cellCorreo").innerHTML =
              objData.data.correo;
            document.querySelector("#cellUsuario").innerHTML =
              objData.data.usuario;
            document.querySelector("#cellRol").innerHTML = objData.data.nombre;
            document.querySelector("#cellStatus").innerHTML = estadoUsuario;
            document.querySelector("#cellDate").innerHTML =
              objData.data.fechaRegistro;
            document.querySelector("#cellHour").innerHTML =
              objData.data.horaRegistro;
            $("#modalViewUsuarios").modal("show");
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
        }
      } else {
        console.error("Error de solicitud: " + request.status);
      }
    }
  };
}

//Funcion para cambiar la contraseña del usuario
function btnUpdatePass(iduser) {
  $("#modalUpdatePass").modal("show");
  // Crear una variable donde seleccionamos el formulario y le agregamos un evento submit
  const formPassUpdate = document.querySelector("#formUpdatePass");
  formPassUpdate.onsubmit = (e) => {
    e.preventDefault();
    // Capturar los valores de los campos de contraseña
    const strPassword = document.querySelector("#txtUpdatePassword").value;
    const strPasswordConfirm = document.querySelector(
      "#txtUpdatePasswordConfirm"
    ).value;
    // Validar que los campos no estén vacíos
    if (strPassword === "" || strPasswordConfirm === "") {
      Swal.fire({
        title: "¡Atención!",
        text: "Los campos son requeridos",
        icon: "error",
        confirmButtonText: "Aceptar",
      });
      return false;
    }
    // Validar que las contraseñas coincidan
    if (strPassword !== strPasswordConfirm) {
      Swal.fire({
        title: "!Atención¡",
        text: "Las contraseñas no son iguales, verificar por favor.",
        icon: "info",
        confirmButtonText: "Aceptar",
      });
      return false;
    }
    // Validar la longitud de la contraseña
    if (strPassword.length < 5) {
      Swal.fire({
        title: "!Atención¡",
        text: "La contraseña debe contener al menos 5 caracteres.",
        icon: "info",
        confirmButtonText: "Aceptar",
      });
      return false;
    }
    // Agregar un indicador de carga
    divLoading.style.display = "flex";
    // Crear una instancia de XMLHttpRequest
    var request = window.XMLHttpRequest
      ? new XMLHttpRequest()
      : new ActiveXObject("Microsoft.XMLHTTP");
    // Definir la URL y los datos a enviar
    var ajaxUrl = Base_URL + "/Usuarios/updatePass/" + iduser;
    var formData = new FormData(formPassUpdate);
    request.open("POST", ajaxUrl, true);
    // Enviar la solicitud
    request.send(formData);
    // Manejar la respuesta
    request.onreadystatechange = () => {
      if (request.readyState == 4 && request.status == 200) {
        var objData = JSON.parse(request.responseText);
        if (objData.status) {
          $("#modalUpdatePass").modal("hide");
          formPassUpdate.reset();
          Swal.fire({
            title: "Usuarios",
            text: objData.msg,
            icon: "success",
            confirmButtonText: "Aceptar",
          });
          tableUsuarios.ajax.reload();
        } else {
          Swal.fire({
            title: "Error",
            text: objData.msg,
            icon: "error",
            confirmButtonText: "Aceptar",
          });
        }
      } else if (request.readyState == 4) {
        Swal.fire({
          title: "Error",
          text: "Algo ha ocurrido en el proceso, verificar código",
          icon: "error",
          confirmButtonText: "Aceptar",
        });
      }
      // Ocultar el indicador de carga
      divLoading.style.display = "none";
    };
  };
}

//Funcion para extraer informacion de usuario para poder editar ya que reutilizaremos codigo de la funcion agregar usuarios
function btnUpdateUser(element, iduser) {
  rowTable = element.parentNode.parentNode.parentNode;
  var request = window.XMLHttpRequest
    ? new XMLHttpRequest()
    : new ActiveXObject("Microsoft.XMLHTTP");
  var ajaxUrl = Base_URL + "/Usuarios/getUsuario/" + iduser;
  request.open("GET", ajaxUrl, true);
  request.send();
  request.onreadystatechange = () => {
    if (request.readyState == 4 && request.status == 200) {
      var objData = JSON.parse(request.responseText);
      if (objData.status) {
        document.querySelector("#idUsuario").value = objData.data.iduser;
        document.querySelector("#txtNombresUpdate").value =
          objData.data.nombres;
        document.querySelector("#txtApellidosUpdate").value =
          objData.data.apellidos;
        document.querySelector("#txtCorreoUpdate").value = objData.data.correo;
        document.querySelector("#txtUsuarioUpdate").value =
          objData.data.usuario;
        document.querySelector("#listRolidUpdate").value = objData.data.idrol;

        if (objData.data.status == 1) {
          document.querySelector("#listStatusUpdate").value = 1;
        } else {
          document.querySelector("#listStatusUpdate").value = 2;
        }
      }
    }
    $("#modalUpdateUsuarios").modal("show");
  };

  //Crear una variable donde seleccionamos el id del formulario (form) y le agregamos un evento submit
  const formUsuarioUpdate = document.querySelector("#formUsuarioUpdate");
  formUsuarioUpdate.onsubmit = (e) => {
    e.preventDefault();
    //Creamos variables y capturamos el id de los inputs
    const strNombre = document.querySelector("#txtNombresUpdate").value;
    const strApellido = document.querySelector("#txtApellidosUpdate").value;
    const strEmail = document.querySelector("#txtCorreoUpdate").value;
    const strUsuario = document.querySelector("#txtUsuarioUpdate").value;
    const intTipoUsuario = document.querySelector("#listRolidUpdate").value;
    const intStatus = document.querySelector("#listStatusUpdate").value;
    //Validamos que los campos no vayan vacios
    if (
      strNombre == "" ||
      strApellido == "" ||
      strEmail == "" ||
      strUsuario == ""
    ) {
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
    var ajaxUrl = Base_URL + "/Usuarios/updateUsuario/" + iduser;
    var formData = new FormData(formUsuarioUpdate);
    request.open("POST", ajaxUrl, true);
    request.send(formData);

    //con la variable request agregamos un evento para monitorear el progreso de la solicitud XMLHttpRequest y manejar la respuesta recibida del servidor
    request.onreadystatechange = () => {
      if (request.readyState == 4 && request.status == 200) {
        //aqui creamos una variable en donde la respuesta que recibamos del servidor en caso de ser verdadera nos devolvera un String de tipo JSON, entonces lo que hacemos es convertir esa cadena en un objeto con JSON.parse. "Esto nos puede servir para poder acceder a los datos del objeto"
        var objData = JSON.parse(request.responseText);
        if (objData.status) {
          if (rowTable == "") {
            tableUsuarios.ajax.reload();
          } else {
            htmlStatus =
              intStatus == 1
                ? '<span class="badge bg-success" style="color:#fff;">Activo</span>'
                : '<span class="badge bg-danger" style="color:#fff;">Inactivo</span>';

            rowTable.cells[1].textContent = strNombre;
            rowTable.cells[2].textContent = strApellido;
            rowTable.cells[3].textContent = strEmail;
            rowTable.cells[4].textContent = strUsuario;
            rowTable.cells[5].textContent =
              document.querySelector(
                "#listRolidUpdate"
              ).selectedOptions[0].text;
            rowTable.cells[6].innerHTML = htmlStatus;
          }
          $("#modalUpdateUsuarios").modal("hide");
          formUsuarioUpdate.reset();
          Swal.fire({
            title: "Usuarios",
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

//Funcion para eliminar usuarios
function btnDeletedUser(iduser) {
  Swal.fire({
    title: "Eliminar usuario",
    text: "¿Realmente quieres eliminar el usuario?",
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
      var ajaxUrl = Base_URL + "/Usuarios/deleteUsuario/";
      var strData = "iduser=" + iduser;
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
            tableUsuarios.ajax.reload();
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
