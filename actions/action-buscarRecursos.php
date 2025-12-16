<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once "../config/database.php";
require_once "../config/config.php";
require_once "../includes/functions.php";

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tipo_recurso = $_POST['tipo_recurso'] ?? null;
    $data_inicio = $_POST['data_inicio'] ?? null;
    $data_fim = $_POST['data_fim'] ?? null;
    $hora_inicio = $_POST['hora_inicio'] ?? null;
    $hora_fim = $_POST['hora_fim'] ?? null;
    
    // Filtros de Sala
    $participantes = $_POST['participantes'] ?? null;
    $equipamentos_sala = $_POST['equipamentos_sala'] ?? []; 

    $id_empresa = buscar_empresa($_SESSION['user_id']);

    if (!$tipo_recurso || !$data_inicio || !$data_fim || !$hora_inicio || !$hora_fim) {
        http_response_code(400);
        echo json_encode(['success' => false, 'error' => 'Preencha todos os campos obrigatórios.']);
        exit;
    }

    $inicio_reserva = $data_inicio . ' ' . $hora_inicio . ':00';
    $fim_reserva = $data_fim . ' ' . $hora_fim . ':00';

    if (strtotime($inicio_reserva) >= strtotime($fim_reserva)) {
        http_response_code(400);
        echo json_encode(['success' => false, 'error' => 'A data de fim deve ser posterior ao início.']);
        exit;
    }

    $db = new Database();
    $pdo = $db->getConnection();

    try {
        // 1. BUSCA DE IDs RESERVADOS
        $sql_reservados = "
            SELECT DISTINCT recurso_id FROM reservas
            WHERE 
                tipo_recurso = :tipo_recurso AND
                status_reserva NOT IN ('cancelada', 'concluida') AND 
                (:fim_reserva > data_inicio AND :inicio_reserva < data_fim)
        ";
        
        $stmt_reservados = $pdo->prepare($sql_reservados);
        $stmt_reservados->execute([
            ':tipo_recurso' => $tipo_recurso,
            ':inicio_reserva' => $inicio_reserva,
            ':fim_reserva' => $fim_reserva
        ]);
        $ids_reservados = $stmt_reservados->fetchAll(PDO::FETCH_COLUMN);

        // 2. Configuração de tabelas e cláusulas
        $tabela_recursos = '';
        $clausulas_extras = "";
        $params_extras = [];

        if ($tipo_recurso === 'sala') {
            $tabela_recursos = 'sala';
            
            // Filtro de Capacidade (ajustado para capacidade_max conforme seu SQL)
            if (!empty($participantes)) {
                $clausulas_extras .= " AND s.capacidade_max >= ?";
                $params_extras[] = $participantes;
            }

            // Filtro de Equipamentos via tabela de ligação 'equipamentos_sala'
            if (!empty($equipamentos_sala) && is_array($equipamentos_sala)) {
                foreach ($equipamentos_sala as $id_equip) {
                    // Garante que a sala possua o equipamento específico
                    $clausulas_extras .= " AND EXISTS (
                        SELECT 1 FROM equipamentos_sala es 
                        WHERE es.sala_id = s.id AND es.equipamento_id = ?
                    )";
                    $params_extras[] = $id_equip;
                }
            }
        } elseif ($tipo_recurso === 'viatura') {
            $tabela_recursos = 'viaturas';
        } elseif ($tipo_recurso === 'equipamento') {
            $tabela_recursos = 'equipamentos';
        } else {
            http_response_code(400);
            echo json_encode(['success' => false, 'error' => 'Tipo inválido.']);
            exit;
        }

        // 3. Preparar placeholders para o NOT IN
        $placeholders = empty($ids_reservados) ? '0' : implode(',', array_fill(0, count($ids_reservados), '?'));

        // 4. Query Final
        // Usamos o alias 's' para a tabela para facilitar as cláusulas extras
        $sql_disponiveis = "
            SELECT s.id, s.nome FROM {$tabela_recursos} s
            WHERE 
                s.empresa_id = ? 
                {$clausulas_extras}
                AND s.id NOT IN ({$placeholders})
        ";

        $stmt_disponiveis = $pdo->prepare($sql_disponiveis);
        $params_final = array_merge([$id_empresa], $params_extras, $ids_reservados);
        $stmt_disponiveis->execute($params_final);
        
        $recursos_disponiveis = $stmt_disponiveis->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode(['success' => true, 'recursos' => $recursos_disponiveis]);
        
    } catch (PDOException $e) {
        http_response_code(500 );
        echo json_encode(['success' => false, 'error' => 'Erro na base de dados: ' . $e->getMessage()]);
    }

} else {
    http_response_code(405 );
    echo json_encode(['success' => false, 'error' => 'Método não permitido.']);
}
?>

