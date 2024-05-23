var divLoading = document.querySelector("#divLoading");

document.addEventListener("DOMContentLoaded", () => {
  fntCambiarInfo();
  fntCambiarPassPerfil();
  validarCamposTexto();
});

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
  

//Funcion para editar la informacion del perfil de usuario
function fntCambiarInfo() {
  const modalPerfil = document.getElementById("btnModalEditInfo");
  modalPerfil.addEventListener("click", () => {
    $("#modalUpdateUsuarios").modal("show");

    //Crear una variable donde seleccionamos el id del formulario (form) y le agregamos un evento submit
    const formUsuarioUpdate = document.querySelector("#formUsuarioUpdate");
    formUsuarioUpdate.onsubmit = (e) => {
      e.preventDefault();
      //Creamos variables y capturamos el id de los inputs
      const strNombre = document.querySelector("#txtNombresUpdate").value;
      const strApellido = document.querySelector("#txtApellidosUpdate").value;
      const strEmail = document.querySelector("#txtCorreoUpdate").value;
      const strUsuario = document.querySelector("#txtUsuarioUpdate").value;
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
      var ajaxUrl = Base_URL + "/Usuarios/putPerfil";
      var formData = new FormData(formUsuarioUpdate);
      request.open("POST", ajaxUrl, true);
      request.send(formData);

      //con la variable request agregamos un evento para monitorear el progreso de la solicitud XMLHttpRequest y manejar la respuesta recibida del servidor
      request.onreadystatechange = () => {
        if (request.readyState == 4 && request.status == 200) {
          //aqui creamos una variable en donde la respuesta que recibamos del servidor en caso de ser verdadera nos devolvera un String de tipo JSON, entonces lo que hacemos es convertir esa cadena en un objeto con JSON.parse. "Esto nos puede servir para poder acceder a los datos del objeto"
          var objData = JSON.parse(request.responseText);
          if (objData.status) {
            $("#modalUpdateUsuarios").modal("hide");
            formUsuarioUpdate.reset();
            Swal.fire({
              title: "Perfil",
              text: objData.msg,
              icon: "success",
              confirmButtonText: "aceptar",
            }).then((result) => {
              if (result.isConfirmed) {
                location.reload();
              }
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
  });
}

//Funcion para cambiar la contraseña del perfil de usuario
function fntCambiarPassPerfil() {
  const formCambiarPass = document.getElementById("formCambioPass");
  formCambiarPass.onsubmit = (e) => {
    e.preventDefault();
    //Capturamos los datos
    const strPasswordActual =
      document.querySelector("#txtPasswordActual").value;
    const strPasswordNew = document.querySelector("#txtPasswordNew").value;
    const strPasswordNewConfirm = document.querySelector(
      "#txtPasswordNewConfirm"
    ).value;
    // Validar que los campos no estén vacíos
    if (
      strPasswordActual === "" ||
      strPasswordNew === "" ||
      strPasswordNewConfirm === ""
    ) {
      Swal.fire({
        title: "¡Atención!",
        text: "Los campos son requeridos",
        icon: "error",
        confirmButtonText: "Aceptar",
      });
      return false;
    }
    // Validar que las contraseñas coincidan
    if (strPasswordNew !== strPasswordNewConfirm) {
      Swal.fire({
        title: "!Atención¡",
        text: "Las contraseña nueva y la confirmacion no son iguales, verificar por favor.",
        icon: "info",
        confirmButtonText: "Aceptar",
      });
      return false;
    }
    // Validar la longitud de la contraseña
    if (strPasswordNew.length < 5) {
      Swal.fire({
        title: "!Atención¡",
        text: "La contraseña nueva debe contener al menos 5 caracteres.",
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
    var ajaxUrl = Base_URL + "/Usuarios/updatePassPerfil/";
    var formData = new FormData(formCambiarPass);
    request.open("POST", ajaxUrl, true);
    // Enviar la solicitud
    request.send(formData);
    // Manejar la respuesta
    request.onreadystatechange = () => {
      if (request.readyState == 4 && request.status == 200) {
        var objData = JSON.parse(request.responseText);
        if (objData.status) {
          formCambiarPass.reset();
          Swal.fire({
            title: "Perfil",
            text: objData.msg,
            icon: "success",
            confirmButtonText: "Aceptar",
          }).then((result) => {
            if (result.isConfirmed) {
              location.reload();
            }
          });
        } else {
          Swal.fire({
            title: "Error",
            text: objData.msg,
            icon: "error",
            confirmButtonText: "Aceptar",
          });
        }
      } else{
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
