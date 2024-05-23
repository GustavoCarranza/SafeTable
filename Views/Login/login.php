<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="">
  <meta name="author" content="Gustavo Carranza">
  <meta name="theme-color" content="#009688">
  <link rel="shortcut icon" href="<?= media(); ?>/images/logo.jpg" type="image/x-icon">
  <link href="<?= media(); ?>/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link rel="stylesheet" href="<?= media(); ?>/css/loginStyle.css">
  <title><?= $data['page_title']; ?></title>
</head>

<body>
  <style>
    #divLoading {
      position: fixed;
      top: 0;
      width: 100%;
      height: 100%;
      background: blue;
      display: flex;
      justify-content: center;
      align-items: center;
      background: rgba(254, 254, 254, 0.65);
      z-index: 9999;
      display: none;
    }

    #divLoading img {
      width: 50px;
      height: 50px;
    }
  </style>
  <div id="divLoading">
    <div>
      <img src="<?= media(); ?>/images/loading.svg" alt="Loading">
    </div>
  </div>

  <div class="container">
    <div class="forms-container">
      <div class="signin-signup">
        <form action="" class="sign-in-form" name="formLogin" id="formLogin">
          <h2 class="title">Iniciar Sesión</h2>
          <div class="input-field">
            <i class="fas fa-user"></i>
            <input type="text" placeholder="Username" name="txtUser" id="txtUser" required />
          </div>
          <div class="input-field">
            <i class="fas fa-lock"></i>
            <input type="password" placeholder="Password" name="txtPassword" id="txtPassword" required />
          </div>
          <button type="submit" class="btn solid"><i class="fas fa-check-circle"></i> Iniciar </button>
        </form>
      </div>
    </div>

    <div class="panels-container">
      <div class="panel left-panel">
        <div class="content">
          <h3>SafeTable</h3>
          <p>
            Esperamos que tu experiencia sea de lo mejor y esta herramienta sea de utilidad para cubrir el maximo de necesidades.
          </p>
        </div>
        <img src="<?= media(); ?>/images/logoLogin.svg" class="image" alt="" />
      </div>
    </div>
  </div>
  <!-- Bootstrap core JavaScript-->
  <script src="<?= media(); ?>/js/jquery/jquery.min.js"></script>
  <script src="<?= media(); ?>/js/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- Core plugin JavaScript-->
  <script src="<?= media(); ?>/js/jquery-easing/jquery.easing.min.js"></script>
  <script src="<?= media(); ?>/js/plugins/sweetalert2.all.min.js"></script>
  <script src="<?= media(); ?>/js/<?= $data['page_functions_js'] ?>"></script>
  <script>
    var Base_URL = "<?php echo Base_URL; ?>";
  </script>
</body>

</html>