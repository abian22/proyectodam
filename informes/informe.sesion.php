<?php
require_once __DIR__ . '/../config/config.globales.php';
require_once __DIR__ . '/../api/comprobar.sesion.php';
require_once __DIR__ . '/../class/class.Usuario.php';
require_once __DIR__ . '/../class/class.Sesion.php';
require_once __DIR__.'/../lib/mpdf/vendor/autoload.php';

$sesion = new Sesion(intval($_GET['id']));
$jugador = new Usuario($sesion->getIdJugador());

$codigoHTML = '
<h1>INFORME DE CITA</h1>

<table>
    <tbody>
        <tr>
            <td style="width: 5cm">PACIENTE</td>
            <td>FECHA Y HORA</td>
            <td>OBSERVACIONES</td>
        </tr>
        <tr>
            <td>'.$jugador->getNombreCompleto().'</td>
            <td>'.$sesion->getFechaHora(true).'</td>
            <td>'.$sesion->getObservaciones().'</td>
        </tr>
    </tbody>
</table>

<p>En Santa Cruz de Tenerife a, '.date('d').' de '.date('F').' de '.date('Y').'</p>
';

$mpdf = new \Mpdf\Mpdf([
   'mode' => 'utf-8',
   'format' => 'A4',
   'margin_left' => 10,
   'margin_right' => 10,
   'margin_top' => 15,
   'margin_bottom' => 15,
]);

$mpdf->SetTitle('Informe de Cita');
$mpdf->charset_in ="UTF-8";

$hojaEstilos = file_get_contents(__DIR__ . "/css/estilospdf.css");
$mpdf->WriteHTML($hojaEstilos, 1);
$mpdf->WriteHTML($codigoHTML, 2);

$mpdf->Output('informeSesion.pdf', \Mpdf\Output\Destination::INLINE);