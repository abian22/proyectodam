<?php
require_once(__DIR__ . "/api/comprobar.sesion.php");
require_once(__DIR__ . '/config/config.globales.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="img/titleicon.png">
    <title><?php echo CONFIG_GENERAL["TITULO_WEB"]; ?> - Cambiar password</title>

    <!-- Header Común a todas las páginas de la aplicación -->
    <?php include(__DIR__ . '/header/header.php'); ?>

    <!-- Configuración Global JS -->
    <script src="./config/config.globales.js"></script>

    <!-- Usuario JS -->
    <script src="./js/funciones.usuario.js"></script>
</head>


<style> 
       body {
            background-color:rgba(0, 0, 0, 0.77);
        }
        
        #cambiarPassword:hover {
               background: linear-gradient(135deg, #6f42c1, #007bff);
        }
    
</style>
<body>

    <?php include(__DIR__ . "/menu/menu.php") ?>

    <!-- Zona derecha: formulario de acceso -->
    <div class="col-lg-12col-12  d-flex justify-content-center align-items-center">
        <div class="w-100" style="max-width: 400px;">
            <h2 class="text-center mb-4 mt-4 text-light">Cambiar Password</h2>
            <form id="form-cambio-password">
                <div class="mb-3">
                    <label for="form-login-password" class="form-label text-light">Password actual</label>
                    <input type="text" class="form-control" name="passwordActual" id="form-cambio-password-password-actual" placeholder="Introduzca su contraseña actual">
                </div>
                <div class="mb-3">
                    <label for="form-login-password" class="form-label text-light">Password nueva <small>(debe contener mayúscula, minúscula, número y símbolo)</small></label>
                    <input type="password" class="form-control" name="passwordNueva1" id="form-cambio-password-password-1" placeholder="Introduzca la nueva contraseña">
                </div>
                <div class="mb-3">
                    <label for="form-login-password" class="form-label text-light">Repita la password nueva</label>
                    <input type="password" class="form-control" name="passwordNueva2" id="form-cambio-password-password-2" placeholder="Introduzca la nueva password">
                </div>
                <div class="mb-3">
                    <span class="badge" id="form-cambio-password-feedback"></span>
                </div>
                <button class="btn btn-primary w-100 text-light" id="cambiarPassword">Cambiar password</button>
            </form>
        </div>
    </div>


    <?php include(__DIR__ . '/header/footer.php'); ?>

    <script>
        document.getElementById("form-cambio-password").addEventListener("submit",
            function(event) {
                event.preventDefault();
                cambiarPasswordUsuario(event);
            }
        );
    </script>

</body>

</html>