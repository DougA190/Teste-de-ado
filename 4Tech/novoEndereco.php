<?php

include("conectar.php");
(isset($_GET['id'])) ? $id_cliente = $_GET['id'] : null;
// $sql_code = "SELECT * FROM usuarios_clientes where id = $id_cliente ";
$query_enderecos_entrega = "SELECT cep, logradouro, numero_endereco, complemento, bairro, cidade, uf, cliente_id
        FROM enderecos_de_entrega 
        WHERE cliente_id = :id_cliente
        ORDER BY id DESC";
// Prepara o comando SQL
$result_enderecos_entrega = $conn->prepare($query_enderecos_entrega);
// Informa o valor do parâmetro "id_cliente" no método bindParam()
$result_enderecos_entrega->bindParam(':id_cliente', $id_cliente);
// Executa o comando SQL
$result_enderecos_entrega->execute();

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/EditarCliente.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <title>Novo Endereco</title>
</head>

<body>
    <!-- Início do header da página-->
    <header>
            <div class="logo">
                <img src="img/Logo.png" alt="Logo da 4Tech">
            </div>
            <?php $row_endereco = $result_enderecos_entrega->fetch(PDO::FETCH_ASSOC)?>
    </header>
    <!-- Fim do header da página-->
    <section class="area-edicao">
        <!--Inicio do formulario de edicao de usuários-->
        <form id="form-edicao" action="controle_Endereco.php" method="POST">
            <h1>Novo endereco de entrega</h1>
            <div class="dados-edicao">
                <input type="hidden" name="cliente_id" class="inputs required" value="<?= $row_endereco['cliente_id'] ?>" readonly>
                <span class="span-required"></span>

                <div class="form-group row">
                    <div class="col-md-8 offset-md-2">
                        <label>CEP</label>
                        <input type="text" name="cepEntrega" id="txtCepEntrega" class="form-control  cep" 
                        placeholder="00000-000" oninput="mascaraCep()" onchange="buscaCepEntrega()" required>                        
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-md-8 offset-md-2">
                        <label>logradouro</label><br>
                        <input type="text" name="logradouro" placeholder="logradouro" class="inputs required form-control" id="txtLogradouroEntrega">
                        <span class="span-required"></span>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-md-8 offset-md-2">
                        <label>Número</label><br>
                        <input type="text" name="numero_endereco" placeholder="numero" class="inputs required form-control">
                        <span class="span-required"></span>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-md-8 offset-md-2">
                        <label>complemento</label><br>
                        <input type="text" name="complemento" id="complemento" placeholder="complemento" class="inputs required form-control">
                        <span class="span-required"></span>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-md-8 offset-md-2">
                        <label>bairro</label><br>
                        <input type="bairro" name="bairro" id="txtBairroEntrega" placeholder="bairro" class="inputs required form-control">
                        <span class="span-required"></span>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-md-8 offset-md-2">
                        <label>cidade</label><br>
                        <input type="cidade" name="cidade" id="txtCidadeEntrega" placeholder="cidade" class="inputs required form-control">
                        <span class="span-required"></span>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-md-8 offset-md-2">
                        <label>UF: </label><br>
                        <select class="form-select form-select-md mb-3 uf" name="ufEntrega" id="slcUfEntrega" aria-label=".form-select-lg example" required>
                            <option selected disabled>Selecione uma das opções</option>
                            <option value="AC">AC</option>
                            <option value="AL">AL</option>
                            <option value="AP">AP</option>
                            <option value="AM">AM</option>
                            <option value="BA">BA</option>
                            <option value="CE">CE</option>
                            <option value="DF">DF</option>
                            <option value="ES">ES</option>
                            <option value="GO">GO</option>
                            <option value="MA">MA</option>
                            <option value="MT">MT</option>
                            <option value="MS">MS</option>
                            <option value="MG">MG</option>
                            <option value="PA">PA</option>
                            <option value="PB">PB</option>
                            <option value="PR">PR</option>
                            <option value="PE">PE</option>
                            <option value="PI">PI</option>
                            <option value="RJ">RJ</option>
                            <option value="RN">RN</option>
                            <option value="RS">RS</option>
                            <option value="RO">RO</option>
                            <option value="RR">RR</option>
                            <option value="SC">SC</option>
                            <option value="SP">SP</option>
                            <option value="SE">SE</option>
                            <option value="TO">TO</option>
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <div class=" offset-md-5">
                        <a href="VisualizarEndereco.php?id=<?= $row_endereco['cliente_id'] ?>"><input type="submit" class="btn btn-primary" name="cadastrarEndereco" id="btn-edicao" value="Confirmar"></a>
                    </div>
                </div>
                <div class="form-group row">
                    <div class=" offset-md-5">
                        <a href="VisualizarEndereco.php?id=<?= $row_endereco['cliente_id'] ?>"><input type="" class="btn btn-primary" name="cancelar" id="btn-cancelar" value="Cancelar"></a>
                    </div>
                </div>
            </div>
        </form>
        <!--Fim do formulario de edição de usuários-->
    </section>
    <script src="js/cep.js"></script>

</body>

</html>