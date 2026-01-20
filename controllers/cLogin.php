<?php
require_once 'models/mUsuario.php';

class CLogin
{
    public $vista;
    private $modelo;

    public function __construct()
    {
        $this->modelo = new Usuario();
        $this->vista = 'login';
    }

    public function login($datos)
    {
        $resultado = [];

        if (isset($datos['usuario']) && isset($datos['password'])) {
            $resultado = $this->modelo->login($datos['usuario'], $datos['password']);
        }

        $this->vista = 'login';
        return $resultado;
    }
}
?>