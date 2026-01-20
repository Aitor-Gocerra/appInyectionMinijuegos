<?php
require_once 'models/mConexion.php';

class Instalador extends Conexion
{
    public function __construct()
    {
        // Sobrescribimos el constructor para conectar SIN base de datos primero
        // Así podemos crearla si no existe.
        try {
            $this->conexion = new PDO(
                "mysql:host=" . servidor . ";charset=UTF8",
                usuario,
                contraseña,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false
                ]
            );
        } catch (PDOException $error) {
            die("Error de conexión: " . $error->getMessage());
        }
    }

    public function crearBaseDatos()
    {
        try {
            // 1. Crear Base de Datos
            $sqlDB = "
                CREATE DATABASE IF NOT EXISTS " . nombreBaseDatos;

            $this->conexion->exec($sqlDB);
            echo "Base de datos '" . nombreBaseDatos . "' verificada/creada.<br>";

            // 2. Seleccionar la Base de Datos
            $this->conexion->exec("USE " . nombreBaseDatos);

            // 3. Crear Tabla
            $sqlTabla = "
                CREATE TABLE IF NOT EXISTS minijuego (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    nombre VARCHAR(100) NOT NULL,
                    descripcion TEXT,
                    url VARCHAR(255) NOT NULL,
                    categoria VARCHAR(50)
                );
            ";
            $this->conexion->exec($sqlTabla);
            echo "Tabla 'minijuego' verificada/creada.<br>";

            // 4. Crear Tabla Usuarios
            $sqlTablaUsr = "
                CREATE TABLE IF NOT EXISTS usuarios (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    usuario VARCHAR(50) NOT NULL,
                    password VARCHAR(255) NOT NULL
                );
            ";
            $this->conexion->exec($sqlTablaUsr);
            echo "Tabla 'usuarios' verificada/creada.<br>";

        } catch (PDOException $e) {
            die("Error al crear BD/Tabla: " . $e->getMessage());
        }
    }

    public function insertarDatos()
    {
        // Aseguramos que estamos usando la BD correcta por si acaso
        $this->conexion->exec("USE " . nombreBaseDatos);

        $juegos = [
            [
                'nombre' => 'Snake',
                'descripcion' => 'El clásico juego de la serpiente. Come manzanas y no te choques contigo mismo.',
                'url' => 'https://patorjk.com/games/snake/',
                'categoria' => 'Arcade'
            ],
            [
                'nombre' => 'Tetris',
                'descripcion' => 'Encaja las piezas geométricas para completar líneas y ganar puntos.',
                'url' => 'https://tetris.com/play-tetris',
                'categoria' => 'Puzzle'
            ],
            [
                'nombre' => 'Pac-Man',
                'descripcion' => 'Come todos los puntos del laberinto mientras evitas a los fantasmas.',
                'url' => 'https://www.google.com/logos/2010/pacman10-i.html',
                'categoria' => 'Arcade'
            ],
            [
                'nombre' => 'Flappy Bird',
                'descripcion' => 'Vuela entre las tuberías sin chocar. Un desafío de precisión.',
                'url' => 'https://flappybird.io/',
                'categoria' => 'Habilidad'
            ],
            [
                'nombre' => 'Sudoku',
                'descripcion' => 'Completa la cuadrícula con números del 1 al 9 sin repetir en filas o columnas.',
                'url' => 'https://sudoku.com/',
                'categoria' => 'Puzzle'
            ],
            [
                'nombre' => 'Ajedrez',
                'descripcion' => 'Juego de estrategia clásico. Jaque mate al rey oponente.',
                'url' => 'https://www.chess.com/play/computer',
                'categoria' => 'Estrategia'
            ],
            [
                'nombre' => 'Dino Run',
                'descripcion' => 'El famoso juego del dinosaurio de Chrome cuando no hay internet.',
                'url' => 'https://chromedino.com/',
                'categoria' => 'Arcade'
            ],
            [
                'nombre' => '2048',
                'descripcion' => 'Une los números iguales para llegar a la ficha 2048.',
                'url' => 'https://play2048.co/',
                'categoria' => 'Puzzle'
            ],
            [
                'nombre' => 'Solitario',
                'descripcion' => 'El clásico juego de cartas para un solo jugador.',
                'url' => 'https://www.google.com/logos/fnbx/solitaire/standalone.html',
                'categoria' => 'Cartas'
            ],
            [
                'nombre' => 'Busaminas',
                'descripcion' => 'Encuentra todas las minas sin detonar ninguna.',
                'url' => 'https://minesweeper.online/',
                'categoria' => 'Puzzle'
            ]
        ];

        try {

            $sql = "
                INSERT INTO minijuego (nombre, descripcion, url, categoria) 
                VALUES (:nombre, :descripcion, :url, :categoria)
                ";

            $stmt = $this->conexion->prepare($sql);

            echo "<h2>Iniciando carga masiva de datos...</h2>";

            foreach ($juegos as $juego) {

                $stmt->bindParam(':nombre', $juego['nombre'], PDO::PARAM_STR);
                $stmt->bindParam(':descripcion', $juego['descripcion'], PDO::PARAM_STR);
                $stmt->bindParam(':url', $juego['url'], PDO::PARAM_STR);
                $stmt->bindParam(':categoria', $juego['categoria'], PDO::PARAM_STR);

                $stmt->execute();

                echo "Insertado juego: " . $juego['nombre'] . "<br>";
            }

            // Insertar Usuarios de Prueba
            $usuarios = [
                ['usuario' => 'admin', 'password' => 'admin123'],
                ['usuario' => 'aitor', 'password' => 'aitor123']
            ];

            $sqlUsr = "
                INSERT INTO usuarios (usuario, password) 
                VALUES (:usuario, :password)";

            $stmtUsr = $this->conexion->prepare($sqlUsr);

            foreach ($usuarios as $usuario) {
                // Verificamos si ya existen para no duplicar en recargas
                $check = $this->conexion->query("SELECT count(*) FROM usuarios WHERE usuario = '" . $usuario['usuario'] . "'")->fetchColumn();

                if ($check == 0) {
                    $stmtUsr->bindParam(':usuario', $usuario['usuario']);
                    $stmtUsr->bindParam(':password', $usuario['password']);
                    $stmtUsr->execute();
                    echo "Insertado usuario: " . $usuario['usuario'] . "<br>";
                }
            }

            echo "<h3>¡Carga completada con éxito!</h3>";

        } catch (PDOException $e) {
            echo "<h3 style='color:red'>Error durante la carga: " . $e->getMessage() . "</h3>";
        }
    }
}

// Ejecutamos el instalador
$instalador = new Instalador();
$instalador->crearBaseDatos(); // Primero creamos BD y Tablas
$instalador->insertarDatos();  // Luego insertamos

?>