<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>
        <?= htmlspecialchars($juego['nombre']) ?>
    </title>
    <link rel="stylesheet" href="css/estilos.css">
</head>

<body>
    <div class="contenedor texto-centrado">
        <h1>
            <?= htmlspecialchars($juego['nombre']) ?>
        </h1>
        <p><strong>Categoría:</strong>
            <?= htmlspecialchars($juego['categoria']) ?>
        </p>
        <p>
            <?= htmlspecialchars($juego['descripcion']) ?>
        </p>

        <br>

        <a href="<?= htmlspecialchars($juego['url']) ?>" class="boton boton-jugar" target="_blank">JUGAR</a>
        <a href="index.php?c=Minijuegos&m=listar" class="boton boton-volver">VOLVER</a>
    </div>
</body>

</html>