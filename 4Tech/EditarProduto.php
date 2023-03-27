<?php
session_start();

if(!empty($_GET['id'])){

    include_once("conexao.php");

    $id = $_GET['id'];

    $result_produto = "SELECT * FROM produto where id = '$id'";
    $sql_query = $mysqli->query($result_produto) or die($mysqli->error);

    if($sql_query->num_rows > 0){
        while($row_produto = mysqli_fetch_assoc($sql_query)) 
        {
            $nomeProduto = $row_produto['nome_produto'];
            $avaliacao = $row_produto['avaliacao'];
            $descricao = $row_produto['descricao'];
            $preco = $row_produto['preco'];
            $qtdEstoque = $row_produto['qtd_estoque'];
            $imagem = $row_produto['imagem'];
        }
    }
    else{
        header('Location: GestaoProdutos.php');
    }

}



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
                <li><a href="GestaoProdutos.php">Voltar</a></li>
            </ul>
        </div>
    </nav>


    <div class="row">
        <form action="saveEdit.php" method="POST">
        <div class="col s6 offset-s3">
            <div class="card">
               <div class="card-content">
                    <span class="card-title">Editar Produto</span>
                    <!-- Nome do produto -->
                    <div class="row">
                        <div class="input-field col s10">
                            <input id="Nome do produto" type="text" name="nome_produto" class="validate" value="<?php echo $nomeProduto ?>" require >
                            <label for="Nome do produto">Nome do Produto</label>
                        </div>
                    </div>
                    

                    <!-- Descrição -->
                    <div class="row">
                        <form class="col s12">
                            <div class="row">
                                <div class="input-field col s10">
                                    <textarea id="descricao" class="materialize-textarea" name="descricao"><?php echo $descricao ?></textarea>
                                    <label for="descricao">Descrição</label>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- Avaliação -->
                    <div class="row">
                        <div class="input-field col s4">
                            <input id="avaliacao" type="number" name="avaliacao" step=".5" min="1" max="5" class="validate" value="<?php echo $avaliacao ?>" require>
                            <label for="avaliacao">Avaliação</label>
                        </div>
                    </div>
                    <!-- QUANTIDADE ESTOQUE -->
                    <div class="row">
                        <div class="input-field col s4">
                            <input id="qtdestoque" type="number"  name="qtd_estoque" validate value="<?php echo $qtdEstoque ?>" require>
                            <label for="qtdestoque">Quantidade do estoque</label>
                        </div>
                    </div>
                    <!-- Preço do Produto-->
                    <div class="row">
                        <div class="input-field col s4">
                            <input id="preco" type="number"  name="preco" step=".1" min="0" class="validate" value="<?php echo $preco; ?>" require>
                            <label for="preco">R$</label>
                        </div>
                    </div>
                    
                    <!-- IMAGEM DO PRODUTO-->
                    <img src=<?= $imagem ?> width="150" height="150">
                    <div class="file-field input-field">
                        <div class="btn grey darken-3">
                            <span>Imagem do Produto</span>
                            <input name="imagem" type="file">
                        </div>
                        <div class="file-path-wrapper">
                            <input class="file-path validate" type="text">
                        </div>
                    </div>
                    <div class="card-action">
                        <a class="btn waves-effect waves-light grey" href="GestaoProdutos.php">Cancelar</a>
                        <a href="GestaoProdutos.php"><input type="submit" class=" waves-light btn black" name="editar" id="editar" value="Editar"></a>       
                    </div>
                </div>
            </div>
            <input type="hidden" name="id" value="<?php echo $id?>">
        </form>
        </div>
</body>
</html>
