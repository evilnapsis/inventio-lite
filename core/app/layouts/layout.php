<!DOCTYPE html>
<!--
* CoreUI - Free Bootstrap Admin Template
* @version v4.2.1
* @link https://coreui.io
* Copyright (c) 2022 creativeLabs Łukasz Holeczek
* Licensed under MIT (https://coreui.io/license)
-->
<!-- Breadcrumb-->
<html lang="en">
  <head>
    <base href="./">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta name="description" content="CoreUI - Open Source Bootstrap Admin Template">
    <meta name="author" content="Łukasz Holeczek">
    <meta name="keyword" content="Bootstrap,Admin,Template,Open,Source,jQuery,CSS,HTML,RWD,Dashboard">
    <title>Inventio Lite</title>
    <link rel="apple-touch-icon" sizes="57x57" href="assets/favicon/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="assets/favicon/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="assets/favicon/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="assets/favicon/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="assets/favicon/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="assets/favicon/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="assets/favicon/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="assets/favicon/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="assets/favicon/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192" href="assets/favicon/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="assets/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="assets/favicon/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="assets/favicon/favicon-16x16.png">
    <link rel="manifest" href="assets/favicon/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="assets/favicon/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">
    <!-- Vendors styles-->
    <link rel="stylesheet" href="vendors/simplebar/css/simplebar.css">
    <link rel="stylesheet" href="assets/css/vendors/simplebar.css">
    <!-- Main styles for this application-->
    <link href="assets/css/style.css" rel="stylesheet">
    <!-- We use those styles to show code examples, you should remove them in your application.-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/prismjs@1.23.0/themes/prism.css">
    <link rel="stylesheet" type="text/css" href="assets/bootstrap-icons/bootstrap-icons.css">
    <script type="text/javascript" src="assets/jquery/jquery.min.js"></script>
    <link href="vendors/@coreui/chartjs/css/coreui-chartjs.css" rel="stylesheet">
  </head>
  <body>
<?php if(!isset($_SESSION["user_id"])):?>
<div class="bg-light min-vh-100 d-flex flex-row align-items-center">
<div class="container">
<div class="row justify-content-center">
<div class="col-lg-6">
<div class="card-group d-block d-md-flex row">
<div class="card col-md-12 p-4 mb-0">
<div class="card-body">
<h1>INVENTIO <b>LITE</b></h1>
<br>
<p class="text-medium-emphasis">Iniciar Sesion al Sistema</p>
<form method="post" action="./?action=processlogin">
<div class="input-group mb-3"><span class="input-group-text">
<svg class="icon">
<use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-user"></use>
</svg></span>
<input class="form-control" type="text" name="username" placeholder="Email">
</div>
<div class="input-group mb-4"><span class="input-group-text">
<svg class="icon">
<use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-lock-locked"></use>
</svg></span>
<input class="form-control" name="password" type="password" placeholder="Password">
</div>
<div class="row">
<div class="col-6">
<button class="btn btn-primary px-4" type="submit">Iniciar Sesion</button>
</div>
<!--
<div class="col-6 text-end">
<button class="btn btn-link px-0" type="button">Forgot password?</button>
</div>
-->
</div>
</form>
<br><br><br>

</div>
</div>

</div>
</div>
</div>
</div>
</div>
<?php else:?>
    <div class="sidebar sidebar-dark sidebar-fixed" id="sidebar">

<div class="sidebar-brand d-none d-md-flex">
<div class="sidebar-brand-full" width="118" height="46" alt="CoreUI Logo">

<h4><a href="./" style="color: white;">INVENTIO<b>LITE</b></a></h4>

</div>
<div class="sidebar-brand-narrow" width="46" height="46" alt="CoreUI Logo">
<h4><a href="./" style="color: white;">I<b>L</b></a></h4>

</div>
</div>









      <ul class="sidebar-nav" data-coreui="navigation" data-simplebar="">
        <li class="nav-item"><a class="nav-link" href="./">
            <svg class="nav-icon">
              <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-home"></use>
            </svg> INICIO</a></li>
        <li class="nav-item"><a class="nav-link" href="./?view=sell">
            <svg class="nav-icon">
              <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-money"></use>
            </svg> VENDER</a>
        </li>
        <li class="nav-item"><a class="nav-link" href="./?view=sells">
            <svg class="nav-icon">
              <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-cart"></use>
            </svg> VENTAS</a>
        </li>
        <li class="nav-item"><a class="nav-link" href="./?view=box">
            <svg class="nav-icon">
              <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-3d"></use>
            </svg> CAJA</a>
        </li>
        <li class="nav-group"><a class="nav-link nav-group-toggle" href="#">
            <svg class="nav-icon">
              <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-folder-open"></use>
            </svg> CATALOGOS</a>
          <ul class="nav-group-items">
            <li class="nav-item"><a class="nav-link" href="./?view=products"><span class="nav-icon"></span> PRODUCTOS</a></li>
            <li class="nav-item"><a class="nav-link" href="./?view=categories"><span class="nav-icon"></span> CATEGORIAS  </a></li>
            <li class="nav-item"><a class="nav-link" href="./?view=clients"><span class="nav-icon"></span> CLIENTES  </a></li>
            <li class="nav-item"><a class="nav-link" href="./?view=providers"><span class="nav-icon"></span> PROVEEDORES  </a></li>
          </ul>
        </li>
        <li class="nav-group"><a class="nav-link nav-group-toggle" href="#">
            <svg class="nav-icon">
              <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-storage"></use>
            </svg> INVENTARIO</a>
          <ul class="nav-group-items">
            <li class="nav-item"><a class="nav-link" href="./?view=inventary"><span class="nav-icon"></span> INVENTARIO</a></li>
            <li class="nav-item"><a class="nav-link" href="./?view=re"><span class="nav-icon"></span> HACER COMPRA  </a></li>
            <li class="nav-item"><a class="nav-link" href="./?view=res"><span class="nav-icon"></span> COMPRAS  </a></li>
          </ul>
        </li>
        <li class="nav-group"><a class="nav-link nav-group-toggle" href="#">
            <svg class="nav-icon">
              <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-chart"></use>
            </svg> REPORTES</a>
          <ul class="nav-group-items">
            <li class="nav-item"><a class="nav-link" href="./?view=reports"><span class="nav-icon"></span> MOVIMIENTOS</a></li>
            <li class="nav-item"><a class="nav-link" href="./?view=sellreports"><span class="nav-icon"></span> REPORTE DE VENTAS  </a></li>
          </ul>
        </li>
<!--
        <li class="nav-title">Components</li>
-->
        <li class="nav-group"><a class="nav-link nav-group-toggle" href="#">
            <svg class="nav-icon">
              <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-settings"></use>
            </svg> ADMINISTRACION</a>
          <ul class="nav-group-items">
            <li class="nav-item"><a class="nav-link" href="./?view=users&opt=all"><span class="nav-icon"></span> USUARIOS</a></li>
            <li class="nav-item"><a class="nav-link" href="./?view=settings&opt=all"><span class="nav-icon"></span> AJUSTES</a></li>
          </ul>
        </li>
        <!--
        <li class="nav-item mt-auto"><a class="nav-link" href="https://coreui.io/docs/templates/installation/" target="_blank">
            <svg class="nav-icon">
              <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-description"></use>
            </svg> Docs</a></li>
        <li class="nav-item"><a class="nav-link nav-link-danger" href="https://coreui.io/pro/" target="_top">
            <svg class="nav-icon">
              <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-layers"></use>
            </svg> Try CoreUI
            <div class="fw-semibold">PRO</div>
          </a></li>
        -->
      </ul>
      <button class="sidebar-toggler" type="button" data-coreui-toggle="unfoldable"></button>
    </div>
    <div class="wrapper d-flex flex-column min-vh-100 bg-light">
      <header class="header header-sticky mb-4">
        <div class="container-fluid">
          <button class="header-toggler px-md-0 me-md-3" type="button" onclick="coreui.Sidebar.getInstance(document.querySelector('#sidebar')).toggle()">
            <svg class="icon icon-lg">
              <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-menu"></use>
            </svg>
          </button><a class="header-brand d-md-none" href="#">
            <svg width="118" height="46" alt="CoreUI Logo">
              <use xlink:href="assets/brand/coreui.svg#full"></use>
            </svg></a>
            <!--
          <ul class="header-nav d-none d-md-flex">
            <li class="nav-item"><a class="nav-link" href="#">Dashboard</a></li>
            <li class="nav-item"><a class="nav-link" href="#">Users</a></li>
            <li class="nav-item"><a class="nav-link" href="#">Settings</a></li>
          </ul>
        -->
          <ul class="header-nav ms-auto">
            <!--
            <li class="nav-item"><a class="nav-link" href="#">
                <svg class="icon icon-lg">
                  <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-bell"></use>
                </svg></a></li>
              -->
          </ul>
          <ul class="header-nav ms-3">
            <li class="nav-item dropdown"><a class="nav-link py-0" data-coreui-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                <div class="avatar avatar-md"><img class="avatar-img" src="assets/img/user.png" alt="user@email.com"></div>
              </a>
              <div class="dropdown-menu dropdown-menu-end pt-0">
                <div class="dropdown-header bg-light py-2">
                  <div class="fw-semibold">Account</div>
                </div><a class="dropdown-item" href="#">
                  <svg class="icon me-2">
                    <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-settings"></use>
                  </svg> Settings</a>
                <div class="dropdown-divider"></div><a class="dropdown-item" href="./logout.php">
                  <svg class="icon me-2">
                    <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-account-logout"></use>
                  </svg> Logout </a>
              </div>
            </li>
          </ul>
        </div>
        <div class="header-divider"></div>
        <div class="container-fluid">
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb my-0 ms-2">
              <li class="breadcrumb-item">
                <!-- if breadcrumb is single--><span>Home</span>
              </li>
              <li class="breadcrumb-item active"><span>Dashboard</span></li>
            </ol>
          </nav>
        </div>
      </header>
      <div class="body flex-grow-1 px-3">
        <div class="container-fluid">

          <?php View::load("index");?>

        </div>
      </div>
      <footer class="footer">
        <div><a href="https://evilnapsis.com/">Evilnapsis </a> © 2026.</div>
        <div class="ms-auto">Version <b>4.2</b></div> 
      </footer>
    </div>
    <?php endif; ?>
    <!-- CoreUI and necessary plugins-->
    <script src="vendors/@coreui/coreui/js/coreui.bundle.min.js"></script>
    <script src="vendors/simplebar/js/simplebar.min.js"></script>
    <!-- Plugins and scripts required by this view-->
    <script src="vendors/chart.js/js/chart.min.js"></script>
    <script src="vendors/@coreui/chartjs/js/coreui-chartjs.js"></script>
    <script src="vendors/@coreui/utils/js/coreui-utils.js"></script>
    <script src="assets/js/main.js"></script>
    <script>
    </script>

  </body>
</html>