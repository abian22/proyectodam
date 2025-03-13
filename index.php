<?php
require_once __DIR__.'/config/config.globales.php';
require_once __DIR__.'/api/comprobar.sesion.php';

global $usuarioActual;
?>

<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo CONFIG_GENERAL['TITULO_WEB']; ?> - Acceso</title>

    <!-- Header Común a todas las páginas de la aplicación -->
    <?php include(__DIR__.'/header/header.php'); ?>

    <!-- Configuración Global JS -->
    <script src="./config/config.globales.js"></script>
</head>
<body >
    <?php include_once __DIR__.'/menu/menu.php'; ?>

    <div class="container mt-2 ">
        <div class="row">
            <div class="col-12">
                <h1>Bienvenido/a <?php echo ucwords(strtolower($usuarioActual->getNombre())); ?></h1>
            </div>
        </div>
    </div>
</body>

<?php include(__DIR__.'/header/footer.php'); ?>
</html>
