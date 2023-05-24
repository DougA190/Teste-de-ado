<?php
session_start();
$nivel_necessario=1;
if (!isset($_SESSION['UsuarioID']) OR ($_SESSION['Grupo_Usuario'] != $nivel_necessario)) {
	// Destrói a sessão por segurança
	session_destroy();
	// Redireciona o visitante de volta pro login
	header("Location: loginBackoffice.html?"); 
	exit;
}else{
	header("Location: gestaoUsuarios.php"); 
}
?>