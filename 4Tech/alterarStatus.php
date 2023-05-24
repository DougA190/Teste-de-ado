<?php
session_start();
include("conexao.php");
$id = $_POST['id'];
$status = $_POST['status'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST['usuario'])) {
    $tabela = 'usuarios_backoffice';
    alterarStatus($tabela,$status, $id);
  }
  else if (isset($_POST['produto'])) {
    $tabela = 'produto';
    alterarStatus($tabela,$status, $id);
  }

}

function alterarStatus($tabela,$status, $id)
{
  // o Global define que a variavel $mysqli é a mesma chamada fora da função
  global $mysqli;

  // atualizar o status na tabela correspondente
  $query = "UPDATE $tabela SET status = '$status' WHERE id = $id ";
  $result = $mysqli->query($query);

  if (!$result) {
    die('Erro ao atualizar o status: ' . $mysqli->error);
  }

  $mysqli->close();

  echo 'Status atualizado com sucesso';

}


?>