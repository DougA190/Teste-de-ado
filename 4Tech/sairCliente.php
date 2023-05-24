<?php
session_start();

// Remove as variáveis de sessão
unset($_SESSION['email']);
unset($_SESSION['senha']);
// Encerra a sessão
session_destroy();
// Redireciona o usuário para a página "indexCliente.php"
header("Location: index.php");
exit();


?>


