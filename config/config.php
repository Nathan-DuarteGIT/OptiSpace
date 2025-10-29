<?php
// config.php
function base_url($path = '') {
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || $_SERVER['SERVER_PORT'] == 443 ? 'https' : 'http';
    $host = $_SERVER['HTTP_HOST'];
    
    // Remove barras duplicadas
    $path = '/' . ltrim($path, '/');
    
    return $protocol . '://' . $host . $path;
}// Se está numa subpasta
?>