<?php
session_start();

include("conexao.php");
(isset($_GET['id'])) ? $id_usuario = $_GET['id'] : null;

if (!empty($_GET['search'])) {
    $data = $_GET['search'];
    $sql_code = "SELECT * FROM produto where nome_produto like '%$data%' ORDER BY id DESC";

} else {
    $sql_code = "select * from produto  inner join imagens_produtos on produto.id = imagens_produtos.id_produto where status=1 and isprincipal = 1";
    //$sql_code2 = "SELECT imagem,id_produto FROM imagens_produtos INNER JOIN  produto ON imagens_produtos.id_produto = produto.id WHERE isprincipal=1";
}
$sql_query = $mysqli->query($sql_code) or die($mysqli->error);
//$sql_query2 = $mysqli->query($sql_code2) or die($mysqli->error);
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.7.2/font/bootstrap-icons.min.css">

    <title>4Tech</title>
</head>

<body>
    <header>
        <div class="logo">
            <img src="img/Logo.png" alt="Logo da 4Tech">
        </div>
        <div class="acesso">
            <i class="bi bi-person-circle"></i><br>
            <a href="">Acesse</a>
            <span>ou</span>
            <a href="">Crie uma conta</a>
        </div>
    </header>

    <div class="container-fluid">
        <div class="row row-cols-1 row-cols-md-4 g-4">
            <?php while ($produto = $sql_query->fetch_assoc()): ?>
                <a href="detalhes.php?id_produto=<?= $produto["id"] ?>">
                    <div class="col">
                        <div class="card h-100">

                            <img src="<?= $produto["imagem"] ?>" class="card-img-top" alt="..."
                                width="40%" height="auto">

                            <div class="card-body">
                                <h5 class="card-title">
                                    <?= $produto["nome_produto"] ?>
                                </h5>
                                <p class="card-text">
                                    <?= $produto["descricao"] ?>
                                </p>
                            </div>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">R$
                                    <span id="preco">
                                        <?= $produto["preco"] ?>
                                    </span>
                                </li>
                                <li class="list-group-item">
                                    Avaliação:
                                    <?= $produto["avaliacao"] ?>
                                </li>
                            </ul>
                            <div class="card-ctrl">
                                <!-- <button type="submit">Detalhes...</button> -->
                                <button type="submit" href="editarUsuario.php">Comprar<i
                                        class="bi bi-cart-plus-fill"></i></button>
                            </div>
                        </div>

                    </div>
                </a>
            <?php endwhile ?>
        </div>
    </div>

    <div class="carrinho">
        <!-- Neste label havera a contagem de itens no carrinho -->
        <!-- <label for="" class="count"></label> -->
        <a href="#"><i class="bi bi-cart-plus-fill"></i></a>
    </div>
    
    <footer>
        <a href="loginBackoffice.html">Acesso restrito</a>
    </footer>
    <script src="js/script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"
        integrity="sha384-zYPOMqeu1DAVkHiLqWBUTcbYfZ8osu1Nd6Z89ify25QV9guujx43ITvfi12/QExE"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.min.js"
        integrity="sha384-Y4oOpwW3duJdCWv5ly8SCFYWqFDsfob/3GkgExXKV4idmbt98QcxXYs9UoXAB7BZ"
        crossorigin="anonymous"></script>
</body>

</html>