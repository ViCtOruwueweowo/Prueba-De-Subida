<?php
require '../../config/config.php';
require '../../config/database.php';
$db = new Database();
$con = $db->conectar();
$id = isset($_GET['id_car']) ? $_GET['id_car'] : '';
$token = isset($_GET['token']) ? $_GET['token'] : '';

if($id == '' ||$token == ''){
    echo 'Error al procesar la peticion';
    exit;
} else {
    $token_tmp = hash_hmac('sha1', $id, KEY_TOKEN);
    
    if($token == $token_tmp) {

        $sql= $con->prepare("SELECT count(id_car) FROM cartas where id_car=?");
        $sql->execute([$id]);
        if($sql->fetchColumn() > 0){
            $sql= $con->prepare("SELECT * FROM cartas inner join car_rar
            on cartas.id_car=car_rar.id_carar left join rareza
            on car_rar.id_rar=rareza.id_ra   where cartas.id_car=?
            LIMIT 1");


            $sql->execute([$id]);
            $row = $sql->fetch(PDO::FETCH_ASSOC);
            $nombre =$row['nombre_c'];
            $rareza=$row['rareza'];
            $price=$row['p_price'];
            $img=$row['imagen_c'];
            $tcg=$row['p_tcg'];
            $dir_images = '../../imagenes/productos/' .$img. '/jpg';
            
            $rutaImg = $dir_images;

                if(!file_exists($rutaImg)){
                    $rutaImg='imagenes/no imagen.png';
}
$images = array();
if(file_exists($dir_images))
{
$dir= dir($dir_images);
while(($archivo = $dir->read()) != false ){
    if($archivo !=  $img.'.jpg' && (strpos($archivo, 'jpg')||strpos($archivo, 'png'))){
        $images[]=$dir_images . $archivo;

    }
}
$dir->close();
}
}
    } else {
        echo 'Error al procesar la peticion';
        exit;
    }
}

$sql = $con->prepare("SELECT cartas.nombre_c as nombre,
rareza.rareza
from
cartas inner join car_rar
on cartas.id_car=car_rar.id_carar left join rareza
on car_rar.id_rar=rareza.id_ra  ");
$sql->execute();
$resultado = $sql->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles</title>
    <link rel="stylesheet" href="../../css/bootstrap.min.css">
    <script src="../../js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="../../css/index2.css">

</head>
<body>
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
          <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
            <li class="nav-item">
              <a class="nav-link " aria-current="page" href="../calendario.php"><b>Calendario</b></a>
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
<main>
<br>
<div class="container">
  <div class="row">
    <div class="col text-center ">
    <img src="<?php echo $rutaImg ?>" alt="" >
    </div>
          <div class="col col-lg-6 d-none d-lg-block">
         <h1>Carta</h1>
         <h3><?php echo $nombre ?></h3>
          <h1>Rareza</h1>
         <h3><?php echo $rareza ?></h3>
         <h1>Price</h1>
         <h3><a href="<?php echo $price ?>">Consultar</a></h3>
            <h1>Tcg</h1>
            <h3><a href="<?php echo $tcg ?>">Consultar</a></h3>
          </div>
          <div class="col- col-sm-12 d-lg-none">
<!-- Button trigger modal -->
<br>
<button type="button" class="btn btn-outline-primary col-12" data-bs-toggle="modal" data-bs-target="#exampleModal">
  Consultar
</button>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5 text-center" id="exampleModalLabel"><?php echo $nombre ?></h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-center">
      <img src="<?php echo $rutaImg ?>" alt="" >
      <h1>Carta</h1>
         <h3><?php echo $nombre ?></h3>
          <h1>Rareza</h1>
         <h3><?php echo $rareza ?></h3>
         <h1>Price</h1>
            <h3><a href="<?php echo $price ?>">Consultar</a></h3>
            <h1>Tcg</h1>
            <h3><a href="<?php echo $tcg ?>">Consultar</a></h3>
      </div>
    </div>
  </div>
</div>
          </div>
        </div>
    </div>

</main>
<script src="../../js/bootstrap.bundle.min.js"></script>
</body>
</html>