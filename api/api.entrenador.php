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
        if (!empty($_POST["juego"])) {
            $usuario->setJuego(sanitizarString($_POST["juego"]));
        }
    
        if (!empty($_POST["especialidad"])) {
            $usuario->setEspecialidad(sanitizarString($_POST["especialidad"]));
        }

        if (isset($_FILES["imagenPerfil"]) && $_FILES["imagenPerfil"]["error"] == UPLOAD_ERR_OK) {
            $imagen = $_FILES["imagenPerfil"]["tmp_name"]; // Ruta temporal del archivo subido
            $imagenABinario = file_get_contents($imagen);  // Convertir la imagen en binario
            
            // Obtener el formato de la imagen
            $formatoImagen = strtolower(pathinfo($_FILES["imagenPerfil"]["name"], PATHINFO_EXTENSION));
            $tiposDeFormatoPosible = ["jpg", "jpeg", "png", "webp", "jfif"];
            
            // Validar la imagen
            if (getimagesize($_FILES["imagenPerfil"]["tmp_name"]) !== false && in_array($formatoImagen, $tiposDeFormatoPosible)) {
                $usuario->setImagenPerfil($imagenABinario); // Guardar la imagen
            } else {
                $respuesta['exito'] = 0;
                $respuesta['mensaje'] = 'El archivo no es una imagen válida.';
                break;
            }
        } else {
            // Mantener imagen actual o establecer una cadena vacía si no hay imagen previa
            $usuario->setImagenPerfil($usuario->getImagenPerfil() ?: ""); 
        }
        

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
            if (empty($_POST["juego"])) {
                $respuesta['exito'] = 0;
                $respuesta['errorJuego'] = 1;
                $respuesta['mensaje'] = 'Debe rellenar el campo juego';
                break;
            }

            if (empty($_POST["especialidad"])) {
                $respuesta['exito'] = 0;
                $respuesta['errorEspecialidad'] = 1;
                $respuesta['mensaje'] = 'Debe rellenar el campo especialidad';
                break;
            }
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

ob_clean();
header('Content-Type: application/json');
echo json_encode($respuesta);
