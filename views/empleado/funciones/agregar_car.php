 
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
    <link rel="stylesheet" href="../../../css/bootstrap.min.css">
    <link rel="stylesheet" href="../../../css/index3.css">
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
    <a class="navbar-brand" href="../index.php" style="  color: whitesmoke;
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
          <a class="nav-link" aria-current="page" href="../calendario.php">Calendario</a>
          </li>
          <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
        Mi Inventario
          </a>
          <ul class="dropdown-menu">
          <a href="listarPersonasConBusqueda.php" class="dropdown-item">Cartas</a>
          <a href="listarPersonasConBusqueda2.php" class="dropdown-item">Productos</a>
          </ul>
      </li>
      <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
        Mi Agenda
          </a>
          <ul class="dropdown-menu">
          <a href="../ac.php" class="dropdown-item">Acreedores</a>
          <a href="../deuda_c.php" class="dropdown-item">Deudores Cartas</a>
          <a href="../deuda_p.php" class="dropdown-item">Deudores Productos</a>
          </ul>
      </li>
     <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
          <?php $nombreUsuario = $_SESSION['usuario']; echo "$nombreUsuario";?>
          </a>
          <ul class="dropdown-menu">
          <a href="../../../config/cerrarSesion.php" class="dropdown-item">Cerrar Sesion</a>
          </ul>
      </li>
    </div>
  </div>
</nav>

<br>

<!---->
   <div class="container" style="color:whitesmoke;background-color: rgba(0, 0, 0, .550);
    box-shadow: 0 4px 5px rgba(10, 2, 1, 55);text-align:left;color:white">
<h1 style="text-align: center;">Agregar Carta</h1>
<hr>
<form action="guardar_carta.php" method="post" enctype="multipart/form-data">
<div class="row">
    <div class="col-12">
    <label  class="form-label">Ingresar Nombre De La Carta:</label>
    <input type="text" class="form-control col-lg-6" id="nom_p" name="nombre_c" placeholder="Nombre Carta. . ." required>
    </div>
    <div class="col-12">
    <label  class="form-label">Ingresar Nombre De La Imagen:</label>
    <input type="text" class="form-control col-lg-6"  name="imagen_c" placeholder="Nombre Imagen. . ." required>
    </div>
    <div class="col-12">
    <label  class="form-label">Ingresar Tipo De Carta:</label>
    <input type="text"  class="form-control" name="tipo_c" placeholder="Magia, Trampa, Monstruo. . ." required>
    </div>
    <div class="col-12">
    <label  class="form-label">Ingresar Archivo</label><br>
    <input type="file" name="imagen" accept=".jpg" required>
    </div>
    
    <div class="col-12">
        <br>
    <input type="submit" class="btn btn-primary btn-lg" value="Subir imagen">
    </div>
</div>
</form>
   </div>
   <script src="../../../js/bootstrap.bundle.min.js"></script>
</body>
</html>

      
