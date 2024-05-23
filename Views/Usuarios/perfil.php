<?php
headerAdmin($data);
getModal('modalPerfil', $data);
?>
<!--Nombre y diseño de la vista-->
<div class="topbar mb-4 shadow bg-white">
    <div class="container-xl ">
        <div class="row">
            <div class="col-12 d-flex justify-content-center align-content-center">
                <div class="ml-4 text-center">
                    <h2 class="text-gray-600"><?= $data['page_tag'] ?></h2>
                </div>
            </div>
        </div>
    </div>
</div>
<!--Fin-->


<div class="container mb-5">
    <div class="row">
        <div class="col-md-4">
            <div class="card mb-3">
                <img src="<?= media() ?>/images/logo.jpg" class="card-img-top" alt="...">
                <div class="card-body">
                    <h5 class="card-title"><?= $_SESSION['UserData']['nombres'] . ' ' . $_SESSION['UserData']['apellidos']; ?></h5>
                    <p class="card-text"><?= $_SESSION['UserData']['nombre']; ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title">Datos Personales</h5>
                    <table class="table">
                        <tbody>
                            <tr>
                                <td style="width: 80px">Nombres: </td>
                                <td><?= $_SESSION['UserData']['nombres']; ?></td>
                            </tr>
                            <tr>
                                <td style="width: 80px">Apellidos: </td>
                                <td><?= $_SESSION['UserData']['apellidos']; ?></td>
                            </tr>
                            <tr>
                                <td style="width: 80px">Correo: </td>
                                <td><?= $_SESSION['UserData']['correo']; ?></td>
                            </tr>
                            <tr>
                                <td style="width: 80px">Usuario: </td>
                                <td><?= $_SESSION['UserData']['usuario']; ?></td>
                            </tr>
                        </tbody>
                    </table>
                    <button class="btn" style="background:#436850; color:#fff" id="btnModalEditInfo"><i class="fas fa-edit"></i> Editar </button>
                </div>
            </div>
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">Cambio de contraseña</h5>
                    <form action="" name="formCambioPass" id="formCambioPass">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <label> Contraseña actual: </label>
                                    <input type="password" name="txtPasswordActual" id="txtPasswordActual" class="form-control w-50">
                                </tr>
                                <tr>
                                    <label> Nueva contraseña: </label>
                                    <input type="password" name="txtPasswordNew" id="txtPasswordNew" class="form-control w-50">
                                </tr>
                                <tr>
                                    <label> Confirmar Contraseña: </label>
                                    <input type="password" name="txtPasswordNewConfirm" id="txtPasswordNewConfirm" class="form-control w-50">
                                </tr>
                            </tbody>
                        </table>
                        <button class="btn" style="background:#436850; color:#fff"><i class="fas fa-lock"></i> Cambiar
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>



<!--no borrar este div-->
</div>

<!--Footer-->
<footer class="sticky-footer bg-white">
    <div class="container my-auto">
        <div class="copyright text-center my-auto">
            <span>Copyright &copy; developer by Gustavo Carranza</span>
        </div>
    </div>
</footer>
<!--Footer-fin-->

</div>
</div>
<?php footerAdmin($data); ?>