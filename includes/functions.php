<?php
require_once "../config/database.php";
require_once "../config/config.php";
// ============================================
// FUNÇÕES DE SEGURANÇA
// ============================================

function showvar($var) {
    echo $var;
}

/**
 * Limpa dados de entrada (previne XSS)
 */
function limpar($data)
{
    if (is_array($data)) {
        return array_map('limpar', $data);
    }
    return htmlspecialchars(strip_tags(trim($data)), ENT_QUOTES, 'UTF-8');
}

/**
 * Valida email
 */
function validar_email($email)
{
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

/**
 * Cria hash de password
 */
function hash_password($password)
{
    return password_hash($password, PASSWORD_DEFAULT);
}

/**
 * Verifica password
 */
function verificar_password($password, $hash)
{
    return password_verify($password, $hash);
}

// ============================================
// FUNÇÕES DE SESSÃO
// ============================================

/**
 * Verifica se utilizador está logado
 */
function esta_logado()
{
    return isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
}

/**
 * Redireciona se não estiver logado
 */
function requer_login()
{
    if (!esta_logado()) {
        header('Location: ' . BASE_URL . 'auth/login.php');
        exit();
    }
}





// ============================================
// Sidebar
// ============================================

function isActive($folder)
{
    $rootFolder = '/OptiSpace';
    $uri = explode('?', $_SERVER['REQUEST_URI'])[0];
    $relativePath = str_replace($rootFolder, '', $uri);

    // Compara se o caminho começa com a pasta
    return strpos($relativePath, $folder) === 0 ? 'text-[#17876E]' : 'text-description';
}

// ============================================
// UPLOAD DE FICHEIROS
// ============================================

/**
 * Faz upload seguro de imagem
 */
function upload_imagem($file, $pasta)
{
    // --- 1. Verificação de Configuração (Opcional, mas recomendado) ---
    if (!defined('MAX_FILE_SIZE') || !defined('ALLOWED_EXTENSIONS') || !defined('UPLOAD_PATH')) {
        return ['sucesso' => false, 'mensagem' => 'Erro de configuração: Constantes de upload (MAX_FILE_SIZE, ALLOWED_EXTENSIONS, UPLOAD_PATH) em falta.'];
    }
    
    // --- 2. Validação Inicial de Upload ---
    
    // Verifica se houve upload e se foi bem-sucedido
    if (!isset($file['error']) || $file['error'] !== UPLOAD_ERR_OK) {
        // Pode-se expandir o tratamento para códigos de erro específicos aqui.
        return ['sucesso' => false, 'mensagem' => 'Erro no upload ou ficheiro não enviado.'];
    }

    // --- 3. Validação de Tamanho ---
    if ($file['size'] > MAX_FILE_SIZE) {
        // Converte o tamanho máximo para MB para a mensagem
        $max_mb = round(MAX_FILE_SIZE / 1024 / 1024, 0); 
        return ['sucesso' => false, 'mensagem' => "Ficheiro muito grande (máx {$max_mb}MB)"];
    }

    // --- 4. Validação do Tipo MIME Real (SEGURANÇA ESSENCIAL) ---
    
    // Lista de tipos MIME aceites
    $allowed_mime_types = ['image/jpeg', 'image/png', 'image/gif'];

    // Verifica se a extensão finfo está disponível
    if (!extension_loaded('fileinfo')) {
        return ['sucesso' => false, 'mensagem' => 'Erro de sistema: Extensão "fileinfo" necessária para segurança não carregada.'];
    }
    
    // Abre a biblioteca de ficheiros MIME e verifica o tipo real do ficheiro temporário
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime_type = finfo_file($finfo, $file['tmp_name']);
    finfo_close($finfo);

    if (!in_array($mime_type, $allowed_mime_types)) {
        return ['sucesso' => false, 'mensagem' => 'Tipo de ficheiro não permitido pelo seu conteúdo real.'];
    }

    // --- 5. Validação de Extensão (Verificação Rápida) ---
    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    if (!in_array($ext, ALLOWED_EXTENSIONS)) {
        // Esta verificação funciona como uma barreira rápida, embora o MIME Type seja mais seguro.
        $ext_list = implode(', ', ALLOWED_EXTENSIONS);
        return ['sucesso' => false, 'mensagem' => "Tipo de ficheiro não permitido (use {$ext_list})"];
    }

    // --- 6. Sanitização e Preparação do Caminho ---
    
    // Sanitiza $pasta para prevenir Path Traversal (../../)
    // Permite apenas caracteres alfanuméricos, hífens e underscores.
    $pasta_segura = $pasta;
    if (empty($pasta_segura)) {
        $pasta_segura = 'default'; // Usa um diretório padrão seguro se $pasta for inválida
    }

    // Gera nome único para o ficheiro
    $nome_novo = uniqid('img_', true) . '.' . $ext;
    
    // Monta o caminho de destino completo
    $caminho_base = rtrim(UPLOAD_PATH, '/') . '/';
    $destino = $caminho_base . $pasta_segura . '/' . $nome_novo;

    // --- 7. Criação da Pasta ---
    // Cria a pasta de destino (e subpastas se necessário) com permissões 0777 (adaptar se necessário)
    $dir_destino = dirname($destino);
    if (!is_dir($dir_destino)) {
        // @ silencia erros em caso de problemas de permissão
        if (!@mkdir($dir_destino, 0777, true)) { 
            return ['sucesso' => false, 'mensagem' => 'Erro ao criar o diretório de destino. Verifique as permissões.'];
        }
    }

    // --- 8. Movimentação Final do Ficheiro ---
    if (move_uploaded_file($file['tmp_name'], $destino)) {
        // Retorna o caminho RELATIVO ao UPLOAD_PATH para guardar na base de dados
        return ['sucesso' => true, 'caminho' => $pasta_segura . '/' . $nome_novo];
    }

    return ['sucesso' => false, 'mensagem' => 'Erro desconhecido ao guardar ficheiro no destino final.'];
}


// ============================================
// FUNÇÕES DATABASE 
// ============================================
/**
 * BUSCAR EMPRESA PELO USER_ID
 */

function buscar_empresa($user_id){
    $db = new Database();
    $conn = $db->getConnection();

    $stmt = $conn->prepare("SELECT empresa_id FROM utilizadores WHERE id = :user_id");
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();

    $empresa_id = $stmt->fetch(PDO::FETCH_ASSOC)['empresa_id'];

    $db->closeConnection();

    return $empresa_id;
}

/**
 * BUSCA POR UTILIZADORES DA EMPRESA
 */

function buscar_utilizadores($user_id){
    $empresa_id = buscar_empresa($user_id);

    $db = new Database();
    $conn = $db->getConnection();

    $stmt = $conn->prepare("SELECT id, nome, email, nivel_acesso, foto_path, status_utilizador FROM utilizadores WHERE empresa_id = :empresa_id AND nivel_acesso != 'admin'");
    $stmt->bindParam(':empresa_id', $empresa_id);
    $stmt->execute();

    $utilizadores = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $db->closeConnection();

    if ($utilizadores) {

        echo <<<HTML
        <table class="w-full">
            <thead>
                <tr class="border-b border-gray-100">
                    <th class="text-left px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider w-3/5">Name</th>
                    <th class="text-left pl-0 pr-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">User Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
        HTML;

        foreach ($utilizadores as $u) {

            $nome  = htmlspecialchars($u['nome']);
            $email = htmlspecialchars($u['email']);
            $foto  = $u['foto_path'] ?: "../uploads/user-default.png";

            // COR DINÂMICA
            $corStatus = $u['status_utilizador'] === "ativo" ? "bg-indigo-600" : "bg-gray-400";
            $corTextStatus = $u['status_utilizador'] === "ativo" ? "text-indigo-600" : "text-gray-400";
            $statusTxt = htmlspecialchars($u['status_utilizador']);

            echo <<<ROW
            <tr class="hover:bg-gray-50 transition-colors">
                <td class="px-6 py-4 w-3/5">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-indigo-100 flex items-center justify-center flex-shrink-0">
                            <i class="fa-solid fa-user text-indigo-600 text-sm"></i>
                        </div>
                        <div>
                            <div class="font-medium text-gray-900 text-sm">$nome</div>
                            <div class="text-gray-500 text-xs">$email</div>
                        </div>
                    </div>
                </td>

                <td class="pl-0 pr-6 py-4">
                    <span class="inline-flex items-center gap-1 text-sm">
                        <span class="$corStatus w-1.5 h-1.5 rounded-full"></span>
                        <span class="$corTextStatus font-medium">$statusTxt</span>
                    </span>
                </td>
            </tr>
            ROW;
        }

        echo "</tbody></table>";

    } else {
        echo "<p class='text-center text-gray-500'>Nenhum utilizador encontrado.</p>";
    }
    $db->closeConnection();
}

/**
 * CONTAR EQUIPAMENTOS DA EMPRESA
 */

function contar_equipamentos($user_id){
    $empresa_id = buscar_empresa($user_id);

    $db = new Database();
    $conn = $db->getConnection();

    $stmt = $conn->prepare("SELECT COUNT(*) as total FROM equipamentos WHERE empresa_id = :empresa_id");
    $stmt->bindParam(':empresa_id', $empresa_id);
    $stmt->execute();

    $total_equipamentos = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

    $db->closeConnection();

    return $total_equipamentos;
}

/**
 * CONTAR SALAS DA EMPRESA
 */

function contar_salas($user_id){
    $empresa_id = buscar_empresa($user_id);

    $db = new Database();
    $conn = $db->getConnection();

    $stmt = $conn->prepare("SELECT COUNT(*) as total FROM sala WHERE empresa_id = :empresa_id");
    $stmt->bindParam(':empresa_id', $empresa_id);
    $stmt->execute();

    $total_salas = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

    $db->closeConnection();

    return $total_salas;
}
/**
 * CONTAR VIATURAS DA EMPRESA
 */

function contar_viaturas($user_id){
    $empresa_id = buscar_empresa($user_id);

    $db = new Database();
    $conn = $db->getConnection();

    $stmt = $conn->prepare("SELECT COUNT(*) as total FROM viaturas WHERE empresa_id = :empresa_id");
    $stmt->bindParam(':empresa_id', $empresa_id);
    $stmt->execute();

    $total_viaturas = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

    $db->closeConnection();

    return $total_viaturas;
}

/**
 * BUSCA POR EQUIPAMENTOS FIXOS DA EMPRESA
 */

function buscar_equipamentos_fixos($user_id){
    $empresa_id = buscar_empresa($user_id);

    $db = new Database();
    $conn = $db->getConnection();

    $stmt = $conn->prepare("SELECT id, nome, foto_path, status_equipamento FROM equipamentos WHERE empresa_id = :empresa_id AND tipoEquipamento = 'fixo'");
    $stmt->bindParam(':empresa_id', $empresa_id);
    $stmt->execute();

    $equipamentos_fixos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $db->closeConnection();

    return $equipamentos_fixos;
}

/**
 * BUSCA POR EQUIPAMENTOS PORTATIL DA EMPRESA
 */

function buscar_equipamentos_portatil($user_id){
    $empresa_id = buscar_empresa($user_id);

    $db = new Database();
    $conn = $db->getConnection();

    $stmt = $conn->prepare("SELECT id, nome, foto_path, status_equipamento FROM equipamentos WHERE empresa_id = :empresa_id AND tipoEquipamento = 'portatil'");
    $stmt->bindParam(':empresa_id', $empresa_id);
    $stmt->execute();

    $equipamentos_portatil = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $db->closeConnection();

    return $equipamentos_portatil;
}

/**
 * BUSCA POR VIATURAS DA EMPRESA
 */

function buscar_viaturas($user_id){
    $empresa_id = buscar_empresa($user_id);

    $db = new Database();
    $conn = $db->getConnection();

    $stmt = $conn->prepare("SELECT id, nome, foto_path, status_viaturas FROM viaturas WHERE empresa_id = :empresa_id");
    $stmt->bindParam(':empresa_id', $empresa_id);
    $stmt->execute();

    $equipamentos_portatil = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $db->closeConnection();

    return $equipamentos_portatil;
}

/**
 * BUSCA POR SALAS DA EMPRESA
 */

function buscar_salas($user_id){
    $empresa_id = buscar_empresa($user_id);

    $db = new Database();
    $conn = $db->getConnection();

    $stmt = $conn->prepare("SELECT id, nome, capacidade_max, localizacao, status_sala FROM sala WHERE empresa_id = :empresa_id");
    $stmt->bindParam(':empresa_id', $empresa_id);
    $stmt->execute();

    $salas = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $db->closeConnection();

    return $salas;
}

/**
 * BUSCA POR EQUIPAMENTOS ASSOCIADOS Á SALA DA EMPRESA
 */

function buscar_equipamentos_sala($sala_id){
    $db = new Database();
    $conn = $db->getConnection();

    $stmt = $conn->prepare("SELECT e.nome FROM equipamentos_sala es JOIN equipamentos e ON es.equipamento_id = e.id WHERE es.sala_id = :sala_id");
    $stmt->bindParam(':sala_id', $sala_id);
    $stmt->execute();

    $equipamentos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $db->closeConnection();

    return $equipamentos;
}

/**
 * BUSCA POR TODAS AS RESERVAS DA EMPRESA DO UTILIZADOR
 */
function buscar_reservas_empresa($user_id) {
    // 1. Identifica a empresa do utilizador logado usando a sua função existente
    $empresa_id = buscar_empresa($user_id);

    $db = new Database();
    $conn = $db->getConnection();

    // 2. Query que busca detalhes da reserva, nome do colaborador e nome do recurso
    // Fazemos JOIN com utilizadores para filtrar pela empresa_id
    $sql = "
        SELECT 
            r.*, 
            u.nome as nome_utilizador,
            CASE 
                WHEN r.tipo_recurso = 'sala' THEN (SELECT nome FROM sala WHERE id = r.recurso_id)
                WHEN r.tipo_recurso = 'viatura' THEN (SELECT nome FROM viaturas WHERE id = r.recurso_id)
                WHEN r.tipo_recurso = 'equipamento' THEN (SELECT nome FROM equipamentos WHERE id = r.recurso_id)
            END as nome_recurso
        FROM reservas r
        JOIN utilizadores u ON r.utilizador_id = u.id
        WHERE u.empresa_id = :empresa_id
        ORDER BY r.data_inicio DESC
    ";

    try {
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':empresa_id', $empresa_id);
        $stmt->execute();
        
        $reservas = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $db->closeConnection();
        
        return $reservas;

    } catch (PDOException $e) {
        $db->closeConnection();
        return []; // Retorna array vazio em caso de erro
    }
}

