<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guardar Carta Detallada</title>
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
    $id_dc = $_POST['id_dc'];
    $cantidad_c = $_POST['cantidad_c'];
    $abono_c = $_POST['abono_c'];
    $notas = $_POST['notas'];
    $concepto = $_POST['concepto'];

    // Preparar la consulta para actualizar los datos en la base de datos
    $sql = "UPDATE deuda_c SET 
            cantidad_c = :cantidad,
            abono_c = :abono,
            notas = :notas,
            concepto = :concepto
            WHERE id_dc = :id";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':cantidad', $cantidad_c);
    $stmt->bindParam(':abono', $abono_c);
    $stmt->bindParam(':notas', $notas);
    $stmt->bindParam(':concepto', $concepto);
    $stmt->bindParam(':id', $id_dc);

    // Ejecutar la consulta
    if ($stmt->execute()) {
        echo "Datos agregados correctamente";
    } else {
        echo "Error al agregar los datos";
    }
} catch (PDOException $e) {
    die("Error de conexión a la base de datos: " . $e->getMessage());
}
?>

</body>
</html>