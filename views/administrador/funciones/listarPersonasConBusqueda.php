<?php
include_once "base_de_datos.php";

# Por defecto hacemos la consulta de todas las personas
$consulta = "SELECT *
FROM cartas
INNER JOIN car_rar ON cartas.id_car = car_rar.id_carar
LEFT JOIN rareza ON car_rar.id_rar = rareza.id_ra
ORDER BY cartas.tipo_c DESC
LIMIT 0;";

# Vemos si hay búsqueda
$busqueda = null; 
if (isset($_GET["busqueda"])) {
    # Y si hay, búsqueda, entonces cambiamos la consulta
    # Nota: no concatenamos porque queremos prevenir inyecciones SQL
    $busqueda = $_GET["busqueda"];
    $consulta = "SELECT *
    FROM cartas
    INNER JOIN car_rar ON cartas.id_car = car_rar.id_carar
    LEFT JOIN rareza ON car_rar.id_rar = rareza.id_ra
    WHERE cartas.nombre_c LIKE ?;
    ";
}
# Preparar sentencia e indicar que vamos a usar un cursor
$sentencia = $base_de_datos->prepare($consulta, [
    PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL,
]);
# Aquí comprobamos otra vez si hubo búsqueda, ya que tenemos que pasarle argumentos al ejecutar
# Si no hubo búsqueda, entonces traer a todas las personas (mira la consulta de la línea 5)
if ($busqueda === null) {
    # Ejecutar sin parámetros
    $sentencia->execute();
} else {
    # Ah, pero en caso de que sí, le pasamos la búsqueda
    # Un arreglo que nomás llevará la búsqueda con % al inicio y al final
    $parametros = ["%$busqueda%"];
    $sentencia->execute($parametros);
}
# Sin importar si hubo búsqueda o no, se nos habrá devuelto un cursor que iteramos más abajo...

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
<html lang="es" class="h-100">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="../../../css/bootstrap.min.css">
    <link rel="stylesheet" href="../../../css/index2.css">
    <title>Cartas</title>

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
    </head>
    <body>
    
    <header>
  <!-- Fixed navbar -->
    <!-- Fixed navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark" aria-label="Offcanvas navbar large">
    <div class="container-fluid">
      <a class="navbar-brand" href="../index.php">WorkStack</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar2" aria-controls="offcanvasNavbar2" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="offcanvas offcanvas-end text-bg-dark" tabindex="-1" id="offcanvasNavbar2" aria-labelledby="offcanvasNavbar2Label">
        <div class="offcanvas-header">
          <h5 class="offcanvas-title" id="offcanvasNavbar2Label"><b>Mis Atajos</b></h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
          <ul class="navbar-nav justify-content-right flex-grow-1 pe-3">
            <li class="nav-item">
              <a class="nav-link " aria-current="page" href="../calendario.php"><b>Calendario</b></a>
            </li>
            <li class="nav-item">
              <a class="nav-link " aria-current="page" href="../empleados.php"><b>Empleados</b></a>
            </li>
            <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <b>Inventario</b>
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="listarPersonasConBusqueda.php"><b>Inventario Carta</b></a></li>
            <li><a class="dropdown-item" href="listarPersonasConBusqueda2.php"><b>Inventario Productos</b></a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="detallar.php">Detalle Carta</a></li>
          </ul>
        </li>
            <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <b>Agenda</b>
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="../acreedores.php"><b>Mis Acreedores</b></a></li>
            <li><a class="dropdown-item" href="../deudores_cartas.php"><b>Mis Deudores Cartas</b></a></li>
            <li><a class="dropdown-item" href="../deudores_productos.php"><b>Mis Deudores Productos</b></a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="agregar_cliente.php">Agregar Cliente</a></li>
          </ul>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <b>Registro</b>
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="../bitacoras/upd_cartas.php"><b>Actualizaciones En Cartas</b></a></li>
            <li><a class="dropdown-item" href="../bitacoras/upd_productos.php"><b>Actualizaciones En Productos</b></a></li>
            <li><a class="dropdown-item" href="../bitacoras/upd_dc.php"><b>Reporte Deuda Cartas</b></a></li>
            <li><a class="dropdown-item" href="../bitacoras/upd_dp.php"><b>Reporte Deuda Productos</b></a></li>
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

