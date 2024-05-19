<?php
session_start();

// Datos de conexión a la base de datos
$dsn = 'mysql:host=localhost;dbname=bd_sistema';
$usuario = 'root';
$contraseña = '';

try {
    // Crear conexión PDO
    $conexion = new PDO($dsn, $usuario, $contraseña);
    // Configurar el modo de error y excepción
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Error de conexión: ' . $e->getMessage();
    die();
}

$nombre = "";
$apellido = "";
$telefono = "";
$correo = "";

// Verificar si el proveedor está autenticado
if (isset($_SESSION["id_cliente"])) {
    // Obtener los datos del proveedor de la sesión
    $nombre = $_SESSION["nombre"];
    $apellido = $_SESSION["apellido"];
    $telefono = $_SESSION["telefono"];
    $correo = $_SESSION["correo"];
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["actualizar"])) {
    // Obtener datos del formulario
    $nombre = $_POST["nombre"];
    $apellido = $_POST["apellido"];
    $telefono = $_POST["telefono"];
    $correo = $_POST["correo"];
    $clave_nueva = $_POST["clave_nueva"];

    // Consulta SQL para verificar si los nuevos valores de teléfono y correo ya existen en la base de datos
    $consulta_existencia = "SELECT id_cliente FROM clientes WHERE (telefono = :telefono AND telefono <> :telefono_anterior) OR (correo = :correo AND correo <> :correo_anterior)";
    $stmt_existencia = $conexion->prepare($consulta_existencia);
    $stmt_existencia->bindParam(':telefono', $telefono);
    $stmt_existencia->bindParam(':telefono_anterior', $_SESSION["telefono"]);
    $stmt_existencia->bindParam(':correo', $correo);
    $stmt_existencia->bindParam(':correo_anterior', $_SESSION["correo"]);
    $stmt_existencia->execute();
    $resultado_existencia = $stmt_existencia->fetch(PDO::FETCH_ASSOC);

    if ($resultado_existencia) {
        $mensaje_error_actualizacion = "El teléfono o correo electrónico ya están en uso por otro proveedor. Proporcione valores únicos.";
    } else {
        // Consulta SQL para actualizar datos del proveedor (solo si hay cambios en teléfono, correo o clave)
        $consulta_actualizar = "UPDATE clientes SET nombre = :nombre, apellido = :apellido";
        $params = array(':nombre' => $nombre, ':apellido' => $apellido);
        
        // Agregar la actualización de teléfono, correo y clave solo si son diferentes a los actuales
        if ($telefono !== $_SESSION["telefono"]) {
            $consulta_actualizar .= ", telefono = :telefono";
            $params[':telefono'] = $telefono;
        }
        if ($correo !== $_SESSION["correo"]) {
            $consulta_actualizar .= ", correo = :correo";
            $params[':correo'] = $correo;
        }
        if (!empty($clave_nueva)) {
            $consulta_actualizar .= ", clave = :clave_nueva";
            $params[':clave_nueva'] = $clave_nueva;
        }

        $consulta_actualizar .= " WHERE id_cliente = :id_cliente";
        $stmt_actualizar = $conexion->prepare($consulta_actualizar);
        foreach ($params as $key => &$val) {
            $stmt_actualizar->bindParam($key, $val);
        }
        $stmt_actualizar->bindParam(':id_cliente', $_SESSION["id_cliente"]);
        $stmt_actualizar->execute();

        $mensaje_actualizacion = "Datos actualizados correctamente.";

        // Actualizar los datos del proveedor en la variable de sesión para reflejar los cambios en la página
        $_SESSION["nombre"] = $nombre;
        $_SESSION["apellido"] = $apellido;
        $_SESSION["telefono"] = $telefono;
        $_SESSION["correo"] = $correo;
    }
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Cuenta - Cliente</title>
    <link rel="stylesheet"  href="cliente.css">
    <style>
        /* Estilo para los campos que no se actualizan */
        .no-actualizado {
            background-color: #f2f2f2; /* Cambiar el color de fondo según tu preferencia */
            opacity: 0.7; /* Cambiar la opacidad según tu preferencia (valores entre 0 y 1) */
        }
    </style>
</head>
<body>
    <?php if (isset($_SESSION["id_cliente"])) : ?>
        <!-- Si el proveedor está autenticado, mostrar el formulario de actualización -->
        <h2>Datos del Proveedor</h2>
        <p>ID: <?php echo $_SESSION["id_cliente"]; ?></p>
        <p>Nombre: <?php echo $_SESSION["nombre"]; ?></p>
        <p>Apellido: <?php echo $_SESSION["apellido"]; ?></p>
        <p>Teléfono: <?php echo $_SESSION["telefono"]; ?></p>
        <p>Correo: <?php echo $_SESSION["correo"]; ?></p>

        <h2>Actualizar Datos</h2>
        <?php if (isset($mensaje_error_actualizacion)) echo "<p>$mensaje_error_actualizacion</p>"; ?>
        <?php if (isset($mensaje_actualizacion)) echo "<p>$mensaje_actualizacion</p>"; ?>
        <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="POST">
            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" value="<?php echo $_SESSION["nombre"]; ?>" <?php if ($_SESSION["nombre"] == $nombre) echo 'class="no-actualizado"'; ?>><br>

            <label for="apellido">Apellido:</label>
            <input type="text" id="apellido" name="apellido" value="<?php echo $_SESSION["apellido"]; ?>" <?php if ($_SESSION["apellido"] == $apellido) echo 'class="no-actualizado"'; ?>><br>

            <label for="telefono">Teléfono:</label>
            <input type="text" id="telefono" name="telefono" value="<?php echo $_SESSION["telefono"]; ?>" <?php if ($_SESSION["telefono"] == $telefono) echo 'class="no-actualizado"'; ?>><br>

            <label for="correo">Correo electrónico:</label>
            <input type="email" id="correo" name="correo" value="<?php echo $_SESSION["correo"]; ?>" <?php if ($_SESSION["correo"] == $correo) echo 'class="no-actualizado"'; ?>><br>

            <label for="clave_nueva">Nueva Clave:</label>
            <input type="password" id="clave_nueva" name="clave_nueva"><br>

            <input type="submit" name="actualizar" value="Actualizar Datos">
        </form>
    <?php else : ?>
        <!-- Si el proveedor no está autenticado, mostrar el formulario de inicio de sesión -->
        <h1>Iniciar Sesión</h1>
        <?php if (isset($mensaje_error)) echo "<p>$mensaje_error</p>"; ?>
        <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="POST">
            <label for="correo">Correo electrónico:</label>
            <input type="email" id="correo" name="correo" required><br>

            <label for="clave">Clave:</label>
            <input type="password" id="clave" name="clave" required><br>

            <input type="submit" value="Iniciar Sesión" name="iniciar_sesion">
        </form>
    <?php endif; ?>


    <a href="../../../cliente/elite.php" class="btn">Regresar</a>
</body>
</html>