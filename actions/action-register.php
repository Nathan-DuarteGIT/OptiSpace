<?php
require_once "../config/database.php";
require_once "../config/config.php";
require_once "../includes/email.php";

// Verificar se é POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: " . BASE_URL . "auth/registo_empresa.php");
    exit();
}

// Verificar se todos os campos foram enviados
if (!isset($_POST['name_admin'], $_POST['name_empresa'], $_POST['email'], $_POST['password'])) {
    header("Location: " . BASE_URL . "auth/registo_empresa.php?erro=" . urlencode("Todos os campos são obrigatórios."));
    exit();
}

// Capturar e validar dados
$name_admin = trim($_POST['name_admin']);
$name_empresa = trim($_POST['name_empresa']);
$email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
$password = trim($_POST['password']);

// Validar campos vazios
if (empty($name_admin) || empty($name_empresa) || empty($email) || empty($password)) {
    $params = http_build_query([
        'erro' => 'Todos os campos são obrigatórios.',
        'name_admin' => $name_admin,
        'name_empresa' => $name_empresa,
        'email' => $email
    ]);
    header("Location: " . BASE_URL . "auth/registo_empresa.php?" . $params);
    exit();
}

// Validar nome completo (pelo menos 2 palavras)
$name_parts = explode(' ', $name_admin);
if (count($name_parts) < 2) {
    $params = http_build_query([
        'erro' => 'Por favor, insira o primeiro e último nome.',
        'name_admin' => $name_admin,
        'name_empresa' => $name_empresa,
        'email' => $email
    ]);
    header("Location: " . BASE_URL . "auth/registo_empresa.php?" . $params);
    exit();
}

// Validar formato de email
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $params = http_build_query([
        'erro' => 'Por favor, insira um email válido.',
        'name_admin' => $name_admin,
        'name_empresa' => $name_empresa,
        'email' => $email
    ]);
    header("Location: " . BASE_URL . "auth/registo_empresa.php?" . $params);
    exit();
}

// Validar tamanho da palavra-passe
if (strlen($password) < 6) {
    $params = http_build_query([
        'erro' => 'A palavra-passe deve ter no mínimo 6 caracteres.',
        'name_admin' => $name_admin,
        'name_empresa' => $name_empresa,
        'email' => $email
    ]);
    header("Location: " . BASE_URL . "auth/registo_empresa.php?" . $params);
    exit();
}

// Hash da palavra-passe
$password_hash = password_hash($password, PASSWORD_BCRYPT);

try {
    $db = new Database();
    $conn = $db->getConnection();

    // Verificar se o email já existe
    $stmt = $conn->prepare("SELECT id FROM utilizadores WHERE email = :email");
    $stmt->bindParam(':email', $email);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $params = http_build_query([
            'erro' => 'Este email já está registado.',
            'name_admin' => $name_admin,
            'name_empresa' => $name_empresa,
            'email' => $email
        ]);
        header("Location: " . BASE_URL . "auth/registo_empresa.php?" . $params);
        exit();
    }

    // Preparar e executar a inserção da empresa
    $stmt = $conn->prepare("INSERT INTO empresa (nome) VALUES (:name_empresa)");
    $stmt->bindParam(':name_empresa', $name_empresa);

    if ($stmt->execute()) {
        $empresa_id = $conn->lastInsertId();

        // Inserir utilizador admin
        $stmt = $conn->prepare("INSERT INTO utilizadores (empresa_id, nome, email, password, nivel_acesso) VALUES (:empresa_id, :name_admin, :email, :password, 'admin')");
        $stmt->bindParam(':empresa_id', $empresa_id);
        $stmt->bindParam(':name_admin', $name_admin);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password_hash);

        if ($stmt->execute()) {
            // Buscar código de ativação gerado
            $stmt = $conn->prepare("SELECT codigo_ativacao FROM utilizadores WHERE email = :email");
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($result && !empty($result['codigo_ativacao'])) {
                // Enviar email com código de ativação
                enviarCodigoAtivacao($email, $result['codigo_ativacao']);

                // Guardar email na sessão
                $_SESSION['email_user'] = $email;

                // Redirecionar para página de ativação com email
                header("Location: " . BASE_URL . "auth/ativacao.php?email=" . urlencode($email));
                exit();
            } else {
                header("Location: " . BASE_URL . "auth/registo_empresa.php?erro=" . urlencode("Erro ao gerar código de ativação."));
                exit();
            }
        } else {
            header("Location: " . BASE_URL . "auth/registo_empresa.php?erro=" . urlencode("Erro ao registar o utilizador."));
            exit();
        }
    } else {
        header("Location: " . BASE_URL . "auth/registo_empresa.php?erro=" . urlencode("Erro ao registar a empresa."));
        exit();
    }

    $db->closeConnection();
} catch (PDOException $e) {
    error_log("Erro no registo: " . $e->getMessage());

    $params = http_build_query([
        'erro' => 'Erro ao processar o registo. Tente novamente.',
        'name_admin' => $name_admin,
        'name_empresa' => $name_empresa,
        'email' => $email
    ]);
    header("Location: " . BASE_URL . "auth/registo_empresa.php?" . $params);
    exit();
}
