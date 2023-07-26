<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guardar Empleado</title>
    <link rel="stylesheet" href="../../../css/index2.css">
    <link rel="stylesheet" href="../../../css/bootstrap.min.css">
</head>
<body>
<style>
        #contendor{
            width: 40%;
            margin: auto;
        }
        body{
            margin-top: 250px;
        }
    </style>
<?php
// Establecer la conexión a la base de datos con PDO
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "workstack";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // Establecer el modo de error PDO en excepción
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Error de conexión a la base de datos: " . $e->getMessage());
}

// Obtener los datos del formulario de manera segura
$nom_cli = $_POST['nom_cli'];
$tel_cli = $_POST['tel_cli'];


// Insertar los datos en la base de datos utilizando consultas preparadas
try {
    $stmt = $conn->prepare("INSERT INTO clientes (nom_cli, tel_cli)
                            VALUES (:nom_cli, :tel_cli)");

    $stmt->bindParam(':nom_cli', $nom_cli);
    $stmt->bindParam(':tel_cli', $tel_cli);

    $stmt->execute();
    echo "<div class='container' id='contenedor'>
    <div class='alert alert-success text-center' role='alert'>
   <h1 style='text-aling:center'>¡Exito, Todos Los Cambios Fueron Realizados De Forma Exitosa, Buen Trabajo!</h1>
   <br>
   <div class='spinner-border text-dark' role='status'>
<span class='visually-hidden'>Loading...</span>
</div>
<br>
   <h6>Espera Estas Siendo Redirigido</h6>
  </div>
  </div>   ";
  header("refresh:3 ;../index.php");
} catch(PDOException $e) {
    echo "Error al agregar los datos: " . $e->getMessage();
}

// Cerrar la conexión a la base de datos
$conn = null;
?>

</body>
</html>