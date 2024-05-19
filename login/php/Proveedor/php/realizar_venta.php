<?php
session_start();

// Variables de conexión a la base de datos
$dsn = 'mysql:host=localhost;dbname=bd_sistema;charset=utf8mb4';
$usuario = 'root';
$contraseña = '';

$id_proveedor = $_SESSION['id_proveedor'];

try {
    // Crear una instancia de la conexión PDO
    $conn = new PDO($dsn, $usuario, $contraseña);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $material_genetico_id = $_POST['material_genetico_id'];
        $cantidad_compra = $_POST['cantidad_compra'];
        $fecha_compra = date("Y-m-d");

        // Realizar la compra
        $sql_compra = "INSERT INTO compras (material_genetico_id, cantidad, fecha_compra, proveedor_id) VALUES(?, ?, ?, ?)";
        $sql_compra = $conn->prepare($sql_compra);
        $sql_compra->execute([$material_genetico_id, $cantidad_compra, $fecha_compra, $id_proveedor]);

        // Actualizar el stock del producto
        $sql_stock = "UPDATE material_genetico SET stock = stock + $cantidad_compra WHERE id_material_genetico = $material_genetico_id";
        $conn->query($sql_stock);

        // Asignar valores a las variables de sesión relacionadas con la compra
        $_SESSION["material_genetico_id"] = $material_genetico_id;
        $_SESSION["cantidad_compra"] = $cantidad_compra;
        $_SESSION["fecha_compra"] = $fecha_compra;

        echo '
        <script>
            alert("Compra Realizada Correctamente");
        </script>
        ';
    }
    $conn = null; // Cerrar la conexión a la base de datos
} catch (PDOException $e) {
    // En caso de error, mostrar el mensaje de error
    echo 'Error de conexión: ' . $e->getMessage();
}



?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Realizar Venta</title>
    <link rel="stylesheet" href="proveedor.css">
</head>
<body>
    <div id="contenido-realizar-venta" style="display: block;">
        <h1>Contenido de Realizar una venta</h1><br><br>

        <h2>Realizar Venta</h2><br>

        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            Material Genetico ID: <input type="text" name="material_genetico_id"><br>
            Cantidad: <input type="text" name="cantidad_compra"><br><br>
            <input type="submit" value="Realizar Venta">
        </form>

    </div>

    <a href="../../../proveedor/elite.php" class="btn">Regresar</a>
</body>
</html>
