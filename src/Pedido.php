<?php

namespace Kawschool;

class Pedido
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
//funcion registrar pedido del producto 
    public function registrar($_params)
    {
        $sql = " INSERT INTO `pedidos`( `cliente_id`, `total`, `fecha`) VALUES (:cliente_id,:total,:fecha)";

        //cambio de metodo prepare por query
        $resultado = $this->cn->query($sql);

        $_array = [
            ':cliente_id' => $_params['cliente_id'],
            ':total' => $_params['total'],
            ':fecha' => $_params['fecha'],
        ];
        if ($resultado->execute($_array))
            return $this->cn->lastInsertId();

        return false;
    }
    //registrar detalle de la compra, insertando la consulta para mostrar el detalle de la compra
    public function registrarDetalle($_params)
    {
        $sql = "INSERT INTO `detalle_pedidos`( `pedidos_id`, `pelicula_id`, `precio`, `cantidad`)
         VALUES (:pedidos_id,:pelicula_id,:precio,:cantidad)";

        $resultado = $this->cn->query($sql);

        $_params = array(
            ':pedidos_id' => $_params['pedidos_id'],
            ':pelicula_id' => $_params['pelicula_id'],
            ':precio' => $_params['precio'],
            ':cantidad' => $_params['cantidad'],
        );
        if ($resultado->execute($_params))
            return true;

        return false;
    }

    public function mostrar()
    {
        $sql = "SELECT p.id, nombre, apellidos, email, total, fecha FROM pedidos p INNER JOIN clientes c ON p.cliente_id = c.id ORDER BY p.id DESC";
        $resultado = $this->cn->prepare($sql);
        if ($resultado->execute())
            return $resultado->fetchAll();


        return false;
    }

    public function mostrarPorid($id)
    {
        $sql = "SELECT p.id, nombre, apellidos, email, total, fecha FROM pedidos p INNER JOIN clientes c ON p.cliente_id = c.id WHERE p.id = :id";
        $resultado = $this->cn->prepare($sql);
        $_array = array(
            ':id' => $id
        );
        if ($resultado->execute($_array))
            return $resultado->fetch();


        return false;
    }
    public function mostrarDetallePoridPedido($id)
    {
        $sql = "SELECT dp.id, p.titulo, dp.precio, dp.cantidad, p.foto FROM detalle_pedidos dp  INNER JOIN peliculas p ON p.id = dp.pelicula_id WHERE dp.id = :id ";
        $resultado = $this->cn->prepare($sql);
        $_array = array(
            ':id' => $id
        );
        if ($resultado->execute($_array))
            return $resultado->fetchAll();


        return false;
    }
}
