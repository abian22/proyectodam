<?php
require_once __DIR__ . '/../config/config.globales.php';
require_once __DIR__ . '/../api/comprobar.sesion.php';
require_once __DIR__ . '/../class/class.Usuario.php';
require_once __DIR__ . '/../class/class.Sesion.php';
require_once __DIR__.'/../lib/mpdf/vendor/autoload.php';

$sesion = new Sesion(intval($_GET['id']));
$jugador = new Usuario($sesion->getIdJugador());

// Datos adicionales (simulación)
$objetivo = "Mejorar la comunicación en equipo y gestionar mejor las emociones durante las partidas.";
$proceso = "Durante la sesión se trabajaron técnicas de comunicación asertiva, control emocional y estrategias de cooperación dentro del juego.";

$codigoHTML = '

<h1>INFORME DE LA SESION</h1>

<h3>Detalles de la sesión</h3>
<table>
    <thead>
        <tr>
            <th>JUGADOR</th>
            <th>FECHA Y HORA</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>'.$jugador->getNombreCompleto().'</td>
            <td>'.$sesion->getFechaHora(true).'</td>
        </tr>
    </tbody>
</table>

<div class="section" style="margin-top:30px">
    <h3>OBJETIVO</h3>
    <p>'.$objetivo.'</p>
</div>

<div class="section">
    <h3>PROCESO</h3>
    <p>'.$proceso.'</p>
</div>
<div class="observaciones">
    <h3>OBSERVACIONES</h3>
    <p>'.$sesion->getObservaciones().'</p>
</div>


<p style="text-align:right;">En Las Palmas de Gran Canaria a, '.date('d').' de '.date('F').' de '.date('Y').'</p>

<div style="margin-top:50px; text-align:right;">
    ____________________________<br>
    Firma del entrenador
</div>
';
$mpdf = new \Mpdf\Mpdf([
   'mode' => 'utf-8',
   'format' => 'A4',
   'margin_left' => 20,
   'margin_right' => 20,
   'margin_top' => 20,
   'margin_bottom' => 20,
]);

$mpdf->SetTitle('Informe de Cita');
$mpdf->charset_in ="UTF-8";

$hojaEstilos = file_get_contents(__DIR__ . "/css/estilospdf.css");
$mpdf->WriteHTML($hojaEstilos, 1);
$mpdf->WriteHTML($codigoHTML, 2);

$mpdf->Output('informeSesion.pdf', \Mpdf\Output\Destination::INLINE);
?>
