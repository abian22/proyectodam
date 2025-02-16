<?php
require_once __DIR__ . "/api/comprobar.sesion.php";

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo CONFIG_GENERAL["TITULO_WEB"]; ?> - Acceso</title>
    <?php include(__DIR__ . "/header/header.php") ?>

    <!-- Configuración Global JS -->
    <script src="./config/config.globales.js"></script>

    <!-- Usuario JS -->
    <script src="./js/funciones.usuario.js"></script>
</head>

<body class="bg-primary">

    <?php include(__DIR__ ."/menu/menu.php") ?>

    <h2 class="text-white">Esto es el home</h2>

    <?php include(__DIR__ . '/header/footer.php'); ?>
</body>

</html>