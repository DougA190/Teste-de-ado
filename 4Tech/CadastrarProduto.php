<?php include "cabecalho.php" ?>

<?php 

session_start();
include('conexao.php');

$nome = mysqli_real_escape_string($mysqli, $_POST['nome_produto']);
$avaliacao = mysqli_real_escape_string($mysqli, $_POST['avaliacao']);
$descricao = mysqli_real_escape_string($mysqli, $_POST['descricao']);
$preco = mysqli_real_escape_string($mysqli,($_POST['preco']));
$qtd_estoque = mysqli_real_escape_string($mysqli, $_POST['qtd_estoque']);
$File = mysqli_real_escape_string($mysqli, ($_POST['imagem']));

$upload = salvarFtperfil($_FILES);
if(gettype($upload) == "string"){
	$File = $upload;
}

$cadastrar = "INSERT INTO produto(nome_produto,avaliacao,descricao,preco,qtd_estoque,imagem) 
VALUES ('$nome','$avaliacao','$descricao','$preco','$qtd_estoque','$File')";

if ($mysqli->query($cadastrar) === TRUE) {
	$_SESSION['status_cadastro'] = true;
	header('Location: CadastrarProduto.html');
	exit;
} else {
	echo $mysqli->error;
}

function salvarFtperfil($file){
	$fotoDir = "img/Produtos/";
	$fotoPath = $fotoDir . basename($file["imagem"]["name"]);
	$fotoTmp = $file["imagem"]["tmp_name"];
	if(move_uploaded_file($fotoTmp, $fotoPath)){
		return $fotoPath;
	}else{
		return false;
	}
}
?>
