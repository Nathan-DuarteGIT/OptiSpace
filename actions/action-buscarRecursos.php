<?php
// action-buscarRecursos.php

// Configurações de ambiente
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Incluir ficheiros de configuração e base de dados
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

    // ** Obter o ID da Empresa **
    // Assumimos que get_id_empresa() funciona ou que está a usar um valor fixo para teste
    $id_empresa = buscar_empresa($_SESSION['user_id']); 

    if (!$tipo_recurso || !$data_inicio || !$data_fim || !$hora_inicio || !$hora_fim || !$id_empresa) {
        http_response_code(400 );
        echo json_encode(['success' => false, 'error' => 'Dados de entrada incompletos ou ID de empresa não encontrado.']);
        exit;
    }

    // 2. CONCATENAR DATA E HORA
    $inicio_reserva = $data_inicio . ' ' . $hora_inicio . ':00';
    $fim_reserva = $data_fim . ' ' . $hora_fim . ':00';

    // 3. Validação de ordem
    if (strtotime($inicio_reserva) >= strtotime($fim_reserva)) {
        http_response_code(400 );
        echo json_encode(['success' => false, 'error' => 'A data/hora de fim deve ser posterior à data/hora de início.']);
        exit;
    }

    $db = new Database();
    $pdo = $db->getConnection();

    try {
        // 4. BUSCA DE IDs RESERVADOS (Filtrado por Empresa via JOIN)
        // Usamos a query que o utilizador confirmou estar correta (com os nomes de coluna ajustados)
        $sql_reservados = "
            SELECT DISTINCT r.recurso_id 
            FROM reservas r
            JOIN utilizadores u ON r.utilizador_id = u.id 
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

        // 5. Determinar a tabela de recursos a usar e extrair filtros específicos
        $tabela_recursos = '';
        $filtros_adicionais = [];
        $params_adicionais = [];

        switch ($tipo_recurso) {
            case 'sala':
                $tabela_recursos = 'sala';
                
                // Filtros de Sala
                $participantes = $_POST['participantes'] ?? null;
                $equipamentos_sala = $_POST['equipamentos_sala'] ?? []; // Array de equipamentos

                if ($participantes) {
                    // Assumimos que a coluna na tabela 'salas' se chama 'capacidade'
                    $filtros_adicionais[] = 'capacidade >= ?';
                    $params_adicionais[] = $participantes;
                }

                // Se houver equipamentos selecionados, adicionamos filtros para cada um
                foreach ($equipamentos_sala as $equipamento) {
                    // Assumimos que a tabela 'salas' tem colunas booleanas (ou int 0/1) para cada equipamento
                    // Ex: 'tem_projetor', 'tem_tv', 'tem_teleconferencia'
                    // O valor do checkbox é o nome da coluna (ex: 'projetor', 'tv', 'teleconferencia')
                    $coluna_equipamento = 'tem_' . $equipamento;
                    $filtros_adicionais[] = "{$coluna_equipamento} = 1";
                }
                
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

        // 6. Preparar a cláusula NOT IN (Correção robusta para HY093)
        $ids_reservados = array_map('strval', $ids_reservados); 
        
        if (empty($ids_reservados)) {
            $placeholders_not_in = 'NULL'; 
            $params_not_in = [];
        } else {
            $placeholders_not_in = implode(',', array_fill(0, count($ids_reservados), '?'));
            $params_not_in = $ids_reservados;
        }

        // 7. BUSCA DE RECURSOS DISPONÍVEIS (Com Filtros de Sala)
        
        // Constrói a cláusula WHERE
        $where_clauses = ["empresa_id = ?"];
        $params_where = [$id_empresa];
        
        // Adiciona filtros específicos de sala
        if (!empty($filtros_adicionais)) {
            $where_clauses = array_merge($where_clauses, $filtros_adicionais);
            $params_where = array_merge($params_where, $params_adicionais);
        }
        
        // Adiciona a cláusula NOT IN
        $where_clauses[] = "id NOT IN ({$placeholders_not_in})";
        
        $where_sql = implode(' AND ', $where_clauses);

        $sql_disponiveis = "
            SELECT id, nome FROM {$tabela_recursos} 
            WHERE 
                {$where_sql}
        ";

        $stmt_disponiveis = $pdo->prepare($sql_disponiveis);

        // Prepara os parâmetros finais: [id_empresa, ...filtros_sala, ...ids_reservados]
        $params = array_merge($params_where, $params_not_in);

        $stmt_disponiveis->execute($params);
        $recursos_disponiveis = $stmt_disponiveis->fetchAll(PDO::FETCH_ASSOC);

        // 8. Devolver os resultados em JSON
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

