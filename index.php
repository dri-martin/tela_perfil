<?php
// Inclui os arquivos necessários para a funcionalidade do código.
require_once('classes/Crud.php'); // Inclui a classe Crud para operações de banco de dados.
require_once('conexao/conexao.php'); // Inclui o arquivo de configuração de conexão com o banco de dados.

// Cria uma instância da classe Database para obter uma conexão com o banco de dados.
$database = new Database();
$db = $database->getConnection();

// Cria uma instância da classe Crud para realizar operações CRUD no banco de dados.
$crud = new Crud($db);

// Verifica se a variável "action" está definida na query string (URL).
if(isset($_GET['action'])){
    // Se "action" estiver definida, verifica seu valor.
    switch($_GET['action']){
        case 'create':
            // Se "action" for "create", chama o método "create" da classe Crud para criar um novo registro no banco de dados com os dados enviados via POST.
            $crud->create($_POST);
            // Em seguida, lê todos os registros do banco de dados.
            $rows = $crud->read();
            break;
        default:
            // Se "action" não for "create", apenas lê todos os registros do banco de dados.
            $rows = $crud->read();
            break;
    }
} else {
    // Se "action" não estiver definida na query string, simplesmente lê todos os registros do banco de dados.
    $rows = $crud->read();
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Perfil</title>
</head>
<body>
<?php
// Aqui começa o código HTML dentro do corpo da página.
?>

    <!-- Formulário de criação de novo registro -->
    <form action="?action=create" method="POST">
        <label for="">Nome de Usuário</label>
        <input type="text" name="username">

        <label for="">E-mail</label>
        <input type="email" name="email">

        <label for="">Senha</label>
        <input type="password" name="password">

        <label for="">Modalidade</label>
        <select name="modality" value="<?php echo $modality ?>">
            <option value="">Selecione...</option>
            <option value="work">Trabalho</option>
            <option value="reading">Leitura</option>
            <option value="study">Estudo</option>
        </select>

        <input type="submit" value="Cadastrar" name="enviar">
    </form>

    <!-- Tabela para exibir os registros do banco de dados -->
    <table>
        <tr>
            <td>Id</td>
            <td>Nome de Usuário</td>
            <td>E-mail</td>
            <td>Senha</td>
            <td>Modalidade</td>
        </tr>

        <?php
        // Verifica se há registros no resultado da leitura.
        if($rows->rowCount() == 0){
            // Se não houver registros, exibe uma mensagem de "Nenhum dado encontrado".
            echo "<tr>";
            echo "<td colspan='7'>Nenhum dado encontrado</td>";
            echo "</tr>";
        } else {
            // Se houver registros, faz um loop para exibi-los em uma tabela.
            while($row = $rows->fetch(PDO::FETCH_ASSOC)){
                echo "<tr>";
                echo "<td>" . $row['id'] . "</td>";
                echo "<td>" . $row['username'] . "</td>";
                echo "<td>" . $row['email'] . "</td>";
                echo "<td>" . $row['password'] . "</td>";
                echo "<td>" . $row['modality'] . "</td>";
                echo "<td>";
                // Aqui geralmente seriam adicionados links para editar e excluir registros.
                echo "</td>";
                echo "</tr>";
            }
        }
        ?>
    </table>

</body>
</html>