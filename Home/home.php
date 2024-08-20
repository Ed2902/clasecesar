
<?php include_once "../login/verificar_sesion.php"; ?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Sistema POO :: Menú de Iconos</title>
  <link rel="shortcut icon" href="../img/logo.png">
  <!-- Última versión compilada y minimizada de CSS de Bootstrap -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" 
  integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">
  <!-- jQuery de Bootstrap -->
  <script src="https://code.jquery.com/jquery-latest.min.js"></script>
  <script src="https://cdn.jsdelivr.net/mark.js/8.6.0/jquery.mark.min.js"></script>
  <!-- Shim de HTML5 y Respond.js para el soporte de IE8 a elementos y consultas de medios de HTML5 -->
  <!-- ADVERTENCIA: Respond.js no funciona si visualiza la página a través de file:// -->
  <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  <!-- Última versión compilada y minimizada de JavaScript de Bootstrap -->
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js" integrity="sha384-aJ21OjlMXNL5UyIl/XNwTMqvzeRMZH2w8c5cRVpzpU8Y5bApTppSuUkhZXN0VxHd" crossorigin="anonymous"></script>
  <!-- Hoja de estilo para la barra lateral de Bootstrap -->
  <link href="../css/bootstrap-sidebar.css" rel="stylesheet">
  <link rel="stylesheet" href="../css/styles.css">

</head>

