<?php
session_start();
include("conexao.php");
(isset($_GET['id'])) ? $id_usuario = $_GET['id'] : null;

if(!empty($_GET['search'])){
    $data = $_GET['search'];
    $sql_code = "SELECT * FROM produto where nome_produto like '%$data%' ORDER BY id DESC";
}else{
$sql_code = "SELECT * FROM produto ORDER BY id DESC";

}
$sql_query = $mysqli->query($sql_code) or die($mysqli->error);
?>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="css/ListarProdutos.css">
    <title>4Tech</title>
</head>

<body>
    <nav>
        <div class="nav-wrapper grey darken-4">
            <a class="brand-logo center">4Tech - Produtos</a>
            <ul id="nav-mobile" class="left hide-on-med-and-down grey darken-4">
                <li><a href="backoffice.html">Voltar</a></li>
                <li><a href="CadastrarProduto.html">Cadastrar</a></li>
            </ul>
        </div>
    </nav>

    <div class="box-search">
        <input type="search" class="form-control w-25" placeholder="Pesquisar" id="pesquisar">
        <button onclick= "searchData()" class="btn btn-primary">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
            </svg>
        </button>

    </div>
    <div class="container">
        <form class="form-gestao">
            <div class="dados-gestao">
                <table border="0">
                    <thead>
                        <tr>
                            <th>Código</th>
                            <th>Produto</th>
                            <th>Avaliação</th>
                            <th>Descrição</th>
                            <th>Preço</th>
                            <th>Status</th>
                            <th>Qtd em estoque</th>
                            <th> Imagem</th>
                        </tr>
                        <tr>
                            <?php while ($produto = $sql_query->fetch_assoc()) : ?>
                                <th><?= $produto["id"] ?></th>
                                <th><?= $produto["nome_produto"] ?></th>
                                <th><?= $produto["avaliacao"] ?></th>
                                <th><?= $produto["descricao"] ?></th>
                                <th><?= $produto["preco"] ?></th>
                                <th>
                                    <label>
                                        <input type="checkbox" id="myCheckbox" class="filled-in" />
                                        <span id="myText"></span>
                                    </label>
                                </th>
                                <th><?= $produto["qtd_estoque"] ?></th>
                                <th><img src=<?= $produto["imagem"] ?> width="50" height="50">
                                </th>
                                <th>
                                    <a href='EditarProduto.php?id=<?php echo $produto["id"]; ?>'>
                                        <img src="img/lapis.png">
                                    </a>
                                    <a href=''>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
                                            <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z" />
                                            <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z" />
                                        </svg>
                                    </a>
</th>

                        </tr>
                    <?php endwhile ?>
                    </thead>
                </table>
            </div>
        </form>
        <script src="js/gestaoProduto.js"></script>
</body>

</html>