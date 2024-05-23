<!-- Agregar usuarios -->
<div class="modal fade" id="modalUsuarios" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg ">
        <div class="modal-content">
            <div class="modal-header" style="background: #ADBC9F; color:#fff;">
                <h5 class="modal-title"> Nuevo Usuario </h5>
                <button type="button" class="btn-close btn-dark " data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <form class="form-horizontal" id="formUsuario" name="formUsuario">
                    <p class="text-danger">Todos los campos son obligatorios</p>

                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="txtNombre">Nombres: </label>
                            <input type="text" name="txtNombres" id="txtNombres" class="form-control valid validText" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="txtApellidos">Apellidos: </label>
                            <input type="text" name="txtApellidos" id="txtApellidos" class="form-control valid validText" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="txtCorreo">Correo electronico: </label>
                            <input type="email" name="txtCorreo" id="txtCorreo" class="form-control valid validEmail" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="txtUsuario">Usuario: </label>
                            <input type="text" name="txtUsuario" id="txtUsuario" class="form-control" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="txtPassword">Password: </label>
                            <input type="password" name="txtPassword" id="txtPassword" class="form-control" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="txtPasswordConfirm">Confirmar Password: </label>
                            <input type="password" name="txtPasswordConfirm" id="txtPasswordConfirm" class="form-control" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="listRolid">Tipo de usuario: </label>
                            <select name="listRolid" id="listRolid" class="form-control">

                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="listStatus">Status: </label>
                            <select name="listStatus" id="listStatus" class="form-control">
                                <option value="1">Activo</option>
                                <option value="2">Inactivo</option>
                            </select>
                        </div>
                    </div>

            </div>

            <div class="modal-footer">
                <button type="submit" class="btn" style="background: #ADBC9F; color:#fff;">
                    <i class="fas fa-fw fa-check-circle"></i>
                    <span> Agregar </span>
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

<!-- Ver informacion del usuario -->
<div class="modal fade" id="modalViewUsuarios" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" style="background: #5F5F5F; color:#fff">
                <h5 class="modal-title">Información del usuario</h5>
                <button type="button" class="btn-close btn-dark " data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <td>Nombres: </td>
                            <td id="cellNombres"></td>
                        </tr>
                        <tr>
                            <td>Apellidos: </td>
                            <td id="cellApellidos"></td>
                        </tr>
                        <tr>
                            <td>Correo electronico: </td>
                            <td id="cellCorreo"></td>
                        </tr>
                        <tr>
                            <td>Usuario: </td>
                            <td id="cellUsuario"></td>
                        </tr>
                        <tr>
                            <td>Rol: </td>
                            <td id="cellRol"></td>
                        </tr>
                        <tr>
                            <td>Status: </td>
                            <td id="cellStatus"></td>
                        </tr>
                        <tr>
                            <td>Fecha de creación: </td>
                            <td id="cellDate"></td>
                        </tr>
                        <tr>
                            <td>Hora de creación: </td>
                            <td id="cellHour"></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-dark" data-bs-dismiss="modal">
                    <i class="fas fa-fw fa-times-circle"></i>
                    Cerrar
                </button>
            </div>
        </div>
    </div>
</div>

<!-- cambio de contraseña del usuario -->
<div class="modal fade" id="modalUpdatePass" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered ">
        <div class="modal-content">
            <div class="modal-header" style="background: #015D80; color:#fff">
                <h5 class="modal-title">Cambiar contraseña del usuario</h5>
                <button type="button" class="btn-close btn-dark " data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" id="formUpdatePass" name="formUpdatePass">
                    <input type="hidden" name="idUserPass" id="idUserPass">

                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="txtUpdatePassword">Nueva contraseña: </label>
                            <input type="password" name="txtUpdatePassword" id="txtUpdatePassword" class="form-control" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="txtUpdatePasswordConfirm">Confirmar Contraseña: </label>
                            <input type="password" name="txtUpdatePasswordConfirm" id="txtUpdatePasswordConfirm" class="form-control" required>
                        </div>
                    </div>
            </div>

            <div class="modal-footer">
                <button type="submit" class="btn" style="background:#015D80; color:#fff;">
                    <i class="fas fa-fw fa-check-circle"></i>
                    <span> Cambiar </span>
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

<!-- Editar usuarios -->
<div class="modal fade" id="modalUpdateUsuarios" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg ">
        <div class="modal-content">
            <div class="modal-header" style="background: #436850; color:#fff;">
                <h5 class="modal-title"> Actualizar Información de usuario </h5>
                <button type="button" class="btn-close btn-dark " data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <form class="form-horizontal" id="formUsuarioUpdate" name="formUsuarioUpdate">
                    <p class="text-danger">Todos los campos son obligatorios</p>

                    <input type="hidden" name="idUsuario" id="idUsuario">

                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="txtNombreUpdate">Nombres: </label>
                            <input type="text" name="txtNombresUpdate" id="txtNombresUpdate" class="form-control valid validText" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="txtApellidosUpdate">Apellidos: </label>
                            <input type="text" name="txtApellidosUpdate" id="txtApellidosUpdate" class="form-control valid validText" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="txtCorreoUpdate">Correo electronico: </label>
                            <input type="email" name="txtCorreoUpdate" id="txtCorreoUpdate" class="form-control valid validEmail" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="txtUsuarioUpdate">Usuario: </label>
                            <input type="text" name="txtUsuarioUpdate" id="txtUsuarioUpdate" class="form-control" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="listRolidUpdate">Tipo de usuario: </label>
                            <select name="listRolidUpdate" id="listRolidUpdate" class="form-control">

                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="listStatusUpdate">Status: </label>
                            <select name="listStatusUpdate" id="listStatusUpdate" class="form-control">
                                <option value="1">Activo</option>
                                <option value="2">Inactivo</option>
                            </select>
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
