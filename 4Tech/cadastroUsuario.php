<?php
session_start();
include("conexao.php");

$nome = mysqli_real_escape_string($mysqli, $_POST['nome']);
$cpf = mysqli_real_escape_string($mysqli, $_POST['cpf']);
$email = mysqli_real_escape_string($mysqli, $_POST['email']);
$senha = mysqli_real_escape_string($mysqli, md5($_POST['senha']));
$grupo_usuario = mysqli_real_escape_string($mysqli, $_POST['radio-btn']);

$cadastrar = "INSERT INTO usuario(nome,cpf,email,senha,status,grupo_usuario) 
VALUES ('$nome','$cpf','$email','$senha','1','$grupo_usuario')
";

if ($mysqli->query($cadastrar) === TRUE) {
	$_SESSION['status_cadastro'] = true;
	header('Location: cadUsuario.html');
	exit;
} else {
	echo $mysqli->error;
}

?>