<?php

    include '../conexion.php';



    if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $telefono = $_POST['telefono'];
    $correo = $_POST['correo'];
    $raza = $_POST['raza'];
    $clave = $_POST["clave"];

    $query_validar_raza = "SELECT raza FROM material_genetico WHERE raza = '$raza'";
    $resultado_validar_raza = mysqli_query($conexion, $query_validar_raza);

    if (mysqli_num_rows($resultado_validar_raza) == 0) {
        // La raza seleccionada no está en la base de datos, mostrar mensaje y detener el registro
        echo '<script>alert("La raza seleccionada no está disponible. Por favor elija una raza válida."); window.location.href = "../../Proveedor/inicio.php";</script>';
        exit; // Detener la ejecución del código
    }

    if (!empty($nombre) && !empty($apellido) && !empty($telefono) && !empty($correo) && !empty($clave)) {

    $query = "INSERT INTO proveedores(nombre, apellido, telefono, correo, raza, clave) 
        VALUES('$nombre', '$apellido', '$telefono', '$correo', '$raza', '$clave')";

    $ejecutar = mysqli_query($conexion, $query);

    if($ejecutar){
        echo '
        <script>
        alert("Usuario almacenado exitosamente");
        window.location = "../../Proveedor/inicio.php";
        </script>
        ';
    }else{
        echo '
        <script>
        alert("Intentelo de nuevo usuario no almacenado");
        window.location = "../../Proveedor/inicio.php";
        </script>
        ';

    }

}else {
    echo "<script>alert('Faltan valores por ingresar.'); window.location.href = '../../Cliente/inicio.php';</script>";
}

    mysqli_close($conexion);

}

    
?>