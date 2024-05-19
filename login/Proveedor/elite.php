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

$id_proveedor = $_SESSION["id_proveedor"];
$nombre = $_SESSION["nombre"];
$apellido = $_SESSION["apellido"];
$telefono = $_SESSION["telefono"];
$correo = $_SESSION["correo"];
$raza = $_SESSION["raza"];


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Elite</title>
    <link rel="stylesheet" href="../css/inicio.css">
</head>

<body style="background-image: url('https://th.bing.com/th/id/OIP.mX2CKLsZxkV_B6qUjJ_n-QHaHa?w=192&h=192&c=7&r=0&o=5&dpr=2&pid=1.7'); background-size: cover; background-position: center;">
<body>
    <div class="inicio">Proveedor</div>
    <header class="encabezado">
        <nav>
            <div><img src="../img/bg5.cms" alt=""></div>
            <div class="user-area"><?php echo "Bienvenido $nombre"; ?></div>
            <ul>
                <li><a href="#" onclick="mostrarContenido('inicio')">Inicio</a></li>
                <li>
                    <a href="#" onclick="mostrarContenido('material-genetico')">Material-Genético</a>
                    <ul>
                        <li><a href="#" onclick="mostrarContenido('agregar')">Agregar Material Genético</a></li>
                        <li><a href="../php/proveedor/php/realizar_venta.php" >Realizar una venta</a></li>
                        <li>
                            <a href="#">Mis ventas</a>
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
                        <li><a href="../php/proveedor/php/configuracion.php" >Configuración</a></li>
                        <li><a href="../php/Proveedor/cerrar_sesion.php">Cerrar Sesión</a></li>
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
        </nav>
    </header>

    <div id="contenido-inicio">
        <h1>BIENVENIDO A LA SECCION DE PROVEEDORES</h1>
    <h2>¡Gracias por usar nuestro sistema! </h2>
   <ul>
    <h2>Aquí tienes un resumen de tu cuenta:</h2>
</ul>
    <h2>-----ACCIONES RAPIDAS-----</h2>
    <ul>
        <li><a href="#" onclick="mostrarContenido('agregar')">Agregar Material Genético</a></li>
        <li><a href="../php/proveedor/php/realizar_venta.php">Realizar una Venta</a></li>
        <li><a href="#" onclick="mostrarContenido('mis-ventas')">Ver Mis Ventas</a></li>
        <li><a href="../php/proveedor/php/configuracion.php">Configurar mi Cuenta</a></li>
        <li><a href="../index.php">Volver al Inicio</a></li>
    
    </ul>
    <style>
    /* Estilo para los contenedores de las secciones */
    .seccion {
        margin-bottom: 20px;
        width: 600px; /* Ancho específico */
        height: auto; /* Altura automática para ajustarse al contenido */
    }

    /* Estilo para los títulos de las secciones */
    .seccion h2 {
        color: #333;
    }

    /* Estilo para los elementos de las listas */
    .seccion ul {
        list-style-type: none;
        padding: 0;
    }

    /* Estilo para los elementos de las listas */
    .seccion ul li {
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
        margin-bottom: 5px;
        background-color: #f9f9f9;
    }

    /* Estilo para los contenedores de imágenes y su información */
    .recuadro {
        margin-bottom: 15px;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
        background-color: #fff;
    }

    /* Estilo para las imágenes dentro de los contenedores */
    .recuadro img {
        width: 500px; 
        height: 400px; 
        display: block; 
        margin: 0 auto; 
    }

    /* Estilo para los títulos de la información */
    .recuadro h3 {
        color: #333;
        font-size: 18px;
        margin-top: 10px;
    }

    /* Estilo para el texto de la información */
    .recuadro p {
        margin: 5px 0;
    }
</style>

    <!-- Sección de Últimos Sementales Vendidos -->
    <div class="seccion">
        <h2>Últimas muestras vendidas</h2>
        <div class="recuadro">
        <img src="https://th.bing.com/th/id/OIP.SFqY8gYUCQc2-9-3QyoynAHaFG?w=245&h=180&c=7&r=0&o=5&dpr=2&pid=1.7" alt="Imagen 2">
        <h3>Simmental </h3>
        <p>Edad:39 meses</p>
        <p>Calidad: Excelente</p>
        <p>Peso: 940kg</p>
    </div>
    <div class="recuadro">
        <img src="https://th.bing.com/th/id/OIP.N4fL33YT9H9yL4F_2qReBAHaFS?w=250&h=180&c=7&r=0&o=5&dpr=2&pid=1.7" alt="Imagen 3">
        <h3>Raza: Brangus</h3>
        <p>Edad: 28 meses</p>
        <p>Calidad: Excelente</p>
        <p>Peso: 900kg</p>
    </div>
</div>
    <h2>Notificaciones</h2>
    <p>No hay notificaciones pendientes en este momento.</p>
 
</div>

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
    $consulta = "SELECT mg.id_material_genetico, mg.raza, mg.precio,
    dm.calidad,dm.principal_uso, dm.cruza, dm.origen, dm.caracteristicas
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
            echo '<td>' . $fila['precio'] . '</td>';
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


    <div id="contenido-agregar" style="display: none;">
        <h1>Contenido de agregar material genetico</h1><br><br>

        <?php


// Verificar si el proveedor está autenticado
if (!isset($_SESSION['id_proveedor'])) {
    header("Location: inicio.php"); // Redirigir al login si no está autenticado
    exit;
}

