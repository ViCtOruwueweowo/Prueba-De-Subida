<?php
require '../../config/database.php';
$db = new Database ;
$con = $db->conectar();
$sql = $con->prepare("SELECT clientes.nom_cli as CLIENTE, clientes.tel_cli as TELEFONO,deuda_c.concepto as CONCEPTO, 
wa.nombre_c as CARTA, wa.rareza as RAREZA, deuda_c.abono_c as ABONO, deuda_c.precio_c as TOTAL,
wa.codigo as CODIGO, deuda_c.f_inicioc as FINICIO, deuda_c.f_finalc as FFINAL, deuda_c.notas as NOTAS 
from clientes inner join deuda_c on clientes.id_cli=deuda_c.id_clientec inner join 
(select car_rar.id_cr, car_rar.id_carar, car_rar.id_rar, car_rar.codigo, cartas.id_car, cartas.nombre_c, rareza.id_ra, 
rareza.rareza from rareza inner join car_rar on rareza.id_ra=car_rar.id_rar inner join cartas on car_rar.id_carar=cartas.id_car)
as wa on deuda_c.cr_fk=wa.id_cr where deuda_c.f_finalc = '0000-00-00'  ORDER BY clientes.nom_cli DESC;");
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
<script src="../../js/bootstrap.bundle.min.js"></script>
<link rel="stylesheet" href="../../css/index3.css">
</head>
<body>
<style>
  /* Custom CSS for the transparent navigation bar with shadow */
  .navbar {
    background-color: transparent !important;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
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
    <a class="navbar-brand" href="index.php" style="  color: whitesmoke;
    font-size: 20px;
    font-family: 'Times New Roman', Times, serif;">WorkStack</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar2" aria-controls="offcanvasNavbar2" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
    </button>
    <div class="offcanvas offcanvas-end text-bg-dark" tabindex="-1" id="offcanvasNavbar2" aria-labelledby="offcanvasNavbar2Label">
    <div class="offcanvas-header">
    <h5 class="offcanvas-title" id="offcanvasNavbar2Label">Mis Atajos</h5>
    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
     <div class="offcanvas-body">
        <ul class="navbar-nav justify-content-right flex-grow-1 pe-3">
          <li class="nav-item">
          <a type="button" class="nav-link" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
 Calendario
</a>

          </li>
          <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
        Mi Inventario
          </a>
          <ul class="dropdown-menu">
          <a href="funciones/listarPersonasConBusqueda.php" class="dropdown-item">Cartas</a>
          <a href="funciones/listarPersonasConBusqueda2.php" class="dropdown-item">Productos</a>
          </ul>
      </li>
      <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
        Mi Agenda
          </a>
          <ul class="dropdown-menu">
          <a href="ac.php" class="dropdown-item">Acreedores</a>
          <a href="deuda_c.php" class="dropdown-item">Deudores Cartas</a>
          <a href="deuda_p.php" class="dropdown-item">Deudores Productos</a>
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
    </div>
  </div>
</nav>
<br>
<div class="container">
<div class="table-responsive">
<table class="table table-dark table-striped ">
  <thead>
    <tr>
      <th scope="col">Nombre</th>
      <th scope="col">Contacto</th>
      <th scope="col">Carta</th>
      <th scope="col">Rareza</th>
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
      <td scope="row" style="color:whitesmoke;"> <?php echo $fila ['TELEFONO'] ?></td>
      <td scope="row" style="color:whitesmoke;"> <?php echo $fila ['CARTA'] ?></td>
      <td scope="row" style="color:whitesmoke;"> <?php echo $fila ['RAREZA'] ?></td>
      <td scope="row" style="color:whitesmoke;"> <?php echo $fila ['TOTAL'] ?></td>
      <td scope="row" style="color:whitesmoke;"> <?php echo $fila ['ABONO'] ?></td>
      <td scope="row" style="color:whitesmoke;"> <?php echo $fila ['FINICIO'] ?></td>
      <td scope="row" style="color:whitesmoke;"> <?php echo $fila ['FFINAL'] ?></td>
    </tr>
      <?php endforeach; $db->desconectarDB(); ?>
  </tbody>
</table>
</div>
<?php

$db = new Database();
$con = $db->conectar();
$sql = $con->prepare("SELECT title, descripcion, color, textColor, start, end
FROM calendario
WHERE MONTH(start) = MONTH(CURRENT_DATE) OR 
      (MONTH(start) < MONTH(CURRENT_DATE) AND MONTH(end) >= MONTH(CURRENT_DATE));");
$sql->execute();
$resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
?>
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">Eventos Para El Mes</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <table class="table table-dark table-striped">
  <thead>
    <tr>
      <th scope="col">Evento</th>
      <th scope="col">Notas</th>
      <th scope="col">Inicio</th>
      <th scope="col">Fin</th>
    </tr>
  </thead>
  <tbody>
  <?php foreach($resultado as $fila): ?>
    <tr>
      <td scope="row" style="color:whitesmoke;"> <?php echo $fila ['title'] ?></td>
      <td style="color:whitesmoke;"><?php echo $fila ['descripcion'] ?></td>
      <td style="color:whitesmoke;"><?php echo $fila ['start'] ?></td>
      <td style="color:whitesmoke;"><?php echo $fila ['end'] ?></td>
    </tr>
      <?php endforeach; ?>
  </tbody>
</table>
      </div>
  
    </div>
  </div>
</div>
</div>
</body>
</html>l