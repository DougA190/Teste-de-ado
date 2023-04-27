<?php
session_start();
include("conexao.php");
(isset($_GET['id'])) ? $id_usuario = $_GET['id'] : null;

if (!empty($_GET['search'])) {
    $data = $_GET['search'];
    $sql_code = "SELECT * FROM produto inner join imagens_produtos where nome_produto like '%$data%' and isprincipal = 1  ORDER BY id DESC";
    //$sql_code = "SELECT * FROM produto  iNNER JOIN imagens_produtos ON produto.id = imagens_produtos.id_produto WHERE isprincipal = 1 like'%$data%' ORDER BY id DESC";

} else {
    //$sql_code = "SELECT * FROM produto ORDER BY id DESC";
    $sql_code = "SELECT * FROM produto iNNER JOIN imagens_produtos ON produto.id = imagens_produtos.id_produto WHERE isprincipal = 1 ORDER BY id DESC";

}
$sql_query = $mysqli->query($sql_code) or die($mysqli->error);

$pagina = (isset($_GET['pagina'])) ? $_GET['pagina'] : 1;

$result_produto = "SELECT * FROM produto";
$resultado_produto = $mysqli->query($result_produto);

//Contar o total de produtos
$total_produtos = mysqli_num_rows($resultado_produto);

//Setar a quantidade de produtos por pagina 
$quantidade_pg = 10;

//Calcular o número de pagina necessárias
$num_pagina = ceil($total_produtos / $quantidade_pg);

//Calcular o inicio da visualização 
$inicio = ($quantidade_pg * $pagina) - $quantidade_pg;

//Selecionar os produtos apresentados na página
$result_produtos = "SELECT * FROM produto limit $inicio, $quantidade_pg";
$resultado_produtos = $mysqli->query($result_produtos);
$total_produtos = mysqli_num_rows($resultado_produtos);

?>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="css/ListarProdutos.css">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
        integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <title>4Tech</title>
</head>

<body>
    <nav>
        <div class="nav-wrapper grey darken-4">
            <a class="brand-logo center"><img src="img/Logo.png" width="70" height="70"></a>
            <ul id="nav-mobile" class="left hide-on-med-and-down grey darken-4">
            
                <li><a href="backoffice.html">Voltar</a></li>
                <li><a href="cadastrarProduto.php">Cadastrar</a></li>
            </ul>
        </div>
    </nav>

    <div class="box-search">
        <input type="search" class="form-control w-25" placeholder="Pesquisar" id="pesquisar">
        <button onclick="searchData()" class="btn btn-primary">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search"
                viewBox="0 0 16 16">
                <path
                    d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
            </svg>
        </button>

    </div>
    <div class="container">
        <form class="form-gestao">
            <div class="dados-gestao">
                <table border="0">
                    <thead>
                        <tr>
                            <th>Códigos</th>
                            <th>Produto</th>
                            <th>Avaliação</th>
                            <th>Descrição</th>
                            <th>Preço</th>
                            <th>Status</th>
                            <th>Qtd em estoque</th>
                            <th>Imagem</th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php while ($produto = $sql_query->fetch_assoc()) : ?>
                        <tr>
                                <td><?= $produto["codigo"] ?></td>
                                <td><?= $produto["nome_produto"] ?></td>
                                <td><?= $produto["avaliacao"] ?></td>
                                <td><?= $produto["descricao"] ?></td>
                                <td>R$<?= $produto["preco"] ?></td>
                                <td>
                                    <label class="switch-mini">
                                        <?php
                                        if ($produto["status"] == 1) {

                                            echo "<div class='switch'>
                                          <label>
                                            
                                            <input type='checkbox' onclick='abrirModal($produto[id],$produto[status])' checked>
                                            <span class='lever'></span>
                                            
                                          </label>
                                        </div>";
                                        } else {
                                            echo "<div class='switch'>
                                            <label>
                                              
                                              <input type='checkbox' onclick='abrirModal($produto[id],$produto[status])'>
                                              <span class='lever'></span>
                                              
                                            </label>
                                          </div>";
                                        } ?>

                                        <span class="slider-mini"></span>
                                    </label>
                                </td>
                                <td><?= $produto["qtd_estoque"] ?></td>
                                <td>
                                   
                                    
                                    <img src="<?=$produto["imagem"]?>"  width="70" height="70">
                                    
                                   
                                </td>
                                <td>
                                    <a href="editarProduto.php?id=<?= $produto['id'] ?>">
                                        <img src="img/lapis.png">
                                    </a>
                                    <a href="detalhes.php?id_produto=<?=$produto['id']?>">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                            class="bi bi-eye" viewBox="0 0 16 16">
                                            <path
                                                d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z" />
                                            <path
                                                d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z" />
                                        </svg>
                                    </a>
                                </td>
                            </tr>

                        <?php endwhile ?>
                    </tbody>

                </table>
            </div>
        </form>

    </div>


    <?php
    //Verificar pagina anterior e posterior
    $pagina_anterior = $pagina - 1;
    $pagina_posterior = $pagina + 1;
    ?>
    <nav>
        <div class="nav-wrapper white white-4">
            <ul class="pagination justify-content-center">
                <?php
                if ($pagina_anterior != 0) { ?>
                    <li class="page-item">
                        <a class="page-link" href="gestaoProdutos.php?pagina=<?php echo $pagina - 1 ?>" tabindex="-1">
                            <span aria-hidden="true">&laquo;</span>
                            <span class="sr-only">Anterior</span>
                        </a>
                    </li>
                <?php }
                ?>

                <?php
                //Apresentar paginação
                for ($i = 1; $i < $num_pagina + 1; $i++) { ?>
                    <li class="page-item"><a class="page-link" href="gestaoProdutos.php?pagina=<?php echo $i ?>"><?php echo $i ?></a></li>
                <?php }
                ?>

                <?php
                if ($pagina_posterior <= $num_pagina) { ?>
                    <li class="page-item">
                        <a class="page-link" href="gestaoProdutos.php?pagina=<?php echo $pagina + 1 ?>">
                            <span aria-hidden="true">&raquo;</span>
                            <span class="sr-only">Próximo</span>
                        </a>
                    </li>
                <?php }
                ?>
            </ul>
        </div>
    </nav>
    <div class="modal" id="myModal">
        <div class="modal-content">
            <div class="modal-header">
                <h1>4Tech</h1>
            </div>
            <div class="modal-body">
                <p>Deseja <span id="spanModal"></span> o produto? </p>
            </div>
            <div class="modal-footer">
                <button id="cancelar">Cancelar</button>
                <button id="confirmar">Confirmar</button>

            </div>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="js/gestaoProduto.js"></script>
</body>

</html>