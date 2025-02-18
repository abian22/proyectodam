<?php

// require_once __DIR__."/api/comprobar.sesion.php";



// $usuario = new Usuario(20);
// $usuario->setPassword("1234");
// $usuario->guardar();
// var_dump($usuario->checkPassword(("123456"))); 

require_once __DIR__ . '/config/config.globales.php';
require_once __DIR__ . '/class/class.Usuario.php';
$usuario = new Usuario(1);
echo "<pre>";
print_r($usuario);
echo "</pre>";
$usuario->setPassword('1234');
$usuario->guardar();
var_dump($usuario->checkPassword(("1234"))); 
