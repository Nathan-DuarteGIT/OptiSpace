<?php
    require_once "../config/database.php";
    require_once "../config/config.php";
    require_once "../includes/email.php";

    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        if(isset($_POST['name'], $_POST['email'], $_POST['palavra_passe'])) {
            $name = $_POST['name'];
            $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
            $palavra_passe = password_hash($_POST['palavra_passe'], PASSWORD_BCRYPT);

            $db = new Database();
            $conn = $db->getConnection();

            // Verificar se o email já existe
            $stmt = $conn->prepare("SELECT id FROM utilizadores WHERE email = :email");
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            if($stmt->rowCount() > 0) {
                // Email já existe
                header("Location: " . BASE_URL . "utilizadores/criar.php?erro_email=" . urlencode("O email já está em uso."));
                exit();
            }
            //verificar o id da empresa do utilizador logado
            $stmt = $conn->prepare("SELECT empresa_id FROM utilizadores WHERE id = :user_id");
            $stmt->bindParam(':user_id', $_SESSION['user_id']);
            $stmt->execute();
            $empresa = $stmt->fetch(PDO::FETCH_ASSOC);


            // Inserir novo utilizador
            $stmt = $conn->prepare("INSERT INTO utilizadores (empresa_id, nome, email, palavra_passe) VALUES (:empresa_id, :nome, :email, :palavra_passe)");
            $stmt->bindParam(':empresa_id', $empresa['empresa_id']);
            $stmt->bindParam(':nome', $name);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':palavra_passe', $palavra_passe);

            // Obter o código de ativação do novo utilizador
            $stmt_codigo = $conn->prepare("SELECT codigo_ativacao FROM utilizadores WHERE email = :email");
            $stmt_codigo->bindParam(':email', $email);
            $stmt_codigo->execute();
            $codigo_ativacao = $stmt_codigo->fetch(PDO::FETCH_ASSOC)['codigo_ativacao'];

            if($stmt->execute()) {
                // Enviar email de boas-vindas
                enviarEmailBoasVindas($email, $name, $codigo_ativacao);
                header("Location: " . BASE_URL . "utilizadores/index.php?sucesso_criar=" . urlencode("Utilizador criado com sucesso."));
                exit();
            } else {
                header("Location: " . BASE_URL . "utilizadores/criar.php?erro_geral=" . urlencode("Ocorreu um erro ao criar o utilizador."));
                exit();
            }

            $db->closeConnection();
        }
    }

?>