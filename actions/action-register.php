<?php
require_once "../config/database.php";
require_once "../config/config.php";
require_once "../includes/functions.php";
require_once "../includes/email.php";

// Verificar se é POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: " . BASE_URL . "auth/registo-empresa.php");
    exit();
}

// Verificar se todos os campos foram enviados
if (!isset($_POST['name_admin'], $_POST['name_empresa'], $_POST['email'], $_POST['password'])) {
    header("Location: " . BASE_URL . "auth/registo-empresa.php?erro=" . urlencode("Todos os campos são obrigatórios."));
    exit();
}

// Capturar e validar dados
$name_admin = trim($_POST['name_admin']);
$name_empresa = trim($_POST['name_empresa']);
$email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
$password = trim($_POST['password']);

// Validar campos vazios
if (empty($name_admin) || empty($name_empresa) || empty($email) || empty($password)) {
    $_SESSION['erro_registo'] = 'Todos os campos são obrigatórios.';
    $_SESSION['form_data'] = [
        'name_admin' => $name_admin,
        'name_empresa' => $name_empresa,
        'email' => $email
    ];
    header("Location: " . BASE_URL . "auth/registo-empresa.php");
    exit();
}

// Validar nome completo (pelo menos 2 palavras)
$name_parts = explode(' ', $name_admin);
if (count($name_parts) < 2) {
    $_SESSION['erro_registo'] = 'Por favor, insira o primeiro e último nome.';
    $_SESSION['form_data'] = [
        'name_admin' => $name_admin,
        'name_empresa' => $name_empresa,
        'email' => $email
    ];
    header("Location: " . BASE_URL . "auth/registo-empresa.php");
    exit();
}

// Validar formato de email
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION['erro_registo'] = 'Por favor, insira um email válido.';
    $_SESSION['form_data'] = [
        'name_admin' => $name_admin,
        'name_empresa' => $name_empresa,
        'email' => $email
    ];
    header("Location: " . BASE_URL . "auth/registo-empresa.php");
    exit();
}

// Validar tamanho da palavra-passe
if (strlen($password) < 6) {
    $_SESSION['erro_registo'] = 'A palavra-passe deve ter no mínimo 6 caracteres.';
    $_SESSION['form_data'] = [
        'name_admin' => $name_admin,
        'name_empresa' => $name_empresa,
        'email' => $email
    ];
    header("Location: " . BASE_URL . "auth/registo-empresa.php");
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
        $_SESSION['erro_registo'] = 'Este email já está registado.';
        $_SESSION['form_data'] = [
            'name_admin' => $name_admin,
            'name_empresa' => $name_empresa,
            'email' => $email
        ];
        header("Location: " . BASE_URL . "auth/registo-empresa.php");
        exit();
    }

    // Verificar se a empresa já existe
    $stmt = $conn->prepare("SELECT id FROM empresa WHERE nome = :name_empresa");
    $stmt->bindParam(':name_empresa', $name_empresa);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $_SESSION['erro_registo'] = 'Esta empresa já está cadastrada.';
        $_SESSION['form_data'] = [
            'name_admin' => $name_admin,
            'name_empresa' => $name_empresa,
            'email' => $email
        ];
        header("Location: " . BASE_URL . "auth/registo-empresa.php");
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
                $_SESSION['erro_registo'] = 'Erro ao gerar código de ativação.';
                $_SESSION['form_data'] = [
                    'name_admin' => $name_admin,
                    'name_empresa' => $name_empresa,
                    'email' => $email
                ];
                header("Location: " . BASE_URL . "auth/registo-empresa.php");
                exit();
            }
        } else {
            $_SESSION['erro_registo'] = 'Erro ao registar o utilizador.';
            $_SESSION['form_data'] = [
                'name_admin' => $name_admin,
                'name_empresa' => $name_empresa,
                'email' => $email
            ];
            header("Location: " . BASE_URL . "auth/registo-empresa.php");
            exit();
        }
    } else {
        $_SESSION['erro_registo'] = 'Erro ao registar a empresa.';
        $_SESSION['form_data'] = [
            'name_admin' => $name_admin,
            'name_empresa' => $name_empresa,
            'email' => $email
        ];
        header("Location: " . BASE_URL . "auth/registo-empresa.php");
        exit();
    }

    $db->closeConnection();
} catch (PDOException $e) {
    error_log("Erro no registo: " . $e->getMessage());

    $_SESSION['erro_registo'] = 'Erro ao processar o registo. Tente novamente.';
    $_SESSION['form_data'] = [
        'name_admin' => $name_admin,
        'name_empresa' => $name_empresa,
        'email' => $email
    ];
    header("Location: " . BASE_URL . "auth/registo-empresa.php");
    exit();
}
