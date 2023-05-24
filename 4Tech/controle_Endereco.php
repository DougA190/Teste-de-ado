<?php
session_start();
include("conexao.php");
include("conectar.php");

        $cep = mysqli_real_escape_string($mysqli, $_POST['cepEntrega']);
        $logradouro = mysqli_real_escape_string($mysqli, $_POST['logradouro']);
        $numero = mysqli_real_escape_string($mysqli, $_POST['numero_endereco']);
        $complemento = mysqli_real_escape_string($mysqli, $_POST['complemento']);
        $bairro = mysqli_real_escape_string($mysqli, $_POST['bairro']);
        $cidade = mysqli_real_escape_string($mysqli, $_POST['cidade']);
        $UF = mysqli_real_escape_string($mysqli, $_POST['ufEntrega']);
        $id = mysqli_real_escape_string($mysqli, $_POST['cliente_id']);
        $idCliente = mysqli_real_escape_string($mysqli, $_POST['cliente_id']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['cadastrarEndereco'])) {
        cadastrarEndereco($cep, $logradouro, $numero, $complemento, $bairro, $cidade, $UF, $id);

    } else if (isset($_POST['cadastrarEnderecoCobranca'])) {
        cadastrarEnderecoCobranca($cep, $logradouro, $numero, $complemento, $bairro, $cidade, $UF, $id);

    }else if (isset($_POST['tornarPrincipalE'])) {
        $id = mysqli_real_escape_string($mysqli, $_POST['idEndereco']);
        $status = mysqli_real_escape_string($mysqli, $_POST['status']);
        $id_cliente = mysqli_real_escape_string($mysqli, $_POST['idCliente']);

        $query_enderecos_entrega = "SELECT id, cep, logradouro, numero_endereco, complemento, bairro, cidade, uf, cliente_id, status
        FROM enderecos_de_entrega 
        WHERE cliente_id = :id_cliente
        ORDER BY id DESC";
        $result_enderecos_entrega = $conn->prepare($query_enderecos_entrega);
        $result_enderecos_entrega->bindParam(':id_cliente', $id_cliente);
        $result_enderecos_entrega->execute();

        while ($row_endereco = $result_enderecos_entrega->fetch(PDO::FETCH_ASSOC)) {
            if ($row_endereco['status'] === 'principal') {
                $id2 = $row_endereco['id'];
                $status2 = "secundario";
                apagarPrincipal($id2, $status2, $id, $status, $id_cliente);
            }
        }
    }else if (isset($_POST['tornarPrincipalC'])) {
        $id = mysqli_real_escape_string($mysqli, $_POST['idEndereco']);
        $status = mysqli_real_escape_string($mysqli, $_POST['status']);
        $id_cliente = mysqli_real_escape_string($mysqli, $_POST['idCliente']);

        $query_enderecos_entrega = "SELECT id, cep, logradouro, numero_endereco, complemento, bairro, cidade, uf, cliente_id, status
        FROM enderecos_de_cobranca 
        WHERE cliente_id = :id_cliente
        ORDER BY id DESC";
        $result_enderecos_entrega = $conn->prepare($query_enderecos_entrega);
        $result_enderecos_entrega->bindParam(':id_cliente', $id_cliente);
        $result_enderecos_entrega->execute();

        while ($row_endereco = $result_enderecos_entrega->fetch(PDO::FETCH_ASSOC)) {
            if ($row_endereco['status'] === 'principal') {
                $id2 = $row_endereco['id'];
                $status2 = "secundario";
                apagarPrincipal2($id2, $status2, $id, $status, $id_cliente);
            }
        }
    }else if (isset($_POST['excluirC'])) {
        $id = mysqli_real_escape_string($mysqli, $_POST['idEndereco']);
        $status = mysqli_real_escape_string($mysqli, $_POST['status2']);
        $id_cliente = mysqli_real_escape_string($mysqli, $_POST['idCliente']);
        excluirC($id,$status,$id_cliente);

    }else if (isset($_POST['excluirE'])) {
        $id = mysqli_real_escape_string($mysqli, $_POST['idEndereco']);
        $status = mysqli_real_escape_string($mysqli, $_POST['status2']);
        $id_cliente = mysqli_real_escape_string($mysqli, $_POST['idCliente']);
        excluirE($id,$status,$id_cliente);

    }else if (isset($_POST['ativarEntrega'])) {
        $id = mysqli_real_escape_string($mysqli, $_POST['idEndereco']);
        $status = mysqli_real_escape_string($mysqli, $_POST['status']);
        $id_cliente = mysqli_real_escape_string($mysqli, $_POST['idCliente']);
        atualizarStatusEndereco($id, $status, $id_cliente);

    }else if (isset($_POST['ativarCobranca'])) {
        $id = mysqli_real_escape_string($mysqli, $_POST['idEndereco']);
        $status = mysqli_real_escape_string($mysqli, $_POST['status']);
        $id_cliente = mysqli_real_escape_string($mysqli, $_POST['idCliente']);
        atualizarStatusEndereco2($id, $status, $id_cliente);
    }
}


