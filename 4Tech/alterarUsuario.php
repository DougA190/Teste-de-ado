<?php
session_start();
include("conexao.php");

$nome = mysqli_real_escape_string($mysqli, $_POST['nome']);
$cpf = mysqli_real_escape_string($mysqli, $_POST['cpf']);
$email = mysqli_real_escape_string($mysqli, $_POST['email']);
$senha = mysqli_real_escape_string($mysqli, md5($_POST['senha']));
$id = mysqli_real_escape_string($mysqli, md5($_POST['id']));


$alterar = "UPDATE usuario
SET nome = $nome, cpf = $cpf, senha = $senha
WHERE id = $id";

if ($mysqli->query($alterar) === TRUE) {
	$_SESSION['status_cadastro'] = true;
	header('Location: TeladeGestao.html');
	exit;
} else {
	echo $mysqli->error;
}

?>