<?php

session_start(); // Iniciar a sessao

// Incluir a conexao com o BD
include_once "conectar.php";
(isset($_GET['id'])) ? $id_cliente = $_GET['id'] : null;
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8" />
    <title>Perfil</title>
</head>

<body>
    <!-- <a href="endereco.php">Listar</a><br> -->

    <h2>Listar Usuários</h2>

    <?php

    if (isset($_SESSION['msg'])) {
        echo $_SESSION['msg'];
        unset($_SESSION['msg']);
    }

    // QUERY recuperar os usuarios do banco de dados
    $query_usuario = "SELECT * FROM clientes INNER JOIN usuarios_clientes ON clientes.id=usuarios_clientes.cliente_id WHERE clientes.id=$id_cliente;";
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
            echo "<a href='editarCliente.php?id=$id'>Editar perfil</a><br>";
            echo "<a href='visualizarEndereco.php?id=$id'>Endereço</a><br>";
            echo "<a href='index.php?usuarios_clientes=$id'>Voltar</a><br>";
            echo "<hr>";
        }
    } else {
        echo "<p style='color: #f00;'>Erro: Nenhum usuário encontrado!</p>";
    }

    ?>
</body>

</html>