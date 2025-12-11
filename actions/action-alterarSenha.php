<?php
require_once "../config/database.php";
require_once "../config/config.php";
require_once "../includes/functions.php";

// Verifica se o usuário está logado
if (!isset($_SESSION['user_id'])) {
    header("Location: " . BASE_URL . "login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['nova_senha'], $_POST['confirmar_senha'])) {
        $nova_senha = $_POST['nova_senha'];
        $confirmar_senha = $_POST['confirmar_senha'];
        $user_id = $_SESSION['user_id'];

        // Validação 1: Verificar se a nova senha tem pelo menos 6 caracteres
        if (strlen($nova_senha) < 6) {
            header("Location: " . BASE_URL . "definicoes/index.php?erro_senha=" . urlencode("A nova senha deve ter no mínimo 6 caracteres."));
            exit();
        }

        // Validação 2: Verificar se a nova senha e a confirmação são iguais
        if ($nova_senha !== $confirmar_senha) {
            header("Location: " . BASE_URL . "definicoes/index.php?erro_senha=" . urlencode("A nova senha e a confirmação não coincidem."));
            exit();
        }

        $db = new Database();
        $conn = $db->getConnection();

        // Buscar a senha atual do usuário na base de dados
        $stmt = $conn->prepare("SELECT password FROM users WHERE id = :user_id");
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();

        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$usuario) {
            header("Location: " . BASE_URL . "definicoes/index.php?erro_senha=" . urlencode("Usuário não encontrado."));
            exit();
        }

        // Validação 3: Verificar se a nova senha é diferente da senha atual
        if (password_verify($nova_senha, $usuario['password'])) {
            header("Location: " . BASE_URL . "definicoes/index.php?erro_senha=" . urlencode("A nova senha não pode ser igual à senha atual."));
            exit();
        }

        // Criptografar a nova senha
        $nova_senha_hash = password_hash($nova_senha, PASSWORD_DEFAULT);

        // Atualizar a senha na base de dados
        $stmt_update = $conn->prepare("UPDATE users SET password = :nova_senha WHERE id = :user_id");
        $stmt_update->bindParam(':nova_senha', $nova_senha_hash);
        $stmt_update->bindParam(':user_id', $user_id);

        if ($stmt_update->execute()) {
            $db->closeConnection();
            header("Location: " . BASE_URL . "definicoes/index.php?sucesso_senha=" . urlencode("Senha alterada com sucesso!"));
            exit();
        } else {
            $db->closeConnection();
            header("Location: " . BASE_URL . "definicoes/index.php?erro_senha=" . urlencode("Erro ao alterar a senha. Tente novamente."));
            exit();
        }
    } else {
        header("Location: " . BASE_URL . "definicoes/index.php?erro_senha=" . urlencode("Por favor, preencha todos os campos obrigatórios."));
        exit();
    }
} else {
    header("Location: " . BASE_URL . "definicoes/index.php");
    exit();
}
