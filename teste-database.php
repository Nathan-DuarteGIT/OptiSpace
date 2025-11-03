<?php
require_once "config/database.php"; 

// Instancia a classe
$db = new Database();

// Tenta conectar
$conn = $db->getConnection();

if ($conn) {
    echo "✅ Conexão bem-sucedida à base de dados!";
} else {
    echo "❌ Falha na conexão à base de dados.";
}

?>