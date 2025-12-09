<?php
    require_once "../config/database.php";
    require_once "../config/config.php";
    require_once "../includes/email.php";

    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        if(isset($_POST['name'], $_POST['email'], $_POST['palavra_passe'])) {
            $name = $_POST['name'];
            $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
            // Uso correto de BCRYPT para hashing de senha
            $palavra_passe = password_hash($_POST['palavra_passe'], PASSWORD_BCRYPT);

            $db = new Database();
            $conn = $db->getConnection();

            // 1. Verificar se o email já existe
            $stmt = $conn->prepare("SELECT id FROM utilizadores WHERE email = :email");
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            if($stmt->rowCount() > 0) {
                // Email já existe
                header("Location: " . BASE_URL . "utilizadores/criar.php?erro_email=" . urlencode("O email já está em uso."));
                exit();
            }

            // 2. Verificar o ID da empresa do utilizador logado (assumindo que $_SESSION['user_id'] está definido)
            // É crucial garantir que a sessão já está iniciada e a variável está disponível.
            if (!isset($_SESSION['user_id'])) {
                // Tratar o caso em que o ID do utilizador logado não está na sessão
                // Exemplo: Redirecionar para login ou usar um valor padrão/erro
                header("Location: " . BASE_URL . "login.php?erro=" . urlencode("Sessão expirada ou utilizador não logado."));
                exit();
            }

            $stmt = $conn->prepare("SELECT empresa_id FROM utilizadores WHERE id = :user_id");
            $stmt->bindParam(':user_id', $_SESSION['user_id']);
            $stmt->execute();
            $empresa = $stmt->fetch(PDO::FETCH_ASSOC);

            // 3. Inserir novo utilizador
            $stmt = $conn->prepare("INSERT INTO utilizadores (empresa_id, nome, email, password) VALUES (:empresa_id, :nome, :email, :password)");
            $stmt->bindParam(':empresa_id', $empresa['empresa_id']);
            $stmt->bindParam(':nome', $name);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $palavra_passe);

            if($stmt->execute()) {
                // 4. Obter o código de ativação do novo utilizador APÓS a inserção
                // O utilizador deve agora existir na base de dados.
                $stmt_codigo = $conn->prepare("SELECT codigo_ativacao FROM utilizadores WHERE email = :email");
                $stmt_codigo->bindParam(':email', $email);
                $stmt_codigo->execute();
                $resultado_codigo = $stmt_codigo->fetch(PDO::FETCH_ASSOC);

                if ($resultado_codigo && isset($resultado_codigo['codigo_ativacao'])) {
                    $codigo_ativacao = $resultado_codigo['codigo_ativacao'];

                    // 5. Enviar email de boas-vindas
                    enviarEmailBoasVindas($email, $name, $codigo_ativacao);
                    header("Location: " . BASE_URL . "utilizadores/index.php?sucesso_criar=" . urlencode("Utilizador criado com sucesso."));
                    exit();
                } else {
                    // Erro ao obter código de ativação (o utilizador foi criado, mas o código não foi encontrado)
                    header("Location: " . BASE_URL . "utilizadores/criar.php?erro_ativacao=" . urlencode("Utilizador criado, mas falha ao obter código de ativação."));
                    exit();
                }

            } else {
                // Erro ao executar o INSERT
                header("Location: " . BASE_URL . "utilizadores/criar.php?erro_geral=" . urlencode("Ocorreu um erro ao criar o utilizador."));
                exit();
            }

            $db->closeConnection();
        }
    }

?>