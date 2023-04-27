<?php

include("conexao.php");
(isset($_GET['id'])) ? $id_usuario = $_GET['id'] : null;
$sql_code = "SELECT * FROM usuarios_backoffice where id = $id_usuario ";
$sql_query = $mysqli->query($sql_code) or die($mysqli->error);

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/cadUsuario.css">
    <title>Editar Usuário</title>
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
        <form id="form-cadastro" action="Controle_Usuarios.php" method="POST">
            <h1>Edição de usuário</h1>
            <?php while ($usuario = $sql_query->fetch_assoc()): ?>
                <div class="dados-cadastro">
                    <input type="number" name="id" class="inputs required" value="<?= $usuario['id'] ?>" readonly>
                    <span class="span-required"></span>
                    <input type="text" name="nome" class="inputs required"
                        oninput="validaNome()" value="<?= $usuario['nome'] ?>">
                    <span class="span-required">O nome precisa de no mínimo 3 caracteres</span>
                    <input type="text" name="cpf" placeholder="CPF" class="inputs required" maxlength="14"
                        oninput="mascaraCPF()" value="<?= $usuario['cpf'] ?>">
                    <span class="span-required">Digite um CPF válido</span>
                    <input type="password" name="senha" placeholder="Senha" class="inputs required" oninput="validaSenha()">
                    <span class="span-required">A senha necessita de no minimo 8 caracteres</span>
                    <input type="password" placeholder="Confirmar Senha" class="inputs required" oninput="comparaSenha()">
                    <span class="span-required">As senhas não combinam</span>
                </div>

                <div class="grupo-usuario">
                    <input type="radio" name="radio-btn" id="radio1" class="required" value="1"
                        oninput="validaGrupo()">Administrador<input type="radio" name="radio-btn" id="radio2" class="required" value="2"
                        oninput="validaGrupo()">Estoquista<span class="span-required">Selecione ao menos um grupo</span>
                </div>
                <input type="submit" name="editarUsuario" id="btn-cadastro" value="Confirmar">

            <?php endwhile ?>
        </form>
        <!--Fim do formulario de edição de usuários-->
    </section>

    <script src="js/validacoesEdicao.js"></script>
</body>

</html>