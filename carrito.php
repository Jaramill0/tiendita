<?php
session_start();
require 'funciones.php';

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];
    require 'vendor/autoload.php';
    $producto = new Kawschool\Articulos;
    $resultado = $producto->mostrarPorId($id);

    //comprobando el resultado del producto en la busqueda
    if (!$resultado)
        header('Location: index.php');

    //SI EL CARRITO EXISTE

    if (isset($_SESSION['carrito'])) {


        //SI LA PELICULA EXISTE EN EL CARRITO
        if (array_key_exists($id, $_SESSION['carrito'])) {

            actualizarPelicula($id);
        } else {
            //SI EL CARRITO NO EXISTE EN EL CARRITo
            agregarPelicula($resultado, $id);
        }
    } else {

        //SI EL CARRITO no existe
        agregarPelicula($resultado, $id);
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<!-- Cuerpo del carrito de compras -->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Vettern Store</title>

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/estilos.css">
</head>

<body>

    <!-- Fixed navbar -->
    <nav class="navbar navbar-default navbar-fixed-top">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php">Vettern</a>
            </div>
            <div id="navbar" class="navbar-collapse collapse">
                <ul class="nav navbar-nav pull-right">
                    <li>
                        <a href="" class="btn">CARRITO <span class="badge"><?php print cantidadPeliculas(); ?></span></a>
                    </li>
                </ul>
            </div>
            <!--/.nav-collapse -->
        </div>
    </nav>
<!-- tabla de informacion del producto elegido por el usuario -->
    <div class="container" id="main">
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Titulo</th>
                    <th>Foto</th>
                    <th>Cantidad</th>
                    <th>Total</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <!-- actualizar carrito dentro del formulario -->
                <?php
                if (isset($_SESSION['carrito']) && !empty($_SESSION['carrito'])) {
                    $c = 0;
                    foreach ($_SESSION['carrito'] as $indice => $value) {
                        $c++;
                        $total = $value['precio'] * $value['cantidad']; ?>
                        <tr>
                            <form action="actualizar_carrito.php" method="post">
                                <td><?php print $c ?></td>
                                <td> <?php print $value['titulo']; ?> </td>
                                <td> <?php
                                        $foto = 'upload/' . $value['foto'];
                                        if (file_exists($foto)) {

                                        ?>
                                        <img src="<?php print $foto; ?>" width="35">
                                    <?php } else { ?>
                                        <img src="assets/imagenes/not-found.jpg" width="35">
                                    <?php } ?>
                                </td>
                                <td> <input type="text" name="cantidad" class="form-control u-size-100" value="<?php print $value['cantidad']; ?> ">
                                </td>
                                <td>
                                    <?php print $total ?> MXN
                                </td>
                                <td>
                                    <button type="submit" class="btn  btn-success btn-xs">
                                        <span class="glyphicon glyphicon-refresh"></span>
                                    </button>
                                    <a href="eliminar_carrito.php?id=<?php print $value['id']; ?>" type="submit" class="btn  btn-danger btn-xs">
                                        <span class="glyphicon glyphicon-trash"></span>
                                    </a>
                                </td>
                            </form>
                        </tr>
                    <?php
                    }
                } else {
                    ?>
                    <tr>
                        <td colspan="7">No hay productos en carrito</td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="4" class="text-right">Total</td>
                    <td><?php print calcularTotal(); ?> MXN</td>
                    <td></td>
                </tr>
            </tfoot>
        </table>
        <hr>
        <?php
        if (isset($_SESSION['carrito']) && !empty($_SESSION['carrito'])) {
        ?>
            <div class="row ">
                <div class="pull-left">
                    <a href="index.php" class="btn btn-info">Seguir Comprando</a>
                </div>
                <div class="pull-right">
                    <a href="finalizar.php" class="btn btn-success">Finalizar Compra</a>
                </div>
            </div>
        <?php
        }
        ?>
    </div> <!-- /container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>

</body>

</html>