<!DOCTYPE html>
<html lang="es">
  <head>
    <base href="./">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta name="description" content="Inventio Lite - Sistema de Inventario y Ventas">
    <meta name="author" content="Evilnapsis">
    <title>Inventio Lite - Dashboard</title>
    <!-- Vendors styles-->
    <link rel="stylesheet" href="assets/vendor/simplebar/css/simplebar.css">
    <link rel="stylesheet" href="assets/css/vendors/simplebar.css">
    <!-- Main styles for this application-->
    <link href="assets/css/style.css" rel="stylesheet">
    <link href="assets/css/custom-inventio.css" rel="stylesheet">
    <script src="assets/vendor/jquery/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="assets/bootstrap-icons/bootstrap-icons.css">
    <link rel="stylesheet" type="text/css" href="assets/vendor/datatables/datatables.min.css">
    <link rel="stylesheet" type="text/css" href="assets/vendor/select2/select2.min.css">
    <script type="text/javascript" src="assets/vendor/sweetalert/sweetalert2.all.min.js"></script>
  </head>
  <body>
    <?php if(isset($_SESSION["user_id"])):
      $curr_user = UserData::getById($_SESSION["user_id"]);
    ?>
    <div class="sidebar sidebar-dark sidebar-fixed border-end" id="sidebar">
      <div class="sidebar-header border-bottom">
        <div class="sidebar-brand">
          <span class="sidebar-brand-full" style="font-size:20px; font-weight: bold;"><i class="bi bi-box-seam me-2"></i>INVENTIO<span class="text-primary">LITE</span></span>
          <span class="sidebar-brand-narrow">IL</span>
        </div>
        <button class="btn-close d-lg-none" type="button" data-coreui-dismiss="offcanvas" data-coreui-theme="dark" aria-label="Close" onclick="coreui.Sidebar.getInstance(document.querySelector(&quot;#sidebar&quot;)).toggle()"></button>
      </div>
      <ul class="sidebar-nav" data-coreui="navigation" data-simplebar="">
        <li class="nav-item">
          <a class="nav-link" href="<?php echo rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\'); ?>/home">
            <i class="nav-icon bi bi-house"></i> Inicio
          </a>
        </li>

        <li class="nav-title">OPERACIONES</li>
        <li class="nav-item">
          <a class="nav-link" href="<?php echo rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\'); ?>/pos">
            <i class="nav-icon bi bi-calculator"></i> Vender POS
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?php echo rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\'); ?>/sells">
            <i class="nav-icon bi bi-cart"></i> Ventas
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?php echo rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\'); ?>/alerts">
            <i class="nav-icon bi bi-bell"></i> Alertas
          </a>
        </li>

        <li class="nav-group">
          <a class="nav-link nav-group-toggle" href="#">
            <i class="nav-icon bi bi-folder"></i> Catálogos
          </a>
          <ul class="nav-group-items compact">
            <li class="nav-item"><a class="nav-link" href="<?php echo rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\'); ?>/products"><span class="nav-icon"><span class="nav-icon-bullet"></span></span> Productos</a></li>
            <li class="nav-item"><a class="nav-link" href="<?php echo rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\'); ?>/categories"><span class="nav-icon"><span class="nav-icon-bullet"></span></span> Categorías</a></li>
            <li class="nav-item"><a class="nav-link" href="<?php echo rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\'); ?>/clients"><span class="nav-icon"><span class="nav-icon-bullet"></span></span> Clientes</a></li>
            <li class="nav-item"><a class="nav-link" href="<?php echo rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\'); ?>/providers"><span class="nav-icon"><span class="nav-icon-bullet"></span></span> Proveedores</a></li>
          </ul>
        </li>

        <li class="nav-group">
          <a class="nav-link nav-group-toggle" href="#">
            <i class="nav-icon bi bi-boxes"></i> Inventario
          </a>
          <ul class="nav-group-items compact">
            <li class="nav-item"><a class="nav-link" href="<?php echo rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\'); ?>/inventory"><span class="nav-icon"><span class="nav-icon-bullet"></span></span> Inventario</a></li>
            <li class="nav-item"><a class="nav-link" href="<?php echo rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\'); ?>/repos"><span class="nav-icon"><span class="nav-icon-bullet"></span></span> Nueva Compra</a></li>
            <li class="nav-item"><a class="nav-link" href="<?php echo rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\'); ?>/purchases"><span class="nav-icon"><span class="nav-icon-bullet"></span></span> Compras</a></li>
            <li class="nav-item"><a class="nav-link" href="<?php echo rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\'); ?>/box"><span class="nav-icon"><span class="nav-icon-bullet"></span></span> Caja</a></li>
          </ul>
        </li>

        <li class="nav-group">
          <a class="nav-link nav-group-toggle" href="#">
            <i class="nav-icon bi bi-bar-chart"></i> Reportes
          </a>
          <ul class="nav-group-items compact">
            <li class="nav-item"><a class="nav-link" href="<?php echo rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\'); ?>/reports/movements"><span class="nav-icon"><span class="nav-icon-bullet"></span></span> Movimientos</a></li>
            <li class="nav-item"><a class="nav-link" href="<?php echo rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\'); ?>/reports/sales"><span class="nav-icon"><span class="nav-icon-bullet"></span></span> Reporte de Ventas</a></li>
          </ul>
        </li>

        <li class="nav-group">
          <a class="nav-link nav-group-toggle" href="#">
            <i class="nav-icon bi bi-gear"></i> Administración
          </a>
          <ul class="nav-group-items compact">
            <li class="nav-item"><a class="nav-link" href="<?php echo rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\'); ?>/users"><span class="nav-icon"><span class="nav-icon-bullet"></span></span> Usuarios</a></li>
            <li class="nav-item"><a class="nav-link" href="<?php echo rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\'); ?>/settings"><span class="nav-icon"><span class="nav-icon-bullet"></span></span> Ajustes</a></li>
          </ul>
        </li>
      </ul>
      <div class="sidebar-footer border-top d-none d-md-flex">
        <button class="sidebar-toggler" type="button" data-coreui-toggle="unfoldable"></button>
      </div>
    </div>
    <div class="wrapper d-flex flex-column min-vh-100">
      <header class="header header-sticky p-0 mb-4 shadow-sm">
        <div class="container-fluid border-bottom px-4">
          <button class="header-toggler" type="button" onclick="coreui.Sidebar.getInstance(document.querySelector('#sidebar')).toggle()" style="margin-inline-start: -14px;">
            <i class="bi bi-list fs-3"></i>
          </button>
          
          <ul class="header-nav ms-auto">
          </ul>
          <ul class="header-nav">
            <li class="nav-item py-1">
              <div class="vr h-100 mx-2 text-body text-opacity-75"></div>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link py-0 pe-0" data-coreui-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                <div class="avatar avatar-md bg-primary text-white d-flex align-items-center justify-content-center rounded-circle fw-bold">
                  <?php echo substr($curr_user->name ?? '',0,1).substr($curr_user->lastname ?? '',0,1); ?>
                </div>
              </a>
              <div class="dropdown-menu dropdown-menu-end pt-0 shadow border-0">
                <div class="dropdown-header bg-light text-body-secondary fw-semibold rounded-top mb-2">Mi Cuenta</div>
                <div class="px-3 py-2">
                  <div class="fw-bold"><?php echo $curr_user->name." ".$curr_user->lastname; ?></div>
                  <div class="small text-muted"><?php echo $curr_user->is_admin ? "Administrador" : "Usuario"; ?></div>
                </div>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="<?php echo rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\'); ?>/settings">
                  <i class="bi bi-gear me-2"></i> Ajustes
                </a>
                <a class="dropdown-item" href="./logout.php">
                  <i class="bi bi-box-arrow-right me-2 text-danger"></i> Cerrar sesión
                </a>
              </div>
            </li>
          </ul>
        </div>
      </header>
      <div class="body flex-grow-1">
        <div class="container-fluid px-4">
          <?php View::load("index"); ?>
        </div>
      </div>
      <footer class="footer px-4 border-top-0 bg-transparent text-muted small">
        <div>Inventio Lite © 2026. Desarrollado por <a href="https://evilnapsis.com/" target="_blank" class="text-decoration-none">Evilnapsis</a></div>
        <div class="ms-auto">v4.2</div>
      </footer>
    </div>
    <?php else:?>
    <div class="bg-light min-vh-100 d-flex flex-row align-items-center">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-md-5">
            <div class="card shadow-lg border-0">
              <div class="card-body p-5">
                <div class="text-center mb-4">
                  <div class="display-1 text-primary mb-2"><i class="bi bi-box-seam-fill"></i></div>
                  <h1 class="h3 fw-bold">Inventio Lite</h1>
                  <p class="text-muted">Sistema de Inventario y Ventas</p>
                </div>
                <form method="post" action="./?action=processlogin">
                  <div class="mb-3">
                    <label class="form-label fw-bold">Usuario</label>
                    <div class="input-group">
                      <span class="input-group-text bg-white border-end-0"><i class="bi bi-person text-muted"></i></span>
                      <input class="form-control border-start-0" name="username" required type="text" placeholder="Tu usuario o correo">
                    </div>
                  </div>
                  <div class="mb-4">
                    <label class="form-label fw-bold">Contraseña</label>
                    <div class="input-group">
                      <span class="input-group-text bg-white border-end-0"><i class="bi bi-lock text-muted"></i></span>
                      <input class="form-control border-start-0" name="password" required type="password" placeholder="Tu contraseña">
                    </div>
                  </div>
                  <div class="d-grid mb-3">
                    <button class="btn btn-primary btn-lg shadow-sm fw-bold" type="submit">Acceder</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php endif; ?>
    <!-- CoreUI and necessary plugins-->
    <script src="assets/vendor/@coreui/coreui/js/coreui.bundle.min.js"></script>
    <script src="assets/vendor/simplebar/js/simplebar.min.js"></script>
    <script src="assets/vendor/chart.js/js/chart.min.js"></script>
    <script src="assets/vendor/datatables/datatables.min.js"></script>
    <script src="assets/vendor/select2/select2.full.min.js"></script>
    <script type="text/javascript">
      $(document).ready(function(){
        const urlParams = new URLSearchParams(window.location.search);
        const view = urlParams.get('view');

        if (view !== 'onesell' && view !== 'onere' && view !== 'sellpos' && view !== 'repos') {
          $(".table:has(thead)").not(".no-datatable").DataTable({
            "responsive": true,
            "language": {
              "url": "./vendors/datatables/esmx.json"
            }
          });
        }

        // Initialize Select2 globally
        if ($.fn.select2) {
          $('.select2').each(function() {
            $(this).select2({
              width: '100%',
              dropdownParent: $(this).parent()
            });
          });
        }

        // SweetAlert from Session
        <?php if(isset($_SESSION["success"])): ?>
          Swal.fire({
            title: '¡Éxito!',
            text: '<?php echo $_SESSION["success"]; ?>',
            icon: 'success',
            confirmButtonText: 'Aceptar',
            timer: 4000,
            timerProgressBar: true,
            confirmButtonColor: '#5856d6'
          });
          <?php unset($_SESSION["success"]); ?>
        <?php endif; ?>

        <?php if(isset($_SESSION["updated"])): ?>
          Swal.fire({
            title: '¡Éxito!',
            text: '<?php echo $_SESSION["updated"]; ?>',
            icon: 'success',
            confirmButtonText: 'Aceptar',
            timer: 4000,
            timerProgressBar: true,
            confirmButtonColor: '#5856d6'
          });
          <?php unset($_SESSION["updated"]); ?>
        <?php endif; ?>

        <?php if(isset($_SESSION["deleted"])): ?>
          Swal.fire({
            title: '¡Éxito!',
            text: '<?php echo $_SESSION["deleted"]; ?>',
            icon: 'success',
            confirmButtonText: 'Aceptar',
            timer: 4000,
            timerProgressBar: true,
            confirmButtonColor: '#5856d6'
          });
          <?php unset($_SESSION["deleted"]); ?>
        <?php endif; ?>

        <?php if(isset($_SESSION["error"])): ?>
          Swal.fire({
            title: '¡Error!',
            text: '<?php echo $_SESSION["error"]; ?>',
            icon: 'error',
            confirmButtonText: 'Aceptar',
            timer: 4000,
            timerProgressBar: true,
            confirmButtonColor: '#d33'
          });
          <?php unset($_SESSION["error"]); ?>
        <?php endif; ?>
      });
    </script>
  </body>
</html>