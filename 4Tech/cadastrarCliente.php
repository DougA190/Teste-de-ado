<?php
session_start();
include('conexao.php');
$nome = mysqli_real_escape_string($mysqli, $_POST['nome']);
$sobrenome = mysqli_real_escape_string($mysqli, $_POST['sobrenome']);
$cpf = mysqli_real_escape_string($mysqli, $_POST['cpf']);
$dataNasc = mysqli_real_escape_string($mysqli, $_POST['dataNasc']);
$genero = mysqli_real_escape_string($mysqli, $_POST['genero']);
$dddCelular = mysqli_real_escape_string($mysqli, $_POST['dddCelular']);
$numCelular = mysqli_real_escape_string($mysqli, $_POST['numCelular']);
$dddTelefone = mysqli_real_escape_string($mysqli, $_POST['dddTelefone']);
$numTelefone = mysqli_real_escape_string($mysqli, $_POST['numTelefone']);
$cepCobranca = mysqli_real_escape_string($mysqli, $_POST['cepCobranca']);
$logradouroCobranca = mysqli_real_escape_string($mysqli, $_POST['logradouroCobranca']);
$numeroCobranca = mysqli_real_escape_string($mysqli, $_POST['numeroCobranca']);
$complementoCobranca = mysqli_real_escape_string($mysqli, $_POST['complementoCobranca']);
$bairroCobranca = mysqli_real_escape_string($mysqli, $_POST['bairroCobranca']);
$cidadeCobranca = mysqli_real_escape_string($mysqli, $_POST['cidadeCobranca']);
$ufCobranca = mysqli_real_escape_string($mysqli, $_POST['ufCobranca']);
$email = mysqli_real_escape_string($mysqli, $_POST['email']);
$senha = mysqli_real_escape_string($mysqli, md5($_POST['senha']));

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['cadastrarCliente'])) {
        cadastrarCliente($nome, $sobrenome, $cpf, $dataNasc, $genero, $dddCelular, $numCelular, $dddTelefone, $numTelefone, $cepCobranca, $logradouroCobranca, $numeroCobranca, $complementoCobranca, $bairroCobranca, $cidadeCobranca, $ufCobranca, $email, $senha);
    }
}
function cadastrarCliente($nome, $sobrenome, $cpf, $dataNasc, $genero, $dddCelular, $numCelular, $dddTelefone, $numTelefone, $cepCobranca, $logradouroCobranca, $numeroCobranca, $complementoCobranca, $bairroCobranca, $cidadeCobranca, $ufCobranca, $email, $senha)
{

    global $mysqli;
    $mysqli->begin_transaction();

    try {
        $query1 = $mysqli->prepare("INSERT INTO clientes(nome,sobrenome,cpf,dataNascimento,genero,ddd_celular,num_celular,ddd_telefone,num_telefone) VALUES ('$nome','$sobrenome','$cpf','$dataNasc','$genero','$dddCelular','$numCelular','$dddTelefone','$numTelefone')");
        $query1->execute();


        $query2 = $mysqli->prepare("SET @cliente_id = LAST_INSERT_ID()");
        $query2->execute();

        $query3 = $mysqli->prepare("INSERT INTO enderecos_de_cobranca(cep,logradouro,numero_endereco,complemento,bairro,cidade,uf,cliente_id) VALUES ('$cepCobranca','$logradouroCobranca','$numeroCobranca','$complementoCobranca','$bairroCobranca','$cidadeCobranca','$ufCobranca',@cliente_id)");
        $query3->execute();

        if (isset($_POST['copiarEndereco'])) {
            $query4 = $mysqli->prepare("INSERT INTO enderecos_de_entrega(cep,logradouro,numero_endereco,complemento,bairro,cidade,uf,cliente_id) (SELECT cep,logradouro,numero_endereco,complemento,bairro,cidade,uf,cliente_id FROM enderecos_de_cobranca WHERE cliente_id = @cliente_id)");
            $query4->execute();
        } else {
            $cepEntrega = mysqli_real_escape_string($mysqli, $_POST['cepEntrega']);
            $logradouroEntrega = mysqli_real_escape_string($mysqli, $_POST['logradouroEntrega']);
            $numeroEntrega = mysqli_real_escape_string($mysqli, $_POST['numeroEntrega']);
            $complementoEntrega = mysqli_real_escape_string($mysqli, $_POST['complementoEntrega']);
            $bairroEntrega = mysqli_real_escape_string($mysqli, $_POST['bairroEntrega']);
            $cidadeEntrega = mysqli_real_escape_string($mysqli, $_POST['cidadeEntrega']);
            $ufEntrega = mysqli_real_escape_string($mysqli, $_POST['ufEntrega']);

            $query4 = $mysqli->prepare("INSERT INTO enderecos_de_entrega(cep,logradouro,numero_endereco,complemento,bairro,cidade,uf,cliente_id) VALUES ('$cepEntrega','$logradouroEntrega','$numeroEntrega','$complementoEntrega','$bairroEntrega','$cidadeEntrega','$ufEntrega',@cliente_id)");
            $query4->execute();
        }

        $query5 = $mysqli->prepare("INSERT INTO usuarios_clientes(email,senha,cliente_id) VALUES ('$email','$senha',@cliente_id)");
        $query5->execute();


        $mysqli->commit();
        header('location: loginCliente.php');
    } catch (mysqli_sql_exception $exception) {
        $mysqli->rollback();
        echo $mysqli->error;
        echo "<script type='javascript'>alert('Houve um erro no seu cadastro! Tente novamente');";
        
        throw $exception;
    }
}