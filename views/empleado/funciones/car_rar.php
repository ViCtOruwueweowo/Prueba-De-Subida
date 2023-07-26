<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guardar Carta Detallada</title>
    <link rel="stylesheet" href="../../../css/bootstrap.min.css">
</head>
<body>
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
$id_carar = $_POST['id_carar'];
$id_rar = $_POST['id_rar'];
$p_price = $_POST['p_price'];
$p_tcg = $_POST['p_tcg'];
$p_beto = $_POST['p_beto'];
$codigo = $_POST['codigo'];
$cantidad = $_POST['cantidad'];

// Insertar los datos en la base de datos
try {
    $stmt = $pdo->prepare("INSERT INTO car_rar (id_carar, id_rar, p_price, p_tcg, p_beto, codigo, cantidad) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$id_carar, $id_rar, $p_price, $p_tcg, $p_beto, $codigo, $cantidad]);

    echo "<div class='alert alert-success'>Carta Registrada Por Completo</div>";
    header("refresh:1 ;listarPersonasConBusqueda.php");
} catch (PDOException $e) {
    echo "Error al agregar los datos: " . $e->getMessage();
}

// Cerrar la conexión a la base de datos
$pdo = null;
?>

</body>
</html>
