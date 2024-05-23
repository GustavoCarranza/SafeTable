<?php headerAdmin($data); ?>

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

<!--Diseño del dashboard-->
<div class="container-fluid">

    <!--Contadores-->
    <div class="row">
        <!-- Card de usuarios -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card shadow h-100 py-2" style="border-left: 5px solid #ADBC9F">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-uppercase mb-1">
                                Usuarios</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800" id="usuarios">
                                
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card shadow h-100 py-2" style="border-left: 5px solid #436850">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-uppercase mb-1">
                                Reservaciones (Restaurantes) </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800" id="reservasR">
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-table fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card shadow h-100 py-2" style="border-left: 5px solid #ADBC9F">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-uppercase mb-1">
                                Reservaciones (Destinations) </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800" id="reservasD">
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-table fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pending Requests Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card shadow h-100 py-2" style="border-left: 5px solid #436850">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-uppercase mb-1">
                                # Comensales
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800" id="comensales">
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-friends fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--Fin-->

    <!--Graficos-->
    <div class="row">
        <div class="col-md-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-success"> Destination con mayor reservas </h6>
                </div>
                <div class="card-body">
                    <canvas id="DestinationMayor" width="400" height="400"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-success"> Cantidad de comensales por Destination</h6>
                </div>
                <div class="card-body">
                    <canvas id="ComensalesD" width="400" height="400"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-success"> Cantidad de comensales por Restaurante </h6>
                </div>
                <div class="card-body">
                    <canvas id="ComensalesR" width="400" height="100"></canvas>
                </div>
            </div>
        </div>
    </div>
    <!--Fin-->
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