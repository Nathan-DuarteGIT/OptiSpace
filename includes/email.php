<?php
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;

$mail = new PHPMailer(true);

$mail->isSMTP();
$mail->Host       = 'smtp.gmail.com';
$mail->SMTPAuth   = true;
$mail->Username   = 'teuemail@gmail.com';
$mail->Password   = 'TUA_SENHA_DE_APP';
$mail->SMTPSecure = 'tls';
$mail->Port       = 587;

function enviarCodigoAtivacao($destinatario, $codigo_ativacao) {
    global $mail;

    try {
        $mail->setFrom($mail->Username, 'OptiSpace');
        $mail->addAddress($destinatario);

        $mail->Subject = 'Código de Ativação';
        $mail->Body    = 'Seu código de ativação é: ' . $codigo_ativacao;

        if($mail->send()) {
            return true;
        } else {
            return false;
        }

    } catch (Exception $e) {
        echo "Erro ao enviar email: {$mail->ErrorInfo}";
        return false;
    }
}
?>