<?php
require_once __DIR__ . '/../config/config.globales.php';
require_once __DIR__ . '/../db/class.HandlerDB.php';
require_once __DIR__ . '/function.globales.php';
require_once __DIR__ . '/abstract.class.ObjetoDB.php';

class Usuario extends ObjetoDB {
    protected int $id = 0;
    protected string $nombre = "";
    protected string $apellidos = "";
    protected string $email = "";
    protected string $password = "";
    protected string $rol = "";
    protected string $ipUltimoAcceso = "";
    protected string $fechaHoraUltimoAcceso = "";
    protected int $intentosFallidos = 0;
    protected bool $bloqueado = false;

    public function __construct(int $id = 0, string $otraClave = "", $valorOtraClave = "") {
        parent::__construct($id, $otraClave, $valorOtraClave);
    }

    public function getId(): int {
        return $this->id;
    }

    public function getNombre(): string {
        return sanitizarString($this->nombre);
    }

    public function setNombre($nombre): void {
        $this->nombre = sanitizarString($nombre);
    }

    public function getApellidos(): string {
        return sanitizarString($this->apellidos);
    }

    public function setApellidos(string $apellidos): void {
        $this->apellidos = sanitizarString($apellidos);
    }

    public function getNombreCompleto(): string {
        return sanitizarString($this->nombre." ".$this->apellidos);
    }

    public function getEmail(): string {
        return sanitizarString($this->email);
    }

    public function setEmail($email): bool {
        if (validarEmail($email)) {
            $this->email = $email;
            return true;
        }
        return false;
    }

    public function setPassword(string $passwordSinCifrar): void {
        $this->password = password_hash($passwordSinCifrar, PASSWORD_BCRYPT, ['cost' => 12]);
    }

    public function checkPassword(string $passwordSinCifrar): bool {
        return password_verify($passwordSinCifrar, $this->password);
    }

    public function getRol(): string {
        return sanitizarString($this->rol);
    }

    public function setRol(string $rol): bool {
        if (in_array($rol, CONFIG_GENERAL['ROLES'])) {
            $this->rol = $rol;
            return true;
        }
        return false;
    }

    public function getIpUltimoAcceso(): string {
        return sanitizarString($this->ipUltimoAcceso);
    }

    public function setIpUltimoAcceso(string $ipUltimoAcceso): void {
        $this->ipUltimoAcceso = $ipUltimoAcceso;
    }

    public function getFechaHoraUltimoAcceso(): string {
        return $this->fechaHoraUltimoAcceso;
    }

    public function setFechaHoraUltimoAcceso(string $fechaHoraUltimoAcceso): void {
        $this->fechaHoraUltimoAcceso = $fechaHoraUltimoAcceso;
    }

    public function getIntentosFallidos(): int {
        return $this->intentosFallidos;
    }

    public function setIntentosFallidos(int $intentosFallidos): void {
        $this->intentosFallidos = $intentosFallidos;
    }

    public function getBloqueado(): bool {
        return $this->bloqueado;
    }

    public function setBloqueado(bool $bloqueado): void {
        $this->bloqueado = $bloqueado;
    }

    public function guardar(): bool {
        if ($this->email == "" || $this->nombre == "" || $this->apellidos == "" || $this->password == "" || $this->rol == "") {
            return false;
        }

        return parent::guardar();
    }
}
?>