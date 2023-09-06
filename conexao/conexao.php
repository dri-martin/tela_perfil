<?php

class Database {
    private $host = "localhost"; // Define o nome do servidor de banco de dados
    private $db_name = "accountregister"; // Define o nome do banco de dados que será usado
    private $username = "root"; // Define o nome de usuário do banco de dados
    private $senha = ""; // Define a senha do banco de dados
    private $conn; // Variável para armazenar a conexão com o banco de dados

    public function getConnection() { // Método público para obter uma conexão com o banco de dados
        $this->conn = null; // Inicializa a variável de conexão como nula

        try {
            // Tenta criar uma nova instância da classe PDO para conectar ao banco de dados MySQL
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->senha);
            
            // Define o modo de erro para PDO::ERRMODE_EXCEPTION, para que exceções sejam lançadas em caso de erro
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            // Em caso de exceção (erro), exibe uma mensagem de erro
            echo "Erro na conexão: " . $e->getMessage();
        }

        // Retorna a conexão ou nulo em caso de erro
        return $this->conn;
    }
}

?>