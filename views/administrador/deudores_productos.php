<?php
require '../../config/database.php';
$db = new Database ;
$con = $db->conectar();
$sql = $con->prepare("SELECT
clientes.nom_cli as CLIENTE, clientes.tel_cli as CONTACTO,
productos.nom_p as PRODUCTO, deuda_p.precio_p as 'TOTAL DEUDA',deuda_p.abono_p as ABONOS ,deuda_p.f_iniciop as 'INICIO', deuda_p.f_finalp as 'FINAL'
from
clientes inner join deuda_p on 
clientes.id_cli=deuda_p.id_clientep
inner join productos
on deuda_p.id_p=productos.id_pro where deuda_p.f_finalp  = '0000-00-00';");
$sql->execute();
$resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
?>
  
<?php
session_start();

// Verificar si el usuario no ha iniciado sesión
if (!isset($_SESSION['usuario'])) {
  echo "Inicia sesión primero por favor :D";
  header("refresh:2 ../../index.php");  // Redireccionamos al archivo de inicio de sesión
  exit();
}

$nombreUsuario = $_SESSION['usuario'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../../css/bootstrap.min.css">
    <link rel="stylesheet" href="../../css/index2.css">
    <script src="../../js/bootstrap.bundle.min.js"></script>
</head>
<body>
<!----><style>
  /* Custom CSS for the transparent navigation bar with shadow */
  .navbar {
    background-color: transparent !important;
    box-shadow: 0 10px 6px rgba(0, 0, 0, 0.1);
  }
  /* Adjust the color of the offcanvas menu content */
  .offcanvas-header {
    background-color: #333; /* Change this to your desired color */
  }

  /* Set the text color to black */
  .navbar-dark .navbar-nav .nav-link {
    color: whitesmoke;
    font-size: 20px;
    font-family: 'Times New Roman', Times, serif;
  }
</style>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark" aria-label="Offcanvas navbar large">
    <div class="container-fluid">
      <a class="navbar-brand" href="index.php">WorkStack</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar2" aria-controls="offcanvasNavbar2" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="offcanvas offcanvas-end text-bg-dark" tabindex="-1" id="offcanvasNavbar2" aria-labelledby="offcanvasNavbar2Label">
        <div class="offcanvas-header">
          <h5 class="offcanvas-title" id="offcanvasNavbar2Label"><b>Mis Atajos</b></h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
          <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
            <li class="nav-item">
              <a class="nav-link " aria-current="page" href="calendario.php"><b>Calendario</b></a>
            </li>
            <li class="nav-item">
              <a class="nav-link " aria-current="page" href="empleados.php"><b>Empleados</b></a>
            </li>
            <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <b>Inventario</b>
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="funciones/listarPersonasConBusqueda.php"><b>Inventario Carta</b></a></li>
            <li><a class="dropdown-item" href="funciones/listarPersonasConBusqueda2.php"><b>Inventario Productos</b></a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="funciones/detallar.php">Detalle Carta</a></li>
          </ul>
        </li>
            <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <b>Agenda</b>
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="acreedores.php"><b>Mis Acreedores</b></a></li>
            <li><a class="dropdown-item" href="deudores_cartas.php"><b>Mis Deudores Cartas</b></a></li>
            <li><a class="dropdown-item" href="deudores_productos.php"><b>Mis Deudores Productos</b></a></li>
          </ul>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <b>Registro</b>
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="bitacoras/upd_cartas.php"><b>Actualizaciones En Cartas</b></a></li>
            <li><a class="dropdown-item" href="bitacoras/upd_productos.php"><b>Actualizaciones En Productos</b></a></li>
            <li><a class="dropdown-item" href="bitacoras/upd_dc.php"><b>Reporte Deuda Cartas</b></a></li>
            <li><a class="dropdown-item" href="bitacoras/upd_dp.php"><b>Reporte Deuda Productos</b></a></li>
          </ul>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
          <?php $nombreUsuario = $_SESSION['usuario']; echo "$nombreUsuario";?>
          </a>
          <ul class="dropdown-menu">
          <a href="../../config/cerrarSesion.php" class="dropdown-item">Cerrar Sesion</a>
          </ul>
      </li>
          </ul>
        </div>
      </div>
    </div> 
  </nav>
<!--FIN DEL NAVEGADOR POR AMOR DE DIOS-->
<br>
<div class="container">
<a href="funciones/agregar_dp.php" class="btn btn-primary">Agregar Nuevos Deudores</a>
<a href="funciones/modificar_dp.php" class="btn btn-primary">Editar Mis Deudores</a>
</div>
<br>
<div class="container">
<div class="table-responsive">
<table class="table table-dark table-striped">
  <thead>
    <tr>
      <th scope="col">Nombre</th>
      <th scope="col">Contacto</th>
      <th scope="col">Producto</th>
      <th scope="col">Total Deuda</th>
      <th scope="col">Abonos</th>
      <th scope="col">Inicio Deuda</th>
      <th scope="col">Final Deuda</th>
    </tr>
  </thead>
  <tbody>
  <?php foreach($resultado as $fila): ?>
    <tr>
      <td scope="row" style="color:whitesmoke;"> <?php echo $fila ['CLIENTE'] ?></td>
      <td scope="row" style="color:whitesmoke;"> <?php echo $fila ['CONTACTO'] ?></td>
      <td scope="row" style="color:whitesmoke;"> <?php echo $fila ['PRODUCTO'] ?></td>
      <td scope="row" style="color:whitesmoke;"> <?php echo $fila ['TOTAL DEUDA'] ?></td>
      <td scope="row" style="color:whitesmoke;"> <?php echo $fila ['ABONOS'] ?></td>
      <td scope="row" style="color:whitesmoke;"> <?php echo $fila ['INICIO'] ?></td>
      <td scope="row" style="color:whitesmoke;"> <?php echo $fila ['FINAL'] ?></td>
    </tr>
      <?php endforeach; ?>
  </tbody>
</table>
</div>
</div>
</body>
</html>