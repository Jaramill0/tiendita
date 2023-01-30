<?php

namespace Kawschool;
//clase categoria para identificar la pelicula en la cual pertenece 
class Categorias
{
    private $config;
    protected $cn = null;

    public function __construct()
    {
        $this->config = parse_ini_file(__DIR__ . '/../config.ini');

        $this->cn = new \PDO($this->config['dns'], $this->config['usuario'], $this->config['clave'], array(
            \PDO::MYSQL_ATTR_INIT_COMMAND => ' SET NAMES utf8'
        ));
    }

    public function mostrar()
    {
        $sql = "SELECT * FROM categorias ";
        $resultado = $this->cn->query($sql);

        if ($resultado->execute()) {
            return $resultado->fetchAll();

            return false;
        }
    }
}
