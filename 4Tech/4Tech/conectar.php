<?php

$hostname = "localhost";
$bancodedados = "4tech";
$usuario = "root";
$senha = "";

try{
    $conn = new PDO("mysql:host=$hostname;dbname=".$bancodedados,$usuario,$senha);
}catch(PDOException $err){
    echo "Erro: Conexão com banco de dados não realizado com sucesso. Erro gerado".$err->getMessage();
}