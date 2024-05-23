<!-- Agregar Reservaciones -->
<div class="modal fade" id="modalRestaurantes" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg ">
        <div class="modal-content">
            <div class="modal-header" style="background: #ADBC9F; color:#fff;">
                <h5 class="modal-title"> Agregar reservación </h5>
                <button type="button" class="btn-close btn-dark " data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <form class="form-horizontal" id="formReserva" name="formReserva">
                    <p class="text-danger">Todos los campos son obligatorios</p>

                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="txtNombre">Restaurante: </label>
                            <select class="form-control" name="listRestaurantes" id="listRestaurantes">

                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="txtHuesped">Huesped: </label>
                            <input type="text" name="txtHuesped" id="txtHuesped" class="form-control valid validText" required>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="txtApellidos">Apellidos: </label>
                            <input type="text" name="txtApellidos" id="txtApellidos" class="form-control valid validText" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="txtVilla">Villa: </label>
                            <input type="text" name="txtVilla" id="txtVilla" class="form-control valid validNumber" required>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="txtHotel">Hotel: </label>
                            <input type="text" name="txtHotel" id="txtHotel" class="form-control valid validText" required>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="txtAdultos">Adultos: </label>
                            <input type="text" name="txtAdultos" id="txtAdultos" class="form-control valid validNumber" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="txtKids">Niños: </label>
                            <input type="text" name="txtKids" id="txtKids" class="form-control valid validNumber">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="txtFecha">Fecha de reservación: </label>
                            <input type="date" name="txtFecha" id="txtFecha" class="form-control">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="txtHorario">Horario de reservación: </label>
                            <input type="time" name="txtHorario" id="txtHorario" class="form-control" required>
                        </div>

                    </div>

                    <div class="row">
                        <div class="form-group col-md-8">
                            <label for="txtComentarios">Comentarios: </label>
                            <textarea class="form-control" name="txtComentarios" id="txtComentarios" rows="4" required></textarea>
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

<!-- Ver informacion de la reservacion-->
<div class="modal fade" id="modalViewReserva" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background: #5F5F5F; color:#fff">
                <h5 class="modal-title">Información de la reservación</h5>
                <button type="button" class="btn-close btn-dark " data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div style="display: flex; margin-bottom: 20px;">
                    <div style="flex: 1; margin-right: 10px;">
                        <table class="table table-bordered" style="width: 100%; max-width: 400px;">
                            <tbody>
                                <tr>
                                    <td style="vertical-align: middle;">Restaurante:</td>
                                    <td id="cellRestaurante"></td>
                                </tr>
                                <tr>
                                    <td style="vertical-align: middle;">Huesped:</td>
                                    <td id="cellHuesped"></td>
                                </tr>
                                <tr>
                                    <td style="vertical-align: middle;">Apellidos:</td>
                                    <td id="cellApellidos"></td>
                                </tr>
                                <tr>
                                    <td style="vertical-align: middle;">Villa:</td>
                                    <td id="cellVilla"></td>
                                </tr>
                                <tr>
                                    <td style="vertical-align: middle;">Hotel:</td>
                                    <td id="cellHotel"></td>
                                </tr>
                                <tr>
                                    <td style="vertical-align: middle;">Adultos:</td>
                                    <td id="cellAdultos"></td>
                                </tr>
                                <tr>
                                    <td style="vertical-align: middle;">Niños:</td>
                                    <td id="cellKids"></td>
                                </tr>
                                <tr>
                                    <td style="vertical-align: middle;">Fecha de reservación:</td>
                                    <td id="cellFechaReserva"></td>
                                </tr>
                                <tr>
                                    <td style="vertical-align: middle;">Horario de reservación:</td>
                                    <td id="cellHoraReserva"></td>
                                </tr>
                                <tr>
                                    <td style="vertical-align: middle;">Comentarios:</td>
                                    <td style="max-width: 200px; overflow-x: auto; vertical-align: middle;" id="cellComentarios"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div style="flex: 1;">
                        <table class="table table-bordered" style="width: 100%; max-width: 400px;">
                            <tbody>
                                <tr>
                                    <td style="vertical-align: middle;">Fecha de creación:</td>
                                    <td id="cellFechaCreacion"></td>
                                </tr>
                                <tr>
                                    <td style="vertical-align: middle;">Hora de creación:</td>
                                    <td id="cellHoraCreacion"></td>
                                </tr>
                                <tr>
                                    <td style="vertical-align: middle;">Usuario que creó la reservación:</td>
                                    <td id="cellUsuarioCreacion"></td>
                                </tr>
                                <tr>
                                    <td style="vertical-align: middle;">Fecha de edición:</td>
                                    <td id="cellFechaEdicion"></td>
                                </tr>
                                <tr>
                                    <td style="vertical-align: middle;">Hora de edición:</td>
                                    <td id="cellHoraEdicion"></td>
                                </tr>
                                <tr>
                                    <td style="vertical-align: middle;">Usuario que editó la reservación:</td>
                                    <td id="cellUsuarioEdicion"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
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

<!-- Editar Reservaciones -->
<div class="modal fade" id="modalEditReservas" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg ">
        <div class="modal-content">
            <div class="modal-header" style="background: #436850; color:#fff;">
                <h5 class="modal-title"> Editar datos de reservación</h5>
                <button type="button" class="btn-close btn-dark " data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <form class="form-horizontal" id="formReservaEdit" name="formReservaEdit">
                    <p class="text-danger">Todos los campos son obligatorios</p>

                    <input type="hidden" name="idreserva" id="idreserva">

                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="txtNombre">Restaurante: </label>
                            <select class="form-control" name="listRestaurantesEdit" id="listRestaurantesEdit">

                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="txtHuesped">Huesped: </label>
                            <input type="text" name="txtHuespedEdit" id="txtHuespedEdit" class="form-control valid validText" required>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="txtApellidos">Apellidos: </label>
                            <input type="text" name="txtApellidosEdit" id="txtApellidosEdit" class="form-control valid validText" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="txtVilla">Villa: </label>
                            <input type="text" name="txtVillaEdit" id="txtVillaEdit" class="form-control valid validNumber" required>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="txtHotel">Hotel: </label>
                            <input type="text" name="txtHotelEdit" id="txtHotelEdit" class="form-control valid validText" required>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="txtAdultos">Adultos: </label>
                            <input type="text" name="txtAdultosEdit" id="txtAdultosEdit" class="form-control valid validNumber" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="txtKids">Niños: </label>
                            <input type="text" name="txtKidsEdit" id="txtKidsEdit" class="form-control valid validNumber">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="txtFecha">Fecha de reservación: </label>
                            <input type="date" name="txtFechaEdit" id="txtFechaEdit" class="form-control">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="txtHorario">Horario de reservación: </label>
                            <input type="time" name="txtHorarioEdit" id="txtHorarioEdit" class="form-control" required>
                        </div>

                    </div>

                    <div class="row">
                        <div class="form-group col-md-8">
                            <label for="txtComentarios">Comentarios: </label>
                            <textarea class="form-control" name="txtComentariosEdit" id="txtComentariosEdit" rows="4" required></textarea>
                        </div>
                    </div>

            </div>

            <div class="modal-footer">
                <button type="submit" class="btn" style="background: #436850; color:#fff;">
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