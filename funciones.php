<?php
//archivo de funciones para agregar la pelicula 
function agregarPelicula($resultado, $id, $cantidad = 1)
{
    $_SESSION['carrito'][$id] = array(
        'id' => $resultado['id'],
        'titulo' => $resultado['titulo'],
        'foto' => $resultado['foto'],
        'precio' => $resultado['precio'],
        'cantidad' => $cantidad
    );
}
//actualizar la pelicula de la tabla indicando su cantidad
function actualizarPelicula($id, $cantidad = FALSE)
{
    if ($cantidad)
        $_SESSION['carrito'][$id]["cantidad"] = $cantidad;
    else
        $_SESSION['carrito'][$id]["cantidad"] += 1;
}
//funcion que calcula el total del carrito con los productos
function calcularTotal()
{
    $total = 0;
    if (isset($_SESSION['carrito'])) {
        foreach ($_SESSION['carrito'] as $indice => $value) {
            $total += $value['precio'] * $value['cantidad'];
        }
    }
    return $total;
}
//funcion que arroja la cantidad  de peliculas
function cantidadPeliculas()
{
    $cantidad = 0;
    if (isset($_SESSION['carrito'])) {
        foreach ($_SESSION['carrito'] as $indice => $value) {
            $cantidad++;
        }
    }

    return $cantidad;
}
