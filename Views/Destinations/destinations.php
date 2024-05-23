<?php
headerAdmin($data);
getModal('ModalDestinations', $data);
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
            <?php if($_SESSION['permisosModulo']['w']){?>
            <button class="btn btn-success btn-block" id="btnModalDestinations"><i class="fas fa-plus"></i> Agregar </button>
            <?php } ?>
        </div>
        <div class="col-12 col-sm-auto mb-2">
            <button class="btn btn-primary btn-block"><i class="fas fa-book"></i> Reservaciones </button>
        </div>
    </div>
</div>
<!--Fin-->

<!--Diseño de la tabla DataTable-->
<div class="container-fluid">
    <div class="container">
        <div class="row">
            <div class="col mb-4">
                <div class="card shadow">
                    <div class="card-body" style="border-bottom: 7px solid #ADBC9F;">
                        <table id="tableDestinations" class="table table-striped nowrap" style="width:100%">
                            <thead>
                                <tr>
                                    <th class="text-center">ID</th>
                                    <th class="text-center">Destination</th>
                                    <th class="text-center">Fecha</th>
                                    <th class="text-center">Horario</th>
                                    <th class="text-center">Huesped</th>
                                    <th class="text-center">Apellidos</th>
                                    <th class="text-center">Villa</th>
                                    <th class="text-center">Hotel</th>
                                    <th class="text-center">Adultos</th>
                                    <th class="text-center">Niños</th>
                                    <th class="text-center">Comentarios</th>
                                    <th class="text-center">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!--Datos cargados desde Ajax-->
                            </tbody>
                        </table>
                    </div>
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