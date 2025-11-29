<?php
require_once "../config/database.php";
require_once "../config/config.php";
require_once "../includes/functions.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // Verificar se todos os dígitos foram enviados
    if (!isset($_POST['digit1'], $_POST['digit2'], $_POST['digit3'], $_POST['digit4'], $_POST['digit5'], $_POST['digit6'])) {
        header("Location: " . BASE_URL . "auth/ativacao.php?erro=" . urlencode("Todos os dígitos são obrigatórios."));
        exit();
    }
    
    // Determinar o email (prioridade: GET > SESSION)
    $email = null;
    
    if (isset($_GET['email']) && !empty($_GET['email'])) {
        $email = trim($_GET['email']);
    } else if (!empty($_SESSION['email_user'])) {
        $email = $_SESSION['email_user'];
    }
    
    if (!$email) {
        header("Location: " . BASE_URL . "auth/ativacao.php?erro=" . urlencode("Email não fornecido."));
        exit();
    }
    
    $db = new Database();
    $conn = $db->getConnection();
    
    $codigo = $_POST['digit1'] . $_POST['digit2'] . $_POST['digit3'] . $_POST['digit4'] . $_POST['digit5'] . $_POST['digit6'];

    $stmt = $conn->prepare("SELECT codigo_ativacao, status_utilizador FROM utilizadores WHERE email = :email");
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $codigo_user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$codigo_user) {
        header("Location: " . BASE_URL . "auth/ativacao.php?email=" . urlencode($email) . "&erro_utilizador=" . urlencode("Utilizador não encontrado."));
        exit();
    }

    if ($codigo == $codigo_user['codigo_ativacao']) {

        if ($codigo_user['status_utilizador'] === 'ativo') {
            if (!empty($_SESSION['email_user'])) {
                unset($_SESSION['email_user']);
            }
            header("Location: " . BASE_URL . "auth/login.php?msg=ja_ativo");
            exit();
        }

        $stmt = $conn->prepare('UPDATE utilizadores SET status_utilizador = :status WHERE email = :email');
        $status = 'ativo';
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        // Verificar após UPDATE
        $stmt = $conn->prepare("SELECT status_utilizador FROM utilizadores WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $check = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($check['status_utilizador'] === 'ativo') {
            if (!empty($_SESSION['email_user'])) {
                unset($_SESSION['email_user']);
            }
            header("Location: " . BASE_URL . "auth/login.php?msg=ativado");
            exit();
        } else {
            header("Location: " . BASE_URL . "auth/ativacao.php?email=" . urlencode($email) . "&erro_ativarConta=" . urlencode("Erro ao ativar a conta."));
            exit();
        }
    } else {
        header("Location: " . BASE_URL . "auth/ativacao.php?email=" . urlencode($email) . "&erro_codigoInvalido=" . urlencode("Código de ativação inválido."));
        exit();
    }
}
?>