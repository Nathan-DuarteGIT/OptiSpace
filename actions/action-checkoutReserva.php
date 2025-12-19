<?php
include_once "../includes/functions.php";
require_once "../config/config.php";
require_once "../config/database.php";

if($_SERVER['REQUEST_METHOD'] === 'GET'){
    if(isset($_GET['id'])) {
        $id_reserva = $_GET['id'];

        $db = new Database();
        $conn = $db->getConnection();

        // Atualizar o status da reserva para 'concluida'
        $stmt = $conn->prepare("UPDATE reservas SET status_reserva = 'concluida' WHERE id = :id_reserva");
        $stmt->bindParam(':id_reserva', $id_reserva);

        if($stmt->execute()) {
            header("Location: " . BASE_URL . "reservas/index.php?sucesso=" . urlencode("Checkout realizado com sucesso."));
            exit();
        } else {
            header("Location: " . BASE_URL . "reservas/index.php?erro_db=" . urlencode("Erro ao realizar checkout. Tente novamente."));
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