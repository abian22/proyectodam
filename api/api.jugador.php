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
    case "CARGAR_JUGADOR":
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
        $datos["juego"] = $usuario->getJuego();
        $datos["ranking"] = $usuario->getRanking();
        $datos["bloqueado"] = $usuario->getBloqueado();
        $respuesta["exito"] = 1;
        $respuesta["datos"] = $datos;
        break;
    case 'GUARDAR_JUGADOR':

        $id = intval($_POST['id']);
        $usuario = new Usuario($id);


        
        if(strlen($nombre) == 0 ||strlen($apellidos) == 0) {
            $respuesta ["exito"] = 0;
            $respuesta ["errorNombreApellidos"] = 1;
            $respuesta ["mensaje"] = "debe rellentar el nombre y los apellidos";
            break;
        }

        $usuario->setNombre(sanitizarString(trim($_POST["nombre"])));
        $usuario->setApellidos(sanitizarString(trim($_POST["apellidos"])));
 
        if (!validarEmail(sanitizarString($_POST["email"]))) {
            $respuesta["exito"] = 0;
            $respuesta["errorEmail"] = 1;
            $respuesta["mensaje"] = "el email no es válido";
            break;
        }

        $usuario->setEmail(sanitizarString($_POST["email"]));
        $usuario->setBloqueado(!($_POST["bloqueado"] === "false"));
        $usuario->setRol("JUGADOR");
        $usuario->setJuego(sanitizarString($_POST["juego"]));
        $usuario->setRanking(sanitizarString($_POST["ranking"]));
        $usuario->setEspecialidad(sanitizarString($_POST["especialidad"]));
        $password1 = sanitizarString($_POST["password1"]);
        $password2 = sanitizarString($_POST["password2"]);

        if ($id > 0) {
            if (strlen($password1) > 0) {
                if (validarCambioPassword($password1, $password2)) {
                    $usuario->setPassword($password1);
                } else {
                    $respuesta["exito"] = 0;
                    $respuesta["errorPassword"] = 1;
                    if ($password1 != $password2) {
                        $respuesta["mensaje"] = "Las contraseñas no coinciden";
                    } else {
                        $respuesta["mensaje"] = "La contraseña no cumple con los criterios mínimos";
                    }
                    break;
                }
            }
        } else {
            if (validarCambioPassword($password1, $password2)) {
                $usuario->setPassword($password1);
            } else {
                $respuesta["exito"] = 0;
                $respuesta["errorPassword"] = 1;
                if ($password1 != $password2) {
                    $respuesta["mensaje"] = "Las contraseñas no coinciden";
                } else {
                    $respuesta["mensaje"] = "La contraseña no cumple con los criterios mínimos";
                }
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

ob_clean();
header('Content-Type: application/json');
echo json_encode($respuesta);
