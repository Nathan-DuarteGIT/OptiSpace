<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// Inclua a sua lógica de conexão e funções necessárias
    require_once "../config/database.php";
    require_once "../config/config.php";
    require_once "../includes/functions.php";

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 1. Receber e validar os dados de entrada
    $tipo_recurso = $_POST['tipo_recurso'] ?? null;
    $data_inicio = $_POST['data_inicio'] ?? null;
    $data_fim = $_POST['data_fim'] ?? null;
    $hora_inicio = $_POST['hora_inicio'] ?? null;
    $hora_fim = $_POST['hora_fim'] ?? null;
    $id_empresa = buscar_empresa($_SESSION['user_id']);

    if (!$tipo_recurso || !$data_inicio || !$data_fim || !$hora_inicio || !$hora_fim) {
        http_response_code(400);
        echo json_encode(['success' => false, 'error' => 'Por favor, preencha todos os campos de Data/Hora e Tipo de Recurso.']);
        exit;
    }

    // 2. CONCATENAR DATA E HORA no PHP para obter os timestamps completos
    $inicio_reserva = $data_inicio . ' ' . $hora_inicio . ':00';
    $fim_reserva = $data_fim . ' ' . $hora_fim . ':00';

    // 3. Validação de ordem: O fim deve ser ESTRICTAMENTE posterior ao início
    if (strtotime($inicio_reserva) >= strtotime($fim_reserva)) {
        http_response_code(400 );
        echo json_encode(['success' => false, 'error' => 'A data/hora de fim deve ser posterior à data/hora de início.']);
        exit;
    }
    $db = new Database();
    $pdo = $db->getConnection();

     try {
        // 4. BUSCA DE IDs RESERVADOS (Filtrado por Empresa via JOIN)
        $sql_reservados = "
            SELECT DISTINCT r.recurso_id 
            FROM reservas r
            JOIN utilizadores u ON r.utilizador_id = u.id // <--- AJUSTAR ESTA LINHA (r.coluna_user = u.coluna_id)
            WHERE 
                u.empresa_id = :id_empresa AND
                r.tipo_recurso = :tipo_recurso AND
                r.status_reserva NOT IN ('cancelada', 'concluida') AND 
                (
                    (:fim_reserva > r.data_inicio AND :inicio_reserva < r.data_fim) 
                )
        ";
        
        $stmt_reservados = $pdo->prepare($sql_reservados);
        $stmt_reservados->execute([
            ':id_empresa' => $id_empresa,
            ':tipo_recurso' => $tipo_recurso,
            ':inicio_reserva' => $inicio_reserva,
            ':fim_reserva' => $fim_reserva
        ]);

        $ids_reservados = $stmt_reservados->fetchAll(PDO::FETCH_COLUMN);

        // 5. Determinar a tabela de recursos a usar
        $tabela_recursos = '';
        switch ($tipo_recurso) {
            case 'sala':
                $tabela_recursos = 'salas';
                break;
            case 'viatura':
                $tabela_recursos = 'viaturas';
                break;
            case 'equipamento':
                $tabela_recursos = 'equipamentos';
                break;
            default:
                http_response_code(400 );
                echo json_encode(['success' => false, 'error' => 'Tipo de recurso inválido.']);
                exit;
        }

        // 6. Preparar a cláusula NOT IN (CORREÇÃO ROBUSTA PARA HY093)
        $ids_reservados = array_map('strval', $ids_reservados); 
        
        if (empty($ids_reservados)) {
            $placeholders = 'NULL'; // Usamos NULL para simplificar a query, pois não há parâmetros a ligar
            $params_reservados = [];
        } else {
            $placeholders = implode(',', array_fill(0, count($ids_reservados), '?'));
            $params_reservados = $ids_reservados;
        }

        // 7. BUSCA DE RECURSOS DISPONÍVEIS (Filtrado por Empresa)
        $sql_disponiveis = "
            SELECT id, nome FROM {$tabela_recursos} 
            WHERE 
                empresa_id = ? AND
                id NOT IN ({$placeholders})
        ";

        $stmt_disponiveis = $pdo->prepare($sql_disponiveis);

        // Prepara os parâmetros: [id_empresa, id_reservado_1, id_reservado_2, ...]
        $params = array_merge([$id_empresa], $params_reservados);

        $stmt_disponiveis->execute($params);
        $recursos_disponiveis = $stmt_disponiveis->fetchAll(PDO::FETCH_ASSOC);

        // 8. Devolver os resultados em JSON
        echo json_encode(['success' => true, 'recursos' => $recursos_disponiveis]);
        
    } catch (PDOException $e) {
        http_response_code(500 );
        echo json_encode(['success' => false, 'error' => 'Erro na base de dados: ' . $e->getMessage()]);
    }
    
} else {
    http_response_code(405);
    echo json_encode(['error' => 'Método não permitido.']);
}
?>
