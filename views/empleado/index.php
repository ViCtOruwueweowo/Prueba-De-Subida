<?php
session_start();

// Verificar si el usuario no ha iniciado sesión
if (!isset($_SESSION['usuario'])) {
    echo "Inicia sesión primero por favor :D";
    header("refresh:5 ../../index.php");  // Redireccionamos al archivo de inicio de sesión
    exit();
}

// Verificar si el tipo de usuario no es 2 (Tipo de usuario que puede acceder a esta página, osea empleado)
if ($_SESSION['tipo_usuario'] !== "2") {
    echo "Acceso no autorizado. Por favor, inicia sesión con una cuenta válida.";
    header("refresh:5 ../../index.php");  // Redireccionamos al archivo de inicio de sesión otra vez
    exit();
}

$nombreUsuario = $_SESSION['usuario'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8"> 
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Inicio</title>
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
    <div class="offcanvas-header" >
    <h5 class="offcanvas-title" id="offcanvasNavbar2Label" >Mis Atajos</h5>
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
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" style=" background-color: transparent !important;
">
        Mi Inventario
          </a>
          <ul class="dropdown-menu" >
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

<!--Contenido Del Index Del EMPLEADO--->

<br>

<!--Todo Mi Apartado De Cartas-->
<div class="container">
<?php
require '../../config/config.php';
require '../../config/database.php';
$db = new Database();
$con = $db->conectar();
$sql = $con->prepare("SELECT distinct id_car,
nombre_c, imagen_c
FROM 
cartas inner join car_rar on
cartas.id_car=car_rar.id_carar inner join rareza on
car_rar.id_rar=rareza.id_ra where rareza.id_ra>='4' ;");
$sql->execute();
$resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
?>
<div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 g-4 ">

        <?php foreach($resultado as $row) { ?>
        <div class="col">
          <div class="card shadow-sm " style=" background-color: rgba(0, 0, 0, .550);
    box-shadow: 0 2px 4px rgba(10, 2, 1, 55);">
            <?php
            $id =$row[('imagen_c')];
            $imagen = "../../imagenes/productos/".$id.".jpg";
            if(!file_exists($imagen)){
              $imagen="imagenes/no image.png";
            }
            ?>
            <img src="<?php echo $imagen; ?>" class="img-fluid" alt="...">
            <div class="card-body" >
              <h6 class="card-title text-center" style="color:white; font-size:20px;    font-family: 'Times New Roman', Times, serif;"><?php echo $row ['nombre_c']; ?></h6>
              <div  class="d-flex justify-content-between align-items-center">
              
              </div>
            
              </div>
            
          </div>
        </div>
        <?php 
      
           } $db->desconectarDB();  ?>   
    </div> 
</div>

<br>

<!-- Modal -->
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
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" >
  <div class="modal-dialog">
    <div class="modal-content" >
      <div class="modal-header text-center">
        <h1 class="modal-title fs-5" id="staticBackdropLabel" style="text-align: center;">Eventos Para El Mes</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <table class="table table-dark table-striped" >
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
      <td style="color:whitesmoke;" ><?php echo $fila ['descripcion'] ?></td>
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
</html>