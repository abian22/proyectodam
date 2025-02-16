<?php
require_once __DIR__ . '/../config/config.globales.php';
require_once __DIR__ . '/../api/comprobar.sesion.php';
require_once __DIR__ . "/../class/class.Usuario.php";

global $usuarioActual;

$id = intval($_GET['id']);
$usuario = new Usuario($id);
?>

<!doctype html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo CONFIG_GENERAL['TITULO_WEB']; ?> - Dentista</title>

    <!-- Header Común a todas las páginas de la aplicación -->
    <?php include(__DIR__ . '/../header/header.php'); ?>

    <!-- Configuración Global JS -->
    <script src="../config/config.globales.js"></script>

    <!-- JS para la gestión de dentistas -->
    <script src="./js/funciones.dentista.js"></script>
</head>

<body>
    <?php include_once __DIR__ . '/../menu/menu.php'; ?>

    <div class="container mt-2">
        <div class="row">
            <div class="col-12">
                <h1>Dentista: <?php echo $usuario->getNombreCompleto(); ?> </h1>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-12">
                <h3>Datos personales</h3>
                <table id="tablaDatosPersonales" class="table">
                    <thead>
                        <tr>
                            <th>Apellidos</th>
                            <th>Nombre</th>
                            <th>Email</th>
                            <th>Rol</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <?php echo $usuario->getNombre(); ?>
                            </td>
                            <td>
                                <?php echo $usuario->getApellidos(); ?>
                            </td>
                            <td>
                                <?php echo $usuario->getEmail(); ?>
                            </td>
                            <td>
                                <?php echo $usuario->getRol(); ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="row mt-3">
            <div class="col-12">
                <h3>Datos de Acceso</h3>
                <table id="tablaDatosAcceso" class="table">
                    <thead>
                        <tr>
                            <th>Ultimo Acceso</th>
                            <th>Intentos Fallidos</th>
                            <th>Bloqueado</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <?php echo $usuario->getFechaHoraUltimoAcceso(true); ?>
                            </td>
                            <td>
                                <?php echo $usuario->getIntentosFallidos(); ?>
                            </td>
                            <td>
                                <?php echo ($usuario->getBloqueado() === false ? "NO" : "SÍ") ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>


</body>


<?php include(__DIR__ . '/../header/footer.php'); ?>

</html>