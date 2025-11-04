<?php

// ============================================
// FUNÇÕES DE SEGURANÇA
// ============================================

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

/**
 * Verifica se é admin
 */
function e_admin()
{
    return isset($_SESSION['nivel_acesso']) && $_SESSION['nivel_acesso'] === 'admin';
}

/**
 * Faz logout
 */
function logout()
{
    session_destroy();
    header('Location: ' . BASE_URL . 'auth/login.php');
    exit();
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
    return strpos($relativePath, $folder) === 0 ? 'text-activeted' : 'text-description';
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
