<?php
require_once __DIR__ . '/../config/config.globales.php';
require_once __DIR__ . '/../db/class.HandlerDB.php';
require_once __DIR__ . '/function.globales.php';
require_once __DIR__ . '/abstract.class.ObjetoDB.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . "/../lib/phpmailer/vendor/autoload.php";
require_once __DIR__ . "/../config/config.email.php";


class MensajeEmail extends ObjetoDB
{
    protected int $id = 0;
    protected int $idUsuario = 0;
    protected string $asunto = "";
    protected string $destinatarios = "";
    protected string $destinatariosCC = "";
    protected string $destinatariosCCO = "";
    protected string $cuerpoMensaje = "";
    protected string $fechaHoraCreacion = "";
    protected string $fechaHoraUltimoEnvio = "";
    protected int $enviado = 0;
    protected int $error = 0;
    protected string $mensajeError = "";

    public function __construct(int $id = 0, string $otraClave = "", $valorOtraClave = "")
    {
        parent::__construct($id, $otraClave, $valorOtraClave);
        $this->setDestinatarios([]);
        $this->setDestinatariosCC([]);
        $this->setDestinatariosCCO([]);

    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getIdUsuario(): int
    {
        return $this->idUsuario;
    }

    public function setIdUsuario(int $idUsuario): void
    {
        $this->idUsuario = $idUsuario;
    }

    public function getAsunto(): string
    {
        return $this->asunto;
    }

    public function setAsunto(string $asunto): void
    {
        $this->asunto = sanitizarString($asunto);
    }
    public function getDestinatarios(): array
    {
        return json_decode($this->destinatarios, true) ?? [];
    }

    public function setDestinatarios(array $destinatarios): void
    {
        $this->destinatarios = json_encode($destinatarios);
    }

    public function getDestinatariosCC(): array
    {
        return json_decode($this->destinatariosCC, true) ?? [];
    }

    public function setDestinatariosCC(array $destinatariosCC): void
    {
        $this->destinatariosCC = json_encode($destinatariosCC);
    }
    public function getDestinatariosCCO(): array
    {
        return json_decode($this->destinatariosCCO, true) ?? [];
    }

    public function setDestinatariosCCO(array $destinatariosCCO): void
    {
        $this->destinatariosCCO = json_encode($destinatariosCCO);
    }

    public function getCuerpoMensaje(): string
    {
        return $this->cuerpoMensaje;
    }

    public function setCuerpoMensaje(string $cuerpoMensaje): void
    {
        $this->cuerpoMensaje = $cuerpoMensaje;
    }

    public function getFechaHoraCreacion(bool $formateada = false): bool
    {
        if ($formateada) {
            return date("d/m/Y H:i", strtotime($this->fechaHoraCreacion));
        }
        return sanitizarString($this->fechaHoraCreacion);
    }

    public function setFechaHoraCreacion(string $fecha): bool
    {
        $fecha = sanitizarString($fecha);
        if (DateTime::createFromFormat("Y-m-d H:i:s", $fecha) !== false) {
            $this->fechaHoraCreacion = $fecha;
            return true;
        }
        return false;
    }

    public function getFechaHoraUltimoEnvio(bool $formateada = false): string
    {
        if ($formateada) {
            return date("d/m/y H:i", strtotime($this->fechaHoraUltimoEnvio));
        }
        return sanitizarString($this->fechaHoraUltimoEnvio);
    }

    public function setFechaHoraUltimoEnvio(string $fecha): bool
    {
        $fecha = sanitizarString($fecha);
        if (DateTime::createFromFormat("Y-m-d H:i:s", $fecha) !== false) {
            $this->fechaHoraUltimoEnvio = $fecha;
            return true;
        }
        return false;
    }

    public function getEnviado(): int
    {
        return $this->enviado;
    }

    public function setEnviado(int $enviado): void
    {
        $this->enviado = $enviado;
    }

    public function getError(): int
    {
        return $this->error;
    }

    public function setError(int $error): void
    {
        $this->error = $error;
    }

    public function getMensajeError(): string
    {
        return $this->mensajeError;
    }

    public function setMensajeError(string $mensajeError): void
    {
        $this->mensajeError = $mensajeError;
    }

    public function guardar(): bool
    {
        if ($this->fechaHoraCreacion == "" || $this->asunto == "") {
            return false;
        }

        return parent::guardar();
    }

    public function enviar(): bool {
        $mail = new PHPMailer(true);

        try {
            //Server settings
            $mail->SMTPDebug = SMTP::DEBUG_OFF;                      //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = CONFIG_EMAIL["HOST"];                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = CONFIG_EMAIL["USER"];;                     //SMTP username
            $mail->Password   = CONFIG_EMAIL["PASSWORD"];;                               //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
            $mail->Port       = CONFIG_EMAIL["PORT"];;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            //Recipients
            $mail->setFrom(CONFIG_EMAIL["REMITENTE_EMAIL"], 'Abián Camejo díaz');
            foreach ($this->getDestinatarios() as $destinatario) {
                $mail->addAddress($destinatario["email"], $destinatario["nombre"]);
            }
            foreach ($this->getDestinatariosCC() as $destinatario) {
                $mail->addCC($destinatario["email"], $destinatario["nombre"]);
            }
            foreach ($this->getDestinatariosCCO() as $destinatario) {
                $mail->addBCC($destinatario["email"], $destinatario["nombre"]);
            }
            $mail->addAddress('abian.camejo@gmail.com', 'Abián Camejo díaz');     //Add a recipient
            //$mail->addAddress('ellen@example.com');               //Name is optional
            //$mail->addReplyTo('info@example.com', 'Information');
            //$mail->addCC('cc@example.com');
            //$mail->addBCC('bcc@example.com');

            //Attachments
            //$mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
            //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

            //Content
            $mail->CharSet ="UTF-8";
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = $this->getAsunto();
            $mail->Body    = $this->getCuerpoMensaje();
            $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            $mail->send();
            $this->setEnviado(1);
            $this->setFechaHoraUltimoEnvio(date("Y-m-d H:i:s"));
            $this->guardar();
            return true;
        } catch (Exception $e) {
            $this->setError(1);
            $this->setMensajeError($mail->ErrorInfo);
            $this->setFechaHoraUltimoEnvio(date("Y-m-d H:i:s"));
            $this->guardar();
            return false;
        }
    }
}
/*
$mensaje = new MensajeEmail();
$mensaje->setDestinatarios(["nombre" => "Abian", "email" => "abian.camejo@gmail.com"]);
$mensaje->setDestinatariosCC([]);
$mensaje->setDestinatariosCCO([]);


$mensaje->setAsunto("Asunto de prueba");
$mensaje->setCuerpoMensaje("estoy probando el programa");
$mensaje->setFechaHoraCreacion(date("Y-m-d H:i:s"));
$mensaje->guardar();

*/