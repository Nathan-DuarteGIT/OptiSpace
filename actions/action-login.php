<?php
require_once "../config/database.php";
require_once "../config/config.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];

    $db = new Database();
    $conn = $db->getConnection();

    // Preparar e executar a consulta
    $stmt = $conn->prepare("SELECT id, nome, foto_path, nivel_acesso, password FROM utilizadores WHERE email = :email");
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {

        // Verificar se a conta está ativa
        if ($user['ativo'] == 0) {
            header("Location: " . BASE_URL . "auth/login.php?conta_inativa=" . urlencode("A conta está inativa."));
            exit();
        }

        // Credenciais válidas, iniciar sessão
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['nome'];
        $_SESSION['user_photo'] = $user['foto_path'];
        $_SESSION['nivel_acesso'] = $user['nivel_acesso'];
        header("Location: " . BASE_URL . "dashboard/index.php");
        exit();
    } else {
        // Credenciais inválidas
        header("Location: " . BASE_URL . "auth/login.php?erro_credenciais=" . urlencode("Email ou palavra-passe inválidos."));
        exit();
    }
    $db->closeConnection();
}
