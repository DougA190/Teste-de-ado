<?php
session_start();
include_once("conexao.php");

if (isset($_POST['editar'])) {
    $id = $_POST['id'];
    $codigo = $_POST['codigo'];
    $nomeProduto = $_POST['nome_produto'];
    $avaliacao = $_POST['avaliacao'];
    $descricao = $_POST['descricao'];
    $preco = $_POST['preco'];
    $qtdEstoque = $_POST['qtd_estoque'];
    //$extensoes_permitidas = array('jpg', 'jpeg', 'png', 'gif');

    // PARTE 3 - ATUALIZAÇÃO DA IMAGEM
   

            //ENDEREÇO DO DIRETÓRIO
            
    // if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] == 0) {
    //     $fotoDir = "img/$id/";
    //     $imagem_tmp = $_FILES['imagem']['tmp_name'];
    //     $imagem = $fotoDir . basename($_FILES['imagem']['name']);
    //     $extensao = pathinfo($imagem, PATHINFO_EXTENSION);

    //     if (in_array($extensao, $extensoes_permitidas)) {
    //         if (gettype($upload) == "string") {
    //             $File = $upload;
    //         }
    //         move_uploaded_file($imagem_tmp, $imagem);
    //     } else {
    //         echo "Erro: Apenas imagens dos tipos " . implode(", ", $extensoes_permitidas) . " são permitidas.";
    //         exit();
    //     }
    // } else {
    //     // Se não foi enviado uma nova imagem, manter a imagem atual do produto
    //     echo 'erro aqui';
    //     $sqlSelect = "SELECT * FROM imagens_produtos WHERE id_produto=$id";
    //     $result = $mysqli->query($sqlSelect);
    //     $row = $result->fetch_assoc();
    //     $imagem = $row['imagem'];
    // }


    $sqlUpdate = "UPDATE produto SET codigo='$codigo',nome_produto='$nomeProduto', avaliacao='$avaliacao', descricao='$descricao', preco='$preco', qtd_estoque='$qtdEstoque' WHERE id='$id'";
    $sql_query = $mysqli->query($sqlUpdate);
    if (!$sql_query) {
        echo "Erro ao atualizar o produto: " . $mysqli->error;
        exit();
    } else {
        header('Location: GestaoProdutos.php');
    }
}

?>