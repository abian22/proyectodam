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


    <script src="./config/config.globales.js"> </script>
</head>

<body class="bg-primary">
    <?php include(__DIR__ . "/menu/menu.php") ?>

</body>

</html>