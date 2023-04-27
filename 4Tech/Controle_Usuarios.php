<?php
session_start();
include("conexao.php");
$nome = mysqli_real_escape_string($mysqli, $_POST['nome']);
$cpf = mysqli_real_escape_string($mysqli, $_POST['cpf']);

$senha = mysqli_real_escape_string($mysqli, md5($_POST['senha']));

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['cadastrarUsuario'])) {
        $email = mysqli_real_escape_string($mysqli, $_POST['email']);
        $grupo_usuario = mysqli_real_escape_string($mysqli, $_POST['radio-btn']);
        cadastrarUsuario($nome, $cpf, $email, $senha, $grupo_usuario);
    } else if (isset($_POST['editarUsuario'])) {
        $id = mysqli_real_escape_string($mysqli, $_POST['id']);
        editarUsuario($nome, $cpf, $senha, $id);
    }
}
function cadastrarUsuario($nome, $cpf, $email, $senha, $grupo_usuario)
{
    // o Global define que a variavel $mysqli é a mesma chamada fora da função
    global $mysqli;
    $cadastrar = "INSERT INTO usuarios_backoffice(nome,cpf,email,senha,status,grupo_usuario_id) 
    VALUES ('$nome','$cpf','$email','$senha','1','$grupo_usuario')
    ";
    if ($mysqli->query($cadastrar) === TRUE) {
        $_SESSION['status_cadastro'] = true;
        header('Location: gestaoUsuarios.php');
        exit;
    } else {
        echo $mysqli->error;
    }
}
function editarUsuario($nome, $cpf, $senha, $id)
{
    // o Global define que a variavel $mysqli é a mesma chamada fora da função
    global $mysqli;
    $editar = "UPDATE usuarios_backoffice
        SET nome = '$nome', cpf = '$cpf', senha = '$senha'
        WHERE id = $id";
    if ($mysqli->query($editar) === TRUE) {
        $_SESSION['status_cadastro'] = true;
        header('Location: gestaoUsuarios.php');
        exit;
    } else {
        echo $mysqli->error;
    }
}
?>