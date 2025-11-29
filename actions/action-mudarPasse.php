<?php
require_once "../config/database.php";
require_once "../config/config.php";
require_once "../includes/email.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['email']) && isset($_POST['password']) && isset($_POST['ConfirmPassword'])) {
        if ($_POST['password'] !== $_POST['ConfirmPassword']) {
            header("Location: " . BASE_URL . "auth/mudar-passe.php?email=" . urlencode($_POST['email']) . "&erro_mudar=" . urlencode("As palavras-passe não coincidem."));
            exit();
        }
        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        $new_password = $_POST['password'];
        $password_hash = password_hash($new_password, PASSWORD_BCRYPT);

        $db = new Database();
        $conn = $db->getConnection();

        // Verificar se o utilizador existe e obter a palavra-passe atual
        $stmt = $conn->prepare("SELECT password FROM utilizadores WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            $old_hash = $row['password'];
            if (password_verify($new_password, $old_hash)) {
                header("Location: " . BASE_URL . "auth/mudar-passe.php?email=" . urlencode($_POST['email']) . "&erro_mudar=" . urlencode("A nova palavra-passe não pode ser igual à anterior."));
                exit();
            }
        } else {
            // Se o utilizador não existir, redirecionar com erro
            header("Location: " . BASE_URL . "auth/mudar-passe.php?email=" . urlencode($_POST['email']) . "&erro_mudar=" . urlencode("Utilizador não encontrado."));
            exit();
        }

        // Atualizar a palavra-passe do utilizador
        $stmt = $conn->prepare("UPDATE utilizadores SET password = :password WHERE email = :email");
        $stmt->bindParam(':password', $password_hash);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        header("Location: " . BASE_URL . "auth/login.php?sucesso_mudar=" . urlencode("Palavra-passe alterada com sucesso. Pode agora entrar."));
        exit();

        $db->closeConnection();
    }
}
