<?php


 
//ANTES DE QUE ALGUIEN DIGA ALGO MAMAGUEVOS
//esta página está hecha con el fin de hacer lo del filtro de empleados, aun no me sale y prefiero regarla aquí que en el bueno xd la única forma de acceder aquí por localhost nomás es poniento la ruta, de ahí en más, esta página no se puede acceder por otros medios, está conectada a la bd sí pero no envía, no hace, no nada



require '../../config/database.php';
$db = new Database ;
$con = $db->conectar();
$sql = $con->prepare("SELECT nombre_user, f_nacimiento,apellidos_user, tel_user,  direccion_user FROM usuarios where tipo_usuario='2' and estado='1'");

$sql0 = $con->prepare("SELECT nombre_user, f_nacimiento,apellidos_user, tel_user,  direccion_user FROM usuarios where tipo_usuario='2' and estado='0'");

$sql->execute();
$sql0->execute();
$resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
$resultado0 = $sql0->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en"> 
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Empleados copia</title>
    <link rel="stylesheet" href="../../css/bootstrap.min.css">
    <link rel="stylesheet" href="../../css/index2.css">

</head>
<body>
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
            <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <b>Inventario</b>
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="funciones/listarPersonasConBusqueda.php"><b>Inventario Carta</b></a></li>
            <li><a class="dropdown-item" href="funciones/listarPersonasConBusqueda2.php"><b>Inventario Productos</b></a></li>
          </ul>
        </li>
         
            <li class="nav-item">
              <a class="nav-link " aria-current="page" href="empleados.php"><b>Empleados</b></a>
            </li>
            <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <b>Agenda</b>
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="acreedores.php"><b>Mis Acreedores</b></a></li>
            <li><a class="dropdown-item" href="deudores.php"><b>Mis Deudores</b></a></li>
          </ul>
        </li>
          </ul>
          <form class="d-flex mt-3 mt-lg-0" role="search">
            <a href="../../index.php" class="btn btn-outline-success">Cerrar Sesion</a>
          </form>
        </div>
      </div>
    </div>
  </nav>

<br>
<br>
<div class="container"> 

<form class="form-inline" method="POST">
  <div class="row">
    <div class="col col-lg-12">
    <a href="funciones/agregarempleado.pphFAKE" type="button" class="btn btn-primary btn-lg">Agregar Nuevo Empleado</a>  
    <a href="funciones/editarempleado.phpFAKE" type="button" class="btn btn-info btn-lg">Editar Empleado Existente</a>
    <button href="" name="filtrar" type="submit" class="btn btn-outline-info btn-lg">Mostrar empleados inactivos</button>
    </form>
<br>
<br>
    </div>
    <div class="col col-md-12 col-lg-12">
<!--Tabla-->
<div class="container">
<table class="table table-dark table-striped">
  <thead >
    <tr>

      <th scope="col">Nombre</th>
      <th scope="col">Apellidos</th>
      <th scope="col">Fecha de nacimiento</th>
      <th scope="col">Telefono</th>
      <th scope="col">Direccion</th>

    </tr>
  </thead> 
  <tbody>
    <?php foreach($resultado as $fila): ?>
    <tr>
      <td scope="row" style="color:whitesmoke;"> <?php echo $fila ['nombre_user'] ?></td>
      <td style="color:whitesmoke;"><?php echo $fila ['apellidos_user'] ?></td>
      <td style="color:whitesmoke;"><?php echo $fila ['f_nacimiento'] ?></td>
      <td style="color:whitesmoke;"><?php echo $fila ['tel_user'] ?></td>
      <td style="color:whitesmoke;"><?php echo $fila ['direccion_user'] ?></td>
</td>
    </tr>
      <?php endforeach; ?>
      
  </tbody>
  
</table>
    </div>
  </div>
</div>



  <script src="../../js/bootstrap.min.js"></script>
  <script src="../../js/bootstrap.bundle.min.js"></script>

</body>
</html>