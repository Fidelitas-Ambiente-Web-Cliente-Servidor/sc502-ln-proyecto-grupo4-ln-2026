<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/../../vendor/autoload.php';

class CorreoService {
    private $mail;

    public function __construct() {
        $this->mail = new PHPMailer(true);
        $this->mail->isSMTP();
        $this->mail->Host       = 'smtp.gmail.com';
        $this->mail->SMTPAuth   = true;
        $this->mail->Username   = 'alimentico.cr@gmail.com';
        $this->mail->Password   = 'txxn jltu cgmb zyqa';
        $this->mail->SMTPSecure = 'tls';
        $this->mail->Port       = 587;
        $this->mail->CharSet    = 'UTF-8';
    }

    public function enviarCorreoHtml($para, $asunto, $contenido) {
        $this->mail->setFrom('alimentico.cr@gmail.com', 'AlimenTICO');
        $this->mail->addAddress($para);
        $this->mail->isHTML(true);
        $this->mail->Subject = $asunto;
        $this->mail->Body    = $contenido;
        $this->mail->send();
    }
}