<?php
require_once __DIR__ . '/../config/config.globales.php';
require_once __DIR__ . '/../db/class.HandlerDB.php';
require_once __DIR__ . '/function.globales.php';
require_once __DIR__ . '/abstract.class.ObjetoDB.php';

class Usuario extends ObjetoDB
{
    protected int $id = 0;
    protected string $nombre = "";
    protected string $apellidos = "";
    protected string $email = "";
    protected string $password = "";
    protected string $rol = "";
    protected string $juego_id = "";
    protected string | null $imagenPerfil = null;
    protected string $especialidad_id = "";
    protected string $ipUltimoAcceso = "";
    protected string | null $fechaHoraUltimoAcceso = "";
    protected int $intentosFallidos = 0;
    protected bool $bloqueado = false;

    public function __construct(int $id = 0, string $otraClave = "", $valorOtraClave = "")
    {
        parent::__construct($id, $otraClave, $valorOtraClave);
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getNombre(): string
    {
        return sanitizarString($this->nombre);
    }

    public function setNombre($nombre): void
    {
        $this->nombre = sanitizarString($nombre);
    }

    public function getApellidos(): string
    {
        return sanitizarString($this->apellidos);
    }

    public function setApellidos(string $apellidos): void
    {
        $this->apellidos = sanitizarString($apellidos);
    }

    public function getNombreCompleto(): string
    {
        return sanitizarString($this->nombre . " " . $this->apellidos);
    }

    public function getEmail(): string
    {
        return sanitizarString($this->email);
    }

    public function setEmail($email): bool
    {
        if (validarEmail($email)) {
            $this->email = $email;
            return true;
        }
        return false;
    }

    public function setPassword(string $passwordSinCifrar): void
    {
        $this->password = password_hash($passwordSinCifrar, PASSWORD_BCRYPT, ['cost' => 12]);
    }

    public function checkPassword(string $passwordSinCifrar): bool
    {
        return password_verify($passwordSinCifrar, $this->password);
    }

    public function getRol(): string
    {
        return sanitizarString($this->rol);
    }

    public function setRol(string $rol): bool
    {
        if (in_array($rol, CONFIG_GENERAL['ROLES'])) {
            $this->rol = $rol;
            return true;
        }
        return false;
    }

    public function getImagenPerfil(): string | null
    {
        return $this->imagenPerfil;
    }

    public function setImagenPerfil(string $imagenPerfil): void
    {
        $this->imagenPerfil = $imagenPerfil;
    }

    public function getJuego(): string
    {

        $gestorDB = new HandlerDB();
        $consutlaSql = "SELECT nombre FROM " . TABLA_JUEGOS . " WHERE id = :id";

        try {
            $query = $gestorDB->dbh->prepare($consutlaSql);
            $query->bindValue(":id", $this->juego_id, PDO::PARAM_INT);
            $query->execute();
            $resultado = $query->fetch(PDO::FETCH_ASSOC);
            return sanitizarString($resultado['nombre']);
        } catch (PDOException $e) {
            file_put_contents(FICHERO_LOG_DB, date('Y-m-d H:i:s') . ": " . $e->getMessage() . PHP_EOL, FILE_APPEND);
            return "Error";
        }
    }

    public function setJuego(string $juego_id): void
    {
        $this->juego_id = $juego_id;
    }

    public function getEspecialidad(): string
    {

        $gestorDB = new HandlerDB();
        $consutlaSql = "SELECT especialidad FROM " . TABLA_ESPECIALIDAD . " WHERE id = :id";

        try {
            $query = $gestorDB->dbh->prepare($consutlaSql);
            $query->bindValue(":id", $this->especialidad_id, PDO::PARAM_INT);
            $query->execute();
            $resultado = $query->fetch(PDO::FETCH_ASSOC);
            return sanitizarString($resultado['especialidad']);
        } catch (PDOException $e) {
            file_put_contents(FICHERO_LOG_DB, date('Y-m-d H:i:s') . ": " . $e->getMessage() . PHP_EOL, FILE_APPEND);
            return "Error";
        }
    }

    public function setEspecialidad(string $especialidad_id): void
    {
        $this->especialidad_id = $especialidad_id;
    }


    public function getIpUltimoAcceso(): string
    {
        return sanitizarString($this->ipUltimoAcceso);
    }

    public function setIpUltimoAcceso(string $ipUltimoAcceso): void
    {
        $this->ipUltimoAcceso = $ipUltimoAcceso;
    }

    public function getFechaHoraUltimoAcceso(bool $formateada = false): string
    {
        if ($formateada) {
            return date('d/m/Y H:i', strtotime($this->fechaHoraUltimoAcceso));
        }
        return $this->fechaHoraUltimoAcceso;
    }

    public function setFechaHoraUltimoAcceso(string $fechaHoraUltimoAcceso): void
    {
        $this->fechaHoraUltimoAcceso = $fechaHoraUltimoAcceso;
    }

    public function getIntentosFallidos(): int
    {
        return $this->intentosFallidos;
    }

    public function setIntentosFallidos(int $intentosFallidos): void
    {
        $this->intentosFallidos = $intentosFallidos;
    }

    public function getBloqueado(): bool
    {
        return $this->bloqueado;
    }

    public function setBloqueado(bool $bloqueado): void
    {
        $this->bloqueado = $bloqueado;
    }

    public function guardar(): bool
    {
        if ($this->email == "" || $this->nombre == "" || $this->apellidos == "" || $this->password == "" || $this->rol == "") {
            return false;
        }

        return parent::guardar();
    }
}

function listadoUsuarios(array $datos, string $rol = ""): array {
    $gestorDB = new HandlerDB();
    $registros = $gestorDB->obtenerRegistros(
        TABLA_USUARIOS,
        $datos,
        'rol = :rol',
        [':rol' => $rol],
        null,
        'FETCH_ASSOC'
    );

    if (isset($registros[0]['id']) && $registros[0]['id'] > 0) {
        return $registros;
    }

    return [];
}

function contarUsuariosPorRol(array $datos, string $rol): int {
    $gestorDB = new HandlerDB();
    $registros = $gestorDB->obtenerRegistros(
        TABLA_USUARIOS,
        $datos,
        'rol = :rol',
        [':rol' => $rol],
        null,
        'FETCH_ASSOC'
    );



    // Devolvemos el número de usuarios encontrados
    return count($registros);
}
?>