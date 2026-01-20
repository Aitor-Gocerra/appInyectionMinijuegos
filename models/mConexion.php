<?php
require_once __DIR__ . '/../config/configDB.php';

    class Conexion{

        protected $conexion;

        public function __construct()
        {

            $this->conexion = new PDO(
                "mysql:host=" . servidor .
                ";dbname=" . nombreBaseDatos . ";charset=UTF8",
                usuario,
                contraseña,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false
                ]
            );
        }

        public function __destruct()
        {
            $this->conexion = null;
        }
    }
?>