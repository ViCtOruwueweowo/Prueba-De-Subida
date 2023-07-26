<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guardar Empleado</title>
    <link rel="stylesheet" href="../../../css/bootstrap.min.css">
    <link rel="stylesheet" href="../../../css/index2.css">
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
 
extract($_POST);

//hash lo hacemos variable que agarra la contraseña del form anterior
$hash = password_hash($contraseña, PASSWORD_DEFAULT);

// Obtener los datos del formulario
$nombre_user = $_POST['nombre_user']; 
$apellidos_user = $_POST['apellidos_user'];
$tel_user = $_POST['telefono'];
$f_nacimiento = $_POST['fechan'];
$direccion_user = $_POST['direccion'];
$usuario = $_POST['usuario']; 

$tipo_usuario = 2;
$estado = 1;

// Insertar los datos en la base de datos
try {
    $stmt = $pdo->prepare("INSERT INTO usuarios(nombre_user, apellidos_user, tel_user, f_nacimiento, direccion_user, usuario, contraseña, tipo_usuario, estado) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$nombre_user, $apellidos_user, $tel_user, $f_nacimiento, $direccion_user, $usuario, $hash, $tipo_usuario, $estado]);
    
    echo "<div class='container' id='contenedor'>
    <div class='alert alert-success text-center' role='alert'>
   <h1 style='text-aling:center'>¡Exito, La Accion Fue Realizada Sin Problemas, Buen Trabajo!</h1>
   <br>
   <div class='spinner-border text-dark' role='status'>
<span class='visually-hidden'>Loading...</span>
</div>
<br>
   <h6>Espera Estas Siendo Redirigido</h6>
  </div>
  </div>   ";     
    header("refresh:2 ; ../empleados.php");
} catch (PDOException $e) {
    echo "Error al agregar los datos: " . $e->getMessage();
}

// Cerrar la conexión a la base de datos
$pdo = null;
?>

</body>
</html>
