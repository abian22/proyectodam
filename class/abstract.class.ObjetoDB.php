<?php
require_once __DIR__ . '/../config/config.globales.php';
require_once __DIR__ . '/../db/class.HandlerDB.php';
require_once __DIR__ . '/function.globales.php';

abstract class ObjetoDB {
    protected int $id;

    public function __construct(int $id = 0, string $otraClave = "", $valorOtraClave = "") {
        if ($id != 0) {
            $gestorDB = new HandlerDB();
            $registros = $gestorDB->obtenerRegistros(
                TABLAS_OBJETO_DB[static::class],
                ['*'],
                'id = :id',
                [':id' => $id],
                null,
                'FETCH_ASSOC'
            );
            foreach ($registros as $registro) {
                foreach ($registro as $campo => $valor) {
                    $this->$campo = $valor;
                }
            }
            return true;
        } else {
            if ($otraClave != "") {
                $otraClave = sanitizarString($otraClave);
                $valorOtraClave = sanitizarString($valorOtraClave);
                $gestorDB = new HandlerDB();
                $registros = $gestorDB->obtenerRegistros(
                    TABLAS_OBJETO_DB[static::class],
                    ['*'],
                    $otraClave.' = :'.$otraClave,
                    [':'.$otraClave => $valorOtraClave],
                    null,
                    'FETCH_ASSOC'
                );
                foreach ($registros as $registro) {
                    foreach ($registro as $campo => $valor) {
                        $this->$campo = $valor;
                    }
                }
                return true;
            }
        }
        return false;
    }

    public function guardar(): bool {
        $gestorDB = new HandlerDB();

        if ($this->id != 0) {
            // Hay que hacer un UPDATE
            $clavesPrimarias = array('id' => $this->id);
            return $gestorDB->actualizarRegistro(
                TABLAS_OBJETO_DB[static::class],
                get_object_vars($this),
                $clavesPrimarias
            );
        } else {
            // Hay que hacer un INSERT
            $resultado = $gestorDB->insertarRegistro(
                TABLAS_OBJETO_DB[static::class],
                get_object_vars($this),
                ['id']
            );
            if (!$resultado) {
                return false;
            } else {
                $this->id = $resultado;
                return true;
            }
        }
    }

    public function eliminar(): bool {
        $gestorDB = new HandlerDB();
        $clavesPrimarias = array('id' => $this->id);
        return $gestorDB->eliminarRegistro(TABLAS_OBJETO_DB[static::class],$clavesPrimarias);
    }
}
?>
