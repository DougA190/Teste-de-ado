<?php
session_start();
include("conexao.php");

$nome = mysqli_real_escape_string($mysqli, $_POST['nome']);
$sobreNome = mysqli_real_escape_string($mysqli, $_POST['sobrenome']);
$cpf = mysqli_real_escape_string($mysqli, $_POST['cpf']);
$email = mysqli_real_escape_string($mysqli, $_POST['email']);
$genero_id = mysqli_real_escape_string($mysqli, $_POST['genero']);
$data_nascimento = mysqli_real_escape_string($mysqli, $_POST['dataNascimento']);
$senha = mysqli_real_escape_string($mysqli, md5($_POST['senha']));

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['editarCliente'])) {
        $id = mysqli_real_escape_string($mysqli, $_POST['id']);
        editarCliente($nome, $sobreNome, $cpf, $genero_id, $data_nascimento,$email,$senha, $id);
    }
}

function editarCliente($nome, $sobreNome, $cpf, $genero_id, $data_nascimento, $email,$senha,$id)
{
    // o Global define que a variavel $mysqli é a mesma chamada fora da função
    global $mysqli;
    $editar = "UPDATE clientes inner join usuarios_clientes on clientes.id = usuarios_clientes.cliente_id
        SET clientes.nome = '$nome', clientes.sobrenome = '$sobreNome', clientes.cpf = '$cpf', clientes.genero = '$genero_id', clientes.dataNascimento = '$data_nascimento'
        ,usuarios_clientes.email='$email', usuarios_clientes.senha='$senha'
        WHERE clientes.id = $id";
    if ($mysqli->query($editar) === TRUE) {
        $_SESSION['status_cadastro'] = true;
        header('Location: index.php?usuarios_clientes=$id');
        exit;
    } else {
        echo $mysqli->error;
    }
}
?>