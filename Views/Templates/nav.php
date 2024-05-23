<!-- Sidebar -->
<ul class="navbar-nav sidebar sidebar-dark accordion" id="accordionSidebar" style="background:#3A4D39;">

    <!-- Sidebar - Brand -->
    <span class="sidebar-brand d-flex align-items-center justify-content-center">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-calendar-check"></i>
        </div>
        <div class="sidebar-brand-text mx-3"> SafeTable </div>
    </span>

    <hr class="sidebar-divider my-0">

    <!--Hacemos una validacion para que en este modulo sea visible si es que el usuario tiene permisos -->
    <?php if (!empty($_SESSION['permisos'][1]['r'])) { ?>
        <li class="nav-item active">
            <a class="nav-link" href="<?= base_url() ?>/dashboard">
                <i class="fas fa-tachometer-alt"></i>
                <span> Dashboard </span></a>
        </li>
    <?php } ?>

    <!-- Divisor -->
    <hr class="sidebar-divider">

    <!-- Opcion de usuarios -->
    <?php if (!empty($_SESSION['permisos'][2]['r'])) { ?>
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                <i class="fas fa-users"></i>
                <span> Usuarios </span>
            </a>
            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item" href="<?= base_url(); ?>/usuarios"><i class="fas fa-user-plus"></i> Crear usuarios </a>
                    <a class="collapse-item" href="<?= base_url(); ?>/roles"><i class="fas fa-key"></i> Roles y permisos</a>
                </div>
            </div>
        </li>
    <?php } ?>


    <!-- Opcion de restaurantes -->
    <?php if (!empty($_SESSION['permisos'][3]['r']) || !empty($_SESSION['permisos'][4]['r'])) { ?>
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities" aria-expanded="true" aria-controls="collapseUtilities">
                <i class="fas fa-utensils"></i>
                <span>Restaurantes</span>
            </a>
            <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">

                    <?php if (!empty($_SESSION['permisos'][3]['r'])) { ?>
                        <a class="collapse-item" href="<?= base_url(); ?>/restaurantes"><i class="fas fa-calendar-plus"></i> Reservaciones </a>
                    <?php } ?>

                    <?php if (!empty($_SESSION['permisos'][4]['r'])) { ?>
                        <a class="collapse-item" href="<?= base_url(); ?>/addRestaurant"><i class="fas fa-store-alt"></i> Agregar restaurantes</a>
                    <?php } ?>

                </div>
            </div>
        </li>
    <?php } ?>


    <!-- Opcion de destinations -->
    <?php if (!empty($_SESSION['permisos'][5]['r']) || !empty($_SESSION['permisos'][6]['r'])) { ?>
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages" aria-expanded="true" aria-controls="collapsePages">
                <i class="fas fa-utensils"></i>
                <span>Destinations Dining</span>
            </a>
            <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">

                    <?php if (!empty($_SESSION['permisos'][5]['r'])) { ?>
                        <a class="collapse-item" href="<?= base_url(); ?>/destinations"><i class="fas fa-calendar-plus"></i> Reservaciones</a>
                    <?php } ?>

                    <?php if (!empty($_SESSION['permisos'][6]['r'])) { ?>
                    <a class="collapse-item" href="<?= base_url(); ?>/addDestination"><i class="fas fa-store-alt"></i> Agregar destination</a>
                    <?php } ?>

                </div>
            </div>
        </li>
    <?php } ?>

    <!-- Opcion de reportes -->
    <?php if (!empty($_SESSION['permisos'][7]['r'])) { ?>
        <li class="nav-item">
            <a class="nav-link" href="<?= base_url(); ?>/reportes">
                <i class="fas fa-chart-bar"></i>
                <span>Reportes</span></a>
        </li>
    <?php } ?>

    <!-- Opcion de cerrar sesion -->
    <li class="nav-item">
        <a class="nav-link" href="#" data-toggle="modal" data-target="#logoutModal">
            <i class="fas fa-sign-out-alt"></i>
            <span>Logout</span></a>
    </li>

    <!-- Divisor -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Icono para comprimir y descomprimir sidebar -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>
<!-- Fin del sidebar -->

<!-- Contenido del header-->
<div id="content-wrapper" class="d-flex flex-column">
    <div id="content" style="background:#F2F1EB">
        <!-- Listado de opcion del usuario -->
        <nav class="navbar navbar-expand topbar mt-n4 static-top" style="background: #ADBC9F; color:#fff">
            <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mt-4" style="color:#000">
                <i class="fa fa-bars"></i>
            </button>
            <ul class="navbar-nav ml-auto mt-4">
                <li class="nav-item dropdown no-arrow">
                    <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="mr-2 d-none d-lg-inline text-white fw-bolder ">
                            <?= $_SESSION['UserData']['nombres'] . " " . $_SESSION['UserData']['apellidos'] . " (" . $_SESSION['UserData']['nombre'] . ")" ?>
                        </span>
                        <img class="img-profile rounded-circle" src="<?= media(); ?>/images/user.png">
                    </a>
                    <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                        <a class="dropdown-item" href="<?= base_url(); ?>/Usuarios/perfil">
                            <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                            Perfil
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                            <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                            Salir
                        </a>
                    </div>
                </li>
            </ul>
        </nav>
        <!-- End of Topbar -->