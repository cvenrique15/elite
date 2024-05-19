<?php

    include '../conexion.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $telefono = $_POST['telefono'];
    $correo = $_POST['correo'];
    $clave = $_POST["clave"];

    if (!empty($nombre) && !empty($apellido) && !empty($telefono) && !empty($correo) && !empty($clave)) {

    $query = "INSERT INTO clientes(nombre, apellido, telefono, correo, clave) 
        VALUES('$nombre', '$apellido', '$telefono', '$correo', '$clave')";

    
    $ejecutar = mysqli_query($conexion, $query);

    if($ejecutar){
        echo '
        <script>
        alert("Usuario almacenado exitosamente");
        window.location = "../../Cliente/inicio.php";
        </script>
        ';
    }else{
        echo '
        <script>
        alert("Intentelo de nuevo usuario no almacenado");
        window.location = "../../Cliente/inicio.php";
        </script>
        ';

    }

    }else {
        echo "<script>alert('Faltan valores por ingresar.'); window.location.href = '../../Cliente/inicio.php';</script>";
    }

    mysqli_close($conexion);
    
    }

?>