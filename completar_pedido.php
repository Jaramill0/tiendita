<?php
session_start();
//importando el archivo de funciones
require 'funciones.php';
//importando el autoload
require 'vendor/autoload.php';
//metodo post para importar el carrito de productos
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_SESSION['carrito']) && !empty($_SESSION['carrito'])) {

        $cliente = new Kawschool\Cliente;
        $_params = array(
            'nombre' => $_POST['nombre'],
            'apellidos' => $_POST['apellidos'],
            'email' => $_POST['email'],
            'telefono' => $_POST['telefono'],
            'comentario' => $_POST['comentario']
        );
        //metodo clase de registrar
        $cliente_id = $cliente->registrar($_params);
        //colocando la clase pedido para invocar el calculo del total 
        $pedido = new Kawschool\Pedido;

        $_params = array(
            'cliente_id' => $cliente_id,
            'total' => calcularTotal(),
            'fecha' => date('Y-m-d')
        );
        $pedido_id = $pedido->registrar($_params);
        //array para registrar los datos del pedido 
        foreach ($_SESSION['carrito'] as $indice => $value) {
            $_params = array(
                'pedidos_id' => $pedido_id,
                'pelicula_id' => $value['id'],
                'precio' => $value['precio'],
                'cantidad' => $value['cantidad'],
            );
            $pedido->registrarDetalle($_params);
        }
        $_SESSION['carrito'] = array();

        header('Location: gracias.php');
    }
}
