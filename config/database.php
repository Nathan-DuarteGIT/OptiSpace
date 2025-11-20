<?php
/**
 * Configuração da Base de Dados - OptiSpace
 */

class Database {
    private $host = 'localhost';
    private $db_name = 'u506280443_andnatDB';
    private $username = 'u506280443_andnatdbUser';
    private $password = 'c9$X~DMlY';
    private $charset = 'utf8mb4';
    private $conn = null;

    /**
     * Conecta à base de dados
     */
    public function getConnection() {
        try {
            $dsn = "mysql:host={$this->host};dbname={$this->db_name};charset={$this->charset}";
            
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ];

            $this->conn = new PDO($dsn, $this->username, $this->password, $options);
            
        } catch(PDOException $e) {
            die("❌ Erro ao conectar à base de dados: " . $e->getMessage());
        }

        return $this->conn;
    }

    /**
     * Fecha a conexão
     */
    public function closeConnection() {
        $this->conn = null;
    }
}
?>