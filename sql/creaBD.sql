CREATE DATABASE IF NOT EXISTS minijuegos_db;
USE minijuegos_db;

CREATE TABLE minijuego (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    descripcion TEXT,
    url VARCHAR(255) NOT NULL,
    categoria VARCHAR(50)
);

INSERT INTO minijuego (nombre, descripcion, url, categoria) VALUES
('Snake', 'El clásico juego de la serpiente. Come manzanas y no te choques contigo mismo.', 'https://patorjk.com/games/snake/', 'Arcade'),
('Tetris', 'Encaja las piezas geométricas para completar líneas y ganar puntos.', 'https://tetris.com/play-tetris', 'Puzzle'),
('Pac-Man', 'Come todos los puntos del laberinto mientras evitas a los fantasmas.', 'https://www.google.com/logos/2010/pacman10-i.html', 'Arcade'),
('Flappy Bird', 'Vuela entre las tuberías sin chocar. Un desafío de precisión.', 'https://flappybird.io/', 'Habilidad'),
('Sudoku', 'Completa la cuadrícula con números del 1 al 9 sin repetir en filas o columnas.', 'https://sudoku.com/', 'Puzzle'),
('Ajedrez', 'Juego de estrategia clásico. Jaque mate al rey oponente.', 'https://www.chess.com/play/computer', 'Estrategia'),
('Dino Run', 'El famoso juego del dinosaurio de Chrome cuando no hay internet.', 'https://chromedino.com/', 'Arcade'),
('2048', 'Une los números iguales para llegar a la ficha 2048.', 'https://play2048.co/', 'Puzzle'),
('Solitario', 'El clásico juego de cartas para un solo jugador.', 'https://www.google.com/logos/fnbx/solitaire/standalone.html', 'Cartas'),
('Busaminas', 'Encuentra todas las minas sin detonar ninguna.', 'https://minesweeper.online/', 'Puzzle');
