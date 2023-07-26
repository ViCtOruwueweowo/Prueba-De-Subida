<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Productos</title>
    <link rel="stylesheet" href="../../../css/bootstrap.min.css">
</head>
<body>
<div class="container " style="width:70% ">
<?php
// Establecer la conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "workstack";

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error de conexión a la base de datos: " . $e->getMessage());
}

// Obtener los datos del formulario
$nom_p = $_POST['nom_p'];
$existencias = $_POST['existencias'];
$precio = $_POST['precio'];
$imagen_p = $_POST['imagen_p'];
$notas_prod = $_POST['notas_prod'];

// Insertar los datos en la base de datos
try {
    $stmt = $pdo->prepare("INSERT INTO productos (nom_p, existencias, precio, imagen_p, notas_prod) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$nom_p, $existencias, $precio, $imagen_p, $notas_prod]);
    if (isset($_FILES['imagen'])) {
        $nombreArchivo = $_FILES['imagen']['name'];
        $archivoTemp = $_FILES['imagen']['tmp_name'];
        $rutaDestino = "../../../imagenes/productos_2/" . $nombreArchivo;

        if (move_uploaded_file($archivoTemp, $rutaDestino)) {
            header("refresh:1 ;listarPersonasConBusqueda2.php");
        } else {
            echo "Hubo un error al guardar la imagen.";
        }
    }
    echo "<div class='alert alert-success'>
    <h1 class='text-center'>Datos Actualizados Correctamente</h1>";
header("refresh:1; listarPersonasConBusqueda2.php");
} catch (PDOException $e) {
    echo "Error al agregar los datos: " . $e->getMessage();
}

// Cerrar la conexión a la base de datos
$pdo = null;
?>
</div>
</body>
</html>