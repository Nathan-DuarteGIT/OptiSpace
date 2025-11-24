<?php
require_once "../config/database.php";
require_once "../config/config.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_SESSION['email_user']) && isset($_POST['digit1'], $_POST['digit2'], $_POST['digit3'], $_POST['digit4'], $_POST['digit5'], $_POST['digit6'])) {
        $db = new Database();
        $conn = $db->getConnection();
        $codigo = $_POST['digit1'] . $_POST['digit2'] . $_POST['digit3'] . $_POST['digit4'] . $_POST['digit5'] . $_POST['digit6'];
        $email = $_SESSION['email_user'];

        $stmt = $conn->prepare("SELECT codigo_ativacao, status_utilizador FROM utilizadores WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $codigo_user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$codigo_user) {
            $error_message = "Utilizador não encontrado.";
            echo "<script>alert('{$error_message}'); window.location.href = '" . BASE_URL . "auth/ativacao.php';</script>";
            exit();
        }

        if ($codigo == $codigo_user['codigo_ativacao']) {
            $log .= "Código correto!\n";

            if ($codigo_user['status_utilizador'] === 'ativo') {
                unset($_SESSION['email_user']);
                header("Location: " . BASE_URL . "auth/login.php?msg=ja_ativo");
                exit();
            }

            $log .= "Executando UPDATE...\n";
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
                unset($_SESSION['email_user']);
                header("Location: " . BASE_URL . "auth/login.php?msg=ativado");
                exit();
            } else {
                $error_message = "Erro ao ativar a conta.";
                echo "<script>alert('{$error_message}'); window.location.href = '" . BASE_URL . "auth/ativacao.php';</script>";
                exit();
            }
        } else {
            $error_message = "Código de ativação inválido.";
            echo "<script>alert('{$error_message}'); window.location.href = '" . BASE_URL . "auth/ativacao.php';</script>";
            exit();
        }
    } else {
        header("Location: " . BASE_URL . "auth/register.php");
        exit();
    }
}
?>

?>