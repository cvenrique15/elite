<?php

    session_start();
    session_destroy();
    header("location: ../../Proveedor/inicio.php");

?>