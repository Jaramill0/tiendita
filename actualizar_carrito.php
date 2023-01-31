<?php
session_start();
require 'funciones.php';
//metodo para actualizar  la cantidad del producto
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $cantidad = $_POST['cantidad'];
    if (is_numeric($cantidad)) {
        if (array_key_exists($id, $_SESSION['carrito'])) 
            actualizarPelicula($id,$cantidad);
    }
    header('Location: carrito.php');
}
