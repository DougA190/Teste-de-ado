<?php
session_start();
include('conexao.php');

if(empty($_POST['email']) || empty($_POST['senha'])) {
    echo "Digita a senha";
	header('Location: TeladeLogin.html');
	exit();
}

$email = mysqli_real_escape_string($mysqli, $_POST['email']);
$senha = mysqli_real_escape_string($mysqli, $_POST['senha']);

$query = "SELECT id,nome,grupo_usuario_id FROM usuarios_backoffice WHERE email = '{$email}' and senha = md5('{$senha}') and status=1";


$result = $mysqli->query($query) or die($mysqli->error);

$row = $result->num_rows;

if($row == 1) {
	 $usuario = mysqli_fetch_assoc($result);
	 $_SESSION['UsuarioID'] = $usuario['id'];
	 $_SESSION['Grupo_Usuario'] = $usuario['grupo_usuario_id'];
	 header("Location: backoffice.html?Grupo_Usuario=$_SESSION[Grupo_Usuario]");
	 exit();
} else {
	$_SESSION['nao_autenticado'] = true;
	header('Location: loginBackoffice.html?err=true');
	exit();
}

?>