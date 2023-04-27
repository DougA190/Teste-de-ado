<?php
session_start();
include('conexao.php');
$nome = mysqli_real_escape_string($mysqli, $_POST['nome']);
$sobrenome = mysqli_real_escape_string($mysqli, $_POST['sobrenome']);
$cpf = mysqli_real_escape_string($mysqli, $_POST['cpf']);
$dataNasc = mysqli_real_escape_string($mysqli, $_POST['dataNasc']);
$sexo = mysqli_real_escape_string($mysqli, $_POST['sexo']);
$dddCelular = mysqli_real_escape_string($mysqli, $_POST['dddCelular']);
$celular = mysqli_real_escape_string($mysqli, $_POST['celular']);
$dddTelefone = mysqli_real_escape_string($mysqli, $_POST['dddTelefone']);
$telefone = mysqli_real_escape_string($mysqli, $_POST['telefone']);
$cepCobranca = mysqli_real_escape_string($mysqli, $_POST['cepCobranca']);
$logradouroCobranca = mysqli_real_escape_string($mysqli, $_POST['logradouroCobranca']);
$numeroCobranca =mysqli_real_escape_string($mysqli, $_POST['numeroCobranca']);
$complementoCobranca =mysqli_real_escape_string($mysqli, $_POST['complementoCobranca']);
$bairroCobranca =mysqli_real_escape_string($mysqli, $_POST['bairroCobranca']);
$cidadeCobranca =mysqli_real_escape_string($mysqli, $_POST['cidadeCobranca']);
$ufCobranca =mysqli_real_escape_string($mysqli, $_POST['ufCobranca']);
function cadastrarCliente(){
$cadastrarCliente = "
start transaction;
insert into clientes(nome,sobrenome,cpf,dataNascimento,sexo,ddd_celular,num_celular,ddd_telefone,num_telefone) values ('João','Pablo Vilanir de Melo', '111.111.111-11','14/10/2002','Masculino','11','95355-3207','11','4245-8911');
SET @cliente_id = LAST_INSERT_ID();
insert into enderecos_de_cobranca(cep,logradouro,numero_endereco,complemento,bairro,cidade,uf,cliente_id) values ('00000-000','Rua Indefinida','11','Casa 2','Pedreira','São Paulo','SP',@cliente_id);
insert into enderecos_de_entrega(cep,logradouro,numero_endereco,complemento,bairro,cidade,uf,cliente_id) values ('00000-000','Rua Indefinida','11','Casa 2','Pedreira','São Paulo','SP',@cliente_id);
insert into usuarios_clientes(email,senha,cliente_id) values ('joao@gmail.com','12345678',@cliente_id);
commit;

";
}
?>