/**
 * RENDARIZAR OS EQUIPAMENTOS FIXOS DA EMPRESA NO FORMCRIAR 
 */

function render_equipamentos_fixos_formCriar($user_id){
    $equipamentos_fixos = buscar_equipamentos_fixos($user_id);

    if ($equipamentos_fixos) {
        foreach ($equipamentos_fixos as $eq) {
            $nome = htmlspecialchars($eq['nome']);
            $id = htmlspecialchars($eq['id']);
            echo <<<EQUIPAMENTO
            <label class="flex items-center cursor-pointer">
                <input type="checkbox" name="equipamentos_sala[]" value="$id" class="mr-3 w-4 h-4 text-indigo-600 rounded focus:ring-2 focus:ring-indigo-500">
                <span>$nome</span>
            </label>
            EQUIPAMENTO;
        }
    }
}

/**
 * RENDARIZAR OS EQUIPAMENTOS FIXOS DA EMPRESA EM CARD 
 */

function render_equipamentos_fixos_card($user_id){
    $equipamentos_fixos = buscar_equipamentos_fixos($user_id);

    if ($equipamentos_fixos) {
        foreach ($equipamentos_fixos as $eq) {
            $nome = htmlspecialchars($eq['nome']);
            $foto_path = $eq['foto_path'] ?: "../uploads/equipamento-default.png";
            echo <<<EQUIPAMENTO
                    <div class="card-dashboard card-item hidden" data-category="equipamentos">
                        <div class="leading-tight flex flex-col items-center">
                            <h4 class="text-base font-semibold text-gray-800 mb-3">$nome</h4>
                            <img src="$foto_path" alt="$nome" class="w-20 h-20 object-contain">
                        </div>
                    </div>
            EQUIPAMENTO;
        }
    }
}

