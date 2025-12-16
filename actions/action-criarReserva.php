<?php
    require_once "../config/database.php";
    require_once "../config/config.php";
    require_once "../includes/email.php";

    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        if(isset($_POST['data_inicio'], $_POST['data_fim'], $_POST['hora_inicio'], $_POST['hora_fim'], $_POST['recurso_id'], $_POST['tipo_recurso'])) {
            $data_inicio = $_POST['data_inicio'];
            $data_fim = $_POST['data_fim'];
            $hora_inicio = $_POST['hora_inicio'];
            $hora_fim = $_POST['hora_fim'];
            $recurso_id = $_POST['recurso_id'];
            $tipo_recurso = $_POST['tipo_recurso'];
            $utilizador_id = $_SESSION['user_id'];
            // CONCATENAR DATA E HORA para obter os timestamps completos
            $data_inicio = $data_inicio . ' ' . $hora_inicio;
            $data_fim = $data_fim . ' ' . $hora_fim;

            $db = new Database();
            $conn = $db->getConnection();

            // Inserir nova reserva
            $stmt = $conn->prepare("INSERT INTO reservas (utilizador_id, recurso_id, tipo_recurso, data_inicio, data_fim) VALUES (:utilizador_id, :recurso_id, :tipo_recurso, :data_inicio, :data_fim)");
            $stmt->bindParam(':utilizador_id', $utilizador_id);
            $stmt->bindParam(':recurso_id', $recurso_id);
            $stmt->bindParam(':tipo_recurso', $tipo_recurso);
            $stmt->bindParam(':data_inicio', $data_inicio);
            $stmt->bindParam(':data_fim', $data_fim);

            if($stmt->execute()) {
                header("Location: " . BASE_URL . "reservas/index.php?sucesso_criar=" . urlencode("Reserva criada com sucesso."));
                exit();
            } else {
                header("Location: " . BASE_URL . "reservas/criar.php?erro_criar=" . urlencode("Erro ao criar a reserva. Tente novamente."));
                exit();
            }
        }
    }
?>