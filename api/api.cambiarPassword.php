<?php

require_once __DIR__ . '/../config/config.globales.php';
require_once __DIR__ . '/../db/class.HandlerDB.php';
require_once __DIR__ . '/../class/function.globales.php';
require_once __DIR__ . '/../class/class.Usuario.php';
require_once __DIR__ . "/../class/class.SecureSessionHandler.php";


// $sesionActual = new SecureSessionHandler();
// $sesionActual->start();
// $usuarioActual = new Usuario($sesionActual->read("id"));

/* @var Usuario $usuarioActual */
global $usuarioActual;


if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit;
}

$tarea = $_POST['tarea'] ?? null;
if (is_null($tarea)) {
    header('Content-Type: application/json');
    echo json_encode([
        'exito' => 0,
        'exitoPassword' => 1,
        'exitoPasswordNueva' => 1,
        'mensaje' => 'No se ha recibido ninguna tarea'
    ]);
    exit;
}


$respuesta = array();
switch ($tarea) {
    case 'CAMBIAR_PASSWORD':
        $passwordActual = (isset($_POST['passwordActual']) && trim($_POST['passwordActual']) !== '') ? $_POST['passwordActual'] : null;
        $passwordNueva = (isset($_POST['passwordNueva']) && trim($_POST['passwordNueva']) !== '') ? $_POST['passwordNueva'] : null;
        $repetirPasswordNueva = (isset($_POST['repetirPasswordNueva']) && trim($_POST['repetirPasswordNueva']) !== '') ? $_POST['repetirPasswordNueva'] : null;

        if (is_null($passwordActual) || is_null($passwordNueva) || is_null($repetirPasswordNueva)) {
            $respuesta['exito'] = 0;
            $respuesta['mensaje'] = 'Debe rellenar todos los campos para cambiar la contraseña';
            break;
        }

        if (!$usuarioActual->checkPassword($passwordActual)) {
            $usuarioActual->setIntentosFallidos($usuarioActual->getIntentosFallidos() + 0);
            $usuarioActual->guardar();
            $respuesta['exitoPassword'] = 0;
            $respuesta['mensaje'] = 'La password actual es incorrecta';
            break;
        } else $respuesta['exitoPassword'] = 1;


        if ($passwordNueva === $passwordActual) {
            $respuesta['exitoPasswordNueva'] = 0;
            $respuesta['mensaje'] = 'La password nueva no puede ser igual que la actual';
            break;
        } else 

        if ($passwordNueva !== $repetirPasswordNueva) {
            $respuesta['exitoPasswordNueva'] = 0;
            $respuesta['mensaje'] = 'La password nueva no coincide';
            break;
        }

        if (!checkPasswordTieneMinuscula($passwordNueva)) {
            $respuesta['exitoPasswordNueva'] = 0;
            $respuesta['mensaje'] = 'La password debe contener al menos una minúscula';
            break;
        }

        if (!checkPasswordTieneMayuscula($passwordNueva)) {
            $respuesta['exitoPasswordNueva'] = 0;
            $respuesta['mensaje'] = 'La password debe contener al menos una mayúscula';
            break;
        }

        if (!checkPasswordTieneNumero($passwordNueva)) {
            $respuesta['exitoPasswordNueva'] = 0;
            $respuesta['mensaje'] = 'La password debe contener al menos un número';
            break;
        }

        if (!checkPasswordTieneSimbolo($passwordNueva)) {
            $respuesta['exitoPasswordNueva'] = 0;
            $respuesta['mensaje'] = 'La password debe contener al menos un símbolo';
            break;
        }

        if (strlen($passwordNueva) < PASSWORD_LONGITUD_MINIMA) {
            $respuesta['exitoPasswordNueva'] = 0;
            $respuesta['mensaje'] = 'La password debe contener al menos 8 carácteres';
            break;
        }

        $usuarioActual->setPassword($passwordNueva);
        $respuesta['exito'] = 1;
        $respuesta['exitoPassword'] = 1;
        $respuesta['exitoPasswordNueva'] = 1;
        $respuesta['mensaje'] = 'La password nueva se ha guardado correctamente ';
        echo $passwordNueva;
        $usuarioActual->guardar();
        break;

    default:
        $respuesta['exito'] = 0;
        $respuesta['mensaje'] = 'Error en la petición';
        break;
}

ob_clean();
header('Content-Type: application/json');
echo json_encode($respuesta);
