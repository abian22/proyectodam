<?php
require_once __DIR__.'/../config/config.globales.php';
require_once __DIR__.'/../api/comprobar.sesion.php';

require_once __DIR__.'/GetJSONTablaEntrenadores_Funciones.php';

$textoBusqueda = "";
$limit = 0;
$offset = 0;
$sortby = 0;
$order = 0;

if (isset($_GET['search'])) {
    $textoBusqueda = $_GET['search'];
}

if (isset($_GET['limit'])) {
    $limit = $_GET['limit'];
}

if (isset($_GET['offset'])) {
    $offset = $_GET['offset'];
}

if (isset($_GET['sort'])) {
    $sortby = $_GET['sort'];
}

if (isset($_GET['order'])) {
    $order = $_GET['order'];
}

ob_clean();
header('Content-Type: application/json');
echo json_encode(listadoTablaEntrenadores($textoBusqueda, $limit, $offset, $sortby, $order));