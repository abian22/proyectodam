<?php
require_once __DIR__ . '/config/config.globales.php';
require_once __DIR__ . '/api/comprobar.sesion.php';

global $usuarioActual;
?>

<!doctype html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="img/titleicon.png">
    <title><?php echo CONFIG_GENERAL['TITULO_WEB']; ?> - Panel de Administración</title>

    <!-- Header Común a todas las páginas de la aplicación -->
    <?php include(__DIR__ . '/header/header.php'); ?>

    <!-- Configuración Global JS -->
    <script src="./config/config.globales.js"></script>

    <!-- Agregar Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free/css/all.min.css" rel="stylesheet">
    <style>
        .card-header {
            background: linear-gradient(135deg, #6f42c1, #007bff);
            color: white;
            font-weight: bold;
            border-radius: 15px 15px 0 0;
        }

        #card {
            transition: transform 0.3s ease-in-out;
        }

        #card:hover {
            transform: scale(1.1);
        }

        .btn:hover {
            background: linear-gradient(135deg, #6f42c1, #007bff);
            
        }


        body {
            background-color:rgba(0, 0, 0, 0.77);
        }

    </style>
</head>

<body>
    <?php include_once __DIR__ . '/menu/menu.php'; ?>

    <div class="container mt-5 rou">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8">
                <div class="bg-dark p-4 rounded">
                    <h1 class="display-4 text-center text-light">Panel de Administración - Bienvenido/a <?php echo ucwords(strtolower($usuarioActual->getNombre())); ?></h1>
                    <p class="lead text-center text-light">
                        Este es el panel principal donde puedes gestionar todos los aspectos de la plataforma. Desde aquí podrás:
                    </p>

                    <ul class="list-unstyled text-light">
                        <li><i class="fas fa-key" style="color:#6f42c1;"></i> Cambiar la contraseña.</li>
                        <li><i class="fas fa-user" style="color:#6f42c1;"></i> Gestionar jugadores.</li>
                        <li><i class="fas fa-chalkboard-teacher" style="color:#6f42c1;"></i> Gestionar entrenadores.</li>
                        <li><i class="fas fa-dumbbell" style="color:#6f42c1;"></i> Gestionar sesiones de entrenamientos.</li>
                        <li><i class="fas fa-chart-line" style="color:#6f42c1;" ></i> Ver el informe del entrenamiento de cada sesión.</li>
                    </ul>

                    <div class="card border-0 mb-3 " >
                        <div class="card-header">
                            <i class="fas fa-tachometer-alt"></i> Resumen general
                        </div>
                        <div class="card-body bg-dark">
                            <div class="row">

                                <!-- Jugadores -->
                                <div class="col-md-6 mb-3 ">
                                    <div class="card shadow-sm bg-dark border-light " id="card">
                                        <div class="card-body">
                                            <h5 class="card-title text-warning">Jugadores Registrados</h5>
                                            <p class="card-text text-light"><?php echo contarUsuariosPorRol(["id"], "JUGADOR"); ?> jugadores disponibles</p>
                                            <a href="<?php echo CONFIG_GENERAL["RUTA_URL_BASE"] ?>/jugadores" class="btn btn-primary btn-lg">Ver jugadores</a>
                                        </div>
                                    </div>
                                </div>

                                <!-- Entrenadores -->
                                <div class="col-md-6 mb-3" >
                                    <div class="card shadow-sm bg-dark border-light" id=card>
                                        <div class="card-body">
                                            <h5 class="card-title text-warning ">Coaches Registrados</h5>
                                            <p class="card-text text-light"><?php echo contarUsuariosPorRol(["id"], "ENTRENADOR"); ?> coaches disponibles</p>
                                            <a href="<?php echo CONFIG_GENERAL["RUTA_URL_BASE"] ?>/entrenadores" class="btn btn-primary btn-lg">Ver entrenadores</a>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php include(__DIR__ . '/header/footer.php'); ?>
    </div>

</body>

</html>
