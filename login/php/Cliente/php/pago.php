<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pago</title>
    <link rel="stylesheet" href="estilos.css">
    <style>
        /* Estilos para el formulario de pago */
        .formulario-pago {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            border-radius: 10px;
            background-color: #f5f5f5;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        .formulario-pago h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        .input-group {
            margin-bottom: 15px;
        }
        .input-group label {
            display: block;
            margin-bottom: 5px;
        }
        .input-group input {
            width: 100%;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        .input-group input:focus {
            outline: none;
            border-color: #007bff;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
        }
        .boton-pagar {
            display: block;
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 5px;
            background-color: #007bff;
            color: #fff;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .boton-pagar:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <header>
        <h1>Proceso de Pago</h1>
        <a href="carrito.php" class="volver">Volver al Carrito</a>
    </header>

    <main>
        <div class="formulario-pago">
            <h2>Ingrese los datos de su tarjeta</h2>
            <form action="procesar_pago.php" method="post">
                <div class="input-group">
                    <label for="nombre">Nombre en la Tarjeta:</label>
                    <input type="text" id="nombre" name="nombre" required>
                </div>
                <div class="input-group">
                    <label for="numero_tarjeta">Número de Tarjeta:</label>
                    <input type="text" id="numero_tarjeta" name="numero_tarjeta" required>
                </div>
                <div class="input-group">
                    <label for="fecha_expiracion">Fecha de Expiración:</label>
                    <input type="text" id="fecha_expiracion" name="fecha_expiracion" placeholder="MM/YY" required>
                </div>
                <div class="input-group">
                    <label for="codigo_seguridad">Código de Seguridad:</label>
                    <input type="text" id="codigo_seguridad" name="codigo_seguridad" maxlength="3" required>
                </div>
                <button type="submit" class="boton-pagar">Pagar</button>
            </form>
        </div>
    </main>
</body>
</html>





