<?php
    require_once "../config/database.php";
    require_once "../config/config.php";
    require_once "../includes/email.php";

    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        if(isset($_POST['email']) && isset($_POST['password'])) {
            $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
            $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

            $db = new Database();
            $conn = $db->getConnection();

            // Atualizar a palavra-passe do utilizador
            $stmt = $conn->prepare("UPDATE utilizadores SET password = :password WHERE email = :email");
            $stmt->bindParam(':password', $password);
            $stmt->bindParam(':email', $email);
            $stmt->execute();

            header("Location: " . BASE_URL . "auth/login.php?sucesso_mudar=" . urlencode("Palavra-passe alterada com sucesso. Pode agora entrar."));
            exit();

            $db->closeConnection();
        }
    }

?>