<!-- Begin page content -->

<main role="main" class="flex-shrink-0">

<div class="container">
    <div class="row">
  <div class="col-md-12">
  </div>
</div>

<div class="row">
 <div class="col-md-12">   
 
 
 <br>
<form class="form-inline" action="listarPersonasConBusqueda.php" method="GET">
  <div class="form-group ">
    
  <div class="row">
    <div class="col col-12 col-lg-4 text-center" >
    <input name="busqueda"  type="text" class="form-control "  placeholder="Buscar">
    </div>

    <div class="col col-sm-3 col-lg-2">
    <button type="submit" class="btn btn-warning btn-md">Buscar ahora</button>
    </div>

    <div class="col col-sm-3 col-lg-2">
    <a href="agregar_car.php" class="btn btn-warning mb-2">Agregar Carta</a>
    </div>

    <div class="col col-sm-3 col-lg-2">
    <a href="agregar_rar.php" class="btn btn-warning mb-2">Agregar Rareza</a>
    </div>

    <div class="col col-sm-3 col-lg-2">
    <a href="modificar_car.php" class="btn btn-warning mb-2">Modificar Carta</a>
    </div>

    </div>
  </div>
</form>
<br>
<div class="table-responsive">
<table class="table table-dark">
  <thead >
			<tr>
      <th>Imagen</th>
      <th>Nombre</th>
				<th>Tipo</th>
				<th>Rareza</th>
        <th>Cantidad</th>
				<th>Tcg</th>
				<th>Price</th>
			</tr>
		</thead>
		<tbody>
			
			<?php while ($resultado = $sentencia->fetchObject()) {?>
			<tr>
        
        <td style="color:whitesmoke;background-color: rgba(0, 0, 0, .550);
    box-shadow: 0 4px 5px rgba(10, 2, 1, 55);"><?php echo "<img src='../../../imagenes/productos/$resultado->imagen_c.jpg' style='width:100px'> " ?></td>
        <td style="color:whitesmoke;background-color: rgba(0, 0, 0, .550);
    box-shadow: 0 4px 5px rgba(10, 2, 1, 55);"><?php echo $resultado->nombre_c ?></td>
				<td style="color:whitesmoke;background-color: rgba(0, 0, 0, .550);
    box-shadow: 0 4px 5px rgba(10, 2, 1, 55);"><?php echo $resultado->tipo_c ?></td>
				<td style="color:whitesmoke;background-color: rgba(0, 0, 0, .550);
    box-shadow: 0 4px 5px rgba(10, 2, 1, 55);"><?php echo $resultado->rareza ?></td>
        <td style="color:whitesmoke;background-color: rgba(0, 0, 0, .550);
    box-shadow: 0 4px 5px rgba(10, 2, 1, 55);"><?php echo $resultado->cantidad ?></td>
				<td style="color:whitesmoke;background-color: rgba(0, 0, 0, .550);
    box-shadow: 0 4px 5px rgba(10, 2, 1, 55);"><a href="<?php echo $resultado->p_tcg ?>">Link Directo</a></td>
				<td style="color:whitesmoke;background-color: rgba(0, 0, 0, .550);
    box-shadow: 0 4px 5px rgba(10, 2, 1, 55);"><a href="<?php echo $resultado->p_price ?>">Link Directo</a></td>
			</tr>
			<?php }?>
		</tbody>
	</table>
</div>
  
</div>

 </div>
 </div>
 </main>
    <!-- Aquí va el contenido de tu web -->
 
    <!-- JavaScript -->
    
<script src="../../../js/bootstrap.min.js"></script> 
<script src="../../../js/bootstrap.bundle.min.js"></script>
 </body>
</html>
