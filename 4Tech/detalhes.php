<?php
session_start();
include('conexao.php');
(isset($_GET['id_produto'])) ? $id_produto = $_GET['id_produto'] : null;
// Função para realizar no banco
$sql_code = "select * from produto inner join imagens_produtos on produto.id = imagens_produtos.id_produto where id_produto = $id_produto and isprincipal=1 ORDER BY id_img";


$sql_query = $mysqli->query($sql_code) or die($mysqli->error);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/detalhes.css">
  <link rel="stylesheet" href="css/estaticos.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
  <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.7.2/font/bootstrap-icons.min.css">
  <?php while ($produto = $sql_query->fetch_assoc()): ?>
    <title>
      <?= $produto['nome_produto'] ?>
    </title>

  </head>

  <body>




    <!-- Inicio do cabecalho -->
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
                      <img src="<?=$produto["imagem"] ?>" class="d-block w-100" alt="...">
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
                      <Button disabled><i class="bi bi-cart"></i>Comprar</Button>
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
</body>

</html>