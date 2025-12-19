<?php
require_once "../config/config.php";
require_once "../config/database.php";
require_once "../includes/functions.php";

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    if(isset($_POST['id_reserva'])) {
        $id_reserva = $_POST['id_reserva'];

        $db = new Database();
        $conn = $db->getConnection();

        // Atualizar o status da reserva para 'cancelada'
        $stmt = $conn->prepare("UPDATE reservas SET status_reserva = 'cancelada' WHERE id = :id_reserva");
        $stmt->bindParam(':id_reserva', $id_reserva);

        if($stmt->execute()) {
            header("Location: " . BASE_URL . "reservas/index.php?sucesso=" . urlencode("Reserva cancelada com sucesso."));
            exit();
        } else {
            header("Location: " . BASE_URL . "reservas/index.php?erro_db=" . urlencode("Erro ao cancelar reserva. Tente novamente."));
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