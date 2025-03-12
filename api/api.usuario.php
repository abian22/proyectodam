<?php

require_once __DIR__ . '/../config/config.globales.php';
require_once __DIR__.'/comprobar.sesion.php';
require_once __DIR__ . '/../db/class.HandlerDB.php';
require_once __DIR__ . '/../class/function.globales.php';
require_once __DIR__ . '/../class/class.Usuario.php';

$sesionActual = new SecureSessionHandler();
$sesionActual->start();
$usuarioActual = new Usuario($sesionActual->read("id"));

// /* @var Usuario $usuarioActual */
global $usuarioActual;

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
    case 'CAMBIAR_PASSWORD':
        // Obtenemos los datos enviados
        $passwordActual = (isset($_POST['passwordActual']) && trim($_POST['passwordActual']) !== '') ? $_POST['passwordActual'] : null;
        $passwordNueva1 = (isset($_POST['passwordNueva1']) && trim($_POST['passwordNueva1']) !== '') ? $_POST['passwordNueva1'] : null;
        $passwordNueva2 = (isset($_POST['passwordNueva2']) && trim($_POST['passwordNueva2']) !== '') ? $_POST['passwordNueva2'] : null;

        if (is_null($passwordActual)) {
            $respuesta['exito'] = 0;
            $respuesta['mensaje'] = 'No ha escrito su contraseña actual';
            break;
        }

        if (!$usuarioActual->checkPassword($passwordActual)) {
            $usuarioActual->setIntentosFallidos($usuarioActual->getIntentosFallidos() + 1);
            $usuarioActual->guardar();

            $respuesta['exito'] = 0;
            $respuesta['mensaje'] = 'Contraseña actual incorrecta';

            break;
        }

        if (is_null($passwordNueva1) || is_null($passwordNueva2)) {
            $respuesta['exito'] = 0;
            $respuesta['mensaje'] = "Debe rellenar la nueva contraseña y repetirla";
            break;
        }

        if (validarCambioPassword($passwordNueva1, $passwordNueva2)) {
            $usuarioActual->setPassword($passwordNueva1);
            $usuarioActual->guardar();
            $respuesta['exito'] = 1;
            $respuesta['mensaje'] = 'Su contraseña ha sido modificada con éxito';
        } else {
            $respuesta['exito'] = 0;
            $respuesta['mensaje'] = "Su contraseña no cumple los requisitos mínimos de seguridad.";
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
