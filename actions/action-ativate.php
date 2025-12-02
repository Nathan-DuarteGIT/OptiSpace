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

    // Determinar o email 
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

    // Validar se os dígitos não estão vazios
    $digit1 = isset($_POST['digit1']) ? trim($_POST['digit1']) : '';
    $digit2 = isset($_POST['digit2']) ? trim($_POST['digit2']) : '';
    $digit3 = isset($_POST['digit3']) ? trim($_POST['digit3']) : '';
    $digit4 = isset($_POST['digit4']) ? trim($_POST['digit4']) : '';
    $digit5 = isset($_POST['digit5']) ? trim($_POST['digit5']) : '';
    $digit6 = isset($_POST['digit6']) ? trim($_POST['digit6']) : '';

    if (
        $digit1 === '' || $digit2 === '' || $digit3 === '' ||
        $digit4 === '' || $digit5 === '' || $digit6 === ''
    ) {
        header("Location: " . BASE_URL . "auth/ativacao.php?email=" . urlencode($email) . "&erro=" . urlencode("Por favor, preencha todos os dígitos do código."));
        exit();
    }

    $db = new Database();
    $conn = $db->getConnection();

    $codigo = $digit1 . $digit2 . $digit3 . $digit4 . $digit5 . $digit6;

    // Validar se o código contém apenas números
    if (!ctype_digit($codigo)) {
        header("Location: " . BASE_URL . "auth/ativacao.php?email=" . urlencode($email) . "&erro=" . urlencode("O código deve conter apenas números."));
        exit();
    }

    try {
        // Buscar utilizador e seu nível de acesso
        $stmt = $conn->prepare("SELECT codigo_ativacao, status_utilizador, nivel_acesso FROM utilizadores WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $codigo_user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$codigo_user) {
            header("Location: " . BASE_URL . "auth/ativacao.php?email=" . urlencode($email) . "&erro=" . urlencode("Utilizador não encontrado."));
            exit();
        }

        // Verificar se já está ativo 
        if ($codigo_user['status_utilizador'] === 'ativo') {
            if (!empty($_SESSION['email_user'])) {
                unset($_SESSION['email_user']);
            }
            header("Location: " . BASE_URL . "auth/login.php?msg=ja_ativo");
            exit();
        }

        // Verificar se o código está correto 
        if (strval($codigo) !== strval($codigo_user['codigo_ativacao'])) {
            header("Location: " . BASE_URL . "auth/ativacao.php?email=" . urlencode($email) . "&erro=" . urlencode("Código incorreto. Por favor, insira novamente."));
            exit();
        }

        // Código correto - determinar o status baseado no nível de acesso
        $novo_status = 'ativo';

        // Log para debug
        error_log("Ativando conta - Email: $email, Nível: {$codigo_user['nivel_acesso']}, Novo Status: $novo_status");

        $stmt = $conn->prepare('UPDATE utilizadores SET status_utilizador = :status WHERE email = :email');
        $stmt->bindParam(':status', $novo_status);
        $stmt->bindParam(':email', $email);

        if (!$stmt->execute()) {
            error_log("Erro ao executar UPDATE para email: $email");
            header("Location: " . BASE_URL . "auth/ativacao.php?email=" . urlencode($email) . "&erro=" . urlencode("Erro ao atualizar o status. Tente novamente."));
            exit();
        }

        // Verificar quantas linhas foram afetadas
        $rowsAffected = $stmt->rowCount();
        error_log("Linhas afetadas pelo UPDATE: $rowsAffected");

        // Verificar se a atualização foi bem-sucedida
        $stmt = $conn->prepare("SELECT status_utilizador FROM utilizadores WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $check = $stmt->fetch(PDO::FETCH_ASSOC);

        error_log("Status após UPDATE: " . ($check ? $check['status_utilizador'] : 'não encontrado'));

        if ($check && $check['status_utilizador'] === 'ativo') {
            if (!empty($_SESSION['email_user'])) {
                unset($_SESSION['email_user']);
            }
            error_log("Conta ativada com sucesso para: $email");
            header("Location: " . BASE_URL . "auth/login.php?msg=ativado");
            exit();
        } else {
            error_log("Falha na ativação - Status final: " . ($check ? $check['status_utilizador'] : 'não encontrado'));
            header("Location: " . BASE_URL . "auth/ativacao.php?email=" . urlencode($email) . "&erro=" . urlencode("Erro ao ativar a conta. Tente novamente."));
            exit();
        }
    } catch (PDOException $e) {
        // Log do erro para depuração
        error_log("Erro na ativação: " . $e->getMessage());

        header("Location: " . BASE_URL . "auth/ativacao.php?email=" . urlencode($email) . "&erro=" . urlencode("Erro ao processar a ativação. Tente novamente."));
        exit();
    }
} else {
    header("Location: " . BASE_URL . "auth/ativacao.php");
    exit();
}
