<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../../../css/bootstrap.min.css.">
    <link rel="stylesheet" href="../../../css/index2.css.">
</head>
<body>
<?php
// Establecer la conexión a la base de datos con PDO
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "workstack";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Obtener los datos del formulario
    $id_cli = $_POST['id_cli'];
    $cantidad_p = $_POST['cantidad_p'];
    $notas = $_POST['notas'];
    $id_pro = $_POST['id_pro'];
    $abono_p = $_POST['abono_p'];
    $concepto = $_POST['concepto'];

    // Insertar los datos en la base de datos con consulta preparada
    $sql = "INSERT INTO deuda_p (id_clientep, cantidad_p, notas, id_p, abono_p, concepto)
            VALUES (:id_cli, :cantidad_p, :notas, :id_pro, :abono_p, :concepto)";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id_cli', $id_cli);
    $stmt->bindParam(':cantidad_p', $cantidad_p);
    $stmt->bindParam(':notas', $notas);
    $stmt->bindParam(':id_pro', $id_pro);
    $stmt->bindParam(':abono_p', $abono_p);
    $stmt->bindParam(':concepto', $concepto);

    if ($stmt->execute()) {
        echo "<div class='alert alert-success'>
              <h1 class='text-center'>Datos Actualizados Correctamente</h1>";
        header("refresh:1; deudores_productos.php");
    } else {
        echo "Error al agregar los datos";
    }
} catch (PDOException $e) {
    die("Error de conexión a la base de datos: " . $e->getMessage());
}

// Cerrar la conexión a la base de datos (opcional, ya que PDO lo cierra automáticamente al final del script)
$conn = null;
?>
</body>
</html>