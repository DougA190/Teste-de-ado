<?php

include("conexao.php");
(isset($_GET['id'])) ? $id_cliente = $_GET['id'] : null;
// $sql_code = "SELECT * FROM usuarios_clientes where id = $id_cliente ";
$sql_code = "SELECT * FROM clientes inner join usuarios_clientes where clientes.id = usuarios_clientes.cliente_id and clientes.id = $id_cliente";
$sql_query = $mysqli->query($sql_code) or die($mysqli->error);

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/cadCliente.css">
    <title>Editar cliente</title>
</head>

<body>
    <!-- Início do header da página-->
    <header>
        <div class="logo">
            <img src="img/Logo.png" alt="Logo da 4Tech">
        </div>

        <a href="GestaoUsuarios.php">Voltar</a>

    </header>
    <!-- Fim do header da página-->
    <section class="area-cadastro">
        <!--Inicio do formulario de cadastro de usuários-->
        <form id="form-cadastro" action="Controle_Cliente.php" method="POST">
            <h1>Editar perfil</h1>
            <?php while ($cliente = $sql_query->fetch_assoc()) : ?>
                <div class="dados-cadastro">
                    <span class="span-required"></span>

                    <br><label>Nome completo</label>
                    <input type="text" name="nome" class="inputs required" oninput="validaNome()" value="<?= $cliente['nome'] ?>">
                    <span class="span-required">O nome precisa de no mínimo 3 caracteres</span>

                    <br><label>Sobrenome</label>
                    <input type="text" name="nome" class="inputs required" oninput="validaNome()" value="<?= $cliente['sobrenome'] ?>">
                    <span class="span-required">O nome precisa de no mínimo 3 caracteres</span>

                    <br><label>CPF</label><br>
                    <input type="text" name="cpf" placeholder="CPF" class="inputs required" maxlength="14" oninput="mascaraCPF()" value="<?= $cliente['cpf'] ?>">
                    <span class="span-required">Digite um CPF válido</span>

                    <br><label>E-mail </label><br>
                    <input type="email" name="email" placeholder="E-mail" class="inputs required" oninput="validaEmail()" value=" <?= $cliente['email'] ?>">
                    <span class="span-required">Inclua um @ no e-mail</span>


                    <br><label>Gênero</label><br>
                    <br><select class="custom-select custom-select-lg mb-3" value=" <?= $cliente['genero'] ?>">
                        <option selected> Gênero </option>
                        <option value="1">Masculino</option>
                        <option value="2">Feminino</option>
                        <option value="3">Outros</option>
                    </select><br>

                    <br><label>Data de nascimento</label><br>
                    <input type="date" name="dataNascimento" class="inputs" oninput="validaData()" value=" <?= $cliente['dataNascimento'] ?>">
                    <span class="span-required">Digite uma data valida</span>

                    <br><label>Alterar Senha</label><br>
                    <input type="password" name="senha" placeholder="Senha" class="inputs required" oninput="validaSenha()">
                    <span class="span-required">A senha necessita de no minimo 8 caracteres</span>

                    <br><label>Confirmar Senha</label><br>
                    <input type="password" placeholder="Confirmar Senha" class="inputs required" oninput="comparaSenha()">
                    <span class="span-required">As senhas não combinam</span>
                </div>

                <input type="submit" name="editarCliente" id="btn-cadastro" value="Confirmar">

            <?php endwhile ?>
        </form>
        <!--Fim do formulario de edição de usuários-->
    </section>

    <script src="js/validacoesEdicao.js"></script>
</body>

</html>