<?php
session_start();
include('conexao.php');
(isset($_GET['id_produto'])) ? $id_produto = $_GET['id_produto'] : null;
$sql_code1 = "SELECT * FROM produto inner join imagens_produtos on produto.id = imagens_produtos.id_produto where id_produto = $id_produto and isprincipal=1 ORDER BY id_img";
$sql_query1 = $mysqli->query($sql_code1) or die($mysqli->error);

(isset($_GET['usuarios_clientes'])) ? $id_cliente = $_GET['usuarios_clientes'] : null;
// Função para realizar no banco

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

  }
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/detalhes.css">
  <link rel="stylesheet" href="css/estaticos.css">
  <link rel="stylesheet" href="css/carrinho.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
  <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.7.2/font/bootstrap-icons.min.css">
  <?php while ($produto = $sql_query1->fetch_assoc()): ?>
    <title>
      <?= $produto['nome_produto'] ?>
    </title>

  </head>

  <body>

    <!-- Inicio do cabecalho -->
    <header>

      <?php
      if (isset($_GET['usuarios_clientes'])) {
        ?>
        <!--logado -->
        <div class="logo">
          <a href="index.php?usuarios_clientes=<?php echo $cliente_id; ?>"><img src="img/Logo.png" alt="Logo da 4Tech"></a>
        </div>
        <?php
      } else {
        ?>
        <div class="logo">
          <a href="index.php"><img src="img/Logo.png" alt="Logo da 4Tech"></a>
        </div>
        <?php
      }
      ?>

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
          <a id="sair" href="sairCliente.php" class="btn btn-danger" style="margin-top:40px; margin-right: -150px;">Sair</a>
        </div>
        <div class="acesso" style="height: 10px; margin-top: 50px;">
          <label><a href="editarCliente.php?id=<?php echo $cliente_id; ?>" style="margin-right: 50px;color: white;">Edite
              sua
              conta</a></label>
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
    <!-- Fim do cabecalho -->

    <div class="container-lg ">
      <div class="row">
        <div class="col-12 col-md-12 col-lg-12">
          <section class="area-principal">
            <div class="row">
              <div class="col-12 col-md-12 col-lg-12">
                <div class="area-nome-produto text-center">
                  <h1>
                    <?= $produto['nome_produto'] ?>
                  </h1>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-12 col-md-6 col-lg-6">
                <!-- Inicio do carousel de imagens -->
                <div id="carouselExample" class="carousel slide">
                  <div class="carousel-inner">
                    <!-- Imagem principal do carousel -->
                    <div class="carousel-item active">
                      <img src="<?= 'img/' . "$produto[id]" . '/' . $produto["imagem"] ?>" class="d-block w-100"
                        alt="...">
                    </div>
                    <?php
                    // Caminho para a pasta que contém as imagens
                    $dir = 'img/' . "$produto[id]" . '/';

                    // Ler os arquivos na pasta e gerar o código HTML para cada imagem
                    $files = scandir($dir);
                    foreach ($files as $file) {

                      if ($file !== '.' && $file !== '..' && is_file($dir . $file) && preg_match('/\.(JPG|jpg|jpeg|png)$/', $file)) {
                        echo "<div class='carousel-item'>
                      <img src='$dir/$file' class='d-block w-100' alt=''>
                    </div>";
                      }
                    }
                    ?>

                  </div>
                  <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample"
                    data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                  </button>
                  <button class="carousel-control-next" type="button" data-bs-target="#carouselExample"
                    data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                  </button>
                </div>
                <!-- Fim do carousel de imagens -->
              </div>
              <!-- Inicio da area de compra -->
              <div class="col-12 col-md-6 col-lg-6 area-compras">
                <!-- Inicio da area com os estoques -->
                <div class="col-12col-md-12col-lg-12 area-estoque text-center">

                  <h2><i class="bi bi-boxes"></i> Ainda há
                    <?= $produto['qtd_estoque'] ?> em estoque
                  </h2>

                </div>
                <!-- Fim da area com estoques -->
                <!-- Inicio area de venda -->
                <div class="area-venda">
                  <!-- Inicio area informacoes de venda -->
                  <div class="row">
                    <div class="col-12 col-md-6 col-lg-6 informacoes-venda">

                      <p>Vendido e entregue por 4Tech</p>
                      <h1>R$
                        <?php
                        $preco_formatado = number_format($produto['preco'], 2, ',', '.');
                        echo $preco_formatado
                          ?>
                      </h1>
                      <p>Parcelamos em até 10x de R$
                        <?php
                        $parcelas = 10;
                        $preco = $produto['preco'];
                        $preco_parcelado = $preco / $parcelas;
                        $preco_formatado = number_format($preco_parcelado, 2, ',', '.');
                        echo $preco_formatado;
                        ?> sem juros no cartão
                      </p>

                    </div>
                    <!-- Fim area informacoes de venda -->
                    <!-- Inicio area controle de venda -->
                    <div class="col-12 col-md-6 col-lg-6 controle-venda">
                      <input type="text" name="cep" id="cep" placeholder="Inserir CEP">
                      <button type="submit" id="enviarProduto" onclick="adicionarNoCarrinho(this)"
                        data-imagem='<?php echo $produto['id'] . '/' . $produto['imagem']; ?>'
                        data-preco='<?php echo $produto['preco'] ?>'
                        data-nome='<?php echo $produto["nome_produto"] ?> '>Adicionar ao carrinho<i
                          class="bi bi-cart-plus-fill"></i>
                      </button>
                    </div>
                    <!-- Fim area controle de venda -->
                  </div>
                  <!-- Inicio area dos interesses do produto -->
                  <div class="row">
                    <div class="col-12 col-md-12 col-lg-12 area-interesses">

                      <p>aqui havera a avaliacao</p>
                      <i class="bi bi-share"></i>

                    </div>
                  </div>
                  <!-- Fim area de interesses do produto -->
                </div>
                <!-- Fim area de venda -->
              </div>
              <!-- Fim da area de compra -->
            </div>
            <!-- Inicio da area de detalhes do produto -->
            <div class="row">
              <div class="col-12 col-md-12 col-lg-12">
                <div class="area-detalhes">
                  <div class="titulo">
                    <h1><i class="bi bi-file-earmark-text"></i>Descrição do produto</h1>

                  </div>
                  <p>
                    <?= $produto['descricao'] ?>
                  </p>
                </div>
              </div>
            </div>
            <!-- Fim da area de detalhes do produto -->
          </section>
        </div>
      </div>
    </div>
    <div class="btn-carrinho-compra">
      <!-- Contagem de itens no carrinho -->
      <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-info" id="contador_carrinho">
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
              ?>
                href="loginCliente.php" <?php }
            ?>><button>Finalizar pedido</button></a>
          </div>
        </div>
      </div>
    </div>
  <?php endwhile ?>
  <!-- Inicio do rodapé -->
  <footer>
    <a href="TeladeLogin.html">Acesso restrito</a>
  </footer>
  <!-- Fim do rodapé -->

  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"
    integrity="sha384-zYPOMqeu1DAVkHiLqWBUTcbYfZ8osu1Nd6Z89ify25QV9guujx43ITvfi12/QExE"
    crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.min.js"
    integrity="sha384-Y4oOpwW3duJdCWv5ly8SCFYWqFDsfob/3GkgExXKV4idmbt98QcxXYs9UoXAB7BZ"
    crossorigin="anonymous"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
  <script type="text/javascript"
    src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.0/jquery.mask.js"></script>
  <script src="js/detalhes.js"></script>
  <script src="js/carrinho.js"></script>
</body>

</html>