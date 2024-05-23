<!--Otorgar permisos a roles-->
<div class="modal fade" id="modalPermisos" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl ">
        <div class="modal-content">
            <div class="modal-header" style="background: #5F5F5F ; color:#fff;">
                <h5 class="modal-title"> Otorgar permisos a roles </h5>
                <button type="button" class="btn-close btn-dark " data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" id="formPermisos" name="formPermisos">
                    <input type="hidden" name="idrol" id="idrol" value="<?= $data['idrol']; ?>" required>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th class="text-center">Módulo</th>
                                    <th class="text-center">Ver</th>
                                    <th class="text-center">Crear</th>
                                    <th class="text-center">Actualizar</th>
                                    <th class="text-center">Eliminar</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                $modulos = $data['modulos'];
                                foreach ($modulos as $modulo) {
                                    $permisos = $modulo['permisos'];
                                    $rCheck = $permisos['r'] == 1 ? " checked " : "";
                                    $wCheck = $permisos['w'] == 1 ? " checked " : "";
                                    $uCheck = $permisos['u'] == 1 ? " checked " : "";
                                    $dCheck = $permisos['d'] == 1 ? " checked " : "";

                                    $idmod = $modulo['idmodulo'];
                                ?>
                                    <tr>
                                        <!--Numero del modulo-->
                                        <td class="text-center">
                                            <?= $no; ?>
                                            <input type="hidden" name="modulos[<?= $idmod; ?>][idmodulo]" value="<?= $idmod ?>" required>
                                        </td>

                                        <!--Titulo del modulo-->
                                        <td class="text-center">
                                            <?= $modulo['nombre']; ?>
                                        </td>

                                        <!--Tipo R-->
                                        <td class="text-center">
                                            <div class="toggle-flip">
                                                <input class="form-check-input" type="checkbox" id="toggleFlip1_<?= $idmod ?>" name="modulos[<?= $idmod; ?>][r]" <?= $rCheck ?>>
                                                <label class="form-check-label" for="toggleFlip1_<?= $idmod ?>" data-toggle-on="" data-toggle-off="">
                                                    <span class="flip-indicator"></span>
                                                </label>
                                            </div>
                                        </td>

                                        <!--Tipo W-->
                                        <td class="text-center">
                                            <div class="toggle-flip">
                                                <input class="form-check-input" type="checkbox" id="toggleFlip2_<?= $idmod ?>" name="modulos[<?= $idmod; ?>][w]" <?= $wCheck ?>>
                                                <label class="form-check-label" for="toggleFlip2_<?= $idmod ?>" data-toggle-on="" data-toggle-off="">
                                                    <span class="flip-indicator"></span>
                                                </label>
                                            </div>
                                        </td>

                                        <!--Tipo U-->
                                        <td class="text-center">
                                            <div class="toggle-flip">
                                                <input class="form-check-input" type="checkbox" id="toggleFlip3_<?= $idmod ?>" name="modulos[<?= $idmod; ?>][u]" <?= $uCheck ?>>
                                                <label class="form-check-label" for="toggleFlip3_<?= $idmod ?>" data-toggle-on="" data-toggle-off="">
                                                    <span class="flip-indicator"></span>
                                                </label>
                                            </div>
                                        </td>

                                        <!--Tipo D-->
                                        <td class="text-center">
                                            <div class="toggle-flip">
                                                <input class="form-check-input" type="checkbox" id="toggleFlip4_<?= $idmod ?>" name="modulos[<?= $idmod; ?>][d]" <?= $dCheck ?>>
                                                <label class="form-check-label" for="toggleFlip4_<?= $idmod ?>" data-toggle-on="" data-toggle-off="">
                                                    <span class="flip-indicator"></span>
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                <?php
                                    $no++;
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn" style="background: #5F5F5F; color:#fff;">
                            <i class="fas fa-fw fa-check-circle"></i>
                            <span> Asignar </span>
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
</div>