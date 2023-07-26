<?php
// Establecer la conexión a la base de datos con PDO
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "workstack";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error de conexión a la base de datos: " . $e->getMessage());
}

// Obtener los datos del formulario
$id_cr = $_POST['id_cr'];
$p_price = $_POST['p_price'];
$p_tcg = $_POST['p_tcg'];
$p_beto = $_POST['p_beto'];
$cantidad = $_POST['cantidad'];

try {
    // Preparar la consulta SQL con parámetros para evitar inyección SQL
    $sql = "UPDATE car_rar SET 
            p_price = :p_price,
            p_tcg = :p_tcg,
            p_beto = :p_beto,
            cantidad = :cantidad
            WHERE id_cr = :id_cr";
    $stmt = $conn->prepare($sql);
    
    // Asignar los valores a los parámetros de la consulta
    $stmt->bindParam(':p_price', $p_price);
    $stmt->bindParam(':p_tcg', $p_tcg);
    $stmt->bindParam(':p_beto', $p_beto);
    $stmt->bindParam(':cantidad', $cantidad);
    $stmt->bindParam(':id_cr', $id_cr);
    
    // Ejecutar la consulta
    if ($stmt->execute()) {
        echo "<div class='alert alert-success'>
              <h1 class='text-center'>Datos Actualizados Correctamente</h1>";
        header("refresh:1; listarPersonasConBusqueda.php");
    } else {
        echo "Error al actualizar los datos.";
    }
} catch (PDOException $e) {
    echo "Error al ejecutar la consulta: " . $e->getMessage();
}

// Cerrar la conexión a la base de datos
$conn = null;
?>
