<!-- Editar usuarios -->
<div class="modal fade" id="modalUpdateUsuarios" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog  modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" style="background: #436850; color:#fff;">
                <h5 class="modal-title"> Editar perfil </h5>
                <button type="button" class="btn-close btn-dark " data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <form class="form-horizontal" id="formUsuarioUpdate" name="formUsuarioUpdate">
                    <p class="text-danger">Todos los campos son obligatorios</p>

                    <div class="row">
                        <div class="form-group">
                            <label for="txtNombreUpdate">Nombres: </label>
                            <input type="text" name="txtNombresUpdate" id="txtNombresUpdate" class="form-control valid validText" value="<?= $_SESSION['UserData']['nombres'] ?>" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group">
                            <label for="txtApellidosUpdate">Apellidos: </label>
                            <input type="text" name="txtApellidosUpdate" id="txtApellidosUpdate" class="form-control valid validText" value="<?= $_SESSION['UserData']['apellidos'] ?>" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group">
                            <label for="txtCorreoUpdate">Correo electronico: </label>
                            <input type="email" name="txtCorreoUpdate" id="txtCorreoUpdate" class="form-control valid validEmail" value="<?= $_SESSION['UserData']['correo'] ?>" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group">
                            <label for="txtUsuarioUpdate">Usuario: </label>
                            <input type="text" name="txtUsuarioUpdate" id="txtUsuarioUpdate" class="form-control" value="<?= $_SESSION['UserData']['usuario'] ?>" required>
                        </div>
                    </div>
            </div>

            <div class="modal-footer">
                <button type="submit" class="btn" style="background: #436850; color:#fff;">
                    <i class="fas fa-fw fa-check-circle"></i>
                    <span> Actualizar </span>
                </button>
                &nbsp;&nbsp;&nbsp;
                <button type="button" class="btn btn-dark" data-bs-dismiss="modal">
                    <i class="fas fa-fw fa-times-circle"></i>
                    Cerrar
                </button>
            </div>
            </form>
        </div>
    </div>
</div>