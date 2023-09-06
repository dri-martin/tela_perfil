<?php
// Inclui o arquivo de conexão com o banco de dados
include_once('Conexao/conexao.php');

// Cria uma instância da classe Database para obter uma conexão com o banco de dados
$db = new Database();

// Define a classe Crud
class Crud{
    private $conn; // Variável que armazena a conexão com o banco de dados
    private $table_name = "contas"; // Nome da tabela no banco de dados

    // Construtor da classe, recebe a conexão como parâmetro
    public function __construct($db){
        $this->conn = $db; // Atribui a conexão à variável $conn
    }

    // Método para criar um registro na tabela
    public function create($postValues){
        $username = $postValues['username']; // Obtém o valor do campo 'username' do array $postValues
        $email = $postValues['email']; // Obtém o valor do campo 'email' do array $postValues
        $password = $postValues['passsword']; // Obtém o valor do campo 'passsword' do array $postValues (correção: deve ser 'password')
        $modality = $postValues['modality']; // Obtém o valor do campo 'modality' do array $postValues

        // Monta a consulta SQL para inserir um registro na tabela
        $query = "INSERT INTO ". $this->table_name . " (username, email, password, modality) VALUES (?,?,?,?)";
        $stmt = $this->conn->prepare($query); // Prepara a consulta SQL

        // Faz a vinculação dos parâmetros da consulta com os valores obtidos
        $stmt->bindParam(1, $username);
        $stmt->bindParam(2, $email);
        $stmt->bindParam(3, $password);
        $stmt->bindParam(4, $modality);

        // Executa o método read para recuperar todos os registros antes de inserir o novo
        $rows = $this->read();

        // Executa a consulta preparada
        if($stmt->execute()){
            // Se a consulta for bem-sucedida, exibe um alerta e redireciona para a página de leitura
            print "<script>alert('Cadastro Ok!')</script>";
            print "<script> location.href='?action=read'; </script>";
            return true; // Retorna verdadeiro para indicar o sucesso na inserção
        }else{
            return false; // Retorna falso em caso de falha na consulta
        }
    }

    // Método para ler todos os registros da tabela
    public function read(){
        $query = "SELECT * FROM ". $this->table_name; // Monta a consulta SQL para selecionar todos os registros
        $stmt = $this->conn->prepare($query); // Prepara a consulta SQL
        $stmt->execute(); // Executa a consulta
        return $stmt; // Retorna o resultado da consulta
    }
}
?>