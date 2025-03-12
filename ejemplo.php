<?php


require_once __DIR__.'/class/class.Usuario.php';

$usuario = new Usuario();
echo "<pre>";
var_dump($usuario);
echo "</pre>";

$usuario->setNombre('alejando');
$usuario->setApellidos('fernandez');
$usuario->setEmail('alejando@gmail.com');
$usuario->setPassword('1234');
$usuario->setRol('JUGADOR');
$usuario->guardar();

echo "<pre>";
var_dump($usuario);
echo "</pre>";


// require_once __DIR__.'/class/class.Paciente.php';

// $paciente = new Paciente(1);
// $paciente->setNif(null);
// $paciente->setNombre('CARLOS');
// $paciente->setApellidos('PÉREZ DÍAZ');
// $paciente->setEmail(null);
// $paciente->setTelefonoMovil('600101010');

// var_dump($paciente->guardar());
// var_dump($paciente->eliminar());