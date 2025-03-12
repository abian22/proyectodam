<?php
require_once(__DIR__.'/config/config.globales.php');
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo CONFIG_GENERAL['TITULO_WEB']; ?> - Acceso</title>

    <!-- Header Común a todas las páginas de la aplicación -->
    <?php include(__DIR__.'/header/header.php'); ?>

    <!-- Configuración Global JS -->
    <script src="./config/config.globales.js"></script>

    <!-- Login JS -->
    <script src="./js/funciones.login.js"></script>
</head>
<body>

<div class="container-fluid">
    <div class="row vh-100">
        <!-- Zona izquierda: imagen -->
        <div class="col-lg-6 d-none d-lg-block bg-image" style="background: url('<?php echo CONFIG_GENERAL['RUTA_URL_BASE'] ?>/img/login/background.jpg') no-repeat center center; background-size: cover;"></div>

        <!-- Zona derecha: formulario de acceso -->
        <div class="col-lg-6 col-12 bg-primary text-white d-flex justify-content-center align-items-center">
            <div class="w-100" style="max-width: 400px;">
                <h2 class="text-center mb-4">DAMDentista 1.0</h2>
                <form id="form-login">
                    <div class="mb-3">
                        <label for="form-login-usuario" class="form-label">Usuario</label>
                        <input type="text" class="form-control" name="usuario" id="form-login-usuario" placeholder="Introduzca su usuario">
                    </div>
                    <div class="mb-3">
                        <label for="form-login-password" class="form-label">Contraseña</label>
                        <input type="password" class="form-control" name="password" id="form-login-password" placeholder="Introduzca su contraseña">
                    </div>
                    <div class="mb-3">
                        <span class="badge" id="form-login-feedback"></span>
                    </div>
                    <button class="btn btn-warning w-100">Acceder</button>
                </form>
            </div>
        </div>

    </div>
</div>

<?php include(__DIR__.'/header/footer.php'); ?>

<script>
    document.getElementById("form-login").addEventListener("submit",
        function (event) {
            event.preventDefault();
            enviarFormularioLogin(event);
        }
    );
</script>

</body>
</html>
