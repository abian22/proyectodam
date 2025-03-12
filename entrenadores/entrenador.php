<?php
require_once __DIR__ . '/../config/config.globales.php';
require_once __DIR__ . '/../api/comprobar.sesion.php';
require_once __DIR__ . '/../class/class.Usuario.php';

global $usuarioActual;

$id = intval($_GET['id']);
$entrenador = new Usuario($id);
?>

<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo CONFIG_GENERAL['TITULO_WEB']; ?> - Entrenador: </title>

    <!-- Header Común a todas las páginas de la aplicación -->
    <?php include(__DIR__ . '/../header/header.php'); ?>

    <!-- Configuración Global JS -->
    <script src="../config/config.globales.js"></script>

    <!-- JS para la gestión de entrenadors -->
    <script src="./js/funciones.usuario.js"></script>
</head>
<body>

<?php include_once __DIR__ . '/../menu/menu.php'; ?>

<?php if ($usuarioActual->getRol() !== 'ADMINISTRADOR') { ?>
<h2>Permiso denegado: No puede acceder a esta área de la aplicación</h2>
<?php } else { ?>

<div class="container mt-2">
    <div class="row">
        <div class="col-12">
            <h1>Entrenador |  <?php echo $entrenador->getNombreCompleto()?></h1>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-12">
            <h3>Datos Personales</h3>
            <table id="tablaDatosPersonales" class="table">
                <thead>
                    <tr>
                        <th>Apellidos</th>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Rol</th>
                        <th>Juego</th>
                        <th>Especialidad</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?php echo $entrenador->getApellidos() ?></td>
                        <td><?php echo $entrenador->getNombre() ?></td>
                        <td><?php echo $entrenador->getEmail() ?></td>
                        <td><?php echo $entrenador->getRol() ?></td>
                        <td><?php echo $entrenador->getJuego() ?></td>
                        <td><?php echo $entrenador->getEspecialidad() ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-12">
            <h3>Datos de Acceso</h3>
            <table id="tablaDatosAcceso" class="table">
                <thead>
                <tr>
                    <th>Último Acceso</th>
                    <th>Intentos Fallidos</th>
                    <th>Bloqueado</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td><?php echo $entrenador->getFechaHoraUltimoAcceso(true) ?></td>
                    <td><?php echo $entrenador->getIntentosFallidos() ?></td>
                    <td><?php echo ($entrenador->getBloqueado() === false ? 'NO' : 'SÍ') ?></td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>

</div>

</body>


<?php include(__DIR__ . '/../header/footer.php'); ?>
<?php } ?>
</html>

