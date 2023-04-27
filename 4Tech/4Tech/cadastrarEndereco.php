<?php

session_start(); // Iniciar a sessao

// Limpar o buffer de saida
ob_start();

// Incluir a conexao com o BD
include_once "conectar.php";

// Id do usuario fixo
//$usuario_id = 4;

// Id do usuario dinamico que vem pela URL
$usuario_id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

// QUERY recuperar os detalhes do usuario do banco de dados
$query_usuario = "SELECT id, nome, email FROM usuario WHERE id=:id LIMIT 1";
$result_usuario = $conn->prepare($query_usuario);
$result_usuario->bindParam(':id', $usuario_id);
$result_usuario->execute();

// Acessa o IF quando encontrar o usuario cadastrado no BD
if ((empty($usuario_id)) or ($result_usuario->rowCount() == 0)) {
    $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Nenhum usuário encontrado!</p>";
    header("Location: endereco.php");
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8" />
    <title>Celke</title>
</head>

<body>
    <a href="endereco.php">Listar</a><br>
    <a href="visualizar.php?id=<?php echo $usuario_id; ?>">Visualizar</a><br>

    <h2>Cadastrar Endereço</h2>

    <?php
    $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

    // Acessa o IF quando o usuario clicar no botao cadastrar
    if (!empty($dados['SendCadEnd'])) {
        //var_dump($dados);

        try {
            //QUERY cadastrar endereco no BD
            $query_endereco = "INSERT INTO enderecos (logradouro, numero, usuario_id) VALUES (:logradouro, :numero, :usuario_id)";
            $cad_endereco = $conn->prepare($query_endereco);
            $cad_endereco->bindParam(':logradouro', $dados['logradouro']);
            $cad_endereco->bindParam(':numero', $dados['numero']);
            $cad_endereco->bindParam(':usuario_id', $usuario_id);
            $cad_endereco->execute();

            if ($cad_endereco->rowCount()) {
                echo "<p style='color: green;'>Endereço cadastrado com sucesso!</p>";
                unset($dados);
            } else {
                echo "<p style='color: #f00;'>Erro: Endereço não cadastrado com sucesso!</p>";
            }
        } catch (PDOException $err) {
            echo "<p style='color: #f00;'>Erro: Endereço não cadastrado com sucesso!</p>";
            //echo "<p style='color: #f00;'>Erro: Endereço não cadastrado com sucesso. Erro gerado " . $err->getMessage() . " </p>";
        }
    }
    ?>

    <form method="POST" action="">
        <?php
        $logradouro = "";
        if (isset($dados['logradouro'])) {
            $logradouro = $dados['logradouro'];
        }
        ?>
        <label>Logradouro: </label>
        <input type="text" name="logradouro" placeholder="Rua, avenida..." value="<?php echo $logradouro; ?>" required><br><br>

        <?php
        $numero = "";
        if (isset($dados['numero'])) {
            $numero = $dados['numero'];
        }
        ?>
        <label>Número: </label>
        <input type="text" name="numero" placeholder="Número do endereço" value="<?php echo $numero; ?>" required><br><br>

        <input type="submit" value="Cadastrar" name="SendCadEnd">
    </form>
</body>

</html>