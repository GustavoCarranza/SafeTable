<!-- Agregar restaurantes -->
<div class="modal fade" id="modalAgregar" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background: #ADBC9F; color:#fff;">
                <h5 class="modal-title"> Nuevo Restaurante </h5>
                <button type="button" class="btn-close btn-dark " data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <form class="form-horizontal" id="formRestaurante" name="formRestaurante">
                    <p class="text-danger">Todos los campos son obligatorios</p>

                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="txtNombre">Nombre: </label>
                            <input type="text" name="txtNombre" id="txtNombre" class="form-control valid validText" required>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="txtDescripcion">Descripción: </label>
                            <textarea class="form-control" name="txtDescripcion" id="txtDescripcion" rows="5"></textarea>
                        </div>
                        <div class="form-group col-md-12">
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

<!-- Editar informacion de restaurantes -->
<div class="modal fade" id="modalEditar" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background: #436850; color:#fff;">
                <h5 class="modal-title"> Actualizar información </h5>
                <button type="button" class="btn-close btn-dark " data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <form class="form-horizontal" id="formRestauranteEdit" name="formRestauranteEdit">
                    <p class="text-danger">Todos los campos son obligatorios</p>

                    <input type="hidden" name="idrestaurante" id="idrestaurante">

                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="txtNombreEdit">Nombre: </label>
                            <input type="text" name="txtNombreEdit" id="txtNombreEdit" class="form-control valid validText" required>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="txtDescripcionEdit">Descripción: </label>
                            <textarea class="form-control" name="txtDescripcionEdit" id="txtDescripcionEdit" rows="5"></textarea>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="listStatusEdit">Status: </label>
                            <select name="listStatusEdit" id="listStatusEdit" class="form-control">
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