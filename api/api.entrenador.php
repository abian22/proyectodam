<?php

require_once __DIR__ . '/../config/config.globales.php';
require_once __DIR__.'/comprobar.sesion.php';
require_once __DIR__ . '/../db/class.HandlerDB.php';
require_once __DIR__ . '/../class/function.globales.php';
require_once __DIR__ . '/../class/class.Usuario.php';

/* @var Usuario $usuarioActual */
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
    case 'CARGAR_ENTRENADOR':
        $id = intval($_POST['id']);
        $usuario = new Usuario($id);
        if ($usuario->getId() == 0) {
            $respuesta['exito'] = 0;
            $respuesta['mensaje'] = 'No se pudo cargar los datos del usuario';
            break;
        }

        $datos['nombre'] = $usuario->getNombre();
        $datos['apellidos'] = $usuario->getApellidos();
        $datos['email'] = $usuario->getEmail();
        $datos['bloqueado'] = $usuario->getBloqueado();

        $respuesta['exito'] = 1;
        $respuesta['datos'] = $datos;
        break;

    case 'GUARDAR_ENTRENADOR':
        $id = intval($_POST['id']);
        $usuario = new Usuario($id);

        $nombre = sanitizarString(trim($_POST["nombre"]));
        $apellidos = sanitizarString(trim($_POST["apellidos"]));
        

        if (strlen($nombre) == 0 || strlen($apellidos) == 0) {
            $respuesta['exito'] = 0;
            $respuesta['errorNombreApellidos'] = 1;
            $respuesta['mensaje'] = 'Debe rellenar el nombre y los apellidos';
            break;
        }

        $usuario->setNombre(sanitizarString($_POST["nombre"]));
        $usuario->setApellidos(sanitizarString($_POST["apellidos"]));
        $usuario->setJuego(sanitizarString($_POST["juego"]));
        $usuario->setEspecialidad(sanitizarString($_POST["especialidad"]));

        if (!validarEmail(sanitizarString($_POST["email"]))) {
            $respuesta['exito'] = 0;
            $respuesta['errorEmail'] = 1;
            $respuesta['mensaje'] = 'El email no es valido';
            break;
        }

        $usuario->setBloqueado(!($_POST["bloqueado"] === 'false'));

        $usuario->setEmail(sanitizarString($_POST["email"]));
        $usuario->setRol("ENTRENADOR");

        $password1 = sanitizarStringPassword($_POST["password1"]);
        $password2 = sanitizarStringPassword($_POST["password2"]);
        if ($id > 0) {
            if (strlen($password1) > 0) {
                if (validarCambioPassword($password1, $password2)) {
                    $usuario->setPassword($password1);
                } else {
                    $respuesta['exito'] = 0;
                    $respuesta['errorPassword'] = 1;
                    if ($password1 != $password2) {
                        $respuesta['mensaje'] = 'Las contraseñas no coinciden';
                    } else {
                        $respuesta['mensaje'] = 'La contraseña no cumple con los criterios mínimos';
                    }
                    break;
                }
            }
        } else {
            if (validarCambioPassword($password1, $password2)) {
                $usuario->setPassword($password1);
            } else {
                $respuesta['exito'] = 0;
                $respuesta['errorPassword'] = 1;
                if ($password1 != $password2) {
                    $respuesta['mensaje'] = 'Las contraseñas no coinciden';
                } else {
                    $respuesta['mensaje'] = 'La contraseña no cumple con los criterios mínimos';
                }
                break;
            }
        }

        if ($usuario->guardar()) {
            $respuesta['exito'] = 1;
        } else {
            $respuesta['exito'] = 0;
            $respuesta['mensaje'] = 'Ha ocurrido un error al intentar guardar el usuario';
        }
        break;

    default:
        $respuesta['exito'] = 0;
        $respuesta['mensaje'] = 'Error en la petición';
        break;
}

//ob_clean();
header('Content-Type: application/json');
echo json_encode($respuesta);
