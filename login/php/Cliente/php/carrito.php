<?php
session_start(); // Iniciar la sesión al principio del archivo

// Establecer conexión a la base de datos
$dsn = 'mysql:host=localhost;dbname=bd_sistema;charset=utf8mb4';
$usuario = 'root';
$contraseña = '';

try {
    $conexion = new PDO($dsn, $usuario, $contraseña);
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Obtener el ID del cliente desde la sesión
    $cliente_id = $_SESSION['id_cliente'] ?? 1; // Aquí asumo que tienes el ID del cliente en la sesión

    // Verificar si se eliminó todo un material genético del carrito
    if (isset($_GET['eliminar_todo'])) {
        $id_material_genetico = $_GET['eliminar_todo'];

        // Eliminar todo el material genético de la base de datos
        $stmt_eliminar_todo = $conexion->prepare("DELETE FROM carrito WHERE cliente_id = ? AND material_genetico_id = ?");
        $stmt_eliminar_todo->execute([$cliente_id, $id_material_genetico]);

        // Redirigir de nuevo al carrito para que se reflejen los cambios
        header('Location: carrito.php');
        exit();
    }

    // Verificar si se eliminó o se redujo la cantidad de un material genético del carrito
    if (isset($_GET['eliminar'])) {
        $id_material_genetico = $_GET['eliminar'];

        // Verificar la cantidad actual en la base de datos
        $stmt_cantidad_actual = $conexion->prepare("SELECT cantidad FROM carrito WHERE cliente_id = ? AND material_genetico_id = ?");
        $stmt_cantidad_actual->execute([$cliente_id, $id_material_genetico]);
        $cantidad_actual = $stmt_cantidad_actual->fetchColumn();

        if ($cantidad_actual > 1) {
            // Si la cantidad en el carrito es mayor a 1, reducir la cantidad en 1
            $stmt_actualizar = $conexion->prepare("UPDATE carrito SET cantidad = cantidad - 1 WHERE cliente_id = ? AND material_genetico_id = ?");
            $stmt_actualizar->execute([$cliente_id, $id_material_genetico]);
        } else {
            // Si la cantidad es 1, eliminar del carrito en la base de datos
            $stmt_eliminar = $conexion->prepare("DELETE FROM carrito WHERE cliente_id = ? AND material_genetico_id = ?");
            $stmt_eliminar->execute([$cliente_id, $id_material_genetico]);
        }

        // Redirigir de nuevo al carrito para que se reflejen los cambios
        header('Location: carrito.php');
        exit();
    }

    // Verificar si se agregó o eliminó cantidad de un material genético del carrito
    if (isset($_POST['agregar_cantidad']) && isset($_POST['id_material_genetico'])) {
        $id_material_genetico = $_POST['id_material_genetico'];
        $cantidad = intval($_POST['agregar_cantidad']);

        // Verificar si el material genético está en el carrito
        $stmt_cantidad_actual = $conexion->prepare("SELECT cantidad FROM carrito WHERE cliente_id = ? AND material_genetico_id = ?");
        $stmt_cantidad_actual->execute([$cliente_id, $id_material_genetico]);
        $cantidad_actual = $stmt_cantidad_actual->fetchColumn();

        if ($cantidad_actual !== false) {
            // Actualizar la cantidad en el carrito en la base de datos
            $stmt_actualizar_cantidad = $conexion->prepare("UPDATE carrito SET cantidad = cantidad + ? WHERE cliente_id = ? AND material_genetico_id = ?");
            $stmt_actualizar_cantidad->execute([$cantidad, $cliente_id, $id_material_genetico]);
        }

        // Redirigir de nuevo al carrito para que se reflejen los cambios
        header('Location: carrito.php');
        exit();
    }

    // Obtener los materiales genéticos del carrito desde la base de datos
    $consulta_ventas = $conexion->prepare("
        SELECT c.material_genetico_id, c.cantidad, m.raza, m.precio_cliente 
        FROM carrito c 
        JOIN material_genetico m ON c.material_genetico_id = m.id_material_genetico 
        WHERE c.cliente_id = ?
    ");
    $consulta_ventas->execute([$cliente_id]);
    $productos_ventas = $consulta_ventas->fetchAll(PDO::FETCH_ASSOC);

    // Calcular total a pagar
    $total_pagar = 0;
    foreach ($productos_ventas as $producto) {
        $total_pagar += $producto['precio_cliente'] * $producto['cantidad'];
    }
} catch (PDOException $e) {
    echo 'Error de conexión: ' . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito de Compras</title>
    <link rel="stylesheet" href="cliente.css">
    <script>
        function mostrarResumen() {
            var resumen = document.getElementById('resumen');
            resumen.style.display = 'block';
        }
    </script>
</head>
<body>
    <header>
        <h1>Carrito de Compras</h1>
        <a href="../../../cliente/elite.php" class="volver">Volver a la Tienda</a>
    </header>

    <main>
        <h2>Productos en el Carrito</h2>
        <div class="productos-carrito">
            <?php foreach ($productos_ventas as $producto): ?>
                <div class="producto-carrito">
                    <h3>Material Genético ID: <?php echo $producto['material_genetico_id']; ?></h3>
                    <p>Raza: <?php echo htmlspecialchars($producto['raza']); ?></p>
                    <p>Precio: $<?php echo htmlspecialchars($producto['precio_cliente']); ?></p>
                    <p>Cantidad: <?php echo $producto['cantidad']; ?></p>
                    <form action="" method="post">
                        <input type="hidden" name="id_material_genetico" value="<?php echo $producto['material_genetico_id']; ?>">
                        <input type="number" name="agregar_cantidad" value="1" min="1" max="10">
                        <input type="submit" value="Agregar Cantidad" class="pagar">
                    </form>
                    <form action="" method="get">
                        <input type="hidden" name="eliminar" value="<?php echo $producto['material_genetico_id']; ?>">
                        <input type="submit" value="Eliminar una cantidad" class="pagar">
                    </form>
                    <a href="carrito.php?eliminar_todo=<?php echo $producto['material_genetico_id']; ?>" class="eliminar">Eliminar Material</a>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="acciones">
            <a href="../../../cliente/elite.php" class="continuar">Continuar Comprando</a><br><br>
            <!-- Botón para mostrar el resumen de la compra -->
            <button onclick="mostrarResumen()" class="continuar">Ver Resumen</button><br><br>
            <!-- Enlace para proceder al pago -->
            <a href="pago.php" class="pagar">Proceder al Pago</a>
        </div>

        <!-- Contenedor para mostrar el resumen de la compra -->
        <div id="resumen" style="display: none;">
            <h2>Resumen de la Compra</h2>
            <p>Total a Pagar: <?php echo $total_pagar; ?></p>
            <ul>
                <?php foreach ($productos_ventas as $producto): ?>
                    <li>Material Genético ID: <?php echo $producto['material_genetico_id']; ?>, Cantidad: <?php echo $producto['cantidad']; ?></li>
                <?php endforeach; ?>
            </ul>
            <!-- Botón para proceder al pago -->
            <a href="pago.php" class="pagar">Pagar</a>
        </div>
    </main>
</body>
</html>









