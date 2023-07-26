<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/index.css">
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
if($_POST)
{
    require('database.php');
    $u = $_POST['usuario'];
    $p = $_POST['contraseña'];

    $conexion = new Database();
    $pdo = $conexion->conectar();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


    $query = $pdo->prepare("SELECT * FROM usuarios WHERE usuario= :u");
    $query->bindParam(":u", $u);
    $query->execute();
    $usuario = $query->fetch(PDO::FETCH_ASSOC);
 
    if ($usuario && $usuario["estado"] == 1) {
        // Usuario válido y estado es igual a 1
        // Verificar la contraseña proporcionada con la almacenada en la base de datos
        if (password_verify($p, $usuario["contraseña"])) {
            session_start();
        $_SESSION['usuario'] = $usuario["usuario"];

        $_SESSION['tipo_usuario'] = $usuario["tipo_usuario"];


        if ($usuario["tipo_usuario"] == "1") {
            echo "<div class='container' id='contenedor'>
            <div class='alert alert-success text-center' role='alert'>
           <h1 style='text-aling:center'>¡Bienvenido De Nuevo!</h1>
           <h2>Que Tengas Buen Dia, No Olvides Cerrar Tu Cuenta Cuando Termines.
           <br>
           <div class='spinner-border text-dark' role='status'>
        <span class='visually-hidden'>Loading...</span>
      </div>
      <br>
           <h6>Espera Estas Siendo Redirigido</h6>
          </div>
          </div>   "; 
            header("refresh:3 ../views/administrador/index.php");
            exit();

        } else if ($usuario["tipo_usuario"] == "2") {
            echo "<div class='container' id='contenedor'>
            <div class='alert alert-success text-center' role='alert'>
           <h1 style='text-aling:center'>¡Bienvenido De Nuevo!</h1>
           <h2>Que Tengas Buen Dia, No Olvides Cerrar Tu Cuenta Cuando Termines.
           <br>
           <div class='spinner-border text-dark' role='status'>
        <span class='visually-hidden'>Loading...</span>
      </div>
      <br>
           <h6>Espera Estas Siendo Redirigido</h6>
          </div>
          </div>   "; 
            header("refresh:3 ../views/empleado/index.php");
        }
            exit();
        } else {
            echo "<div class='container' id='contenedor'>
            <div class='alert alert-warning text-center' role='alert'>
           <h1 style='text-aling:center'>¡Ups, Algo Salio Mal, Usuario O Contraseña Incorrectos, Verifica Tu Informacion!</h1>
           <br>
           <div class='spinner-border text-dark' role='status'>
        <span class='visually-hidden'>Loading...</span>
      </div>
      <br>
           <h6>Espera Estas Siendo Redirigido</h6>
          </div>
          </div>   ";                 header("refresh:3 ../index.php");
            exit();
        }

        } elseif ($usuario && $usuario["estado"] != 1) {
            // Usuario válido pero estado no es igual a 1
            echo "<div class='container' id='contenedor'>
            <div class='alert alert-danger text-center' role='alert'>
           <h1 style='text-aling:center'>¡Ups, Algo Salio Mal, Parece Ser Que No Estas Registrado Comunicate Con El Administrador Mas Cercano!</h1>
           <br>
           <div class='spinner-border text-dark' role='status'>
        <span class='visually-hidden'>Loading...</span>
      </div>
      <br>
           <h6>Espera Estas Siendo Redirigido</h6>
          </div>
          </div>   ";     
                 header("refresh:3 ../index.php");
            exit();
        } else {
            echo "<div class='container' id='contenedor'>
            <div class='alert alert-danger text-center' role='alert'>
           <h1 style='text-aling:center'>¡Ups, Algo Salio Mal, Usuario O Contraseña Incorrectos, Verifica Tu Informacion!</h1>
           <br>
           <div class='spinner-border text-dark' role='status'>
        <span class='visually-hidden'>Loading...</span>
      </div>
      <br>
           <h6>Espera Estas Siendo Redirigido</h6>
          </div>
          </div>   ";     
        header("refresh:3 ../index.php");
        exit();
    }
}
?>

</body>
</html>