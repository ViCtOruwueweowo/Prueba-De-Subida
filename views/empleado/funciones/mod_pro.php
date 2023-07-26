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
    <script src="../../../js/bootstrap.bundle.min.js"></script>
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
          <a type="button" class="nav-link" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
 Calendario
</a>          </li>
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

<?php
include 'date.php';
$conexion = new database();
$conexion->conectarDB();

// Obtener la lista de productos para el filtro
$consulta = "SELECT * FROM productos";
$tabla = $conexion->seleccionar($consulta);

// Filtrar el producto seleccionado
if (isset($_POST['depa'])) {
    $depa = $_POST['depa'];
    $consultaf = "SELECT * FROM productos WHERE id_pro ='$depa'";
    $tablaf = $conexion->seleccionar($consultaf);
}
?>

<div class="container" style="color: whitesmoke; background-color: rgba(0, 0, 0, .550);
    box-shadow: 0 4px 5px rgba(10, 2, 1, 55); text-align: left; color: white">

    <form class="row g-3" method="POST">
        <div class="col-auto">
            <h2 class="form-label">Selecciona el producto a modificar</h2>
        </div>
        <div class="col-auto">
            <select class="form-select" name="depa" aria-label="Default select example">
                <?php
                foreach ($tabla as $registro) {
                    $selected = (isset($_POST['depa']) && $_POST['depa'] == $registro->id_pro) ? 'selected' : '';
                    echo "<option value='" . $registro->id_pro . "' $selected>" . $registro->nom_p . "</option>";
                }
                ?>
            </select>
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-primary mb-3">Filtrar</button>
        </div>

        <!-- Mostrar los campos dentro del formulario principal -->
        <?php
        if (isset($tablaf)) {
            foreach ($tablaf as $registro) {
                echo "<input type='hidden' name='id_pro' value='$registro->id_pro'> ";
                echo "<label for='existencias'>Existencias</label>";
                echo "<input class='form-control' name='existencias' value='$registro->existencias' required> ";
            }
        }
        ?>

        <!-- Botón para enviar los datos al archivo car_rar.php -->
        <div class="col-12">
            <button type="submit" formaction="mod_pro2.php" class="btn btn-primary">Enviar Datos</button>
        </div>
    </form>

</div>

<!-- Agregar estilos y scripts para el modal -->
<link rel="stylesheet" href="ruta/estilos/bootstrap.min.css">
<script src="ruta/scripts/bootstrap.min.js"></script>

<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
     aria-labelledby="staticBackdropLabel" aria-hidden="true">
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
                    <?php
                    $consulta_eventos = "SELECT * FROM calendario";
                    $eventos = $conexion->seleccionar($consulta_eventos);
                    foreach ($eventos as $fila):
                        ?>
                        <tr>
                            <td scope="row" style="color: whitesmoke;"><?php echo $fila['title'] ?></td>
                            <td style="color: whitesmoke;"><?php echo $fila['descripcion'] ?></td>
                            <td style="color: whitesmoke;"><?php echo $fila['start'] ?></td>
    <td style="color:whitesmoke;"><?php echo $fila['end'] ?></td>
  </tr>
      <?php endforeach; ?>
  </tbody>
</table>
      </div>
  
    </div>
  </div>
</div>
</body>
</html>