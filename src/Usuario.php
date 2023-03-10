<?php

namespace Kawschool;

class Usuario
{
    
    private $config;
    protected $cn = null;
    //constructor de conexion a la BD indicando la ruta del archivo config
    public function __construct()
    {
        $this->config = parse_ini_file(__DIR__ . '/../config.ini');

        $this->cn = new \PDO($this->config['dns'], $this->config['usuario'], $this->config['clave'], array(
            \PDO::MYSQL_ATTR_INIT_COMMAND => ' SET NAMES utf8'
        ));
    }
//funcion de login para la autenticacion del usuario en el carrito de compras
    public function login($nombre, $clave)
    {
        $sql = "SELECT * FROM `usuarios` WHERE nombre_usuario = :nombre AND clave = :clave ";
        $resultado = $this->cn->prepare($sql);

        $_array = array(
            ":nombre" => $nombre,
            ":clave" => $clave
        );

        if ($resultado->execute($_array)) {
            return $resultado->fetch();

            return false;
        }
    }
}
