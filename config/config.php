<?php
// config.php

// Mostrar erros 
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Configurações de sessão
session_start();

// Configurações de upload
define('UPLOAD_PATH', __DIR__ . '/../uploads/');
define('MAX_FILE_SIZE', 5242880); // 5MB
define('ALLOWED_EXTENSIONS', ['jpg', 'jpeg', 'png', 'gif']);

// Timezone Portugal
date_default_timezone_set('Europe/Lisbon');

// URL base do projeto
define('BASE_URL', 'https://andnat.antrob.eu');
define('SITE_NAME', 'OptiSpace');

// Email (para ativação de contas)
//define('EMAIL_FROM', 'noreply@optispace.local');
//define('EMAIL_NAME', 'OptiSpace');
?>