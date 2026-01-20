<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Lista de Minijuegos</title>
    <link rel="stylesheet" href="css/estilos.css">
</head>

<body>
    <div class="contenedor">
        <h1>Minijuegos Disponibles</h1>

        <!-- Enlace a Login -->
        <div class="acciones-superiores">
            <a href="index.php?c=Login&m=login" class="boton">Iniciar Sesión (Pruebas SQL)</a>
        </div>

        <!-- Buscador Inseguro -->
        <div class="caja-busqueda">
            <form action="index.php?c=Minijuegos&m=buscar" method="POST">
                <label>Buscar Minijuego:</label>
                <input type="text" name="texto" value="<?= isset($busqueda) ? htmlspecialchars($busqueda) : '' ?>">
                <button type="submit">Buscar</button>
            </form>

            <?php if (isset($sql_debug)) { ?>
                <div class="mensaje-depuracion-busqueda">
                    <strong>Consulta SQL Ejecutada:</strong><br>
                    <code><?= htmlspecialchars($sql_debug) ?></code>
                </div>
            <?php } ?>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Categoría</th>
                    <th>Descripción</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($minijuegos as $juego) { ?>
                    <tr>
                        <td>
                            <!-- SANITIZACIÓN: htmlspecialchars() convierte caracteres especiales (<, >, etc.)
                                 en su forma segura para prevenir ataques XSS (Cross-Site Scripting) 
                                 
                                 Si $juego['nombre'] contiene: <script>alert('HACK!')</script>, el navegador ejecutaría ese JavaScript.

                                 -->
                            <a href="index.php?c=Minijuegos&m=añadirHistorial&id=<?= $juego['id'] ?>">
                                <?= htmlspecialchars($juego['nombre']) ?>
                            </a>
                        </td>
                        <td>
                            <?= htmlspecialchars($juego['categoria']) ?>
                        </td>
                        <td>
                            <?= htmlspecialchars($juego['descripcion']) ?>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        <?php if (!empty($historialJuegos)) { ?>
            <div class="historial">
                <h3>Últimos juegos visitados</h3>
                <div class="historial-lista">
                    <?php foreach ($historialJuegos as $juego) { ?>
                        <div class="historial-elemento">
                            <b><?= htmlspecialchars($juego['nombre']) ?></b>
                            <br>
                            <?= htmlspecialchars($juego['categoria']) ?>
                        </div>
                    <?php } ?>
                </div>
            </div>
        <?php } ?>
    </div>
</body>

</html>