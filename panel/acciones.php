<?php
require '../vendor/autoload.php';
//llamando a la clase y namespace de articulos
$producto = new Kawschool\Articulos;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if ($_POST['accion'] === 'Registrar') {

        if (empty($_POST['titulo']))
            exit('Completar titulo');

        if (empty($_POST['descripcion']))
            exit('Completar titulo');

        if (empty($_POST['categoria_id']))
            exit('Seleccionar una Categoria');

        if (!is_numeric($_POST['categoria_id']))
            exit('Seleccionar una Categoria válida');

        //array de datos para los campos de texto al llenar los datos de cada campo de la tabla registrar_pelicula
        $_params = array(
            'titulo' => $_POST['titulo'],
            'descripcion' => $_POST['descripcion'],
            'foto' => subirFoto(),
            'precio' => $_POST['precio'],
            'categoria_id' => $_POST['categoria_id'],
            'fecha' => date('Y-m-d')
        );
        $rpt = $producto->registrar($_params);

        if ($rpt)
            header('Location: productos/index.php');
        else
            print 'Error al registrar';
    }
    if ($_POST['accion'] === 'Actualizar') {
        if (empty($_POST['titulo']))
            exit('Completar titulo');

        if (empty($_POST['descripcion']))
            exit('Completar titulo');

        if (empty($_POST['categoria_id']))
            exit('Seleccionar una Categoria');

        if (!is_numeric($_POST['categoria_id']))
            exit('Seleccionar una Categoria válida');

        //Array de datos para Actualizar los datos de la pelicula
        $_params = array(
            'titulo' => $_POST['titulo'],
            'descripcion' => $_POST['descripcion'],
            'precio' => $_POST['precio'],
            'categoria_id' => $_POST['categoria_id'],
            'fecha' => date('Y-m-d'),
            'id' => $_POST['id'],
        );

        if (!empty($_POST['foto_temp']))
            $_params['foto'] = $_POST['foto_temp'];

        if (!empty($_FILES['foto']['name']))
            $_params['foto'] = subirFoto();

        $rpt = $producto->actualizar($_params);
        if ($rpt)
            header('Location: productos/index.php');
        else
            print 'Error al Actualizar la Pelicula';
    }
}
//metodo get para eliminar la pelicula desde el parametro ID
if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    $id = $_GET['id'];

    $rpt = $producto->eliminar($id);

    if ($rpt)
        header('Location: productos/index.php');
    else
        print 'Error al Eliminar la Pelicula';
}


//funcion para subir fotos de la portada de la pelicula 
function subirFoto()
{
    $carpeta = __DIR__ . '/../upload/';

    $archivo = $carpeta . $_FILES['foto']['name'];

    move_uploaded_file($_FILES['foto']['tmp_name'], $archivo);

    return $_FILES['foto']['name'];
}
