<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Login Inseguro</title>
    <link rel="stylesheet" href="css/estilos.css">
</head>

<body>
    <div class="contenedor">
        <h1>Login (Inyección SQL habilitada)</h1>

        <form action="index.php?c=Login&m=login" method="POST">
            <label>Usuario:</label>
            <input type="text" name="usuario" required>
            <br>
            <label>Contraseña:</label>
            <input type="password" name="password" required>
            <br>
            <button type="submit">Entrar</button>
        </form>
        <br>
        <a href="index.php" class="boton">Volver al Inicio</a>

        <!-- Debug SQL -->
        <?php if (isset($sql)) { ?>
            <div class="caja-depuracion-sql">
                <h3>Consulta SQL Ejecutada:</h3>
                <code class="bloque-codigo-sql"><?= htmlspecialchars($sql) ?></code>
            </div>
        <?php } ?>

        <!-- Resultado -->
        <?php if (isset($usuario) && $usuario) { ?>
            <div class="caja-exito-login">
                <h3>Login Exitoso!</h3>
                <p>Bienvenido, <strong>
                        <?= htmlspecialchars($usuario['usuario']) ?>
                    </strong></p>
                <pre><?= print_r($usuario, true) ?></pre>
            </div>
        <?php } elseif (isset($usuario)) { ?>
            <div class="mensaje-error-login">Login Incorrecto</div>
        <?php } ?>
    </div>
</body>

</html>