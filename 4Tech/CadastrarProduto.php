<?php
session_start();
include('conectar.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Compiled and minified CSS -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">

    <!-- Compiled and minified JavaScript -->
    <!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>-->
    
    <title>4Tech-Cadastrar Produtos</title>
</head>

<body>

    <?php
    $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

    //ACESSA O IF QUANDO O USUARIO CLICAR NO BOTÃO
    if (!empty($dados['senCadProd'])) {

        // QUERY CADASTRAR PRODUTO
        $query_produto = "INSERT INTO produto(nome_produto,codigo,avaliacao,status,descricao,preco,qtd_estoque) VALUES(:nome_produto,:codigo,:avaliacao,1,:descricao,:preco,:qtd_estoque)";

        //PREPARA A QUERY
        $cadProduto = $conn->prepare($query_produto);


        //SUBSTITUIR OS LINKS PELOS VALORES DO FORMULÁRIO
        $cadProduto->bindParam(':nome_produto', $dados['nome_produto']);
        $cadProduto->bindParam(':codigo', $dados['codigo']);
        $cadProduto->bindParam(':avaliacao', $dados['avaliacao']);
        $cadProduto->bindParam(':descricao', $dados['descricao']);
        $cadProduto->bindParam(':preco', $dados['preco']);
        $cadProduto->bindParam(':qtd_estoque', $dados['qtd_estoque']);

        //EXECUTA A QUERY
        $cadProduto->execute();

        //ACESSA O IF QUANDO CADASTRAR O USUARIO NO BD
        if ($cadProduto->rowCount()) {

            //RECEBER O ID DO REGISTRO CADASTRADO
            $produtoId = $conn->lastInsertId();

            //ENDEREÇO DO DIRETÓRIO
            $diretorio = "img/$produtoId/";

            //CRIAR O DIRETÓRIO
            mkdir($diretorio, 0755);

            //RECEBER OS ARQUIVOS DO FORMULÁRIO 
            $arquivo = $_FILES['imagem'];

            //LER O ARRAY DE ARQUIVOS
            for ($cont = 0; $cont < count($arquivo['name']); $cont++) {

                //RECEBER NOME DA IMAGEM
                $nome_arquivo = $arquivo['name'][$cont];

                //CRIAR O ENDEREÇO DE DESTINO DAS IMAGENS
                $destino = $diretorio . $arquivo['name'][$cont];

                //ACESSA O IF QUANDO REALIZAR O UPLOAD CORRETAMENTE
                if (move_uploaded_file($arquivo['tmp_name'][$cont], $destino)) {

                    $query_imagem = "INSERT INTO imagens_produtos (imagem,id_produto,isprincipal) VALUES (:imagem, :id_produto,:isprincipal)";
                    /*$isprincipal = ($destino = $dados[0])?1:0;
                    $cad_imagem->bindParam(':isprincipal',$isprincipal);*/
                    $cad_imagem = $conn->prepare($query_imagem);
                    $cad_imagem->bindParam(':imagem', $nome_arquivo);
                    $cad_imagem->bindParam(':id_produto', $produtoId);
                    $is_principal = ($cont == 0 && isset($dados['isprincipal']));
                    $cad_imagem->bindParam(':isprincipal', $is_principal);
                    if ($cad_imagem->execute()) {
                        if ($is_principal) {
                            $id_imagem = $conn->lastInsertId();
                            $sql_img = "UPDATE imagens_produtos set isprincipal=0 where id_img != $id_imagem and id_produto=$produtoId";
                            $conn->query($sql_img);
                        }
                    } else {
                        $_SESSION['msg'] = "<p> erro no Cadastrado</p>";
                    }
                    // $_SESSION['msg'] = "<p> Produto Cadastrado</p>";
                    header("location:GestaoProdutos.php");
                } else {
                    $_SESSION['msg'] = "<p> erro no Cadastrado</p>";
                }
            }
        }
    }
    if (isset($_SESSION['msg'])) {
        echo $_SESSION['msg'];
        unset($_SESSION['msg']);
    }
    ?>
    <nav>
        <div class="nav-wrapper grey darken-4">
            <a class="brand-logo center">4Tech - Cadastrar Produto</a>
           
            <ul id="nav-mobile" class="left hide-on-med-and-down grey darken-4">
                <li><a href="backoffice.html">Voltar</a></li>
            </ul>
        </div>
    </nav>

    <div class="row">
        <form method="post" action="" enctype="multipart/form-data">
            <div class="col s6 offset-s3">
                <div class="card">
                    <div class="card-content">
                        <span class="card-title">Cadastrar Produtos</span>
                        <div class="row">
                            <div class="input-field col s12">

                                <input id="codigo" type="text" name="codigo" class="validate" require>
                                <label for="codigo">Código do produtos</label>
                            </div>
                        </div>
                        <!-- Nome do produto -->
                        <div class="row">
                            <div class="input-field col s12">
                                <input id="Nome do produto" type="text" name="nome_produto" class="validate" require>
                                <label for="Nome do produto">Nome do Produto</label>
                            </div>
                        </div>

                        <!-- Descrição -->
                        <div class="row">
                            <form class="col s12">
                                <div class="row">
                                    <div class="input-field col s12">
                                        <textarea id="descricao" class="materialize-textarea" name="descricao"></textarea>
                                        <label for="descricao">Descrição</label>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <!-- Avaliação -->
                        <div class="row">
                            <div class="input-field col s4">
                                <input id="avaliacao" type="number" name="avaliacao" step=".5" min="1" max="5" class="validate" require>
                                <label for="avaliacao">Avaliação</label>
                            </div>
                        </div>

                        <!-- QUANTIDADE ESTOQUE -->
                        <div class="row">
                            <div class="input-field col s4">
                                <input id="qtdestoque" type="number" name="qtd_estoque" validate require>
                                <label for="qtdestoque">Quantidade do estoque</label>
                            </div>
                        </div>

                        <!-- Preço do Produto-->
                        <div class="row">
                            <div class="input-field col s4">
                                <input id="preco" type="number" name="preco" step=".1" min="0" class="validate" require>
                                <label for="preco">R$</label>
                            </div>
                        </div>
                        <!--<div class="row">
                                <label>
                                    <input class="row" type="checkbox" name="isprincipal" value="1">
                                    <span>Definir como imagem principal</span> 
                                </label>
                            </div>-->
                        <div class="row">
                       <!-- PREVIEW-->
                            <div class="row" id="previews"> </div>
                            <!-- RADIO BUTTON-->
                            <div class="row" id="radios"> </div>
                        </div>
                            <!-- IMAGEM DO PRODUTO-->
                            <div class="file-field input-field">
                                <div class="btn grey darken-3">
                                    <span>Imagem do Produto</span>

                                    <input type="file" name="imagem[]" accept="image/*" multiple onchange="previewImagens();">
                                </div>
                                
                                <div class="file-path-wrapper">
                                    <input class="file-path validate">
                                </div>
                            </div>
                        </div>
                        <div class="card-action">

                            <a class="btn waves-effect waves-light grey" href="GestaoProdutos.php">Cancelar
                            </a>
                            <input class="waves-light btn black" type="submit" name="senCadProd" value="Cadastrar">
                        </div>
                    </div>
        </form>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.8/js/materialize.min.js"></script>

    <script src="js/cadastrarProduto.js"></script>
</body>

</html>