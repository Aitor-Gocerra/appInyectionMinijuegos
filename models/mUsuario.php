<?php

require_once __DIR__ . '/mConexion.php';

class Usuario extends Conexion
{

    public function login($usuario, $password)
    {
        try {
            // VULNERABLE: Concatenación directa de strings sin sanitizar
            $sql = "SELECT * FROM usuarios WHERE usuario = '$usuario' AND password = '$password'";
            
            // Ejecutamos la query directamente
            $stmt = $this->conexion->query($sql);

            // Devolvemos el resultado y la query para mostrarla (EDUCTATIVO)
            return [
                'usuario' => $stmt->fetch(PDO::FETCH_ASSOC),
                'sql' => $sql
            ];
            
        } catch (PDOException $error) {
            // En caso de error SQL (muy probable en inyecciones), lo devolvemos también
            return [
                'usuario' => null,
                'sql' => $sql ?? 'Error generando SQL',
                'error' => $error->getMessage()
            ];
        }
    }
}
?>