/**
 * RENDARIZAR OS EQUIPAMENTOS PORTATIL DA EMPRESA EM CARD 
 */

function render_equipamentos_portatil_card($user_id){
    $equipamentos_portatil = buscar_equipamentos_portatil($user_id);

    if ($equipamentos_portatil) {
        foreach ($equipamentos_portatil as $eq) {
            $nome = htmlspecialchars($eq['nome']);
            $foto_path = $eq['foto_path'] ?: "../uploads/equipamento-default.png";
            echo <<<EQUIPAMENTO
                    <div class="card-dashboard card-item hidden" data-category="equipamentos">
                        <div class="leading-tight flex flex-col items-center">
                            <h4 class="text-base font-semibold text-gray-800 mb-3">$nome</h4>
                            <img src="$foto_path" alt="$nome" class="w-20 h-20 object-contain">
                        </div>
                    </div>
            EQUIPAMENTO;
        }
    }
}

/**
 * RENDARIZAR AS VIATURAS DA EMPRESA EM CARD 
 */

function render_viaturas_card($user_id){
    $viaturas = buscar_viaturas($user_id);

    if ($viaturas) {
        foreach ($viaturas as $v) {
            $nome = htmlspecialchars($v['nome']);
            $foto_path = $v['foto_path'] ?: "../uploads/equipamento-default.png";
            echo <<<VIATURA
                    <div class="card-dashboard card-item hidden" data-category="viaturas">
                        <div class="leading-tight flex flex-col items-center">
                            <h4 class="text-base font-semibold text-gray-800 mb-3">$nome</h4>
                            <img src="$foto_path" alt="$nome" class="w-20 h-20 object-contain">
                        </div>
                    </div>
            VIATURA;
        }
    }
}

