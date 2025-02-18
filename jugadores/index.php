<?php
require_once __DIR__ . '/../config/config.globales.php';
require_once __DIR__ . '/../api/comprobar.sesion.php';

global $usuarioActual;
?>

<!doctype html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo CONFIG_GENERAL['TITULO_WEB']; ?> - Jugadores</title>

    <!-- Header Común a todas las páginas de la aplicación -->
    <?php include(__DIR__ . '/../header/header.php'); ?>
    <?php include(__DIR__ . '/../header/header_bootstraptable.php'); ?>

    <!-- Configuración Global JS -->
    <script src="../config/config.globales.js"></script>

    <!-- JS para la gestión de dentistas -->
    <script src="./js/funciones.jugador.js"></script>
</head>

<body>
    <?php include_once(__DIR__. "/modal/crear.editar.jugador.php"); ?>
    <?php include_once __DIR__. '/../menu/menu.php'; ?>

    <div class="container mt-2">
        <div class="row">
            <div class="col-12">
                <h1>Jugadores</h1>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="row">
                    <div class="col-12 text-center">
                        <button class="btn btn-success" onclick="abrirModalJugador(0)">Añadir jugador</button>
                    </div>
                </div>
                <!-- Tabla listado dentistas -->
                <div class="row">
                    <div class="col-12">
                        <table class="table-striped tablaListado" id="tablaListadoJugadores" data-toggle="table"
                            data-url="<?php echo CONFIG_GENERAL['RUTA_URL_BASE'] . "/jugadores/GetJSONTablaJugadores.php"; ?>"
                            data-unique-id="id"
                            data-search="true"
                            data-show-refresh="true"
                            data-show-toggle="false"
                            data-show-columns="true"
                            data-pagination="true"
                            data-side-pagination="server"
                            data-page-size="15"
                            data-striped="true"
                            data-classes="table table-hover table-condensed"
                            data-page-list="[5, 10, 15, 20, 50, 100, 200]">
                            <thead>
                                <tr>
                                    <th data-width="180" data-field="apellidos" data-sortable="true">Apellidos</th>
                                    <th data-width="180" data-field="nombre" data-sortable="true">Nombre</th>
                                    <th data-width="150" data-field="email" data-sortable="true">Email</th>
                                    <th data-width="150" data-field="juego" data-sortable="true">Juego</th>
                                    <th data-width="150" data-field="ranking" data-sortable="true">Ranking</th>
                                    <th data-width="150" data-field="especialidad" data-sortable="true">Especialidad</th>
                                    <th data-width="50" data-field="acciones">Acciones</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
                <!-- Tabla listado dentistas -->
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap-table@1.24.0/dist/bootstrap-table.min.js"></script>
    <?php include(__DIR__ . '/../header/footer_bootstraptable.php'); ?>
    

</body>


<?php include(__DIR__ . '/../header/footer.php'); ?>

</html>