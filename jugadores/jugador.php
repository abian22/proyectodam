<?php
require_once __DIR__ . '/../config/config.globales.php';
require_once __DIR__ . '/../api/comprobar.sesion.php';
require_once __DIR__ . '/../class/class.Usuario.php';
require_once __DIR__ . '/../class/class.Sesion.php';

global $usuarioActual;

$id = intval($_GET['id']);
$usuario = new Usuario($id);

# Preparamos el listado de sesiones de los jugadores
$sesiones = listadoSesionesJugador($usuario->getId());
$filasSesionesHtml = '';
foreach ($sesiones as $sesion) {

    $entrenador = new Usuario($sesion['idEntrenador']);

    $filasSesionesHtml .= '<tr>' . "\n";
    $filasSesionesHtml .= '    <td>' . obtenerFechaHoraFormateada($sesion['fechaHora'], 'd/m/Y H:i') . '</td>' . "\n";
    $filasSesionesHtml .= '    <td>' . $entrenador->getNombreCompleto() . '</td>' . "\n";
    $filasSesionesHtml .= '    <td>' . $sesion['observaciones'] . '</td>' . "\n";
    $filasSesionesHtml .= '    <td>' . "\n";
    $filasSesionesHtml .= '       <button onclick="abrirModalSesionJugador(this, ' . $sesion['id'] . ')" class="btn btn-sm btn-warning">Editar</button>' . "\n";
    $filasSesionesHtml .= '        <button onclick="eliminarSesionJugador(this, ' . $sesion['id'] . ')" class="btn btn-sm btn-danger">Eliminar</button>' . "\n";
    $filasSesionesHtml .= '        <a target="_blank" href="../informes/informe.sesion.php?id='.$sesion['id'].'" class="btn btn-sm btn-info">Informe</a>'."\n";
    $filasSesionesHtml .= '    </td>' . "\n";
    $filasSesionesHtml .= '</tr>' . "\n";
}
?>


<!doctype html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo CONFIG_GENERAL['TITULO_WEB']; ?> - Dentista: </title>

    <!-- Header Común a todas las páginas de la aplicación -->
    <?php include(__DIR__ . '/../header/header.php'); ?>
    <?php include(__DIR__ . '/../header/header_bootstraptable.php'); ?>

    <script src="../config/config.globales.js"></script>


    <script src="./js/funciones.jugador.js"></script>
</head>

<body>
    <input type="hidden" id="idJugador" value="<?php echo $usuario->getId() ?>">

    <?php include_once(__DIR__ . '/modal/crear.editar.jugador.sesion.php'); ?>

    <?php include_once __DIR__ . '/../menu/menu.php'; ?>

    <?php if ($usuarioActual->getRol() !== 'ADMINISTRADOR') { ?>
        <h2>Permiso denegado: No puede acceder a esta área de la aplicación</h2>
    <?php } else { ?>

        <div class="container mt-2">
            <div class="row">
                <div class="col-12">
                    <h1>Jugador | <?php echo $usuario->getNombreCompleto() ?></h1>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-12">
                    <h3>Datos Personales</h3>
                    <table id="tablaDatosPersonales" class="table  table-hover table-bordered" >
                        <thead  class="table-dark">
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
                                <td><?php echo $usuario->getApellidos() ?></td>
                                <td><?php echo $usuario->getNombre() ?></td>
                                <td><?php echo $usuario->getEmail() ?></td>
                                <td><?php echo $usuario->getRol() ?></td>
                                <td><?php echo $usuario->getJuego() ?></td>
                                <td><?php echo $usuario->getEspecialidad() ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-12">
                    <h3>Datos de Acceso</h3>
                    <table id="tablaDatosAcceso" class="table table-bordered">
                        <thead  class="table-dark">
                            <tr>
                                <th>Último Acceso</th>
                                <th>Intentos Fallidos</th>
                                <th>Bloqueado</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><?php echo $usuario->getFechaHoraUltimoAcceso(true) ?></td>
                                <td><?php echo $usuario->getIntentosFallidos() ?></td>
                                <td><?php echo ($usuario->getBloqueado() === false ? 'NO' : 'SÍ') ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-12">
                    <h3>Citas</h3>
                    <button class="btn btn-sm btn-success" onclick="abrirModalSesionJugador(this,0)">Agregar Cita</button>
                    <table id="tablaListadoSesionesJugador" class="table table-bordered">
                        <thead  class="table-dark">
                            <tr>
                                <th>Fecha/Hora</th>
                                <th>Entrenador/a</th>
                                <th>Observaciones</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php echo $filasSesionesHtml; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        </div>


</body>


<?php include(__DIR__ . '/../header/footer.php'); ?>
<?php } ?>

</html>