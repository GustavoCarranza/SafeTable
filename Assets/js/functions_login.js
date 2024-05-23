var divLoading = document.querySelector("#divLoading");
//Cada vez que se recargue la pagina se ejecutaran las funciones que se le vayan agregando
document.addEventListener("DOMContentLoaded", () => {
  fntLogin();
});

//Funcion para el funcionamiento del login
function fntLogin() {
  //Validamos si existe el formulario
  if (document.querySelector("#formLogin")) {
    var formLogin = document.querySelector("#formLogin");
    formLogin.onsubmit = (e) => {
      e.preventDefault();

      //Capturamos en variables los id de (los inputs
      let txtUser = document.querySelector("#txtUser").value;
      let txtPassword = document.querySelector("#txtPassword").value;
      //Validamos que los inputs no vayan vacios
      if (txtUser == "" || txtPassword == "") {
        Swal.fire({
          title: "¡Atención!",
          text: "Ingresa el usuario y contraseña",
          icon: "error",
          confirmButtonText: "Aceptar",
        });
        return false;
      } else {
        divLoading.style.display = "flex";
        //Creamos un objeto XMLHttRequest lo cual nos permite realizar peticiones al navegador web
        var request = window.XMLHttpRequest
          ? new XMLHttpRequest()
          : new ActiveXObject("Microsoft.XMLHTTP");
        //Creamos la variable de ruta apuntando al controlador mas el metodo a crear
        var ajaxUrl = Base_URL + "/Login/loginUser";
        var formData = new FormData(formLogin);
        request.open("POST", ajaxUrl, true);
        request.send(formData);
        //con la variable request agregamos un evento para monitorear el progreso de la solicitud XMLHttpRequest y manejar la respuesta recibida del servidor
        request.onreadystatechange = function () {
          if (request.readyState == 4 && request.status == 200) {
            //aqui creamos una variable en donde la respuesta que recibamos del servidor en caso de ser verdadera nos devolvera un String de tipo JSON, entonces lo que hacemos es convertir esa cadena en un objeto con JSON.parse. "Esto nos puede servir para poder acceder a los datos del objeto"
            var objData = JSON.parse(request.responseText);
            if (objData.status) {
              window.location = Base_URL + "/dashboard";
            } else {
              Swal.fire({
                title: "¡Atención!",
                text: objData.msg,
                icon: "error",
                confirmButtonText: "Aceptar",
              });
              document.querySelector("#txtPassword").value = "";
            }
          }
          divLoading.style.display = "none";
        };
      }
    };
  }
}
