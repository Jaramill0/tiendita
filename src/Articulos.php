<?php

namespace Kawschool;

class Articulos
{
    //Conexion a la BD Mejorada con un Constructor mas simple 
    private $config;
    protected $cn = null;

    public function __construct()
    {
        $this->config = parse_ini_file(__DIR__ . '/../config.ini');

        $this->cn = new \PDO($this->config['dns'], $this->config['usuario'], $this->config['clave'], array(
            \PDO::MYSQL_ATTR_INIT_COMMAND => ' SET NAMES utf8'
        ));
    }
//funcion para registrar la pelicula mediante una consulta SQL
    public function registrar($_params)
    {
        $sql = "INSERT INTO `peliculas`(`titulo`, `descripcion`, `foto`, `precio`, `categoria_id`, `fecha`) 
        VALUES (:titulo,:descripcion,:foto,:precio,:categoria_id,:fecha)";

        $resultado = $this->cn->prepare($sql);

        $_array = [
            ':titulo' => $_params['titulo'],
            ':descripcion' => $_params['descripcion'],
            ':foto' => $_params['foto'],
            ':precio' => $_params['precio'],
            ':categoria_id' => $_params['categoria_id'],
            ':fecha' => $_params['fecha'],
        ];
        if ($resultado->execute($_array))
            return true;

        return false;
    }
    //Mejoras en la funcion Actualizar para el registro de la pelicula y guardar cambios
    public function actualizar($_params)
    {
        $sql = "UPDATE `peliculas` SET `titulo`=:titulo,`descripcion`=:descripcion,`foto`=:foto,`precio`=:precio,`categoria_id`=:categoria_id,`fecha`=:fecha
        WHERE `id`= :id";

//implemento el metodo Query para ejecutar la consulta
        $resultado = $this->cn->query($sql);

        $_array = [
            ':titulo' => $_params['titulo'],
            ':descripcion' => $_params['descripcion'],
            ':foto' => $_params['foto'],
            ':precio' => $_params['precio'],
            ':categoria_id' => $_params['categoria_id'],
            ':fecha' => $_params['fecha'],
            ':id' => $_params['id']
        ];
        if ($resultado->execute($_array))
            return true;

        return false;
    }
    //funcion para eliminar el registro que el usuario ejecute en articulos
    public function  eliminar($id)
    {
        $sql = "DELETE FROM `peliculas`  WHERE `id`=:id";

        $resultado = $this->cn->prepare($sql);

        $_array = array(
            ':id' => $id
        );
        if ($resultado->execute($_array))
            return true;

        return false;
    }
    //funcion para mostrar los registros de las peliculas agregadas en la tabla
    public function mostrar()
    {
         $sql = "SELECT peliculas.id, titulo, descripcion,foto,nombre,precio,fecha,estado FROM peliculas
        INNER JOIN categorias 
        ON peliculas.categoria_id = categorias.id ORDER BY peliculas.id DESC ";

        $resultado = $this->cn->query($sql);

        if ($resultado->execute()) {
            return $resultado->fetchAll();

            return false;
        }
    }
    //indicando la funcion mostrar por Id
    public function mostrarPorId($id)
    {
        $sql = "SELECT * FROM `peliculas` WHERE `id`=:id ";
        $resultado = $this->cn->prepare($sql);

        $_array = array(
            ":id" => $id
        );

        if ($resultado->execute($_array)) {
            return $resultado->fetch();

            return false;
        }
    }
}
