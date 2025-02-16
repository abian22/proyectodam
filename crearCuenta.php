<?php
require_once(__DIR__ . '/config/config.globales.php');
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo CONFIG_GENERAL['TITULO_WEB']; ?> - Acceso</title>

    <!-- Header Común a todas las páginas de la aplicación -->
    <?php include(__DIR__ . '/header/header.php'); ?>

    <!-- Configuración Global JS -->
    <script src="./config/config.globales.js"></script>

    <!-- Login JS -->
    <script src="./js/funciones.login.js"></script>
</head>

<body class="overflow-hidden">
    <?php include(__DIR__ . "/menu/menuPreLogin.php") ?>
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
                            <label for="form-crearCuenta-nombre" class="form-label">Nombre</label>
                            <input type="text" class="form-control" name="nombre" id="form-crearCuenta-nombre" placeholder="Introduzca su nombre">
                        </div>
                        <div class="mb-3">
                            <label for="form-crearCuenta-email" class="form-label">Email</label>
                            <input type="text" class="form-control" name="email" id="form-crearCuenta-email" placeholder="Introduzca su email">
                        </div>
                        <div class="mb-3">
                            <label for="form-crearCuenta-rol" class="form-label">Rol</label>
                            <select class="form-select" aria-label="Default select example">
                                <option selected>Selecciona tu rol</option>
                                <option value="Administrador">Administrador</option>
                                <option value="Dentista">Dentista</option>
                                <option value="Enfermero">Enfermero</option>
                                <option value="Auxiliar">Auxiliar</option>
                                <option value="Recepcionistaq">Recepcionista</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="form-crearCuenta-password" class="form-label">Contraseña</label>
                            <input type="password" class="form-control" name="password" id="form-crearCuenta-password" placeholder="Introduzca su contraseña">
                        </div>
                        <div class="mb-3">
                            <span class="badge" id="form-crearCuenta-feedback"></span>
                        </div>
                        <button class="btn btn-warning w-100">Crear cuenta</button>
                    </form>
                </div>
            </div>

        </div>
    </div>

    <?php include(__DIR__ . '/header/footer.php'); ?>

    <script>
        document.getElementById("form-login").addEventListener("submit",
            function(event) {
                event.preventDefault();
                enviarFormularioLogin(event);
            }
        );
    </script>

</body>

</html>