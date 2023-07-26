<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../../../css/bootstrap.min.css">
</head>
<body>
<?php
// Establecer la conexión a la base de datos
$host = "localhost";
$dbname = "workstack";
$username = "root";
$password = "";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error de conexión a la base de datos: " . $e->getMessage());
}

// Obtener los datos del formulario
$nombre_c = $_POST['nombre_c'];
$imagen_c = $_POST['imagen_c'];
$tipo_c = $_POST['tipo_c'];

// Insertar los datos en la base de datos
try {
    $stmt = $pdo->prepare("INSERT INTO cartas (nombre_c, imagen_c, tipo_c) VALUES (?, ?, ?)");
    $stmt->execute([$nombre_c, $imagen_c, $tipo_c]);

    if (isset($_FILES['imagen'])) {
        $nombreArchivo = $_FILES['imagen']['name'];
        $archivoTemp = $_FILES['imagen']['tmp_name'];
        $rutaDestino = "../../../imagenes/productos/" . $nombreArchivo;

        if (move_uploaded_file($archivoTemp, $rutaDestino)) {
            echo "<div class='alert alert-success'>Carta Guardada Con Éxito</div>";
            header("refresh:1 ;agregar_rar.php");
        } else {
            echo "Hubo un error al guardar la imagen.";
        }
    }
} catch (PDOException $e) {
    echo "Error al agregar los datos: " . $e->getMessage();
}

// Cerrar la conexión a la base de datos
$pdo = null;
?>


</body>
</html>