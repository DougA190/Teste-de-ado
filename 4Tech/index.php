<?php
session_start();

include("conexao.php");

(isset($_GET['usuarios_clientes'])) ? $id_cliente = $_GET['usuarios_clientes'] : null;

if (!empty($_GET['search'])) {
    $data = $_GET['search'];
    $sql_code = "SELECT * FROM produto where nome_produto like '%$data%' ORDER BY id DESC";

} else {
    $logado = "";
    $cliente_id = "";
    if (isset($_SESSION['id'])) {
        $id = $_SESSION['id'];
        $sql_code = "SELECT nome FROM usuarios_clientes inner join clientes WHERE clientes.id='$id'";
        $sql_code2 = "SELECT * FROM clientes INNER JOIN usuarios_clientes on clientes.id = usuarios_clientes.cliente_id WHERE clientes.id=$id";

        $sql_query = $mysqli->query($sql_code) or die($mysqli->error);
        $sql_query2 = $mysqli->query($sql_code2) or die($mysqli->error);


        if ($sql_query->num_rows > 0 and $sql_query2->num_rows > 0) {

            $cliente = $sql_query->fetch_assoc();
            $cliente2 = $sql_query2->fetch_assoc();
            $logado = $cliente['nome'];
            $cliente_id = $cliente2['id'];
            $sql_code2 = "SELECT cep FROM enderecos_de_entrega WHERE status = 'principal' and cliente_id =$id_cliente;";
            $cepEntrega = $mysqli->query($sql_code2) or die($mysqli->error);
        }
    }
}
include("conexao.php");

if (!empty($_GET['search'])) {
    $data = $_GET['search'];
    $sql_code = "SELECT * FROM produto where nome_produto like '%$data%' ORDER BY id DESC";
} else {
    $sql_code = "select * from produto  inner join imagens_produtos on produto.id = imagens_produtos.id_produto where status=1 and isprincipal = 1";
    //$sql_code2 = "SELECT imagem,id_produto FROM imagens_produtos INNER JOIN  produto ON imagens_produtos.id_produto = produto.id WHERE isprincipal=1";

}
$sql_query = $mysqli->query($sql_code) or die($mysqli->error);
//$sql_query2 = $mysqli->query($sql_code2) or die($mysqli->error);

