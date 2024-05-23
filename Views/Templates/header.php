<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Gustavo Carranza">
    <meta name="theme-color" content="#009688">
    <link rel="shortcut icon" href="<?= media(); ?>/images/logo.jpg" type="image/x-icon">
    <title> <?= $data['page_title'] ?> </title>
    <!-- CSS-->
    <link href="<?= media(); ?>/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="<?= media(); ?>/css/sb-admin-2.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= media(); ?>/css/style.css">
    <!-- Estilo de letra-->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <!--CSS API DataTable-->
    <link rel="stylesheet" href="<?= media(); ?>/css/DataTable/bootstrapp.min.css">
    <link rel="stylesheet" href="<?= media(); ?>/css/DataTable/dataTables.bootstrap5.css">
    <link rel="stylesheet" href="<?= media(); ?>/css/DataTable/responsive.bootstrap5.css">
    <!--CSS SweetAlert2-->
    <link rel="stylesheet" href="<?= media(); ?>/css/plugins/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</head>

<body id="page-top">
    <div id="divLoading">
        <div>
            <img src="<?= media(); ?>/images/loading.svg" alt="Loading">
        </div>
    </div>
    <div id="wrapper">

        <?php require_once("nav.php"); ?>