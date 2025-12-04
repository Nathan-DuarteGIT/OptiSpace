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
    // Verifica se houve upload
    if (!isset($file['error']) || $file['error'] !== UPLOAD_ERR_OK) {
        return ['sucesso' => false, 'mensagem' => 'Erro no upload'];
    }

    // Verifica tamanho (5MB)
    if ($file['size'] > MAX_FILE_SIZE) {
        return ['sucesso' => false, 'mensagem' => 'Ficheiro muito grande (máx 5MB)'];
    }

    // Verifica extensão
    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    if (!in_array($ext, ALLOWED_EXTENSIONS)) {
        return ['sucesso' => false, 'mensagem' => 'Tipo de ficheiro não permitido (use JPG, PNG ou GIF)'];
    }

    // Gera nome único
    $nome_novo = uniqid('img_', true) . '.' . $ext;
    $destino = UPLOAD_PATH . $pasta . '/' . $nome_novo;

    // Cria pasta se não existir
    if (!is_dir(dirname($destino))) {
        mkdir(dirname($destino), 0777, true);
    }

    // Move ficheiro
    if (move_uploaded_file($file['tmp_name'], $destino)) {
        return ['sucesso' => true, 'caminho' => $pasta . '/' . $nome_novo];
    }

    return ['sucesso' => false, 'mensagem' => 'Erro ao guardar ficheiro'];
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
 * BUSCA POR EQUIPAMENTOS FIXOS DA EMPRESA
 */

function buscar_equipamentos_fixos($user_id){
    $empresa_id = buscar_empresa($user_id);

    $db = new Database();
    $conn = $db->getConnection();

    $stmt = $conn->prepare("SELECT id, nome, foto_path, status_equipamento FROM recursos WHERE empresa_id = :empresa_id AND tipo_recurso = 'equipamento_fixo'");
    $stmt->bindParam(':empresa_id', $empresa_id);
    $stmt->execute();

    $equipamentos_fixos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $db->closeConnection();

    return $equipamentos_fixos;
}

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