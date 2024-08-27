<?php
// Conexão com BD MySQL (usuário 'root', senha 'root' e banco 'uniasselvi')
$link = mysqli_connect("localhost", "root", "", "uniasselvi");

// Verifica se a conexão com o banco de dados foi bem-sucedida
if ($link === false) {
    die("ERRO: Não foi possível conectar ao BD. " . mysqli_connect_error());
}

// Verifica se o formulário foi enviado (método POST)
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Valida se todos os campos foram preenchidos
    if (!empty($_POST['nome']) && !empty($_POST['cargo']) && !empty($_POST['descCargo']) && !empty($_POST['setor']) && !empty($_POST['salario'])) {

        // Variáveis criadas para obter valores dos parâmetros do formulário
        $nome = ucwords(strtolower(mysqli_real_escape_string($link, $_POST['nome'])));
        $cargo = ucwords(strtolower(mysqli_real_escape_string($link, $_POST['cargo'])));
        $descCargo = ucfirst(strtolower(mysqli_real_escape_string($link, $_POST['descCargo'])));
        $setor = ucwords(strtolower(mysqli_real_escape_string($link, $_POST['setor'])));
        $salario = mysqli_real_escape_string($link, $_POST['salario']);

        // Pegando o próximo código (sem utilização de sequence do banco)
        $codigo = 1;
        $sql = "SELECT MAX(CODIGO) AS CODIGO FROM funcionario";
        if ($result = mysqli_query($link, $sql)) {
            if ($row = mysqli_fetch_array($result)) {
                if (intval($row['CODIGO']) > 0) {
                    $codigo = intval($row['CODIGO']) + 1;
                }
            }
        }

        // Realiza inserção do novo registro na tabela do banco de dados
        $sql = "INSERT INTO funcionario (CODIGO, NOME, CARGO, DESCRICAOCARGO, SETOR, SALARIO) 
                VALUES ('$codigo', '$nome', '$cargo', '$descCargo', '$setor', '$salario')";

        if (mysqli_query($link, $sql)) {
            echo "Gravação efetuada com sucesso!"; // aqui poderia ser incluído um código para redirect
        } else {
            echo "Erro (Não foi possível inserir o registro na tabela) $sql. " . mysqli_error($link);
        }

    } else {
        echo "Todos os campos são obrigatórios!";
    }
}

// Fecha a conexão
mysqli_close($link);
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="ISO-8859-1">
<title>Cadastro de Funcionário</title>
<link rel="stylesheet" href="styles.css">
<style>
    .tabela {
        width: 100%;
    }

    table {
        width: 100%;
    }

    textarea {
        width: 100%; /* Deixa o textarea com largura total da coluna */
        height: 100px; /* Define a altura do textarea */
    }
</style>
</head>
<body>
<div class="tabela">
    <form action="cadastro.php" method="post">
        <table>
            <tr>
                <td colspan="2">CADASTRAR O FUNCIONÁRIO</td>
            </tr>
            <tr>
                <td>Nome:</td>
                <td><input type="text" name="nome" required></td>
            </tr>
            <tr>
                <td>Cargo:</td>
                <td><input type="text" name="cargo" required></td>
            </tr>
            <tr>
                <td>Descrição do cargo:</td>
                <td><textarea name="descCargo" required></textarea></td>
            </tr>
            <tr>
                <td>Setor:</td>
                <td><input type="text" name="setor" required></td>
            </tr>
            <tr>
                <td>Salário:</td>
                <td><input type="text" name="salario" required></td>
            </tr>
        </table>
        <input type="submit" value="Gravar">
    </form>
</div>
</body>
</html>