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
    $id_empresa = 1;

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
       // ** 4. BUSCA DE IDs RESERVADOS (Filtrado por Empresa via JOIN) **
        $sql_reservados = "
            SELECT DISTINCT recurso_id FROM reservas
            WHERE 
                tipo_recurso = :tipo_recurso AND
                status_reserva NOT IN ('cancelada', 'concluida') AND 
                (
                    (:fim_reserva > data_inicio AND :inicio_reserva < data_fim) 
                )
        ";
        
        $stmt_reservados = $pdo->prepare($sql_reservados);
        $stmt_reservados->execute([
            ':tipo_recurso' => $tipo_recurso,
            ':inicio_reserva' => $inicio_reserva,
            ':fim_reserva' => $fim_reserva
        ]);


        $ids_reservados = $stmt_reservados->fetchAll(PDO::FETCH_COLUMN);

        // 1. Determinar a tabela de recursos a usar
        $tabela_recursos = '';
        switch ($tipo_recurso) {
            case 'sala':
                $tabela_recursos = 'sala';
                break;
            case 'viatura':
                $tabela_recursos = 'viaturas';
                break;
            case 'equipamento':
                $tabela_recursos = 'equipamentos';
                break;
            default:
                // Se o tipo de recurso for inválido, devolve um erro 400
                http_response_code(400 );
                echo json_encode(['success' => false, 'error' => 'Tipo de recurso inválido.']);
                exit;
        }

        // 2. Preparar a cláusula NOT IN
        // Se a lista de IDs reservados estiver vazia, usamos um ID que nunca existirá (e.g., 0)
        // para evitar erro de sintaxe na query.
        $placeholders = empty($ids_reservados) ? '0' : implode(',', array_fill(0, count($ids_reservados), '?'));

        // 3. Encontra todos os recursos disponíveis (excluindo os reservados)
        // Nota: Removemos a condição 'tipo = ?' da query, pois a tabela já está filtrada.
        $sql_disponiveis = "
            SELECT id, nome FROM {$tabela_recursos} 
            WHERE 
                empresa_id = ? AND
                id NOT IN ({$placeholders})
        ";

        $stmt_disponiveis = $pdo->prepare($sql_disponiveis);

        // 4. Prepara os parâmetros para a execução
        // A lista de parâmetros é apenas os IDs reservados (se existirem).
        $params = array_merge([$id_empresa], $params_reservados);

        $stmt_disponiveis->execute($params);
        $recursos_disponiveis = $stmt_disponiveis->fetchAll(PDO::FETCH_ASSOC);

        // 5. Devolver os resultados em JSON
        echo json_encode(['success' => true, 'recursos' => $recursos_disponiveis]);
       /* echo json_encode([
    'success' => true, 
    'recursos' => $recursos_disponiveis,
    'debug_ids_reservados' => $ids_reservados, // Adiciona os IDs reservados para depuração
    'debug_tabela' => $tabela_recursos, // Adiciona a tabela usada
    'debug_id_empresa' => $id_empresa // Adiciona o ID da empresa usado
]);*/
        
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Erro na base de dados: ' . $e->getMessage()]);
    }

} else {
    http_response_code(405);
    echo json_encode(['error' => 'Método não permitido.']);
}
?>