// $sql_cliente = "SELECT * FROM clientes INNER JOIN usuarios_clientes ON clientes.id = usuarios_clientes.cliente_id WHERE clientes.id=$id"
// $sql_query = $mysqli->query($sql_code) or die($mysqli->error); 
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/carrinho.css">
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
        <?php

        if (isset($_GET['usuarios_clientes'])) {
            ?>
            <!--logado -->
            <div class="acesso" style="margin-top: 50px;">
                <img src="https://static.kabum.com.br/conteudo/temas/001/imagens/k5/images/profile_ninja.png" alt="Ninja"
                    width="32" height="32" style="margin-right: 140px;">
                <!-- <i class="bi bi-person-circle" style="margin-right: -50px;"></i><br> -->
            </div>
            <div class="acesso" style="margin-top: 50px;">
                <label class="mr-3 nome" style="color:white; margin-right: 20px;">
                    <?php echo "Olá: " . $logado; ?>
                </label>
            </div>
            <div class="acesso">
                <a id="sair" href="sairCliente.php" class="btn btn-danger"
                    style="margin-top:40px; margin-right: -150px;">Sair</a>
            </div>
            <div class="acesso" style="height: 10px; margin-top: 50px;">
                <label><a href="editarCliente.php?id=<?php echo $cliente_id; ?>"
                        style="margin-right: 50px;color: white;">Edite sua conta</a></label>
                <label><a href="Perfil.php?id=<?php echo $cliente_id; ?>"
                        style="margin-right: 50px;color: white;">Perfil</a></label>
            </div>

            <?php
        } else {
            ?>
            <div class="acesso">
                <i class="bi bi-person-circle"></i><br>
                <a href="loginCliente.php">Acesse</a>
                <span>ou</span>
                <a href="cadastroCliente.html">Crie uma conta</a>
            </div>
            <?php
        }
        ?>
    </header>

    <div class="container-fluid">
        <div class="row row-cols-1 row-cols-md-4 g-4">
            <?php while ($produto = $sql_query->fetch_assoc()): ?>
                <div class="col">
                    <a href="detalhes.php?id_produto=<?= $produto["id"] ?>">
                        <div class="card h-100">

                            <img src="img/<?= $produto["id"] . "/" . $produto["imagem"] ?>" class="card-img-top" alt="..."
                                width="40%" height="auto">
                            <div class="card-body">
                                <h5 class="card-title">
                                    <?= $produto["nome_produto"] ?>
                                </h5>
                                <p class="card-text">
                                    <!-- <?= $produto["descricao"] ?> -->
                                </p>
                            </div>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">R$
                                    <span id="preco">
                                        <?= number_format($produto["preco"], 2, ',', '.') ?>
                                    </span>
                                </li>
                                <li class="list-group-item">
                                    Avaliação:
                                    <?= $produto["avaliacao"] ?>
                                </li>
                            </ul>
                    </a>
                    <div class="card-ctrl">
                        <button type="submit" id="enviarProduto" onclick="adicionarNoCarrinho(this)"
                            data-imagem='<?php echo $produto['id'] . '/' . $produto['imagem']; ?>'
                            data-preco='<?php echo $produto['preco'] ?>'
                            data-nome='<?php echo $produto["nome_produto"] ?> '>Adicionar ao carrinho<i
                                class="bi bi-cart-plus-fill"></i>
                        </button>
                    </div>
                </div>

            </div>

        <?php endwhile ?>
    </div>
    </div>

    <div class="btn-carrinho-compra">
        <!-- Contagem de itens no carrinho  -->
        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-info"
            id="contador_carrinho">
            0
        </span>
        <a id="btnCarrinho"><i class="bi bi-cart-plus-fill" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight"
                aria-controls="offcanvasRight"></i></a>
        <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
            <div class="offcanvas-header">
                <h5>Carrinho de compras</h5>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <div class="frete">
                    <div class="col-12 col-md-6 col-lg-6">
                        <h5>Entrega</h5>
                        <label>Cep: </label>
                        <input type="text" class="form-control  cep" name="cepEntrega" id="txtCepEntrega"
                            placeholder="00000-000" oninput="mascaraCep()" onchange="buscaCepEntrega()" required <?php
                            if (isset($cepEntrega)) {
                                $cep = $cepEntrega->fetch_assoc()['cep'];
                                echo "value='$cep'";
                            }
                            ?>>
                        <label>Valor do frete R$<span id="valorFrete">00,00</span></label>
                    </div>
                </div>
                <table id="tbl-carrinho">
                    <thead>
                        <tr class="titulo-carrinho">
                            <th>Item</th>
                            <th>Preço</th>
                            <th>Quantidade</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
                <div class="ctrl-compra">
                    <p>Valor total: <span id="precoCompra">R$ 00,00</span></p>

                    <a <?php
                    if (isset($_GET['usuarios_clientes'])) {
                        ?> href="checkout.php?id=<?= $id_cliente ?>" <?php } else {
                        ?> href="loginCliente.php" <?php }
                    ?>><button>Finalizar pedido</button></a>
                </div>
            </div>
        </div>
    </div>

    <?php

    if (isset($_GET['usuarios_clientes'])) {
        ?>
        <!--logado -->
        <footer>

        </footer>

        <?php
    } else {
        ?>
        <footer>
            <a href="loginBackoffice.html">Acesso restrito</a>
        </footer>
        <?php
    }
    ?>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"
        integrity="sha384-zYPOMqeu1DAVkHiLqWBUTcbYfZ8osu1Nd6Z89ify25QV9guujx43ITvfi12/QExE"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.min.js"
        integrity="sha384-Y4oOpwW3duJdCWv5ly8SCFYWqFDsfob/3GkgExXKV4idmbt98QcxXYs9UoXAB7BZ"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"
        integrity="sha384-zYPOMqeu1DAVkHiLqWBUTcbYfZ8osu1Nd6Z89ify25QV9guujx43ITvfi12/QExE"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.min.js"
        integrity="sha384-Y4oOpwW3duJdCWv5ly8SCFYWqFDsfadob/3GkgExXKV4idmbt98QcxXYs9UoXAB7BZ"
        crossorigin="anonymous"></script>
    <script src="js/script.js"></script>
    <script src="js/carrinho.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</body>

</html>