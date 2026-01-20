<?php
require_once 'models/mMinijuego.php';

class CMinijuegos
{

    public $vista;
    private $modelo;

    public function __construct()
    {
        $this->modelo = new Minijuego();
        $this->vista = '';
        $this->inicializarCookies();
    }

    private function inicializarCookies()
    {
        // Crear cookie de historial si no existe
        if (!isset($_COOKIE['historial'])) {
            setcookie('historial', json_encode([]), time() + (86400 * 30), "/");
        }

    }

    public function listar()
    {
        // Obtener listado de juegos
        $minijuegos = $this->modelo->obtenerTodos();

        // Obtener historial
        $historialJuegos = $this->obtenerHistorial();

        $this->vista = 'lista';
        return [
            'minijuegos' => $minijuegos,
            'historialJuegos' => $historialJuegos
        ];
    }

    public function buscar($datos)
    {
        $texto = isset($datos['texto']) ? $datos['texto'] : '';
        $resultado = $this->modelo->buscar($texto);

        // Obtener historial (para mantener el layout)
        $historialJuegos = $this->obtenerHistorial();

        $this->vista = 'lista';
        return [
            'minijuegos' => $resultado['resultados'],
            'historialJuegos' => $historialJuegos,
            'sql_debug' => $resultado['sql'],
            'busqueda' => $texto
        ];
    }

    public function añadirHistorial()
    {

        if (isset($_GET['id'])) {
            $id = intval($_GET['id']);
            $juego = $this->modelo->obtenerPorId($id);

            if ($juego) {
                // Obtener historial actual
                $historialAntiguo = [];
                if (isset($_COOKIE['historial'])) {
                    $historialAntiguo = json_decode($_COOKIE['historial'], true);
                }

                // Asegurar que sea un array
                if (!is_array($historialAntiguo)) {
                    $historialAntiguo = [];
                }

                // Crear nuevo historial con el juego actual primero
                $nuevoHistorial = [$id];

                // Añadir los demás juegos (sin repetir el actual)
                foreach ($historialAntiguo as $idJuegoAntiguo) {
                    if ($idJuegoAntiguo != $id) {
                        $nuevoHistorial[] = $idJuegoAntiguo;
                    }
                }

                // Limitar el historial a los últimos 10 juegos
                $nuevoHistorial = array_slice($nuevoHistorial, 0, 10);

                // Actualizar cookie
                setcookie('historial', json_encode($nuevoHistorial), time() + (86400 * 30), "/");

                $this->vista = 'detalle';
                return ['juego' => $juego];
            }
        }

        // Si falla, volver al listado
        return $this->listar();
    }

    private function obtenerHistorial()
    {
        $historialJuegos = [];

        if (isset($_COOKIE['historial'])) {
            $idsHistorial = json_decode($_COOKIE['historial'], true);

            if (is_array($idsHistorial)) {
                foreach ($idsHistorial as $histId) {
                    $juego = $this->modelo->obtenerPorId($histId);
                    if ($juego) {
                        $historialJuegos[] = $juego;
                    }
                }
            }
        }

        return $historialJuegos;
    }
}
?>