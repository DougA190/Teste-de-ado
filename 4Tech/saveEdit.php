<?php

    include_once("conexao.php");

    if(isset($_POST['editar']))
    {
        $id = $_POST['id'];
        $nomeProduto = $_POST['nome_produto'];
        $avaliacao = $_POST['avaliacao'];
        $descricao = $_POST['descricao'];
        $preco = $_POST['preco'];
        $qtdEstoque = $_POST['qtd_estoque'];
        $imagem = $_POST['imagem'];

        $sqlUpdate = "UPDATE produto SET nome_produto='$nomeProduto', avaliacao='$avaliacao', descricao='$descricao', preco='$preco', qtd_estoque='$qtdEstoque', imagem='$imagem'
        WHERE id='$id'";

        $sql_query = $mysqli->query($sqlUpdate);
    }
    header('Location: GestaoProdutos.php');

?>