<?php
require_once "../config/config.php";

// Remove todas as variáveis de sessão
$_SESSION = array();

// Destrói a sessão
session_destroy();

// Redireciona para a página de login
header('Location: ' . BASE_URL . ' index.php');
exit;
?>