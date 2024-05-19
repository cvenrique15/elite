<?php

    session_start();
    include '../conexion.php';

    $correo = $_POST['correo'];
    $clave = $_POST['clave'];

    if (!$conexion) {
        die("Error al conectar: " . mysqli_connect_error());
    }
    
    $validar_login = mysqli_query($conexion, "SELECT id_proveedor, nombre, apellido, telefono, correo, raza 
    FROM proveedores WHERE correo='$correo' AND clave='$clave'");

    if(mysqli_num_rows($validar_login) > 0){
        $fila = mysqli_fetch_assoc($validar_login);
        $nombre = $fila['nombre'];

        $_SESSION['id_proveedor'] = $fila['id_proveedor'];
        $_SESSION['nombre'] = $fila['nombre'];
        $_SESSION['apellido'] = $fila['apellido'];
        $_SESSION['telefono'] = $fila['telefono'];
        $_SESSION['correo'] = $fila['correo'];
        $_SESSION['raza'] = $fila['raza'];

        $_SESSION['nombre'] = $nombre;
        header("location: ../../Proveedor/elite.php");
        exit;
    }else{
        echo '
        <script>
            alert("Usuario no existe, por favor verifique los datos");
            window.location = "../../Proveedor/inicio.php";
        </script>
        ';
        exit;
    }


