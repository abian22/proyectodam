<?php
require_once __DIR__.'/../config/config.globales.php';
require_once __DIR__.'/../api/comprobar.sesion.php';

require_once __DIR__.'/../db/class.HandlerDB.php';
require_once __DIR__.'/../class/class.Usuario.php';

/***********************************************************************************
 * Genera la consulta a la DB para obtener el listado de dentistas para la tabla
 ***********************************************************************************/
function generarConsultaListadoTablaJugadores(string $textoBusqueda = "", int $limit = 0, int $offset = 0, string | int $sortby = 0, string | int $order = ""): array | bool {
    $parametrosWhere = array();

    $consultaSql = '
        SELECT
            DISTINCT(d.id)
        FROM 
            '.TABLA_USUARIOS.' d        
        WHERE 
            d.rol = :rol                
    ';

    $parametrosWhere[':rol'] = "JUGADOR";

    if ($textoBusqueda != "") {
        $consultaSql .= ' AND (
            d.nombre LIKE :textoBusqueda
            OR d.apellidos LIKE :textoBusqueda
            OR d.email LIKE :textoBusqueda
        )';
        $parametrosWhere[':textoBusqueda'] = "%{$textoBusqueda}%";
    }

    $gestorDB = new HandlerDB();
    $gestorDB->lastQuery = $consultaSql;
    try {
        $consultaSql = $gestorDB->dbh->prepare($consultaSql);
        foreach($parametrosWhere as $parametro => $valor) {
            $consultaSql->bindValue($parametro, $valor);
        }
        $consultaSql->execute();
        $ids = $consultaSql->fetchAll(PDO::FETCH_COLUMN);
    } catch (PDOException $e) {
        $mensajeLog = date('Y-m-d H:i:s').": ".$e->getMessage();
        file_put_contents(FICHERO_LOG_DB, $mensajeLog.PHP_EOL.$gestorDB->lastQuery.PHP_EOL.PHP_EOL, FILE_APPEND);
        $gestorDB->error = $e->getMessage();
        return false;
    }

    $totalFilas = $consultaSql->rowCount();

    if ($sortby === 0) {
        $criterioOrden = ' ORDER BY ud.apellidos ASC, ud.nombre ASC';
    } else {
        $criterioOrden = ' ORDER BY ud.'.$sortby.' '.$order;
    }

    if ($limit != 0) {
        $criterioLimit = ' LIMIT '.$limit.' OFFSET '.$offset;
    }

    if (empty($ids)) {
        $ids = [0];
    }


    $consultaSqlDatos = '
        SELECT
            ud.id,
            ud.nombre,
            ud.apellidos,
            ud.email,
            ud.rol,
            j.id AS juego_id,
            j.nombre AS juego,
            e.especialidad
        FROM ' . TABLA_USUARIOS . ' ud
        LEFT JOIN ' . TABLA_JUEGOS . ' j ON ud.juego_id = j.id
        LEFT JOIN ' . TABLA_ESPECIALIDAD . ' e ON ud.especialidad_id = e.id
        WHERE ud.id IN (' . implode(",", $ids) . ')
        ' . $criterioOrden . $criterioLimit;


    $gestorDB->lastQuery = $consultaSqlDatos;
    try {
        $consultaSqlDatos = $gestorDB->dbh->prepare($consultaSqlDatos);
        foreach($parametrosWhere as $parametro => $valor) {
            $consultaSql->bindValue($parametro, $valor);
        }
        $consultaSqlDatos->execute();
        $resultados = $consultaSqlDatos->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        $mensajeLog = date('Y-m-d H:i:s').": ".$e->getMessage();
        file_put_contents(FICHERO_LOG_DB, $mensajeLog.PHP_EOL.$gestorDB->lastQuery.PHP_EOL.PHP_EOL, FILE_APPEND);
        $gestorDB->error = $e->getMessage();
        return false;
    }

    $respuesta = array();
    $respuesta['datos'] = $resultados;
    $respuesta['totalFilas'] = $totalFilas;

    return $respuesta;
}

/***********************************************************************************
 * Devuelve el JSON con el listado de dentistas
 ***********************************************************************************/
function listadoTablaJugadores(string $textoBusqueda = "", int $limit = 0, int $offset = 0, string | int $sortby = 0, string | int $order = ""): array | bool {
    $resultadosConsulta = generarConsultaListadoTablaJugadores($textoBusqueda, $limit, $offset, $sortby, $order);

    
    if ($resultadosConsulta !== false) {
        $jsonDatos = array();
        
   
        $i = 0;
        foreach($resultadosConsulta['datos'] as $fila) {
            $jsonDatos[$i]['nombre'] = $fila['nombre'];
            $jsonDatos[$i]['apellidos'] = $fila['apellidos'];
            $jsonDatos[$i]['email'] = $fila['email'];
            $jsonDatos[$i]['rol'] = $fila['rol'];
            $jsonDatos[$i]['j.id'] = $fila['juego_id'];
            if ($jsonDatos[$i]['j.id'] == 1) {
                $jsonDatos[$i]['juego'] = $fila['juego'] . ' <img src="../img/juegos/lol.png" alt="Imagen" style="width: 20px; height: auto;">';
            } elseif ($jsonDatos[$i]['j.id'] == 2) {
                $jsonDatos[$i]['juego'] = $fila['juego'] . ' <img src="../img/juegos/valorant.png" alt="Imagen" style="width: 20px; height: auto;">';
            } elseif ($jsonDatos[$i]['j.id'] == 3) {
                $jsonDatos[$i]['juego'] = $fila['juego'] . ' <img src="../img/juegos/csgo.ico" alt="Imagen" style="width: 20px; height: auto;">';
            } else  $jsonDatos[$i]['juego'] = $fila['juego'];

            $jsonDatos[$i]['especialidad'] = $fila['especialidad'];
            $jsonDatos[$i]['acciones']  = '<button class="btn btn-warning" onclick="abrirModalJugador(this,'.$fila['id'].')">Editar</button>';
            $jsonDatos[$i]['acciones'] .= '<a class="btn btn-success ms-1" href="jugador.php?id='.$fila['id'].'">Ver</a>';


            $i++;
        }
        $respuesta['total'] = $resultadosConsulta['totalFilas'];
        $respuesta['rows'] = $jsonDatos;

        return $respuesta;
    }

    return false;
}
