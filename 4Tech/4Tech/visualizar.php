<?php

session_start(); // Iniciar a sessao

// Limpar o buffer de saida
ob_start();

// Incluir a conexao com o BD
include_once "conectar.php";

// Id do usuario dinamico que vem pela URL
$usuario_id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8" />
    <title>Celke</title>
</head>

<body>
    <a href="endereco.php">Listar</a><br>

    <h2>Detalhes do Usuário</h2>

    <?php
    // QUERY recuperar os detalhes do usuario do banco de dados
    $query_clientes = "SELECT id, nome, email FROM usuarios_clientes WHERE id=:id LIMIT 1";
    $result_clientes = $conn->prepare($query_clientes);
    $result_clientes->bindParam(':id', $clientes_id);
    $result_clientes->execute();

    // Acessa o IF quando encontrar o clientes cadastrado no BD
    if (($result_clientes) and ($result_clientes->rowCount() != 0)) {
        $row_clientes = $result_clientes->fetch(PDO::FETCH_ASSOC);
        //var_dump($row_clientes);
        extract($row_clientes);
        echo "ID: $id <br>";
        echo "Nome: $nome <br>";
        echo "E-mail: $email <br>";
        echo "<a href='cadastrarEndereco.php?id=$id'>Cadastrar Endereço</a><br>";
        echo "<hr>";

        // QUERY recuperar os enderecos do usuario do banco de dados
        $query_enderecos = "SELECT id, endereco, numero, bairro, cidade, estado, status, cep
                            FROM enderecos 
                            WHERE usuario_id=:usuario_id
                            ORDER BY id DESC";
        $result_enderecos = $conn->prepare($query_enderecos);
        $result_enderecos->bindParam(':usuario_id', $usuario_id);
        $result_enderecos->execute();

        // Acessa o IF quando encontrar endereco cadastrado no BD
        if (($result_enderecos) and ($result_enderecos->rowCount() != 0)) {
            while ($row_endereco = $result_enderecos->fetch(PDO::FETCH_ASSOC)) {
                //var_dump($row_usuario);
                extract($row_endereco);
                echo "ID: $id <br>";
                echo "Endereco: $endereco <br>";
                echo "Número: $numero <br>";
                echo "Bairro: $bairro <br>";
                echo "Cidade: $cidade <br>";
                echo "Estado: $estado <br>";
                echo "Cep: $cep <br>";
                echo "<hr>";
            }
        } else {
            echo "<p style='color: #f00;'>Erro: Nenhum endereço encontrado!</p>";
        }
    } else {
        $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Nenhum usuário encontrado!</p>";
        header("Location: index.php");
    }

    ?>
</body>

</html>