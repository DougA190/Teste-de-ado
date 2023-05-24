<?php

include("conectar.php");
$id_cliente = isset($_GET['id']) ? $_GET['id'] : null;

// Define o comando SQL para recuperar os endereços do cliente com o ID informado
$query_enderecos_entrega = "SELECT id, cep, logradouro, numero_endereco, complemento, bairro, cidade, uf, cliente_id, status
        FROM enderecos_de_entrega 
        WHERE cliente_id = :id_cliente
        ORDER BY id DESC";
// Prepara o comando SQL
$result_enderecos_entrega = $conn->prepare($query_enderecos_entrega);
// Informa o valor do parâmetro "id_cliente" no método bindParam()
$result_enderecos_entrega->bindParam(':id_cliente', $id_cliente);
// Executa o comando SQL
$result_enderecos_entrega->execute();

$query_enderecos_cobranca = "SELECT id, cep, logradouro, numero_endereco, complemento, bairro, cidade, uf, cliente_id, status
        FROM enderecos_de_cobranca 
        WHERE cliente_id = :id_cliente
        ORDER BY id DESC";
$result_enderecos_cobranca = $conn->prepare($query_enderecos_cobranca);
$result_enderecos_cobranca->bindParam(':id_cliente', $id_cliente);
$result_enderecos_cobranca->execute();

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/visualizarEndereco.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <title>Perfil cliente</title>
</head>

