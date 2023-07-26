<?php
session_start();

// Verificar si el usuario no ha iniciado sesión
if (!isset($_SESSION['usuario'])) {
    echo "Inicia sesión primero por favor :D";
    header("refresh:5 ../../index.php");  // Redireccionamos al archivo de inicio de sesión
    exit();
}

// Verificar si el tipo de usuario no es 1 (Tipo de usuario que puede acceder a esta página, osea el admin)
if ($_SESSION['tipo_usuario'] !== "1") { 
      echo "Acceso no autorizado. Por favor, inicia sesión con una cuenta válida.";
    header("refresh:5 ../../index.php");  // Redireccionamos al archivo de inicio de sesión
    exit();
}

$nombreUsuario = $_SESSION['usuario'];
?>

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


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>
    <link rel="stylesheet" href="../../css/bootstrap.min.css">
    <link rel="stylesheet" href="../../css/index2.css">
</head>
<body >
<style>
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
    <div class="container-fluid" >
      <a class="navbar-brand" href="index.php">WorkStack</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar2" aria-controls="offcanvasNavbar2" aria-label="Toggle navigation" >
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="offcanvas offcanvas-end text-bg-dark" tabindex="-1" id="offcanvasNavbar2" aria-labelledby="offcanvasNavbar2Label" >
        <div class="offcanvas-header">
          <h5 class="offcanvas-title" id="offcanvasNavbar2Label"><b>Mis Atajos</b></h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body"  >
          <ul class="navbar-nav justify-content-right flex-grow-1 pe-3">
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
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="funciones/agregar_cliente.php">Agregar Cliente</a></li>
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
        <li class="nav-item dropdown responsive">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
          <?php $nombreUsuario = $_SESSION['usuario']; echo "$nombreUsuario";?>
          </a>
          <ul class="dropdown-menu dropdown-responsive">
          <a href="../../config/cerrarSesion.php" class="dropdown-item dropdown-responsive">Cerrar Sesion</a>
          </ul>
      </li>
          </ul>
        </div>
      </div>
    </div>
  </nav>
<!--cabezera #212529-->

<br>
<!---->
<div class="container" style="background-color:transparent;border-radius:10px">
<main>
      <div class="container">
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
              <h6 class="card-title text-center"  style="color:white; font-size:19px;    font-family: 'Times New Roman', Times, serif;"><?php echo $row ['nombre_c']; ?></h6>
              <div  class="d-flex justify-content-between align-items-center">
              
       <!--       <a href="details.php?id_car=<?php echo $row ['id_car']; ?>&token=<?php echo 
             hash_hmac('sha1',$row['id_car'],KEY_TOKEN);?>" class="btn 
             btn-info">Detalles</a>-->
            
              </div>
            
              </div>
            
          </div>
        </div>
        <?php } ?>   
    </div>     
    </div>
    <hr>
    <h4 class="text-center"  style="color: white;font-size:25px;font-family:'Times New Roman', Times, serif" >Todos Mis Atajos</h4>
    <hr style="border:solid;border-color:white">
   <div class="row">
    <div class="col-12 col-sm-12 col-lg-6">
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js'></script>
    <script>

      document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
         
          locale:"es",
          headerToolbar:{
         
           
         
          }
        });
        calendar.render();
      });

      
    </script>
     <div id='calendar' style="background-color: rgba(0, 0, 0, 0.500);color:white"></div>
    </div>
    <div class="col-6">
    <div class="d-grid gap-2-center">
      <br>
      <br>
      <br>
      <br>
    <a class="btn btn-warning" type="button" href="funciones/listarPersonasConBusqueda.php">Mi Inventario</a>
    <br>
    <a class="btn btn-warning" type="button" href="acreedores.php">Mi Agenda</a>
    <br>
    <a class="btn btn-warning" type="button" href="empleados.php">Mis Empleados</a>
    <br>
    </div>
    </div>
   </div>
    </div>  
</main>

</div>
<br>
<footer class="footer mt-auto py-3 bg-dark">
<div class="container text-center">
<span class="text-center" style="color:white">Aplicacion Desarrollada Unicamente Para Fines De Venta Y Distribucion De Menores.</span>
</div>
</footer>
<script src="../../js/bootstrap.bundle.min.js"></script>
</body>
</html>
