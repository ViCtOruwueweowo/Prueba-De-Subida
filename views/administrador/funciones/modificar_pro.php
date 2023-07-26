<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guardar Carta Detallada</title>
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
$id_pro = $_POST['id_pro'];
$existencias = $_POST['existencias'];
$precio = $_POST['precio'];

$notas_prod = $_POST['notas_prod'];


// Insertar los datos en la base de datos
$sql = "UPDATE productos SET 
existencias = '$existencias',
precio = '$precio',
notas_prod = '$notas_prod'
 where id_pro='$id_pro'";
if ($conn->query($sql) === TRUE) {
    echo "<div class='alert alert-success'>
              <h1 class='text-center'>Datos Actualizados Correctamente</h1>";
        header("refresh:1; listarPersonasConBusqueda2.php");
} else {
    echo "Error al agregar los datos: " . $conn->error;
}

// Cerrar la conexión a la base de datos
$conn->close();
?>

</body>
</html>