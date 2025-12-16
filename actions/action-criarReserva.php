<?php
    require_once "../config/database.php";
    require_once "../config/config.php";
    require_once "../includes/email.php";

    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        // 2. VERIFICAÇÃO DE DADOS POST
        if(isset($_POST['data_inicio'], $_POST['data_fim'], $_POST['hora_inicio'], $_POST['hora_fim'], $_POST['id_recurso_selecionado'], $_POST['tipo_recurso'])) {
            
            // 3. VERIFICAÇÃO DE UTILIZADOR (CRÍTICO)
            if (!isset($_SESSION['user_id'])) {
                // Se o utilizador não estiver logado, redireciona para o login ou mostra erro
                header("Location: " . BASE_URL . "login.php?erro=" . urlencode("Sessão expirada ou utilizador não autenticado."));
                exit();
            }
            
            $data_inicio = $_POST['data_inicio'];
            $data_fim = $_POST['data_fim'];
            $hora_inicio = $_POST['hora_inicio'];
            $hora_fim = $_POST['hora_fim'];
            $recurso_id = $_POST['id_recurso_selecionado'];
            $tipo_recurso = $_POST['tipo_recurso'];
            $utilizador_id = $_SESSION['user_id'];
            
            // CONCATENAR DATA E HORA para obter os timestamps completos
            // Nota: O PDO/MySQL espera o formato 'YYYY-MM-DD HH:MM:SS'
            $data_inicio_full = $data_inicio . ' ' . $hora_inicio . ':00';
            $data_fim_full = $data_fim . ' ' . $hora_fim . ':00';

            $db = new Database();
            $conn = $db->getConnection();

            // Inserir nova reserva
            $stmt = $conn->prepare("INSERT INTO reservas (utilizador_id, recurso_id, tipo_recurso, data_inicio, data_fim) VALUES (:utilizador_id, :recurso_id, :tipo_recurso, :data_inicio, :data_fim)");
            $stmt->bindParam(':utilizador_id', $utilizador_id);
            $stmt->bindParam(':recurso_id', $recurso_id);
            $stmt->bindParam(':tipo_recurso', $tipo_recurso);
            $stmt->bindParam(':data_inicio', $data_inicio_full); // Usar a variável full
            $stmt->bindParam(':data_fim', $data_fim_full);       // Usar a variável full

            if($stmt->execute()) {
                // Sucesso
                header("Location: " . BASE_URL . "reservas/index.php?sucesso_criar=" . urlencode("Reserva criada com sucesso."));
                exit();
            } else {
                // Falha na execução da query
                header("Location: " . BASE_URL . "reservas/criar.php?erro_criar=" . urlencode("Erro ao criar a reserva. Tente novamente."));
                exit();
            }
        } else {
            // Dados POST incompletos
            header("Location: " . BASE_URL . "reservas/criar.php?erro_criar=" . urlencode("Dados de formulário incompletos."));
            exit();
        }
    } else {
        // Método não permitido
        header("Location: " . BASE_URL . "reservas/criar.php");
        exit();
    }
?>