<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guardar Carta Detallada</title>
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
    // Establecer el modo de error PDO en excepción
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Error de conexión a la base de datos: " . $e->getMessage());
}

// Obtener los datos del formulario de manera segura
$id_cli = $_POST['id_cli'];
$cantidad_c = $_POST['cantidad_c'];
$notas = $_POST['notas'];
$id_cr = $_POST['id_cr'];
$abono_c = $_POST['abono_c'];
$concepto = $_POST['concepto'];

// Insertar los datos en la base de datos utilizando consultas preparadas
try {
    $stmt = $conn->prepare("INSERT INTO deuda_c (id_clientec, cantidad_c, notas, cr_fk, abono_c, concepto)
                            VALUES (:id_cli, :cantidad_c, :notas, :id_cr, :abono_c, :concepto)");

    $stmt->bindParam(':id_cli', $id_cli);
    $stmt->bindParam(':cantidad_c', $cantidad_c);
    $stmt->bindParam(':notas', $notas);
    $stmt->bindParam(':id_cr', $id_cr);
    $stmt->bindParam(':abono_c', $abono_c);
    $stmt->bindParam(':concepto', $concepto);

    $stmt->execute();
    echo "Datos agregados correctamente";
} catch(PDOException $e) {
    echo "Error al agregar los datos: " . $e->getMessage();
}

// Cerrar la conexión a la base de datos
$conn = null;
?>

</body>
</html>