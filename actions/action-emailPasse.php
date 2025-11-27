<?php
    require_once "../config/database.php";
    require_once "../config/config.php";
    require_once "../includes/email.php";

    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        if(isset($_POST['email'])) {
            $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);

            $db = new Database();
            $conn = $db->getConnection();

            // Verificar se o email existe
            $stmt = $conn->prepare("SELECT id, nome FROM utilizadores WHERE email = :email");
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if($user) {
                // Enviar email com o link de recuperação
                enviarEmailRecuperacao($email, $user['nome']);
                header("Location: " . BASE_URL . "auth/login.php?sucesso_recover=" . urlencode("Instruções para recuperar a palavra-passe foram enviadas para o seu email."));
                exit();
            } else {
                // Email não encontrado
                header("Location: " . BASE_URL . "auth/recuperar-passe.php?erro_email=" . urlencode("Email não encontrado."));
                exit();
            }
            $db->closeConnection();
        }
    }
?>