<body>
  <!-- Contenedor de Bootstrap -->
  <div id="wrapper">
    <!-- Navegación -->
    <nav class="navbar navbar-light navbar-fixed-top" style="background-color: #f65b13d2;">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
            <span class="sr-only">Alternar navegación</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#menu-toggle" id="menu-toggle"> <span class="glyphicon glyphicon-menu-hamburger" aria-hidden="true"></span>  <h1 class="h3 text-right"></h1> 
          </a>
        </div>
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
          <ul class="nav navbar-nav navbar-right">
            <li class="dropdown"> <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-user" aria-hidden="true"></span> <span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="#"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Perfil</a></li>
                <li><a href="#"><span class="glyphicon glyphicon-wrench" aria-hidden="true"></span> Configuración</a></li>
              </ul>
            </li>
            <li><a href="../login/destruir.php"><span class="glyphicon glyphicon-off" aria-hidden="true"></span> Cerrar sesión</a></li>
          </ul>
        </div>
      </div>
    </nav>

   <!--  <div id="bootstrap-sidebar" class="dark-theme icon-menu">
      <ul class="sidebar-nav">
        <li class="active" data-tooltip="Inicio"> <a href="../index.html"><span class="glyphicon glyphicon-home" aria-hidden="true"></span> <span class="menu-text">Inicio</span></a></li>
        <li data-tooltip="Consulta Categoría"> <a href="../dasboard/das_espaciocliente.php"><span class="glyphicon glyphicon-signal" aria-hidden="true"></span> <span class="menu-text">Consulta Categoría</span></a></li> -->
        <!-- <li data-tooltip="Reportes"> <a href="/Tablas/CompraMostrar.php"><span class="glyphicon glyphicon-file" aria-hidden="true"></span> <span class="menu-text">Reportes</span></a></li>
        <li data-tooltip="Catálogo"> <a href="#"><span class="glyphicon glyphicon-list" aria-hidden="true"></span> <span class="menu-text">Catálogo</span></a></li> -->
        <!-- <li data-tooltip="Bandeja de entrada"> <a href="#"><span class="glyphicon glyphicon-inbox" aria-hidden="true"></span> <span class="menu-text">Bandeja de entrada</span></a></li>
        <li data-tooltip="Favoritos"> <a href="#"><span class="glyphicon glyphicon-heart" aria-hidden="true"></span> <span class="menu-text">Favoritos</span></a></li>
        <li data-tooltip="Activos"> <a href="#"><span class="glyphicon glyphicon-folder-open" aria-hidden="true"></span> <span class="menu-text">Activos</span></a></li>
        <li data-tooltip="Tareas"> <a href="#"><span class="glyphicon glyphicon-tasks" aria-hidden="true"></span> <span class="menu-text">Tareas</span></a></li>
        <li data-tooltip="Localización"> <a href="#"><span class="glyphicon glyphicon-globe" aria-hidden="true"></span> <span class="menu-text">Localización</span></a></li>
        <li data-tooltip="Pagos"> <a href="#"><span class="glyphicon glyphicon-credit-card" aria-hidden="true"></span> <span class="menu-text">Pagos</span></a></li>
        <li data-tooltip="Entrenamiento"> <a href="#"><span class="glyphicon glyphicon-education" aria-hidden="true"></span> <span class="menu-text">Entrenamiento</span></a></li>
        <li data-tooltip="Personalización"> <a href="#"><span class="glyphicon glyphicon-scissors" aria-hidden="true"></span> <span class="menu-text">Personalización</span></a></li>
        <li data-tooltip="Usuarios"> <a href="#"><span class="glyphicon glyphicon-user" aria-hidden="true"></span> <span class="menu-text">Usuarios</span></a></li>
        <li data-tooltip="Configuración"> <a href="#"><span class="glyphicon glyphicon-cog" aria-hidden="true"></span> <span class="menu-text">Configuración</span></a></li> -->
      </ul>
    </div>
    <!-- #sidebar-wrapper -->
    <!-- Contenido de la página -->
    <div id="main-page-content">
      <div class="container-fluid">
        <img class="logotipo" src="../img/logo.png" alt="logofastwaysas" width="150" height="100" style="margin-top: 15px; margin-bottom: 15px;">
        
        <div class="row">
          <div class="col-lg-12">
            <div class="panel panel-default">
              <div class="panel-heading">Sistema de Inventario residuos industriales 1.0</div>
              <div class="panel-body" id="feature-content">
                <div class="col-md-3">
                  <div class="panel panel-primary">
                    <div class="panel-body text-center" onclick="location.href='../inventario/Tabla_inventarioconsolidadoy.php'" data-tooltip="Ver Inventario">
                      <span class="glyphicon glyphicon-check icon-big" aria-hidden="true"></span>
                      <h3>Mi Inventario</h3>
                    </div>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="panel panel-primary">
                    <div class="panel-body text-center" onclick="location.href='../salidainventario/tabla_salida.php'" data-tooltip="Crear Orden de Salida">
                      <span class="glyphicon glyphicon-export icon-big" aria-hidden="true"></span>
                      <h3>Orden de Salida</h3>
                    </div>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="panel panel-primary">
                    <div class="panel-body text-center" onclick="location.href='../dasboard/das_espaciocliente.php'" data-tooltip="Ver Ocupación de la Bodega">
                      <span class="glyphicon glyphicon-stats icon-big" aria-hidden="true"></span>
                      <h3>Metas y balance</h3>
                    </div>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="panel panel-primary">
                    <div class="panel-body text-center" onclick="location.href='../dasboard/tablaproducto_proveedor.php'" data-tooltip="Histórico de Movimientos">
                      <span class="glyphicon glyphicon-book icon-big" aria-hidden="true"></span>
                      <h3>Balance Proveedor</h3>
                    </div>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="panel panel-primary">
                    <div class="panel-body text-center" onclick="location.href='../clientes/tabla.php'" data-tooltip="Inventario General">
                      <span class="glyphicon glyphicon-plus icon-big" aria-hidden="true"></span>
                      <h3>Proveedores</h3>
                    </div>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="panel panel-primary">
                    <div class="panel-body text-center" onclick="location.href='../producto/tabla_productos.php'" data-tooltip="Agregar Producto">
                      <span class="glyphicon glyphicon-plus icon-big" aria-hidden="true"></span>
                      <h3>Productos</h3>
                    </div>
                  </div>
                </div>
                 <div class="col-md-3">
                  <div class="panel panel-primary">
                    <div class="panel-body text-center" onclick="location.href='../clientela/tabla.php'" data-tooltip="Editar Inventario">
                      <span class="glyphicon glyphicon-book icon-big" aria-hidden="true"></span>
                      <h3>Clientes</h3>
                    </div>
                  </div>
                </div>
                <!-- <div class="col-md-3">
                  <div class="panel panel-primary">
                    <div class="panel-body text-center" onclick="location.href='../clientes/crearcliente.html'" data-tooltip="Ver clientes">
                      <span class="glyphicon glyphicon-check icon-big" aria-hidden="true"></span>
                      <h3>Mis clientes</h3>
                    </div>
                  </div>
                </div> -->
              </div>
            </div>
          </div>
        </div>
        <div style="clear:both"></div>
      </div>
    </div>
  </div>
  <!-- /#wrapper -->
  <!-- Script para alternar el menú -->
  <script src="../js/sidebar.js"></script>
</body>

</html>
