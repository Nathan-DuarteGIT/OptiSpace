<?php
include_once "../includes/functions.php";
require_once "../config/config.php";
require_once "../config/database.php";


if($_SERVER['REQUEST_METHOD'] === 'POST'){
    if(isset($_POST['id_reserva'], $_POST['pin_confirmacao'])) {
        $id_reserva = $_POST['id_reserva'];
        $pin_confirmacao = $_POST['pin_confirmacao'];

        $db = new Database();
        $conn = $db->getConnection();

        // Verificar se o PIN está correto
        $stmt = $conn->prepare("SELECT codigo, status_reserva FROM reservas WHERE id = :id_reserva");
        $stmt->bindParam(':id_reserva', $id_reserva);
        $stmt->execute();
        $reserva = $stmt->fetch(PDO::FETCH_ASSOC);

        if($reserva) {
            if($reserva['status_reserva'] === 'pendente') {
                if($reserva['codigo'] === $pin_confirmacao) {
                    // Atualizar o status da reserva para 'confirmada'
                    $update_stmt = $conn->prepare("UPDATE reservas SET status_reserva = 'confirmada' WHERE id = :id_reserva");
                    $update_stmt->bindParam(':id_reserva', $id_reserva);
                    if($update_stmt->execute()) {
                        header("Location: " . BASE_URL . "reservas/index.php?sucesso=" . urlencode("Reserva confirmada com sucesso."));
                        exit();
                    } else {
                        header("Location: " . BASE_URL . "reservas/index.php?erro_db=" . urlencode("Erro ao confirmar reserva. Tente novamente."));
                        exit();
                    }
                } else {
                    die("DB: " . $reserva['codigo'] . " | Input: " . $pin_confirmacao);
                    header("Location: " . BASE_URL . "reservas/index.php?erro_pin=" . urlencode("PIN de confirmação incorreto."));
                    exit();
                }
            } else {
                header("Location: " . BASE_URL . "reservas/index.php?erro_status=" . urlencode("A reserva já foi confirmada ou não está em estado pendente."));
                exit();
            }
        } else {
            header("Location: " . BASE_URL . "reservas/index.php?erro_inexistente=" . urlencode("Reserva não encontrada."));
            exit();
        }
    } else {
        header("Location: " . BASE_URL . "reservas/index.php?erro_campos=" . urlencode("Por favor, preencha todos os campos obrigatórios."));
        exit();
    }
} else {
    header("Location: " . BASE_URL . "reservas/index.php");
    exit();
}
?>