<?php


session_start();

if (!isset($_SESSION['nombre'])) {
    echo '
        <script>
            alert("Por favor debes iniciar sesión");
            window.location = "index.php";
        </script>
    ';
    session_destroy();
    die();
}

$id_cliente = $_SESSION["id_cliente"];
$nombre = $_SESSION["nombre"];
$apellido = $_SESSION["apellido"];
$telefono = $_SESSION["telefono"];
$correo = $_SESSION["correo"];
$raza = $_SESSION["raza"];

?>


<?php

// Establecer conexión a la base de datos
$dsn = 'mysql:host=localhost;dbname=bd_sistema;charset=utf8mb4';
$usuario = 'root';
$contraseña = '';

try {
    $conexion = new PDO($dsn, $usuario, $contraseña);
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $cliente_id = 1; // Supongamos que tienes el ID del cliente en la sesión

    $stmt_carrito = $conexion->prepare("SELECT SUM(cantidad) as total_productos FROM carrito WHERE cliente_id = ?");
    $stmt_carrito->execute([$cliente_id]);
    $resultado_carrito = $stmt_carrito->fetch(PDO::FETCH_ASSOC);
    $carrito_cantidad = $resultado_carrito['total_productos'] ?? 0;

    // Consulta SQL para obtener los productos de la tabla material_genetico
    $consulta = "SELECT id_material_genetico, raza, precio_cliente FROM material_genetico";
    $stmt = $conexion->query($consulta);
    $productos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Verificar si se agregó un producto al carrito
    if (isset($_POST['agregar'])) {
        $id_producto = $_POST['agregar'];

        // Inicializa el carrito si no existe
        if (!isset($_COOKIE['carrito'])) {
            $carrito = [];
        } else {
            $carrito = json_decode($_COOKIE['carrito'], true);
        }

        // Agregar el producto al carrito
        if (!isset($carrito[$id_producto])) {
            $carrito[$id_producto] = 1; // Cantidad inicial
        } else {
            $carrito[$id_producto]++; // Aumentar la cantidad
        }

        // Guardar el carrito en una cookie
        setcookie('carrito', json_encode($carrito), time() + (86400 * 30), "/"); // Expira en 30 días

        // Guardar el producto en la base de datos
        $cantidad = $carrito[$id_producto];

        $stmt_insert = $conexion->prepare("INSERT INTO carrito (cliente_id, material_genetico_id, cantidad) VALUES (?, ?, ?)ON DUPLICATE KEY UPDATE cantidad = VALUES(cantidad)");
        $stmt_insert->execute([$cliente_id, $id_producto, 1]);

        // Redirigir al carrito para reflejar los cambios
        header('Location:elite.php');
        exit();
    }
} catch (PDOException $e) {
    echo 'Error de conexión: ' . $e->getMessage();
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Elite</title>
    <link rel="stylesheet" href="../css/inicio.css">
</head>

<body>



    <div class="inicio">Cliente</div>
    <header class="encabezado">
        <nav>
            <div><img src="../img/bg5.cms" alt=""></div>
            <div class="user-area"><?php echo "Bienvenido $nombre"; ?></div>

            <ul>
                <li><a href="#" onclick="mostrarContenido('inicio')">Inicio</a></li>
                <li>
                    <a href="#" onclick="mostrarContenido('material-genetico')">Material-Genético</a>
                    <ul>
                        <li><a href="../php/cliente/php/realizar_compra.php" >Realizar una compra</a></li>
                        <li>
                            <a href="#">Mis compras</a>
                            <ul>
                                <li><a href="#" onclick="mostrarContenido('finalizados')">Finalizados</a></li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="#" onclick="mostrarContenido('mi-perfil')">Mi Perfil</a>
                    <ul>
                        <li><a href="#" onclick="mostrarContenido('mi-cuenta')">Mi cuenta</a></li>
                        <li><a href="../php/cliente/php/configuracion.php">Configuración</a></li>
                        <li><a href="../php/Cliente/cerrar_sesion.php">Cerrar Sesión</a></li>
                    </ul>
                </li>
                <li>
                    <a href="#" onclick="mostrarContenido('contacto')">Contacto</a>
                    <ul>
                        <li><a href="#" onclick="mostrarContenido('soporte')">Soporte</a></li>
                        <li><a href="#" onclick="mostrarContenido('contactenos')">Contáctenos</a></li>

                    </ul>
                </li>
            </ul>

            
            <a href="../php/cliente/php/carrito.php" class="carrito-icono">
            <img src="../img/carrito.jpeg" alt="Carrito">
            <span class="carrito-cantidad"><?php echo $carrito_cantidad; ?></span>
            </a>

        </nav>
    </header>

    <div id="contenido-inicio">
        <h1>Contenido de Inicio</h1>

        

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tienda</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
<body style="background-image: url('https://th.bing.com/th/id/OIP.30gif325Fq3CstxoK6LpuAHaEB?w=275&h=180&c=7&r=0&o=5&dpr=2&pid=1.7'); background-size: cover;">
    <main>
        <h2>Productos Disponibles</h2>
        <div class="productos">
            <?php foreach ($productos as $producto): ?>
                <div class="producto">
                    <h3><?php echo $producto['raza']; ?></h3>
                    <p>Precio: $<?php echo $producto['precio_cliente']; ?></p>
                    <form action="" method="post">
                        <input type="hidden" name="agregar" value="<?php echo $producto['id_material_genetico']; ?>">
                        <input type="submit" value="Agregar al Carrito">
                    </form>
                </div>
            <?php endforeach; ?>
        </div>
    </main>
</body>
</html>

    </div>

    <div id="contenido-material-genetico" style="display: none;">
        <h1>Contenido de Material Genético</h1><br><br>

        <?php
// Configuración de la conexión a la base de datos
$dsn = 'mysql:host=localhost;dbname=bd_sistema';
$usuario = 'root';
$contraseña = '';

try {
    // Crear una nueva conexión PDO
    $conexion = new PDO($dsn, $usuario, $contraseña);

    // Configurar el modo de error y excepción
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Consulta SQL para obtener los datos de la tabla
    $consulta = "SELECT mg.id_material_genetico, mg.raza, mg.precio_cliente,
    dm.calidad, dm.principal_uso, dm.cruza, dm.origen, dm.caracteristicas
FROM material_genetico mg, descripcion_material_genetico dm
WHERE mg.id_material_genetico = dm.id_descripcion;";

    // Preparar la consulta
    $stmt = $conexion->prepare($consulta);

    // Ejecutar la consulta
    $stmt->execute();

    // Obtener los resultados de la consulta
    $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Comprobar si hay resultados
    if ($resultados) {
        // Imprimir la tabla HTML
        echo '<table border="1">';
        echo '<tr><th>ID</th><th>Raza</th><th>Calidad</th><th>Precio</th><th>Principal uso</th><th>Cruza</th><th>Origen</th><th>Caracteristicas</th></tr>';
        foreach ($resultados as $fila) {
            echo '<tr>';
            echo '<td>' . $fila['id_material_genetico'] . '</td>';
            echo '<td>' . $fila['raza'] . '</td>';
            echo '<td>' . $fila['calidad'] . '</td>';
            echo '<td>' . $fila['precio_cliente'] . '</td>';
            echo '<td>' . $fila['principal_uso'] . '</td>';
            echo '<td>' . $fila['cruza'] . '</td>';
            echo '<td>' . $fila['origen'] . '</td>';
            echo '<td>' . $fila['caracteristicas'] . '</td>';

            echo '</tr>';
        }
        echo '</table>';
    } else {
        echo 'No se encontraron resultados.';
    }
} catch (PDOException $e) {
    echo 'Error: ' . $e->getMessage();
}
?>

    </div>


    <div id="contenido-finalizados" style="display: none;">
        <h1>Contenido de Mis compras finalizadas</h1><br>

        <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Compras</title>
</head>
<body>
    <h1>Mis compras</h1>

    <?php


    $dsn = 'mysql:host=localhost;dbname=bd_sistema;charset=utf8mb4';
    $usuario = 'root';
    $contraseña = '';

    try {
        $conexion = new PDO($dsn, $usuario, $contraseña);
        $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Obtener el ID del cliente de la sesión
        $id_cliente = $_SESSION['id_cliente'];

        // Consulta SQL para seleccionar las compras del cliente actual
        $consulta = "SELECT * FROM ventas WHERE cliente_id = :id_cliente";

        $stmt = $conexion->prepare($consulta);
        $stmt->bindParam(':id_cliente', $id_cliente, PDO::PARAM_INT);
        $stmt->execute();

        // Obtener los resultados de la consulta
        $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($resultados) {
            // Imprimir la tabla HTML con los resultados
            echo '<table border="1">';
            echo '<tr><th>ID Venta</th><th>Material Genético ID</th><th>Cantidad</th><th>Fecha Venta</th><th>Cliente ID</th></tr>';
            foreach ($resultados as $fila) {
                echo '<tr>';
                echo '<td>' . $fila['id_ventas'] . '</td>';
                echo '<td>' . $fila['material_genetico_id'] . '</td>';
                echo '<td>' . $fila['cantidad'] . '</td>';
                echo '<td>' . $fila['fecha_venta'] . '</td>';
                echo '<td>' . $fila['cliente_id'] . '</td>';
                echo '</tr>';
            }
            echo '</table>';
        } else {
            echo 'No se encontraron compras para este cliente.';
        }
    } catch (PDOException $e) {
        echo 'Error de conexión: ' . $e->getMessage();
    }
    ?>
</body>
</html>

    </div>

    <div id="contenido-mi-perfil" style="display: none;">
        <h1>Contenido de Mi perfil</h1><br><br>
            <h2>
                <?php echo "Id-Cliente ! $id_cliente !"; ?>
            </h2><br>
            <h2>
                <?php echo "Nombre ! $nombre !"; ?>
            </h2><br>
            <h2>
                <?php echo "Apellido ! $apellido !"; ?>
            </h2><br>
            <h2>
                <?php echo "Telefono ! $telefono !"; ?>
            </h2><br>
            <h2>
                <?php echo "Correo ! $correo !"; ?>
            </h2><br>
    </div>

    <div id="contenido-mi-cuenta" style="display: none;">
        <h1>Contenido de mi cuenta</h1>
    </div>

    <div id="contenido-contacto" style="display: none;">
        <h1>Contenido de Contacto</h1>
    </div>

    <div id="contenido-soporte" style="display: none;">
        <h1>Contenido de Soporte</h1>
    </div>

    <div id="contenido-contactenos" style="display: none;">
        <h1>Contenido de Contáctenos</h1>
    </div>


    <script>
        function mostrarContenido(id) {
            var contenidos = document.querySelectorAll('[id^="contenido-"]');
            contenidos.forEach(function (elemento) {
                elemento.style.display = 'none';
            });

            var contenidoMostrar = document.getElementById('contenido-' + id);
            if (contenidoMostrar) {
                contenidoMostrar.style.display = 'block';
            }
        }
    </script>
</body>

</html>