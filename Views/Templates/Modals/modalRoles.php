<!--Agregar roles-->
<div class="modal fade" id="modalRoles" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" style="background: #ADBC9F; color:#fff;">
                <h5 class="modal-title"> Nuevo Rol </h5>
                <button type="button" class="btn-close btn-dark " data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <form class="form-horizontal" id="formRoles" name="formRoles">
                    <p class="text-danger">Todos los campos son obligatorios</p>

                    <div class="form-group">
                        <label class="control-label" for="txtNombre">Nombre: </label>
                        <input type="text" name="txtNombre" id="txtNombre" class="form-control valid validText" required>
                    </div>

                    <div class="form-group">
                        <label class="control-label" for="txtDescripcion">Descripción: </label>
                        <textarea class="form-control" id="txtDescripcion" name="txtDescripcion" rows="2" placeholder="Descripcion del rol" required></textarea>
                    </div>

                    <div class="form-group">
                        <label class="control-label" for="listStatus">Status: </label>
                        <select name="listStatus" id="listStatus" class="form-control">
                            <option value="1">Activo</option>
                            <option value="2">Inactivo</option>
                        </select>
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

<!--Editar roles-->
<div class="modal fade" id="modalUpdateRoles" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" style="background: #436850; color:#fff;">
                <h5 class="modal-title"> Actualizar información Rol </h5>
                <button type="button" class="btn-close btn-dark " data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <form class="form-horizontal" id="formRolesUpdate" name="formRolesUpdate">
                    <p class="text-danger">Todos los campos son obligatorios</p>

                    <input type="hidden" name="idRol" id="idRol" required>

                    <div class="form-group">
                        <label class="control-label" for="txtNombreUpdate">Nombre: </label>
                        <input type="text" name="txtNombreUpdate" id="txtNombreUpdate" class="form-control valid validText" required>
                    </div>

                    <div class="form-group">
                        <label class="control-label" for="txtDescripcionUpdate">Descripción: </label>
                        <textarea class="form-control" id="txtDescripcionUpdate" name="txtDescripcionUpdate" rows="2" placeholder="Descripcion del rol" required></textarea>
                    </div>

                    <div class="form-group">
                        <label class="control-label" for="listStatusUpdate">Status: </label>
                        <select name="listStatusUpdate" id="listStatusUpdate" class="form-control">
                            <option value="1">Activo</option>
                            <option value="2">Inactivo</option>
                        </select>
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

