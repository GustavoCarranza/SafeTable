<?php
headerAdmin($data);
getModal("modalReportes", $data);
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
                <button type="button" class="btn btn-block" style="background: #ADBC9F; color:#fff;" id="btnModalReportes"><i class="fas fa-file-alt"></i> Reporte Restaurantes </button>
            <?php } ?>
        </div>
        <div class="col-12 col-sm-auto mb-2">
            <?php if ($_SESSION['permisosModulo']['w']) { ?>
                <button type="button" class="btn btn-block" style="background: #ADBC9F; color:#fff;" id="ModalDestinations"><i class="fas fa-file-alt"></i> Reporte Destinations </button>
            <?php } ?>
        </div>
    </div>
</div>
<!--Fin-->

<!--Contenido de los graficos-->
<div class="container-fluid">
    <div class="row">
        <div class="col-md-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-success"> Restaurante con mayor reservas </h6>
                </div>
                <div class="card-body">
                    <canvas id="RestauranteMayor" width="400" height="400"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-success"> Top 3 Restaurantes mas populares </h6>
                </div>
                <div class="card-body">
                    <canvas id="RestaurantePopular" width="400" height="400"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-success">Mes con mayor reservas</h6>
                </div>
                <div class="card-body">
                    <canvas id="MesMayor" width="400" height="100"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>
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