<?php
session_start();
include("conexao.php");
(isset($_GET['id'])) ? $id_usuario = $_GET['id'] : null;

if (!empty($_GET['search'])) {
    $data = $_GET['search'];
    $sql_code = "SELECT * FROM usuarios_backoffice where nome like '%$data%' ORDER BY id DESC";
} else {
    $sql_code = "SELECT * FROM usuarios_backoffice ORDER BY id";

}
$sql_query = $mysqli->query($sql_code) or die($mysqli->error);
?>

<!DOCTYPE html>
<html lang="pt-br">


<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' href="css/gestaoUsuarios.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <title>Gestão de acessos</title>
</head>


<body>
    <header>
        <div class="logo">
            <img src="img/Logo.png" alt="Logo da 4Tech">
        </div>
        <div class="logado">
            <h2>Usuario logado: João Pablo</h2>
            <a href="">
                <a href="backoffice.html">
                    <h3>Voltar</h3>
                </a>
            </a>
        </div>
    </header>
    <div class="titulo">
        <h1>Gestão de acessos</h1>
    </div>
    <!--Inicio da Gestão de acessos-->
    
    <div class="area-pesquisa">
        
        <input type="search" name="nome" placeholder="Pesquisar" id="pesquisar">
        <button onclick="searchData()" > <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
            </svg></button>
    </div>
    <section class="area-gestao">
        <form class="form-gestao">
            <div class="tbl-usuarios">
                <table border="0" id="tabela-dados">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Nome</th>
                            <th>CPF</th>
                            <th>Email</th>
                            <th>Grupo</th>
                            <th>Status</th>
                            <th>Ação</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($usuario = $sql_query->fetch_assoc()): ?>
                            <tr>
                                <td>
                                    <?= $usuario["id"] ?>
                                </td>
                                <td>
                                    <?= $usuario["nome"] ?>
                                </td>
                                <td>
                                    <?= $usuario["cpf"] ?>
                                </td>
                                <td>
                                    <?= $usuario["email"] ?>
                                </td>
                                <td>
                                    <?php if ($usuario["grupo_usuario_id"] == 1) {
                                        echo 'Administrador';
                                    } else {
                                        echo 'Estoquista';
                                    } ?>


                                </td>
                                <td>
                                    <span class="status">
                                        <?php if ($usuario["status"] == 1) {
                                            echo 'Ativo';
                                        } else {
                                            echo 'Inativo';
                                        } ?>
                                    </span>
                                </td>
                                <td>
                                    <a href="editarUsuario.php?id=<?= $usuario['id'] ?>"><img src="img/lapis.png"></a>
                                    <label class="switch-mini">
                                        <?php
                                        if ($usuario["status"] == 1) {
                                            echo "<input type='checkbox' onclick='abrirModal($usuario[id],$usuario[status])' class='myCheckbox' checked>";
                                        } else {
                                            echo "<input type='checkbox' onclick='abrirModal($usuario[id],$usuario[status])' class='myCheckbox'>";
                                        } ?>

                                        <span class="slider-mini"></span>
                                    </label>
                                </td>
                            </tr>
                        <?php endwhile ?>
                    </tbody>
                </table>
            </div>

        </form>


    </section>
    <section class="area-controle">
        <a href="cadUsuario.html"><button type="submit" name="novoUsuario" class="botao-cadastro">Novo
                Usuario</button></a>
        </label>


        <div class="modal" id="myModal">
            <div class="modal-content">
                <div class="modal-header">
                    <h1>4Tech</h1>
                </div>
                <div class="modal-body">
                    <p>Deseja <span id="spanModal"></span> o usuário? </p>
                </div>
                <div class="modal-footer">
                    <button id="cancelar">Cancelar</button>
                    <button id="confirmar">Confirmar</button>
                </div>
            </div>
        </div>


    </section>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

    <script src="js/gestaoUsu.js"></script>

</body>


</html>