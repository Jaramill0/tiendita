<?php

session_start();
if (!isset($_SESSION['usuario_info']) or empty($_SESSION['usuario_info']))
    header('Location: ../index.php');
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Vettern Store</title>

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="../../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../assets/css/estilos.css">
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
                <a class="navbar-brand" href="../dashboard.php">Vettern</a>
            </div>
            <div id="navbar" class="navbar-collapse collapse">
                <ul class="nav navbar-nav pull-right">
                    <li class="active">
                        <a href="index.php" class="btn">Pedidos</a>
                    </li>
                    <li>
                        <a href="../productos/index.php" class="btn">Productos</a>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php print $_SESSION['usuario_info']['nombre_usuario']; ?> <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="../cerrar_sesion.php">Salir</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
            <!--/.nav-collapse -->
        </div>
    </nav>

    <div class="container" id="main">
        <div class="row">
            <div class="col-md-12">
                <fieldset>
                    <?php
                    require '../../vendor/autoload.php';
                    $id = $_GET['id'];
                    $pedido = new Kawschool\Pedido;

                    $info_pedido = $pedido->mostrarPorid($id);
                    $info_detalle_pedido = $pedido->mostrarDetallePoridPedido($id);

                    ?>
                    <legend>INFORMACION DE LA COMPRA</legend>
                    <div class="form-group">
                        <label>Nombre </label>
                        <input class="form-control" value="<?php print $info_pedido['nombre'] ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label>Apellidos </label>
                        <input class="form-control" value="<?php print $info_pedido['apellidos'] ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label>Correo </label>
                        <input class="form-control" value="<?php print $info_pedido['email'] ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label>Fecha </label>
                        <input class="form-control" value="<?php print $info_pedido['fecha'] ?>" readonly>
                    </div>
                    <hr>
                    PRODUCTOS COMPRADOS
                    <hr>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Titulo</th>
                                <th>Foto</th>
                                <th>Precio</th>
                                <th>Cantidad</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php



                            $cantidad = count($info_detalle_pedido);
                            if ($cantidad > 0) {
                                $c = 0;
                                for ($x = 0; $x < $cantidad; $x++) {
                                    $c++;
                                    $item = $info_detalle_pedido[$x];
                                    $total = $item['precio'] * $item['cantidad'];
                            ?>
                                    <tr>
                                        <td> <?php print $c ?> </td>
                                        <td><?php print $item['titulo'] ?></td>
                                        <td class="text-center">
                                            <?php
                                            $foto = '../../upload/' . $item['foto'];
                                            if (file_exists($foto)) {

                                            ?>
                                                <img src="<?php print $foto; ?>" width="35">
                                            <?php } else { ?>
                                                SIN FOTO
                                            <?php } ?>
                                        </td>
                                        </td>
                                        <td><?php print $item['precio'] ?>MXN</td>
                                        <td><?php print $item['cantidad'] ?></td>
                                        <td><?php print $total ?></td>

                                    </tr>
                                <?php
                                }
                            } else {
                                ?>
                                <tr>
                                    <td colspan="6">NO HAY REGISTROS</td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Total de Compra </label>
                            <input class="form-control" value="<?php print $info_pedido['total'] ?>" readonly>
                        </div>
                    </div>
                </fieldset>
                <br><br>
                <div class="pull-left">
                    <a href="index.php" class="btn btn-danger hidden-print">Cancelar</a>
                </div>
                <div class="pull-right">
                    <a href="javascript:;" id="btnImprimir" class="btn btn-success hidden-print">Imprimir</a>
                </div>
            </div>
        </div>

    </div> <!-- /container -->
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="../../assets/js/jquery.min.js"></script>
    <script src="../../assets/js/bootstrap.min.js"></script>
    <script>
        $('#btnImprimir').on('click', () => {
            window.print();
            return false;
        })
    </script>
</body>

</html>