function excluirE($id,$status,$id_cliente){
    global $mysqli;
    $exluir = "UPDATE enderecos_de_entrega SET status='$status' WHERE id='$id'";
    if ($mysqli->query($exluir) === TRUE) {
        header("Location: VisualizarEndereco.php?id=$id_cliente");
        exit;
    } else {
        echo $mysqli->error;
    }
}

function excluirC($id,$status,$id_cliente){
    global $mysqli;
    $exluir = "UPDATE enderecos_de_cobranca SET status='$status' WHERE id='$id'";
    if ($mysqli->query($exluir) === TRUE) {
        header("Location: VisualizarEndereco.php?id=$id_cliente");
        exit;
    } else {
        echo $mysqli->error;
    }
}

function apagarPrincipal($id2, $status2, $id, $status, $id_cliente){
    global $mysqli;
    $atualizar = "UPDATE enderecos_de_entrega SET status='$status2' WHERE id='$id2'";
    if ($mysqli->query($atualizar) === TRUE) {
        atualizarStatusEndereco($id, $status, $id_cliente);;
    } else {
        echo $mysqli->error;
    }
}

function atualizarStatusEndereco($id, $status, $id_cliente)
{
    global $mysqli;
    $atualizar = "UPDATE enderecos_de_entrega SET status='$status' WHERE id='$id'";
    if ($mysqli->query($atualizar) === TRUE) {
        header("Location: VisualizarEndereco.php?id=$id_cliente");
        exit;
    } else {
        echo $mysqli->error;
    }
}

function apagarPrincipal2($id2, $status2, $id, $status, $id_cliente){
    global $mysqli;
    $atualizar = "UPDATE enderecos_de_cobranca SET status='$status2' WHERE id='$id2'";
    if ($mysqli->query($atualizar) === TRUE) {
        atualizarStatusEndereco2($id, $status, $id_cliente);;
    } else {
        echo $mysqli->error;
    }
}

function atualizarStatusEndereco2($id, $status, $id_cliente)
{
    global $mysqli;
    $atualizar = "UPDATE enderecos_de_cobranca SET status='$status' WHERE id='$id'";
    if ($mysqli->query($atualizar) === TRUE) {
        header("Location: VisualizarEndereco.php?id=$id_cliente");
        exit;
    } else {
        echo $mysqli->error;
    }
}

function cadastrarEndereco($cep, $logradouro, $numero, $complemento, $bairro, $cidade, $UF, $id)
{
    // o Global define que a variavel $mysqli é a mesma chamada fora da função
    global $mysqli;
    $cadastrar = "INSERT INTO enderecos_de_entrega(cep,logradouro,numero_endereco,complemento,bairro,cidade,uf,cliente_id, status)
    VALUES ('$cep', '$logradouro', '$numero', '$complemento','$bairro','$cidade','$UF', '$id', 'secundario')";
    if ($mysqli->query($cadastrar) === TRUE) {
        $_SESSION['status_cadastro'] = true;
        header("Location: VisualizarEndereco.php?id=$id");
        exit;
    } else {
        echo $mysqli->error;
    }
}

function cadastrarEnderecoCobranca($cep, $logradouro, $numero, $complemento, $bairro, $cidade, $UF, $id)
{
    global $mysqli;
    $cadastrar = "INSERT INTO enderecos_de_cobranca(cep,logradouro,numero_endereco,complemento,bairro,cidade,uf,cliente_id, status)
    VALUES ('$cep', '$logradouro', '$numero', '$complemento','$bairro','$cidade','$UF', '$id', 'secundario')";
    if ($mysqli->query($cadastrar) === TRUE) {
        $_SESSION['status_cadastro'] = true;
        header("Location: VisualizarEndereco.php?id=$id");
        exit;
    } else {
        echo $mysqli->error;
    }
}
