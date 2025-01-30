<?php

require_once __DIR__ . '/../config/config.globales.php';
require_once __DIR__ . '/../db/class.HandlerDB.php';
require_once __DIR__ . '/../class/function.globales.php';
require_once __DIR__ . '/../class/class.Usuario.php';

// Comprobamos que se ha accedido a esta api mediante POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405); // Método no permitido
    exit;
}

// Comprobamos que existe el campo tarea
$tarea = $_POST['tarea'] ?? null;
if (is_null($tarea)) {
    header('Content-Type: application/json');
    echo json_encode(['exito' => 0, 'mensaje' => 'No se ha recibido ninguna tarea']);
    exit;
}


$respuesta = array();
switch($tarea) {
    case 'VALIDAR_LOGIN':
        // Obtenemos los datos enviados
        $usuario = (isset($_POST['usuario']) && trim($_POST['usuario']) !== '') ? $_POST['usuario'] : null;
        $password = (isset($_POST['password']) && trim($_POST['password']) !== '') ? $_POST['password'] : null;

        if (!is_null($usuario) && !is_null($password)) {
            if (!validarEmail($usuario)) {
                $respuesta['exito'] = 0;
                $respuesta['mensaje'] = 'Usuario/Contraseña incorrectos';
                break;
            }

            $usuario = new Usuario(0, 'email', $usuario);
            if ($usuario->getId() == 0) {
                $respuesta['exito'] = 0;
                $respuesta['mensaje'] = 'Usuario/Contraseña incorrectos';
                break;
            }

            if ($usuario->getBloqueado()) {
                $respuesta['exito'] = 0;
                $respuesta['mensaje'] = 'Usuario bloqueado';
                break;
            }

            if ($usuario->checkPassword($password)) {
                $usuario->setIntentosFallidos(0);
                $usuario->setFechaHoraUltimoAcceso(date('Y-m-d H:i:s'));
                $usuario->setIpUltimoAcceso(obtenerIpUsuario());
                $usuario->guardar();

                // Crear la sesión
                require_once __DIR__."/../class/class.SecureSessionHandler.php";
                $sesion = new SecureSessionHandler();
                $sesion->start();
                $sesion->write("id", $usuario->getId());
                $sesion->write("ip", obtenerIpUsuario());
                $respuesta['exito'] = 1;
                $respuesta['mensaje'] = 'Login correcto';
            } else {
                $respuesta['exito'] = 0;
                $respuesta['mensaje'] = 'Usuario/Contraseña incorrectos';

                $usuario->setIntentosFallidos($usuario->getIntentosFallidos() + 1);
                if ($usuario->getIntentosFallidos() >= CONFIG_GENERAL['MAXIMO_INTENTOS_FALLIDOS']) {
                    $usuario->setBloqueado(true);
                    $respuesta['mensaje'] = 'Ha superado el máximo número de intentos fallidos. Su usuario ha sido bloqueado.';
                }
                $usuario->guardar();
            }
        } else {
            $respuesta['exito'] = 0;
            $respuesta['mensaje'] = 'Debe rellenar todos los campos';
        }

        break;
    default:
        $respuesta['exito'] = 0;
        $respuesta['mensaje'] = 'Error en la petición';
        break;
}

ob_clean();
header('Content-Type: application/json');
echo json_encode($respuesta);
