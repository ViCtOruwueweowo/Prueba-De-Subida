<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../../../css/bootstrap.min.css">
    <link rel="stylesheet" href="../../../css/index3.css">
    <script rel="stylesheet" href="../../../js/bootstrap.bundle.min.js"></script>
    <style>
        #contendor{
            width: 40%;
            margin: auto;
        }
        body{
            margin-top: 250px;
        }
    </style>
</head>
<body>

<?php
try {
    // Establecer la conexión a la base de datos con PDO
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "workstack";

    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Obtener los datos del formulario
    $id_pro = $_POST['id_pro'];
    $existencias = $_POST['existencias'];
    

    // Preparar la consulta para actualizar los datos en la base de datos
    $sql = "UPDATE productos SET 
            existencias = :existencias
            WHERE id_pro = :id_pro";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':existencias', $existencias);
    $stmt->bindParam(':id_pro', $id_pro);
   

    // Ejecutar la consulta
    if ($stmt->execute()) {
        echo "<div class='container' id='contenedor'>
        <div class='alert alert-success text-center' role='alert'>
       <h1 style='text-aling:center'>¡Hecho, La Accion Fue Realizada Con Exito!</h1>
       <br>
       <div class='spinner-border text-dark' role='status'>
    <span class='visually-hidden'>Loading...</span>
  </div>
  <br>
       <h6>Espera Estas Siendo Redirigido</h6>
      </div>
      </div>   ";
      header("refresh:2 ;listarPersonasConBusqueda2.php");
    } else {
        echo "<div class='container' id='contenedor'>
        <div class='alert alert-danger text-center' role='alert'>
       <h1 style='text-aling:center'>¡Ups, Algo Salio Mal, Verifica Que La Informacion Sea Valida!</h1>
       <br>
       <div class='spinner-border text-dark' role='status'>
    <span class='visually-hidden'>Loading...</span>
  </div>
  <br>
       <h6>Espera Estas Siendo Redirigido</h6>
      </div>
      </div>   ";
      header("refresh:2 ;listarPersonasConBusqueda2.php");
    }
} catch (PDOException $e) {
    die("Error de conexión a la base de datos: " . $e->getMessage());
}
?>

</body>
</html>