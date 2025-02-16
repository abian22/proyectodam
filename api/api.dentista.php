<?php

require_once __DIR__ . '/../config/config.globales.php';
require_once __DIR__ . '/../db/class.HandlerDB.php';
require_once __DIR__ . '/../class/function.globales.php';
require_once __DIR__ . '/../class/class.Usuario.php';
require_once __DIR__ . "/../class/class.SecureSessionHandler.php";


$sesionActual = new SecureSessionHandler();
$sesionActual->start();
$usuarioActual = new Usuario($sesionActual->read("id"));

// /* @var Usuario $usuarioActual */
// global $usuarioActual;

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
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
switch ($tarea) {
    case "CARGAR_DENTISTA":
        $id = intval($_POST["id"]);
        $usuario = new Usuario($id);
        if ($usuario->getId() < 0) {
            $respuesta["exito"] = 0;
            $respuesta["mensaje"] = "No se pudo cargar los datos de los usuarios";
            break;
        }

        $datos["nombre"] = $usuario->getNombre();
        $datos["apellidos"] = $usuario->getApellidos();
        $datos["email"] = $usuario->getEmail();
        $datos["bloqueado"] = $usuario->getBloqueado();
        $respuesta["exito"] = 1;
        $respuesta["datos"] = $datos;
        break;
    case 'GUARDAR_DENTISTA':

        $id = intval($_POST['id']);
        $usuario = new Usuario($id);
        $usuario->setNombre(sanitizarString($_POST["nombre"]));

        $usuario->setApellidos(sanitizarString($_POST["apellidos"]));

        if (!validarEmail(sanitizarString($_POST["email"]))) {
            $respuesta["exito"] = 0;
            $respuesta["mensaje"] = "el email no es válido";
            break;
        }

        $usuario->setBloqueado(!($_POST["bloqueado"] === "false"));

        $usuario->setEmail(sanitizarString($_POST["email"]));
        $usuario->setRol("DENTISTA");
        $password1 = sanitizarString($_POST["password1"]);
        $password2 = sanitizarString($_POST["password2"]);


        if ($id > 0) {
            if (strlen($password1) > 0) {
                if (validarCambioPassword($password1, $password2)) {
                    $usuario->setPassword($password1);
                } else {
                    $respuesta["exito"] = 0;
                    $respuesta["mensaje"] = "Revise los campos de contraseñas";
                    break;
                }
            }
        } else {
            if (validarCambioPassword($password1, $password2)) {
                $usuario->setPassword($password1);
            } else {
                $respuesta["exito"] = 0;
                $respuesta["mensaje"] = "Revise los campos de contraseñas";
                break;
            }
        }
        if ($usuario->guardar()) {

            $respuesta["exito"] = 1;
        } else {
            $respuesta["exito"] = 0;
            $respuesta["mensaje"] = "Ha ocurrido un error al intentar guardar el usuario";
            break;
        }

        break;

    default:
        $respuesta['exito'] = 0;
        $respuesta['mensaje'] = 'Error en la petición';
        break;
}


header('Content-Type: application/json');
echo json_encode($respuesta);
