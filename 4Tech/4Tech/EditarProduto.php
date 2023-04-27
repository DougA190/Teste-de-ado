<?php
session_start();
include("conexao.php");
(isset($_GET['id'])) ? $id = $_GET['id'] : null;
// $sql_code = "SELECT * FROM produto where id = $id ";
$sql_code = "select * from produto  inner join imagens_produtos on produto.id = imagens_produtos.id_produto where id_produto = $id and isprincipal =1";

// $sql_code2 = "SELECT imagem,id_produto FROM imagens_produtos INNER JOIN  produto ON imagens_produtos.id_produto = produto.id WHERE isprincipal=1";
$sql_query = $mysqli->query($sql_code) or die($mysqli->error);

?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">

    <!-- Compiled and minified JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <link rel="stylesheet" href="css/ListarProdutos.css">
    <title>4Tech</title>
</head>

<body>

    <nav>
        <div class="nav-wrapper grey darken-4">
            <a class="brand-logo center">4Tech - Editar Produto</a>
            <ul id="nav-mobile" class="left hide-on-med-and-down grey darken-4">
                <li><a href="gestaoProdutos.php">Voltar</a></li>
            </ul>
        </div>
    </nav>

    <?php while ($produto = $sql_query->fetch_assoc()): ?>
        <div class="row">
            <form action="saveEdit.php" method="POST" enctype="multipart/form-data">
                <div class="col s6 offset-s3">
                    <div class="card">
                        <div class="card-content">
                            <span class="card-title">Editar Produto</span>
                            <!-- Código do produto -->
                            <div class="row">
                                <div class="input-field col s10">
                                    <input id="codigo" type="text" name="codigo" class="validate"
                                        value="<?= $produto['codigo'] ?>" require>
                                    <label for="codigo">Código do Produto</label>
                                </div>
                            </div>
                            <!-- Nome do produto -->
                            <div class="row">
                                <div class="input-field col s10">
                                    <input id="Nome do produto" type="text" name="nome_produto" class="validate"
                                        value="<?= $produto['nome_produto'] ?>" require>
                                    <label for="Nome do produto">Nome do Produto</label>
                                </div>
                            </div>

                            <!-- Descrição -->
                            <div class="row">
                                <form class="col s12">
                                    <div class="row">
                                        <div class="input-field col s10">
                                            <textarea id="descricao" class="materialize-textarea"
                                                name="descricao"><?= $produto['descricao'] ?></textarea>
                                            <label for="descricao">Descrição</label>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <!-- Avaliação -->
                            <div class="row">
                                <div class="input-field col s4">
                                    <input id="avaliacao" type="number" name="avaliacao" step=".5" min="1" max="5"
                                        class="validate" value="<?= $produto['avaliacao'] ?>" require>
                                    <label for="avaliacao">Avaliação</label>
                                </div>
                            </div>
                            <!-- QUANTIDADE ESTOQUE -->
                            <div class="row">
                                <div class="input-field col s4">
                                    <input id="qtdestoque" type="number" name="qtd_estoque" validate
                                        value="<?= $produto['qtd_estoque'] ?>" require>
                                    <label for="qtdestoque">Quantidade do estoque</label>
                                </div>
                            </div>
                            <!-- Preço do Produto-->
                            <div class="row">
                                <div class="input-field col s4">
                                    <input id="preco" type="number" name="preco" step=".1" min="0" class="validate"
                                        value="<?= $produto['preco'] ?>" require>
                                    <label for="preco">R$</label>
                                </div>
                            </div>

                            <!-- IMAGEM DO PRODUTO-->
                            <!-- <img src="img/<?= $produto["id"] . '/' . $produto["imagem"] ?>" width="170" height="170"> -->
                            <?php
                            // Caminho para a pasta que contém as imagens
                            $dir = 'img/' . "$produto[id]" . '/';

                            // Ler os arquivos na pasta e gerar o código HTML para cada imagem
                            $files = scandir($dir);
                            foreach ($files as $file) {

                                if ($file !== '.' && $file !== '..' && is_file($dir . $file) && preg_match('/\.(JPG|jpg|jpeg|png)$/', $file)) {
                                    echo "<div class='carousel-item'>
                      <img src='$dir/$file' class='d-block w-100' alt='$file' width='170' height='170'>
                    </div>";
                                }
                            }
                            ?>

                            <div class="file-field input-field">
                                <div class="btn grey darken-3">
                                    <span>Alterar Imagem</span>
                                    <input type="file" name="imagem" id="imagem" multiple="true">
                                </div>
                                <div class="file-path-wrapper">
                                    <input class="file-path validate" type="text">
                                </div>
                            </div>
                            <div class="card-action">
                                <a class="btn waves-effect waves-light grey" href="gestaoProdutos.php">Cancelar</a>
                                <a><input type="submit" class=" waves-light btn black" name="editar" id="editar"
                                        value="Editar"></a>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="id" value="<?php echo $id ?>">
            </form>
        </div>
    <?php endwhile ?>
</body>

</html>