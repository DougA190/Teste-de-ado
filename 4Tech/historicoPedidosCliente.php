<?php

include("conectar.php");
$id_cliente = isset($_GET['id']) ? $_GET['id'] : null;

// Define o comando SQL para recuperar os endereços do cliente com o ID informado
$query_pedidos = "SELECT id, cep, logradouro, numero_endereco, complemento, bairro, cidade, uf, cliente_id, status
        FROM enderecos_de_entrega 
        WHERE cliente_id = :id_cliente
        ORDER BY id DESC";
// Prepara o comando SQL
$result_pedidos = $conn->prepare($query_pedidos);
// Informa o valor do parâmetro "id_cliente" no método bindParam()
$result_pedidos->bindParam(':id_cliente', $id_cliente);
// Executa o comando SQL
$result_pedidos->execute();


?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/visualizarEndereco.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <title>Histórico de pedidos</title>
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

            <!-- Coluna para a lista de pedidos -->
            <div class="col-md-6 box linha-vertical">
                <div class="area-visualizar">
                    <form id="form-visualizar" action="Controle_Cliente.php" method="POST">
                        <h1>Pedidos feitos</h1>
                        <hr />
                        <?php

                        // exibe os pedidos em andamento
                            $result_pedidos->execute();
                            while ($row_pedido = $result_pedidos->fetch(PDO::FETCH_ASSOC)) {
                                if ($row_pedido['status'] == 'em andamento') {
                                ?>
                                    <div class="dados-visualizar col-md-6">
                                        <!-- código para exibir os pedidos em andamento -->
                                        <input type="hidden" name="id" class="inputs required" value="<?= $row_pedido['cliente_id'] ?>" readonly>
                                        <div class="form-group row">
                                            <div class="col-md-8 offset-md-2">
                                                <label><strong>Pedidos em andamento</strong></label><br>
                                                <label>Número do pedido: <?= $row_pedido['id'] ?></label><br>
                                                <label>Data de pedido: <?= $row_pedido['data_pedido'] ?></label><br>
                                                <label>Valor total: <?= $row_pedido['total'] ?></label><br>
                                                <label>Status: <?= $row_pedido['status'] ?></label><br>
                                            </div>
                                            <?php if ($row_pedido['status'] === 'em andamento') : ?>
                                                <div class="col-md-8 offset-md-1">
                                                    <form method="POST" action="controle_Endereco.php">
                                                        <input type="hidden" name="idEndereco" value="<?= $row_pedido['id'] ?>">
                                                        <input type="hidden" name="status" value="cancelado">
                                                        <input type="hidden" name="idCliente" value="<?= $row_pedido['cliente_id'] ?>">
                                                        <button type="submit" class="btn btn-primary offset-md-1" name="cancelar">Cancelar</button>
                                                    </form>
                                                </div>
                                            <?php endif; ?>
                            
                                        </div>
                                    </div>
                                <?php
                                }
                            }
                        
                            // exibe os pedidos aguardando pagamento
                            $result_pedidos->execute();
                            while ($row_pedido = $result_pedidos->fetch(PDO::FETCH_ASSOC)) {
                                if ($row_pedido['status'] == 'aguardando pagamento') {
                                ?>
                                    <div class="dados-visualizar col-md-6">
                                        <!-- código para exibir os aguardando pagamento -->
                                        <input type="hidden" name="id" class="inputs required" value="<?= $row_pedido['cliente_id'] ?>" readonly>
                                        <div class="form-group row">
                                            <div class="col-md-8 offset-md-2">
                                                <label><strong>Pedidos aguardando pagamento</strong></label><br>
                                                <label>Número do pedido: <?= $row_pedido['id'] ?></label><br>
                                                <label>Data de pedido: <?= $row_pedido['data_pedido'] ?></label><br>
                                                <label>Valor total: <?= $row_pedido['total'] ?></label><br>
                                                <label>Status: <?= $row_pedido['status'] ?></label><br>
                                            </div>
                                            <?php if ($row_pedido['status'] === 'aguardando pagamento') : ?>
                                                <div class="col-md-8 offset-md-2">
                                                    <form method="POST" action="controle_Endereco.php">
                                                        <input type="hidden" name="idEndereco" value="<?= $row_pedido['id'] ?>">
                                                        <input type="hidden" name="status" value="cancelado">
                                                        <input type="hidden" name="idCliente" value="<?= $row_pedido['cliente_id'] ?>">
                                                        <button type="submit" class="btn btn-primary offset-md-1" name="cancelar">Cancelar</button>
                                                    </form>
                                                </div>
                                                <hr />
                                            <?php endif; ?>
                                            <hr />
                                        </div>
                                    </div>
                        <?php
                                }
                            }
                        
                            // exibe os pedidos concluidos
                            $result_pedidos->execute();
                            while ($row_pedido = $result_pedidos->fetch(PDO::FETCH_ASSOC)) {
                                if ($row_pedido['status'] == 'concluido') {
                                ?>
                                    <div class="dados-visualizar col-md-6">
                                        <!-- código para exibir os pedidos concluidos -->
                                        <input type="hidden" name="id" class="inputs required" value="<?= $row_pedido['cliente_id'] ?>" readonly>
                                        <div class="form-group row">
                                            <div class="col-md-8 offset-md-2">
                                                <label><strong>Pedidos concluídos</strong></label><br>
                                                <label>Número do pedido: <?= $row_pedido['id'] ?></label><br>
                                                <label>Data de pedido: <?= $row_pedido['data_pedido'] ?></label><br>
                                                <label>Valor total: <?= $row_pedido['total'] ?></label><br>
                                                <label>Status: <?= $row_pedido['status'] ?></label><br>
                                            </div>                                        
                                            <hr />
                                        </div>
                                    </div>
                        <?php
                                }
                            }
                        
                            // exibe os pedidos cancelados
                            $result_pedidos->execute();
                            while ($row_pedido = $result_pedidos->fetch(PDO::FETCH_ASSOC)) {
                                if ($row_pedido['status'] == 'cancelado') {
                                ?>
                                    <div class="dados-visualizar col-md-6">
                                        <!-- código para exibir os pedidos cancelados -->
                                        <input type="hidden" name="id" class="inputs required" value="<?= $row_pedido['cliente_id'] ?>" readonly>
                                        <div class="form-group row">
                                            <div class="col-md-8 offset-md-2">
                                                <label><strong>Pedidos cancelados</strong></label><br>
                                                <label>Número do pedido: <?= $row_pedido['id'] ?></label><br>
                                                <label>Data de pedido: <?= $row_pedido['data_pedido'] ?></label><br>
                                                <label>Valor total: <?= $row_pedido['total'] ?></label><br>
                                                <label>Status: <?= $row_pedido['status'] ?></label><br>
                                            </div>
                                            <hr />
                                        </div>
                                    </div>
                        <?php
                                }
                            }
                        ?>
                    </form>
                </div>
            </div>

        </div>




</body>

</html>