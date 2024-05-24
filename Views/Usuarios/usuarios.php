<?php
headerAdmin($data);
getModal('modalUsuarios', $data);
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

<!--Botones-->
<div class="container mb-3">
    <div class="row">
        <div class="col-12 col-sm-auto mb-2">
            <?php if ($_SESSION['permisosModulo']['w']) { ?>
                <button type="button" class="btn btn-block" style="background: #ADBC9F; color:#fff;" data-bs-toggle="modal" data-bs-target="#modalUsuarios" id="btnModalUsuarios"><i class="fas fa-user-plus"></i> Agregar </button>
            <?php } ?>
        </div>
        <div class="col-12 col-sm-auto mb-2">
            <form id="btnPDFUsuarios" name="btnPDFUsuarios">
                <button class="btn btn-block" style="background:#7E0000; color:#fff;"><i class="fas fa-file-pdf"></i> PDF </button>
            </form>
        </div>
    </div>
</div>
<!--Fin-->

<!--Diseño de tabla Datatable-->
<div class="container-fluid">
    <div class="container">
        <div class="row">
            <div class="col mb-4">
                <div class="card shadow">
                    <div class="card-body" style="border-bottom: 7px solid #ADBC9F;">
                        <table id="tableUsers" class="table table-striped nowrap" style="width:100%">
                            <thead>
                                <tr>
                                    <th class="text-center">ID</th>
                                    <th class="text-center">Nombres</th>
                                    <th class="text-center">Apellidos</th>
                                    <th class="text-center">Correo</th>
                                    <th class="text-center">Usuario</th>
                                    <th class="text-center">Rol</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!--REGISTROS DE LA TABLA MEDIANTE AJAX-->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--Fin-->

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