<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../../css/bootstrap.min.css">
    <link rel="stylesheet" href="../../../css/index2.css">

    <title>Document</title>
</head>
<body>
<?php
// Establecer la conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "workstack";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Error de conexión a la base de datos: " . $conn->connect_error);
}

// Obtener los datos del formulario
$id_acreedor = $_POST['id_acreedor'];
$descuento = $_POST['descuento'];
$f_finalacreed = $_POST['f_finalacreed'];
$notas_ac = $_POST['notas_ac'];


// Insertar los datos en la base de datos
$sql = "UPDATE acreedor SET 
descuento = '$descuento',
f_finalacreed = '$f_finalacreed',
notas_ac = '$notas_ac'
 where id_acreedor='$id_acreedor'";
if ($conn->query($sql) === TRUE) {
    echo "<div class='alert alert-success'>
    <h1 class='text-center'>Datos Actualizados Correctamente</h1>";
header("refresh:1;../acreedores.php");
} else {
    echo "Error al agregar los datos: " . $conn->error;
}

// Cerrar la conexión a la base de datos
$conn->close();
?>

</body>
</html>