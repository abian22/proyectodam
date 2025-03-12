<?php

require_once __DIR__ . '/../config/config.globales.php';
require_once __DIR__.'/comprobar.sesion.php';
require_once __DIR__ . '/../db/class.HandlerDB.php';
require_once __DIR__ . '/../class/function.globales.php';
require_once __DIR__ . '/../class/class.Sesion.php';

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
    case 'CARGAR_SESION':
        $id = intval($_POST['id']);
        $sesion = new Sesion($id);
        if ($sesion->getId() == 0) {
            $respuesta['exito'] = 0;
            $respuesta['mensaje'] = 'No se pudo cargar los datos de la sesion';
            break;
        }

        $datos['id'] = $sesion->getId();
        $datos['fechaHora'] = $sesion->getFechaHora();
        $datos['idJugador'] = $sesion->getIdJugador();
        $datos['idEntrenador'] = $sesion->getIdEntrenador();
        $datos['observaciones'] = $sesion->getObservaciones();

        $respuesta['exito'] = 1;
        $respuesta['datos'] = $datos;
        break;

    case 'GUARDAR_SESION':
        $id = intval($_POST['id']);
        $sesion = new Sesion($id);

        $sesion->setObservaciones(sanitizarString($_POST['observaciones']));
        $idJugador = intval($_POST['idJugador']);
        $idEntrenador = intval($_POST['idEntrenador']);

        if ($idJugador == 0 && $idEntrenador == 0) {
            $respuesta['exito'] = 0;
            $respuesta['mensaje'] = 'La sesion debe tener un entrenador o un jugador asociado';
            break;
        }

        $sesion->setIdJugador($idJugador);
        $sesion->setIdEntrenador($idEntrenador);

        if (!validarFecha($_POST['fechaHora'])) {
            $respuesta['exito'] = 0;
            $respuesta['errorFecha'] = 1;
            $respuesta['mensaje'] = 'La fecha no es válida';
            break;
        }

        $sesion->setFechaHora($_POST['fechaHora']);

        if ($sesion->guardar()) {
            $respuesta['exito'] = 1;
        } else {
            $respuesta['exito'] = 0;
            $respuesta['mensaje'] = 'Ha ocurrido un error al intentar guardar la cita';
        }
        break;

    case 'ELIMINAR_SESION':
        $id = intval($_POST['id']);
        $sesion = new Sesion($id);
        if ($sesion->eliminar()) {
            $respuesta['exito'] = 1;
        } else {
            $respuesta['exito'] = 0;
            $respuesta['mensaje'] = 'No se ha podido eliminar la sesion';
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
