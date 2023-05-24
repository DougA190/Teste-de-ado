<?php
session_start();
include "conexao.php";

if(empty($_POST['email']) || empty($_POST['senha'])){

 header('Location:loginCliente.php');
 exit();
}

$email = mysqli_real_escape_string($mysqli, $_POST['email']);
$senha = mysqli_real_escape_string($mysqli, md5($_POST['senha']));

if(empty($email) && empty($senha)){

    header("Location:loginCliente.php?error=Necessário preencher o email e senha");
    exit();

}else{

    $query = "select * from usuarios_clientes inner join clientes on usuarios_clientes.cliente_id = clientes.id where email = '$email' and senha='$senha'";

    $result = $mysqli->query($query) or die($mysqli->error);
    
    $row = $result->num_rows;
    
    if($row == 1) {
         $cliente = mysqli_fetch_assoc($result);
         $_SESSION['id'] = $cliente['id'];
        //  $_SESSION['senha'] = $usuario['senha'];
         header("Location: index.php?usuarios_clientes=$_SESSION[id]");
         exit();
    }else{
        header("Location:loginCliente.php?error=Usuario Não foi localizado");
        exit();
    }
    }
    
    session_start();
    include "conexao.php";
    if(isset($_POST['email']) || isset($_POST['senha'])){
    
     function validate($data){
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
     }
     $email = mysqli_real_escape_string($mysqli, $_POST['email']);
     $senha = mysqli_real_escape_string($mysqli,md5($_POST['senha']));
    
    if(empty($email) && empty($senha)){
        
    }else{
        $sql = "select *from usuarios_clientes inner join clientes where email = '$email' and senha='$senha'";
        $sql_query = $mysqli->query($sql) or die($mysqli->error);
        if($row == 1) {
            $cliente = mysqli_fetch_assoc($sql_query);
        $_SESSION['id'] = $cliente['id'];
        header("Location: index.php?usuarios_clientes=$_SESSION[id]");
        exit();
        }
        }
    }
    

?>