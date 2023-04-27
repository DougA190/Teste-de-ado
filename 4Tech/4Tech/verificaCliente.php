<?php
session_start();
include "conexao.php";
if(isset($_POST['email']) && isset($_POST['senha'])){

 function validate($data){
$data = trim($data);
$data = stripslashes($data);
$data = htmlspecialchars($data);
return $data;
 }
 $email = validate($_POST['email']);
 $senha = validate($_POST['senha']);

if(empty($email) && empty($senha)){
    header("Location:loginCliente.php?error=Necessário preencher o email e senha");
    exit();
}else if(empty($email)){
    header("Location:loginCliente.php?error=E-mail é obrigatorio");
    exit();
}else if(empty($senha)){
    header("Location:loginCliente.php?error=Senha é obrigatorio");
    exit();
}else{
    $sql = "SELECT * FROM clientes WHERE email = '$email' and senha='$senha'";
    $sql_query = $mysqli->query($sql) or die($mysqli->error);

    if(mysqli_num_rows($sql_query)==1){
$row = mysqli_fetch_assoc($sql_query);
if($row['email']=== $email && $row['senha']===$senha){
    $_SESSION['email'] = $row['email'];
    $_SESSION['nome'] = $row['nome'];
    $_SESSION['id'] = $row['id'];
    header("Location:indexCliente.php");
    exit();
}else{
    header("Location:loginCliente.php?error=Usuario Não foi localizado");
    exit();
}
    }else{
        header("Location:loginCliente.php?error=Usuario Não foi localizado");
    exit();
    }
}
}
?>
