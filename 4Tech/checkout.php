<?php

include("conexao.php");
(isset($_GET['id'])) ? $id_cliente = $_GET['id'] : null;
// $sql_code = "SELECT * FROM usuarios_clientes where id = $id_cliente ";
$sql_code = "SELECT * FROM clientes INNER JOIN usuarios_clientes ON clientes.id=usuarios_clientes.cliente_id WHERE clientes.id=$id_cliente;";
$sql_code2 = "SELECT * FROM enderecos_de_entrega WHERE status = 'principal' and cliente_id =$id_cliente;";
$sql_query = $mysqli->query($sql_code) or die($mysqli->error);
$sql_query2 = $mysqli->query($sql_code2) or die($mysqli->error);

$sql_code3 = "SELECT cep FROM enderecos_de_entrega WHERE status = 'principal' and cliente_id =$id_cliente;";
$cepEntrega = $mysqli->query($sql_code3) or die($mysqli->error);

?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/checkout.css">
    <link rel="stylesheet" href="css/carrinho.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.7.2/font/bootstrap-icons.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <title>4Tech</title>

</head>

<body>

    <header>
        <div class="logo">
            <img src="img/Logo.png" alt="Logo da 4Tech">
            <label><a href="VisualizarEndereco.php?id=<?= $id_cliente; ?>"
                    style="margin-right: 50px;color: white;">Editar
                    endereços</a></label>
        </div>
    </header>
    <div class="container">
        <div class="py-5 text-center">
            <h2>Finalize seu Pedido</h2>
        </div>

        <form action="pedidos.php" method="post" class="needs-validation">


            <div class="row">
                <div class="col-md-4 order-md-2 mb-4">
                    <h4 class="d-flex justify-content-between align-items-center mb-3">
                        <span class="text-muted">Seu carrinho</span>

                    </h4>
                    <div>
                        <h5>Escolha um dos valores abaixo para frete:</h5>
                        <label for="frete1">Correios</label>
                        <input type="radio" name="frete" id="frete1">
                        <label for="frete2">Sedex</label>
                        <input type="radio" name="frete" id="frete2">
                        <label for="frete3">Movvi</label>
                        <input type="radio" name="frete" id="frete3">
                    </div>
                    <table id="tbl-carrinho">
                        <thead>
                            <tr class="titulo-carrinho">
                                <th>Item</th>
                                <th>Preço</th>
                                <th>Quantidade</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                        <tfoot>
                            <th scope="row">Frete</th>
                            <td><span id="valorFrete">R$00,00</span></td>
                            </tr>
                            <tr>
                                <th scope="row">Total (BRL)</th>
                                <td><strong id="precoCompra">R$00,00</strong></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <div class="col-md-8 order-md-1 form-pedido">
                    <?php while ($cliente = $sql_query->fetch_assoc()): ?>
                        <h4 class="mb-3">Dados de cobrança</h4>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="primeiroNome">Nome</label>
                                <input type="text" class="form-control" id="primeiroNome" placeholder="Primeiro nome"
                                    value="<?= $cliente['nome'] ?>" readonly>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="sobrenome">Sobrenome</label>
                                <input type="text" class="form-control" id="sobrenome" placeholder="Sobrenome"
                                    value="<?= $cliente['sobrenome'] ?>" readonly>
                                <div class="invalid-feedback">
                                    É obrigatório inserir um sobre nome válido.
                                </div>
                            </div>
                        </div>


                        <div class="mb-3">
                            <label for="email">E-mail</label>
                            <input type="email" class="form-control" id="email" placeholder="fulano@exemplo.com"
                                value="<?= $cliente['email'] ?>" readonly>
                            <div class="invalid-feedback">
                                Por favor, insira um endereço de e-mail válido, para atualizações de entrega.
                            </div>
                        </div>
                    <?php endwhile ?>
                    <div class="enderecos-entrega">
                        <?php while ($endereço = $sql_query2->fetch_assoc()): ?>
                            <div class="endereco">
                                <div class="row">
                                    <h4>Endereço de entrega</h4>
                                    <div class="col-12 col-md-2 col-lg-2">
                                        <label>Cep: </label>
                                        <input type="text" class="form-control  cep" name="cepEntrega" id="txtCepEntrega"
                                            placeholder="00000-000" oninput="mascaraCep()" onchange="buscaCepEntrega()"
                                            required value="<?= $endereço['cep'] ?>" readonly>
                                    </div>
                                    <div class="col-12 col-md-10 col-lg-10">
                                        <label>Logradouro: </label>
                                        <input type="text" class="form-control  logradouro" name="logradouroEntrega"
                                            id="txtLogradouroEntrega" placeholder="Logradouro" required
                                            value="<?= $endereço['logradouro'] ?>" readonly>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6 col-md-2 col-lg-2">
                                        <label>Número: </label>
                                        <input type="number" class="form-control  numero" name="numeroEntrega"
                                            id="txtNumeroEntrega" placeholder="00" required
                                            value="<?= $endereço['numero_endereco'] ?>" readonly>
                                    </div>
                                    <div class="col-6 col-md-4 col-lg-4">
                                        <label>Complemento: </label>
                                        <input type="text" class="form-control  complemento" name="complementoEntrega"
                                            id="txtComplemento" placeholder="Complemento"
                                            value="<?= $endereço['complemento'] ?>" readonly>
                                    </div>
                                    <div class="col-12 col-md-6 col-lg-6">
                                        <label>Bairro: </label>
                                        <input type="text" class="form-control  bairro" name="bairroEntrega"
                                            id="txtBairroEntrega" placeholder="Bairro" required
                                            value="<?= $endereço['bairro'] ?>" readonly>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6 col-md-8 col-lg-8">
                                        <label>Cidade: </label>
                                        <input type="text" class="form-control  cidade" name="cidadeEntrega"
                                            id="txtCidadeEntrega" placeholder="Cidade" required
                                            value="<?= $endereço['cidade'] ?>" readonly>
                                    </div>
                                    <div class="col-12 col-md-4 col-lg-4">
                                        <label>UF: </label>
                                        <select class="form-select form-select-md mb-3 uf" name="ufEntrega"
                                            id="slcUfEntrega" aria-label=".form-select-lg example" required readonly>
                                            <option selected>
                                                <?= $endereço['uf'] ?>
                                            </option>

                                        </select>
                                    </div>
                                </div>
                            </div>
                        <?php endwhile ?>
                    </div>
                    <a href="NovoEndereco.php?id=<?= $id_cliente; ?>"
                        onclick="alterarEndereco(event,'NovoEndereco.php?id=<?php echo $id_cliente; ?>')"><button
                            class="btn btn-primary">Alterar
                            endereço</button></a>

                    <hr class="mb-4">

                    <h4 class="mb-3">Pagamento</h4>

                    <div class="d-block my-3">

                        <div class="custom-control custom-radio">
                            <input id="paypal" name="paymentMethod" type="radio" class="custom-control-input" checked
                                required>
                            <label class="custom-control-label" for="paypal">Boleto</label>
                        </div>
                        <div class="custom-control custom-radio">
                            <input id="cartao" name="paymentMethod" type="radio" class="custom-control-input" required>
                            <label class="custom-control-label" for="cartao">Cartão de crédito</label>
                        </div>
                    </div>
                    <div class="cartao-credito">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="cc-nome">Nome no cartão</label>
                                <input type="text" class="form-control" id="cc-nome">
                                <small class="text-muted">Nome completo, como mostrado no cartão.</small>
                                <div class="invalid-feedback">
                                    O nome que está no cartão é obrigatório.
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="cc-numero">Número do cartão de crédito</label>
                                <input type="text" class="form-control" id="cc-numero"
                                    placeholder="#### #### #### ####">
                                <div class="invalid-feedback">
                                    O número do cartão de crédito é obrigatório.
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label for="cc-expiracao">Data de expiração</label>
                                <input type="month" class="form-control" id="cc-expiracao">
                                <div class="invalid-feedback">
                                    Data de expiração é obrigatória.
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="cc-cvv">CVV</label>
                                <input type="text" class="form-control" id="cc-cvv" placeholder="####" maxlength="4">
                                <div class="invalid-feedback">
                                    Código de segurança é obrigatório.
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr class="mb-4">
                    <div class="text-center">

                        <a href="statusPedido.php"><button class="btn btn-primary btn-lg btn-block"
                                type="submit">Confirmar
                                compra</button></a>
                    </div>
        </form>
    </div>

    </div>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        crossorigin="anonymous"></script>
    <script>
        window.jQuery || document.write('<script src="../../assets/js/vendor/jquery-slim.min.js"><\/script>')
    </script>
    <script src="../../assets/js/vendor/popper.min.js"></script>
    <script src="../../dist/js/bootstrap.min.js"></script>
    <script src="../../assets/js/vendor/holder.min.js"></script>
    <script src="js/checkout.js"></script>
    <script src="js/carrinho.js"></script>
    <script src="js/cep.js"></script>
</body>

</html>