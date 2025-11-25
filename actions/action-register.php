<?php
    require_once "../config/database.php";
    require_once "../config/config.php";
    require_once "../includes/email.php";

    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        if(isset($_POST['name_admin'], $_POST['name_empresa'], $_POST['email'], $_POST['password'])) {
            $name_admin = $_POST['name_admin'];
            $name_empresa = $_POST['name_empresa'];
            $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
            $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

            $db = new Database();
            $conn = $db->getConnection();
            //verificar se o email já existe
            $stmt = $conn->prepare("SELECT id FROM utilizadores WHERE email = :email");
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            if($stmt->rowCount() > 0) {
                header("Location: " . BASE_URL . "auth/registo_empresa.php?erro_email=" . urlencode("Email já existe!"));
                exit();
            }

            // Preparar e executar a inserção
            $stmt = $conn->prepare("INSERT INTO empresa (nome) VALUES (:name_empresa)");
            $stmt->bindParam(':name_empresa', $name_empresa);

            if ($stmt->execute()) {
                $empresa_id = $conn->lastInsertId();
                $stmt = $conn->prepare("INSERT INTO utilizadores (empresa_id, nome, email, password, nivel_acesso) VALUES (:empresa_id, :name_admin, :email, :password, 'admin')");
                $stmt->bindParam(':empresa_id', $empresa_id);
                $stmt->bindParam(':name_admin', $name_admin);
                $stmt->bindParam(':email', $email);
                $stmt->bindParam(':password', $password);
                if($stmt->execute()) {
                    // Registo bem-sucedido
                    $stmt = $conn->prepare("SELECT codigo_ativacao FROM utilizadores WHERE email = :email");
                    $stmt->bindParam(':email', $email);
                    $stmt->execute();
                    $codigo_ativacao = $stmt->fetch(PDO::FETCH_ASSOC);
                    enviarCodigoAtivacao($email, $codigo_ativacao['codigo_ativacao']);
                    $_SESSION['email_user'] = $email;
                    header("Location: " . BASE_URL . "auth/ativacao.php");
                    exit();
                } else {
                    // Erro no registo do utilizador
                    header("Location: " . BASE_URL . "auth/registo_empresa.php?erro_registoUtilizador=" . urlencode("Erro ao registar o utilizador!"));
                    exit();
                }


            } else {
                // Erro no registo
                header("Location: " . BASE_URL . "auth/registo_empresa.php?erro_registoEmpresa=" . urlencode("Erro ao registar a empresa."));
                exit();
            }
            $db->closeConnection();
        }
    }
?>