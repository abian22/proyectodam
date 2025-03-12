<?php

require_once __DIR__.'/../config/config.globales.php';
require_once __DIR__.'/../class/class.SecureSessionHandler.php';
require_once __DIR__.'/../class/class.Usuario.php';

$sesionActual = new SecureSessionHandler();
$sesionActual->start();

$respuesta = array();
if ($sesionActual->read('id') === false || $sesionActual->read('ip') !== obtenerIpUsuario()) {
    $sesionActual->destroySession();
    if (isset($_POST['tarea'])) {
        $respuesta['exito'] = 0;
        $respuesta['mensaje'] = 'Su sesión ha caducado. Debe volver a hacer login.';
        header('Content-Type: application/json');
        echo json_encode($respuesta);
        exit;
    } else {
        header('Location: '.CONFIG_GENERAL['RUTA_URL_BASE'].'/login.php');
        exit;
    }
} else {
    $usuarioActual = new Usuario($sesionActual->read('id'));
    if ($usuarioActual->getBloqueado()) {
        $sesionActual->destroySession();
        header('Location: '.CONFIG_GENERAL['RUTA_URL_BASE'].'/login.php');
    }
}