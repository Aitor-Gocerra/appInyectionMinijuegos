<?php

require_once __DIR__ . '/mConexion.php';

class Minijuego extends Conexion
{

    // Obtener todos los minijuegos
    public function obtenerTodos()
    {
        try {
            // Consulta SQL simple para traer todo de la tabla minijuego
            $sql = '
                    SELECT *
                    FROM minijuego;
                ';
            $stmt = $this->conexion->query($sql);

            // fetchAll devuelve un array con TODAS las filas encontradas.
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $error) {
            return [];
        }
    }

    // Obtener un minijuego por ID
    public function obtenerPorId($id)
    {
        try {
            // Usamos sentencias preparadas (:id) para seguridad contra inyecciones SQL.
            $sql = '
                    SELECT *
                    FROM minijuego
                    WHERE id = :id;
                ';

            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();

            // fetch devuelve UNA sola fila (la primera encontrada).
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $error) {
            return null;
        }
    }

    // Buscador VULNERABLE a SQL Injection
    public function buscar($texto)
    {
        try {
            // VULNERABLE: Directa concatenación
            $sql = "SELECT * FROM minijuego WHERE nombre LIKE '%$texto%'";

            $stmt = $this->conexion->query($sql);

            return [
                'resultados' => $stmt->fetchAll(PDO::FETCH_ASSOC),
                'sql' => $sql
            ];
        } catch (PDOException $error) {
            return [
                'resultados' => [],
                'sql' => $sql ?? 'Error SQL',
                'error' => $error->getMessage()
            ];
        }
    }
}
?>