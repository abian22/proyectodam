<?php
require_once __DIR__ . '/../config/config.globales.php';
require_once __DIR__ . '/../db/class.HandlerDB.php';
require_once __DIR__ . '/function.globales.php';
require_once __DIR__ . '/abstract.class.ObjetoDB.php';

class Sesion extends ObjetoDB {
    protected int $id = 0;
    protected int $idJugador = 0;
    protected int $idEntrenador = 0;
    protected string $fechaHora = "";
    protected string $observaciones = "";


    public function __construct(int $id = 0, string $otraClave = "", $valorOtraClave = "") {
        parent::__construct($id, $otraClave, $valorOtraClave);
    }

    public function getId(): int {
        return $this->id;
    }

    public function getIdJugador(): int {
        return $this->idJugador;
    }

    public function setIdJugador(int $idJugador): void {
        $this->idJugador = $idJugador;
    }

    public function getIdEntrenador(): int {
        return $this->idEntrenador;
    }

    public function setIdEntrenador(int $idEntrenador): void {
        $this->idEntrenador = $idEntrenador;
    }

    public function getFechaHora(bool $formateada = false): string | null {
        if (is_null($this->fechaHora)) {
            return null;
        }

        if ($formateada) {
            return date('d/m/Y H:i', strtotime($this->fechaHora));
        }

        return $this->fechaHora;
    }

    public function setFechaHora(string | null $fechaHora): void {
        if ($fechaHora == "") {
            $this->fechaHora = null;
        } else {
            $this->fechaHora = $fechaHora;
        }
    }

    public function getObservaciones(): string {
        return $this->observaciones;
    }

    public function setObservaciones(string $observaciones): void {
        $this->observaciones = sanitizarString($observaciones);
    }


    public function guardar(): bool {
        if ($this->fechaHora == "") {
            return false;
        }

        return parent::guardar();
    }
}

function listadoSesionesJugador(int $idJugador): array {
    $gestorDB = new HandlerDB();
    $registros = $gestorDB->obtenerRegistros(
        TABLA_SESIONES,
        ['*'],
        'idJugador = :idJugador',
        [':idJugador' => $idJugador],
        null,
        'FETCH_ASSOC'
    );

    

    if (isset($registros[0]['id']) && $registros[0]['id'] > 0) {
        return $registros;
    }

    return [];
}
?>