<body>
    <!-- Início do header da página-->
    <header>

        <div class="logo">
            <img src="img/Logo.png" alt="Logo da 4Tech">
            <a href="Perfil.php?id=<?= $id_cliente ?>">Voltar</a>

        </div>
    </header>

    <div class="container-fluid">
        <div class="row">

            <!-- Coluna para a lista de endereços de entrega -->
            <div class="col-md-6 box linha-vertical">
                <div class="area-visualizar">
                    <form id="form-visualizar" action="Controle_Cliente.php" method="POST">
                        <h1>Endereços de Entrega</h1>
                        <a href="novoEndereco.php?id=<?= $id_cliente ?>" class="btn btn-primary">Novo Endereço</a><hr/>
                        <?php
                        // verifica se existe algum endereço com status "principal"
                        $has_principal = false;
                        while ($row_endereco = $result_enderecos_entrega->fetch(PDO::FETCH_ASSOC)) {
                            if ($row_endereco['status'] === 'principal') {
                                $has_principal = true;
                                // exibe o endereço principal em primeiro
                        ?>
                                <div class="dados-visualizar col-md-6">
                                    <!-- código para exibir o endereço principal -->
                                    <input type="hidden" name="id" class="inputs required" value="<?= $row_endereco['cliente_id'] ?>" readonly>
                                    <div class="form-group row">
                                        <div class="col-md-8 offset-md-2">
                                            <label><strong>Endereço Principal</strong></label><br>
                                            <label>CEP: <?= $row_endereco['cep'] ?></label><br>
                                            <label>logradouro: <?= $row_endereco['logradouro'] ?></label><br>
                                            <label>Número: <?= $row_endereco['numero_endereco'] ?></label><br>
                                            <label>complemento: <?= $row_endereco['complemento'] ?></label><br>
                                            <label>bairro: <?= $row_endereco['bairro'] ?></label><br>
                                            <label>cidade: <?= $row_endereco['cidade'] ?></label><br>
                                            <label>uf: <?= $row_endereco['uf'] ?></label><br>
                                        </div>
                                        <hr/>
                                    </div>
                                </div>
                                <?php
                            }
                        }

                        // se não houver endereço principal, exibe todos os endereços
                        if ($has_principal == true) {
                            $result_enderecos_entrega->execute();
                            while ($row_endereco = $result_enderecos_entrega->fetch(PDO::FETCH_ASSOC)) {
                                if ($row_endereco['status'] == 'secundario') {
                                    // exibe os endereços secundários
                                ?>
                                    <div class="dados-visualizar col-md-6">
                                        <!-- código para exibir os endereços secundários -->
                                        <input type="hidden" name="id" class="inputs required" value="<?= $row_endereco['cliente_id'] ?>" readonly>
                                        <div class="form-group row">
                                            <div class="col-md-8 offset-md-2">
                                                <label>CEP: <?= $row_endereco['cep'] ?></label><br>
                                                <label>logradouro: <?= $row_endereco['logradouro'] ?></label><br>
                                                <label>Número: <?= $row_endereco['numero_endereco'] ?></label><br>
                                                <label>complemento: <?= $row_endereco['complemento'] ?></label><br>
                                                <label>bairro: <?= $row_endereco['bairro'] ?></label><br>
                                                <label>cidade: <?= $row_endereco['cidade'] ?></label><br>
                                                <label>uf: <?= $row_endereco['uf'] ?></label><br>
                                            </div>
                                                <?php if ($row_endereco['status'] === 'secundario') : ?>
                                                    <div class="col-md-8 offset-md-2">
                                                        <form method="POST" action="controle_Endereco.php">
                                                            <input type="hidden" name="idEndereco" value="<?= $row_endereco['id'] ?>">
                                                            <input type="hidden" name="status" value="principal">
                                                            <input type="hidden" name="status2" value="inativo">
                                                            <input type="hidden" name="idCliente" value="<?= $row_endereco['cliente_id'] ?>">
                                                            <button type="submit" class="btn btn-primary offset-md-1" name="tornarPrincipalE">Tornar principal</button>
                                                            <button type="submit" class="btn btn-primary offset-md-1" name="excluirE">Excluir</button>
                                                        </form>
                                                    </div>
                                                    <hr/>
                                                <?php endif; ?>
                                        </div>
                                    </div>
                                <?php
                                }
                            }
                        }

                        if ($has_principal == true) {
                            $result_enderecos_entrega->execute();
                            while ($row_endereco = $result_enderecos_entrega->fetch(PDO::FETCH_ASSOC)) {
                                if ($row_endereco['status'] == 'inativo') {
                                    // exibe os endereços secundários
                                ?>
                                    <div class="dados-visualizar col-md-6">
                                        <!-- código para exibir os endereços secundários -->
                                        <input type="hidden" name="id" class="inputs required" value="<?= $row_endereco['cliente_id'] ?>" readonly>
                                        <div class="form-group row">
                                            <div class="col-md-8 offset-md-2">
                                                <label><strong>Endereço Inativo</strong></label><br>
                                                <label class="cinza">CEP: <?= $row_endereco['cep'] ?></label><br>
                                                <label class="cinza">logradouro: <?= $row_endereco['logradouro'] ?></label><br>
                                                <label class="cinza">Número: <?= $row_endereco['numero_endereco'] ?></label><br>
                                                <label class="cinza">complemento: <?= $row_endereco['complemento'] ?></label><br>
                                                <label class="cinza">bairro: <?= $row_endereco['bairro'] ?></label><br>
                                                <label class="cinza">cidade: <?= $row_endereco['cidade'] ?></label><br>
                                                <label class="cinza">uf: <?= $row_endereco['uf'] ?></label><br>
                                            </div>
                                            <?php if ($row_endereco['status'] === 'inativo') : ?>
                                                    <div class="col-md-8 offset-md-1">
                                                        <form method="POST" action="controle_Endereco.php">
                                                            <input type="hidden" name="idEndereco" value="<?= $row_endereco['id'] ?>">
                                                            <input type="hidden" name="status" value="secundario">
                                                            <input type="hidden" name="idCliente" value="<?= $row_endereco['cliente_id'] ?>">
                                                            <button type="submit" class="btn btn-primary offset-md-1" name="ativarEntrega">Ativar endereço</button>
                                                        </form>
                                                    </div>
                                                <?php endif; ?>
                                            <hr/>
                                        </div>
                                    </div>
                        <?php
                                }
                            }
                        }
                        ?>
                    </form>
                </div>
            </div>


            <!-- Coluna para listar enderecço de cobrança -->
            <div class="col-md-6 box linha-vertical">
                <div class="area-visualizar">
                    <form id="form-visualizar" action="Controle_Cliente.php" method="POST">
                        <h1>Endereço de cobrança</h1>
                        <a href="novoCobrancaEndereco.php?id=<?= $id_cliente ?>" class="btn btn-primary">Novo Endereço</a><hr/>
                        <?php
                        // verifica se existe algum endereço com status "principal"
                        $has_principal = false;
                        while ($row_endereco = $result_enderecos_cobranca->fetch(PDO::FETCH_ASSOC)) {
                            if ($row_endereco['status'] === 'principal') {
                                $has_principal = true;
                                // exibe o endereço principal em primeiro
                        ?>
                                <div class="dados-visualizar col-md-6">
                                    <input type="hidden" name="id" class="inputs required" value="<?= $clientes['id'] ?>" readonly>
                                    <div class="form-group row">
                                        <div class="col-md-8 offset-md-2">
                                            <label><strong>Endereço Principal</strong></label><br>
                                            <label>CEP: <?= $row_endereco['cep'] ?></label><br>
                                            <label>logradouro: <?= $row_endereco['logradouro'] ?></label><br>
                                            <label>Número: <?= $row_endereco['numero_endereco'] ?></label><br>
                                            <label>complemento: <?= $row_endereco['complemento'] ?></label><br>
                                            <label>bairro: <?= $row_endereco['bairro'] ?></label><br>
                                            <label>cidade: <?= $row_endereco['cidade'] ?></label><br>
                                            <label>uf: <?= $row_endereco['uf'] ?></label><br>                                            
                                        </div>
                                        <hr/>
                                    </div>
                                </div>
                                <?php
                            }
                        }

                        // se não houver endereço principal, exibe todos os endereços
                        if ($has_principal == true) {
                            $result_enderecos_cobranca->execute();
                            while ($row_endereco = $result_enderecos_cobranca->fetch(PDO::FETCH_ASSOC)) {
                                if ($row_endereco['status'] == 'secundario') {
                                    // exibe os endereços secundários
                                ?>
                                    <div class="dados-visualizar col-md-6">
                                        <input type="hidden" name="id" class="inputs required" value="<?= $clientes['id'] ?>" readonly>
                                        <div class="form-group row">
                                            <div class="col-md-8 offset-md-2">
                                                <label>CEP: <?= $row_endereco['cep'] ?></label><br>
                                                <label>logradouro: <?= $row_endereco['logradouro'] ?></label><br>
                                                <label>Número: <?= $row_endereco['numero_endereco'] ?></label><br>
                                                <label>complemento: <?= $row_endereco['complemento'] ?></label><br>
                                                <label>bairro: <?= $row_endereco['bairro'] ?></label><br>
                                                <label>cidade: <?= $row_endereco['cidade'] ?></label><br>
                                                <label>uf: <?= $row_endereco['uf'] ?></label><br>
                                            </div>
                                                <?php if ($row_endereco['status'] === 'secundario') : ?>
                                                    <div class=" col-md-8 offset-md-1">
                                                        <form method="POST" action="controle_Endereco.php">
                                                            <input type="hidden" name="idEndereco" value="<?= $row_endereco['id'] ?>">
                                                            <input type="hidden" name="status" value="principal">
                                                            <input type="hidden" name="status2" value="inativo">
                                                            <input type="hidden" name="idCliente" value="<?= $row_endereco['cliente_id'] ?>">
                                                            <button type="submit" class="btn btn-primary offset-md-1" name="tornarPrincipalC">Tornar principal</button>
                                                            <button type="submit" class="btn btn-primary offset-md-1" name="excluirC">Excluir</button>
                                                        </form>
                                                    </div>
                                                <?php endif; ?>
                                            <hr/>
                                        </div>
                                    </div>
                        <?php
                                }
                            }
                        }
                        
                        if ($has_principal == true) {
                            $result_enderecos_cobranca->execute();
                            while ($row_endereco = $result_enderecos_cobranca->fetch(PDO::FETCH_ASSOC)) {
                                if ($row_endereco['status'] == 'inativo') {
                                    // exibe os endereços secundários
                                ?>
                                    <div class="dados-visualizar col-md-6"">
                                        <!-- código para exibir os endereços secundários -->
                                        <input type="hidden" name="id" class="inputs required" value="<?= $row_endereco['cliente_id'] ?>" readonly>
                                        <div class="form-group row">
                                            <div class="col-md-8 offset-md-2">
                                                <label><strong>Endereço Inativo</strong></label><br>
                                                <label class="cinza">CEP: <?= $row_endereco['cep'] ?></label><br>
                                                <label class="cinza">logradouro: <?= $row_endereco['logradouro'] ?></label><br>
                                                <label class="cinza">Número: <?= $row_endereco['numero_endereco'] ?></label><br>
                                                <label class="cinza">complemento: <?= $row_endereco['complemento'] ?></label><br>
                                                <label class="cinza">bairro: <?= $row_endereco['bairro'] ?></label><br>
                                                <label class="cinza">cidade: <?= $row_endereco['cidade'] ?></label><br>
                                                <label class="cinza">uf: <?= $row_endereco['uf'] ?></label><br>
                                            </div>
                                            <?php if ($row_endereco['status'] === 'inativo') : ?>
                                                    <div class="col-md-8 offset-md-1">
                                                        <form method="POST" action="controle_Endereco.php">
                                                            <input type="hidden" name="idEndereco" value="<?= $row_endereco['id'] ?>">
                                                            <input type="hidden" name="status" value="secundario">
                                                            <input type="hidden" name="idCliente" value="<?= $row_endereco['cliente_id'] ?>">
                                                            <button type="submit" class="btn btn-primary offset-md-1" name="ativarCobranca">Ativar endereço</button>
                                                        </form>
                                                    </div>
                                                <?php endif; ?>
                                            <hr/>
                                        </div>
                                    </div>
                        <?php
                                }
                            }
                        }
                        ?>
                    </form>
                </div>
            </div>
        </div>




</body>

</html>