/**
 * RENDARIZAR AS SALAS DA EMPRESA EM CARD  
 */

function render_salas_card($user_id){
    $salas = buscar_salas($user_id);

    if ($salas) {
        foreach ($salas as $s) {
            $nome = htmlspecialchars($s['nome']);
            $capacidade = htmlspecialchars($s['capacidade_max']);
            $localizacao = htmlspecialchars($s['localizacao']);
            $equipamentos = buscar_equipamentos_sala($s['id']);
            $equipamentos_list = array_map(function($e) {
                return htmlspecialchars($e['nome']);
            }, $equipamentos);
            $equipamentos_str = implode(', ', $equipamentos_list);

            echo <<<SALA
                    <div class="card-dashboard card-item" data-category="salas">
                        <div class="leading-tight">
                            <h4 class="text-base font-semibold text-gray-800 mb-1">$nome</h4>
                            <p class="text-base font-semibold text-gray-600 mb-2">$capacidade lugares</p>
                            <p class="text-base font-semibold text-gray-500">$equipamentos_str</p>
                        </div>
                    </div>
            SALA;
        }
    }
}

/**
 * RENDERIZAR AS RESERVAS DA EMPRESA EM FORMATO DE CARD
 */
function render_reservas_empresa_cards($user_id) {
    // 1. Obtém as reservas usando a função de busca
    $reservas = buscar_reservas_empresa($user_id);

    if ($reservas) {
        foreach ($reservas as $r) {
            // Conversão dos timestamps para objetos de tempo
            $timestamp_inicio = strtotime($r['data_inicio']);
            $timestamp_fim = strtotime($r['data_fim']);

            // Formatação de datas e horas
            $data_inicio = date('d/m/Y', $timestamp_inicio);
            $data_fim    = date('d/m/Y', $timestamp_fim);
            $hora_inicio = date('H:i', $timestamp_inicio);
            $hora_fim    = date('H:i', $timestamp_fim);
            
            $recurso = htmlspecialchars($r['nome_recurso']);
            $status = htmlspecialchars($r['status_reserva']);

            // Definição de cores dinâmicas para o Status
            // Definição de cores dinâmicas para o Status
            switch($r['status_reserva']) {
                case 'confirmada': 
                    $corStatus = 'bg-green-100 text-green-800 border border-green-200'; 
                    break;
                case 'pendente':   
                    $corStatus = 'bg-yellow-100 text-yellow-800 border border-yellow-200'; 
                    break;
                case 'cancelada':  
                    $corStatus = 'bg-red-100 text-red-800 border border-red-200'; 
                    break;
                case 'concluida':  
                    $corStatus = 'bg-blue-100 text-blue-800 border border-blue-200'; 
                    break;
                default:           
                    $corStatus = 'bg-blue-100 text-gray-800 border border-gray-200'; 
                    break;
            }

            echo <<<INICIO
            <div class="card-dashboard">
                <div class="leading-tight">
                    <p class="text-xs text-black leading-relaxed"><span class="font-semibold">Data:</span> $data_inicio</p>
            INICIO;

            // Só exibe a "Data de fim" se for diferente da "Data de início"
            if ($data_inicio !== $data_fim) {
                echo <<<DATAFIM
                    <p class="text-xs text-black leading-relaxed"><span class="font-semibold">Data de fim:</span> $data_fim</p>
                DATAFIM;
            }
            echo <<<INFORMATION
                    <p class="text-xs text-black leading-relaxed"><span class="font-semibold">Hora de início:</span> $hora_inicio</p>
                    <p class="text-xs text-black leading-relaxed"><span class="font-semibold">Hora de fim:</span> $hora_fim</p>
                    <p class="text-xs text-black leading-relaxed"><span class="font-semibold">Recurso:</span> $recurso</p>

                    <div class="flex items-center gap-3 mt-2">
                        <span class="font-medium text-sm text-black">Status:</span>
                        <span class="inline-block $corStatus text-xs font-medium px-3 py-1 rounded-full">$status</span>
                    </div>
                </div>
            </div>
            INFORMATION;
        }
    } else {
        echo "<p class='text-gray-500 text-sm'>Não existem reservas registadas para a sua empresa.</p>";
    }
}