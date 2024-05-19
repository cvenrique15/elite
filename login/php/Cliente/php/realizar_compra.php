<?php
session_start();

$dsn = 'mysql:host=localhost;dbname=bd_sistema;charset=utf8mb4';
$usuario = 'root';
$contraseña = '';

// Suponiendo que tienes el id del cliente disponible en alguna variable, por ejemplo $_SESSION['id_cliente']
$id_cliente = $_SESSION['id_cliente']; // Asegúrate de obtener este valor de donde corresponda en tu aplicación

try {
    // Crear una instancia de la conexión PDO
    $conn = new PDO($dsn, $usuario, $contraseña);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $material_genetico_id = $_POST['material_genetico_id'];
        $cantidad_venta = $_POST['cantidad_venta'];
        $fecha_venta = date("Y-m-d");

        // Verificar si hay suficiente stock para la venta
        $sql_stock = "SELECT stock FROM material_genetico WHERE id_material_genetico = ?";
        $stmt = $conn->prepare($sql_stock);
        $stmt->execute([$material_genetico_id]);
        
        $row_stock = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row_stock) {
            $stock_disponible = $row_stock['stock'];

            if ($cantidad_venta > $stock_disponible) {
                echo "No hay suficiente stock disponible para realizar la venta.";
            } else {
                // Realizar la venta
                $sql_venta = "INSERT INTO ventas (material_genetico_id, cantidad, fecha_venta, cliente_id) VALUES (?, ?, ?, ?)";
                $stmt_venta = $conn->prepare($sql_venta);
                $stmt_venta->execute([$material_genetico_id, $cantidad_venta, $fecha_venta, $id_cliente]);

                // Actualizar el stock del producto
                $nuevo_stock = $stock_disponible - $cantidad_venta;
                $sql_actualizar_stock = "UPDATE material_genetico SET stock = ? WHERE id_material_genetico = ?";
                $stmt_actualizar_stock = $conn->prepare($sql_actualizar_stock);
                $stmt_actualizar_stock->execute([$nuevo_stock, $material_genetico_id]);

                echo '
                <script>
                    alert("Compra Realizada Correctamente");
                </script>
                ';
            }
        } else {
            echo '
            <script>
                alert("El producto especificado no existe");
            </script>
            ';
        }
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
    <title>Realizar Compra</title>
    <link rel="stylesheet" href="cliente.css">
</head>
<body>

<h2>Realizar Compra</h2><br>

<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
    Material Genetico ID: <input type="text" name="material_genetico_id"><br>
    Cantidad: <input type="text" name="cantidad_venta"><br><br>
    <input type="submit" value="Realizar Compra">
</form><br><br>

<a href="../../../cliente/elite.php" class="btn">Regresar</a>

</body>
</html>
