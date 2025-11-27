<?php
require __DIR__ . '/../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;

$mail = new PHPMailer(true);

$mail->isSMTP();
$mail->Host       = 'smtp.hostinger.com';
$mail->SMTPAuth   = true;
$mail->Username   = 'andnat@antrob.eu';
$mail->Password   = '&t1Q6=njx]BK';
$mail->SMTPSecure = 'tls';
$mail->Port       = 587;

function enviarCodigoAtivacao($destinatario, $codigo_ativacao)
{
    global $mail;

    try {
        $mail->setFrom($mail->Username, 'OptiSpace');
        $mail->addAddress($destinatario);

        $mail->Subject = 'Código de Ativação';
        $mail->Body    = 'Seu código de ativação é: ' . $codigo_ativacao;

        if ($mail->send()) {
            return true;
        } else {
            return false;
        }
    } catch (Exception $e) {
        echo "Erro ao enviar email: {$mail->ErrorInfo}";
        return false;
    }
}


function enviarEmailRecuperacao($destinatario){

    global $mail;

    try {
        $mail->setFrom($mail->Username, 'OptiSpace');
        $mail->addAddress($destinatario);

        $mail->Subject = 'Redefinição da Sua Palavra-passe';
        $mail->Body    = "Recebemos um pedido para recuperar o acesso à sua conta. \n" . "Para continuar, clique no link abaixo e siga as instruções: \n" .
                         BASE_URL . 'auth/mudar-passe.php?email=' . $destinatario . "\n \n" .
                         'Se você não solicitou essa alteração, por favor ignore este email.';

        if ($mail->send()) {
            return true;
        } else {
            return false;
        }
    } catch (Exception $e) {
        echo "Erro ao enviar email: {$mail->ErrorInfo}";
        return false;
    }
    
}