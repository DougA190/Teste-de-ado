<?php

session_start(); // Iniciar a sessao

// Incluir a conexao com o BD
include_once "conectar.php";
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8" />
    <title>Celke</title>
</head>

<body>
    <a href="endereco.php">Listar</a><br>

    <h2>Listar Usuários</h2>

    <?php

    if (isset($_SESSION['msg'])) {
        echo $_SESSION['msg'];
        unset($_SESSION['msg']);
    }

    // QUERY recuperar os usuarios do banco de dados
    $query_usuario = "SELECT id, nome, email, genero FROM usuarios_clientes ORDER BY id DESC";
    $result_usuarios = $conn->prepare($query_usuario);
    $result_usuarios->execute();

    // Acessa o IF quando encontrar usuario cadastrado no BD
    if (($result_usuarios) and ($result_usuarios->rowCount() != 0)) {
        while ($row_usuario = $result_usuarios->fetch(PDO::FETCH_ASSOC)) {
            //var_dump($row_usuario);
            extract($row_usuario);
            echo "ID: $id <br>";
            echo "Nome: $nome <br>";
            echo "E-mail: $email <br>";
            echo "Genero: $genero <br>";
            echo "<a href='cadastrarEndereco.php?id=$id'>Cadastrar Endereço</a><br>";
            echo "<a href='visualizar.php?id=$id'>Visualizar</a><br>";
            echo "<a href='editarCliente.php?id=$id'>Editar</a><br>";
            echo "<hr>";
        }
    } else {
        echo "<p style='color: #f00;'>Erro: Nenhum usuário encontrado!</p>";
    }

    ?>
</body>

</html>