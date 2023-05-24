<?php
session_start();
include('conexao.php');
$cliente_id = mysqli_real_escape_string($mysqli, $_POST['id']);
$data_atual = date('d-m-Y');
$produto_id = mysqli_real_escape_string($mysqli, $_POST['id_produto']);
$quantidade = mysqli_real_escape_string($mysqli, $_POST['qtdproduto']);
$precoTotal = mysqli_real_escape_string($mysqli, $_POST['precoCompra']);


?>