// Configuración de la conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$database = "bd_sistema";

// Crear la conexión
$conexion = new mysqli($servername, $username, $password, $database);

// Verificar la conexión
if ($conexion->connect_error) {
    die("Error en la conexión: " . $conexion->connect_error);
}

// Obtener los datos del proveedor desde la sesión
$proveedor_id = $_SESSION['id_proveedor'];
$query_proveedor = "SELECT nombre, apellido, telefono, correo, clave FROM proveedores WHERE id_proveedor = $proveedor_id";
$resultado_proveedor = mysqli_query($conexion, $query_proveedor);
$proveedor = mysqli_fetch_assoc($resultado_proveedor);

// Verifica si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $id_material_genetico_array = $_POST['raza']; // Array de IDs de materiales genéticos seleccionados

    // Insertar la asociación en la tabla proveedor_material_genetico para cada material genético seleccionado
    foreach ($id_material_genetico_array as $id_material_genetico) {
        $query_insert_asociacion = "INSERT INTO proveedor_material_genetico (proveedor_id, material_genetico_id)
                                    VALUES ($proveedor_id, $id_material_genetico)";
        $resultado_insert_asociacion = mysqli_query($conexion, $query_insert_asociacion);
    }

    // Cerrar la conexión
    mysqli_close($conexion);

    // Redireccionar a otra página o mostrar un mensaje de éxito
    header("Location: otra_pagina.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agregar Material Genético</title>
</head>
<body>

<?php echo "Su raza principal es: $raza"; ?><br><br><br>

<?php

$query = "
    SELECT 
        p.raza AS raza_proveedor,
        mg.raza AS raza_material_genetico
    FROM 
        proveedores p
    JOIN 
        proveedor_material_genetico pmg ON p.id_proveedor = pmg.proveedor_id
    JOIN 
        material_genetico mg ON pmg.material_genetico_id = mg.id_material_genetico
    WHERE 
        p.id_proveedor = ?
";

// Preparar y ejecutar la declaración
$stmt = $conexion->prepare($query);
$stmt->bind_param("i", $proveedor_id); // "i" indica que el parámetro es un entero
$stmt->execute();
$resultado = $stmt->get_result();

// Mostrar los resultados
while ($fila = $resultado->fetch_assoc()) {
    echo "Raza del material genético: " . $fila['raza_material_genetico'] . "<br>";
}

?><br>

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    <label for="raza">Raza:</label>
    <select id="raza" name="raza[]" multiple required>
        <option value="">Seleccione la raza</option>
        <?php
        $query_razas = "SELECT id_material_genetico, raza FROM material_genetico";
        $resultado_razas = mysqli_query($conexion, $query_razas);

        if (mysqli_num_rows($resultado_razas) > 0) {
            while ($row = mysqli_fetch_assoc($resultado_razas)) {
                echo "<option value='" . $row['id_material_genetico'] . "'>" . $row['raza'] . "</option>";
            }
        }
        ?>
    </select><br>

    <input type="submit" value="Agregar">
</form>

</body>
</html>

<?php
mysqli_close($conexion); // Cerrar la conexión al final del script
?>



    </div>

    <div id="contenido-finalizados" style="display: none;">
        <h1>Contenido de Mis ventas finalizadas</h1>

        <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ventas</title>
</head>
<body>
    <h1>Mis ventas</h1><br><br>

<?php


$dsn = 'mysql:host=localhost;dbname=bd_sistema;charset=utf8mb4';
$usuario = 'root';
$contraseña = '';

try {
    $conexion = new PDO($dsn, $usuario, $contraseña);
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Obtener el ID del proveedor de la sesión
    $id_proveedor = $_SESSION['id_proveedor'];

    // Consulta SQL para seleccionar las compras del proveedor actual
    $consulta = "SELECT * FROM compras WHERE proveedor_id = :id_proveedor";
                 
    $stmt = $conexion->prepare($consulta);
    $stmt->bindParam(':id_proveedor', $id_proveedor, PDO::PARAM_INT);
    $stmt->execute();

    // Obtener los resultados de la consulta
    $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($resultados) {
        // Imprimir la tabla HTML con los resultados
        echo '<table border="1">';
        echo '<tr><th>ID Compra</th><th>Material Genético ID</th><th>Cantidad</th><th>Fecha Compra</th><th>Proveedor ID</th></tr>';
        foreach ($resultados as $fila) {
            echo '<tr>';
            echo '<td>' . $fila['id_compras'] . '</td>';
            echo '<td>' . $fila['material_genetico_id'] . '</td>';
            echo '<td>' . $fila['cantidad'] . '</td>';
            echo '<td>' . $fila['fecha_compra'] . '</td>';
            echo '<td>' . $fila['proveedor_id'] . '</td>';
            echo '</tr>';
        }
        echo '</table>';
    } else {
        echo 'No se encontraron compras para este proveedor.';
    }
} catch (PDOException $e) {
    echo 'Error de conexión: ' . $e->getMessage();
}
?>
    
</body>
<br><br>


</html>
    </div>

    <div id="contenido-mi-perfil" style="display: none;">
        <h1>Contenido de Mi perfil</h1><br><br>
            <h2>
                <?php echo "Id-Proveedor ! $id_proveedor !"; ?>
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
             <h2>
                <?php echo "raza ! $raza !"; ?>
                
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
