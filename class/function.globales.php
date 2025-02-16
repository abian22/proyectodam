<?php

/***********************************************************************************
 * Comprueba si un string (contraseña) contiene una mayúscula
 ***********************************************************************************/
function checkPasswordTieneMayuscula(string $password): bool
{
    return preg_match('@[A-Z]@', $password);
}

/***********************************************************************************
 * Comprueba si un string (contraseña) contiene una minúscula
 ***********************************************************************************/
function checkPasswordTieneMinuscula(string $password): bool
{
    return preg_match('@[a-z]@', $password);
}

/***********************************************************************************
 * Comprueba si un string (contraseña) contiene un número
 ***********************************************************************************/
function checkPasswordTieneNumero(string $password): bool
{
    return preg_match('@[0-9]@', $password);
}

/***********************************************************************************
 * Comprueba si un string (contraseña) contiene un símbolo
 ***********************************************************************************/
function checkPasswordTieneSimbolo(string $cadena): bool
{
    return preg_match('/[!@#$%^&*()\-_+={}\[\]\\|:;"\'<>?,.]/', $cadena);
}

/***********************************************************************************
 * Comprueba si un string (contraseña) tiene una longitud mínimo
 ***********************************************************************************/
function checkPasswordLongitud(string $password): bool
{
    return strlen($password >= 6);
}


/***********************************************************************************
 * Comprobar que las contraseñas coinciden y cumplen con los criterios anteriores
 ***********************************************************************************/
function validarCambioPassword(string $password1, string $password2): bool
{
    if ($password1 != $password2) {
        return false;
    }

    if (strlen($password1) < PASSWORD_LONGITUD_MINIMA) {
        return false;
    }

    if (
        checkPasswordTieneMinuscula($password1) && checkPasswordTieneMayuscula($password2) && checkPasswordTieneNumero($password1)
        && checkPasswordTieneSimbolo($password1)
    ) {
        return true;
    }

    return false;
}


/***********************************************************************************
 * Sanitizar entrada
 ***********************************************************************************/
function sanitizarString(string $dato): string
{
    $dato = trim($dato);
    return htmlspecialchars($dato, ENT_QUOTES | ENT_HTML5, 'UTF-8');
}

/***********************************************************************************
 * Sanitizar entrada password
 ***********************************************************************************/
function sanitizarStringPassword($dato): string
{
    $dato = trim($dato);
    $dato = htmlspecialchars($dato, ENT_NOQUOTES, 'UTF-8');
    return str_replace('&amp;', '&', $dato);
}


/***********************************************************************************
 * Obtiene la dirección IP del cliente/usuario
 ***********************************************************************************/
function obtenerIpUsuario(): string
{
    $ip = '';
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } elseif (!empty($_SERVER['REMOTE_ADDR'])) {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}


/***********************************************************************************
 * Comprueba si un email tiene estructura de email
 ***********************************************************************************/
function validarEmail($email): bool
{
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}


/***********************************************************************************
 * Validar URL
 ***********************************************************************************/
function validarURL($url): bool
{
    return filter_var($url, FILTER_VALIDATE_URL) !== false;
}


/***************************************************************************************
 * Devuelve una fecha formateada en función del criterio de formato (d/m/Y o H:i o...)
 ***************************************************************************************/
function obtenerFechaHoraFormateada($fechaHora, $formato): string
{
    $dateTime = new DateTime($fechaHora);
    return $dateTime->format($formato);
}


/***************************************************************************************
 * Comprueba si una fecha es válida
 ***************************************************************************************/
function validarFecha(string | null $fecha): bool
{
    if (strtotime($fecha) === false) {
        return false;
    } else {
        return true;
    }
}
