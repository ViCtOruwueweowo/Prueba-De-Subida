<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../../../css/bootstrap.min.css">
    <link rel="stylesheet" href="../../../css/index2.css">
    <script rel="stylesheet" href="../../../js/bootstrap.bundle.min.js"></script>

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
    // Configurar el modo de error para que PDO lance excepciones en caso de error
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error de conexión a la base de datos: " . $e->getMessage());
}

// Obtener los datos del formulario
$id_cli = $_POST['id_cli'];
$descuento = $_POST['descuento'];
$f_finalacreed = $_POST['f_finalacreed'];
$notas_ac = $_POST['notas_ac'];

// Insertar los datos en la base de datos usando consultas preparadas
try {
    $sql = "INSERT INTO acreedor (descuento, f_finalacreed, notas_ac, id_clientu) VALUES (:descuento, :f_finalacreed, :notas_ac, :id_cli)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':descuento', $descuento);
    $stmt->bindParam(':f_finalacreed', $f_finalacreed);
    $stmt->bindParam(':notas_ac', $notas_ac);
    $stmt->bindParam(':id_cli', $id_cli);

    if ($stmt->execute()) {
        echo "<div class='alert alert-success'>
        <h1 class='text-center'>Datos Agregados Correctamente</h1>";
    header("refresh:1;../acreedores.php");
    } else {
        echo "Error al agregar los datos";
    }
} catch (PDOException $e) {
    echo "<div class='alert alert-danger'> " . $e->getMessage();
    echo "</div> "; 
    header("refresh:1;../acreedores.php");
}

// Cerrar la conexión a la base de datos
$conn = null;
?>
</body>
</html>