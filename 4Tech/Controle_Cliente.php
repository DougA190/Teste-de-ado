<?php
session_start();
include("conexao.php");
$nome = mysqli_real_escape_string($mysqli, $_POST['nome']);
$cpf = mysqli_real_escape_string($mysqli, $_POST['cpf']);
$email = mysqli_real_escape_string($mysqli, $_POST['email']);
$genero = mysqli_real_escape_string($mysqli, $_POST['genero']);
$data_nascimento = mysqli_real_escape_string($mysqli, $_POST['data_nascimento']);

$senha = mysqli_real_escape_string($mysqli, md5($_POST['senha']));

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['editarCliente'])) {
        $id = mysqli_real_escape_string($mysqli, $_POST['id']);
        editarCliente($nome, $cpf, $email, $genero, $data_nascimento, $senha, $id);
    }
}

function editarCliente($nome, $cpf, $email, $genero, $data_nascimento, $senha, $id)
{
    // o Global define que a variavel $mysqli é a mesma chamada fora da função
    global $mysqli;
    $editar = "UPDATE usuarios_clientes
        SET nome = '$nome', cpf = '$cpf', senha = '$senha', email = '$email', genero = '$genero', data_nascimento = '$data_nascimento
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