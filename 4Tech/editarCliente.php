<?php

include("conexao.php");
(isset($_GET['id'])) ? $id_cliente = $_GET['id'] : null;
// $sql_code = "SELECT * FROM usuarios_clientes where id = $id_cliente ";
$sql_code = "SELECT * FROM clientes INNER JOIN usuarios_clientes ON clientes.id=usuarios_clientes.cliente_id WHERE clientes.id=$id_cliente;";
$sql_query = $mysqli->query($sql_code) or die($mysqli->error);

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/EditarCliente.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <title>Editar cliente</title>
</head>

<body>
    <!-- Início do header da página-->
    <header>
    <?php while ($clientes = $sql_query->fetch_assoc()) : ?>
        <div class="logo">
            <img src="img/Logo.png" alt="Logo da 4Tech">
           <a href="VisualizarEndereco.php?id=<?=$id_cliente?>">Editar endereços</a>
        </div>
        
    </header>
    
    <!-- Fim do header da página-->
    <section class="area-edicao">
        <!--Inicio do formulario de edicao de usuários-->
        <form id="form-edicao" action="Controle_Cliente.php" method="POST">
            <h1>Editar perfil</h1>
                    <div class="dados-edicao">
                        <input type="hidden" name="id" class="inputs required" value="<?= $clientes['id'] ?>" readonly>
                        <span class="span-required"></span>

                        <div class="form-group row">
                            <div class="col-md-8 offset-md-2">
                                <label>Nome completo</label>
                                <input type="text" name="nome" id="nome" placeholder="Nome" class="inputs required form-control" oninput="validaNome()" value="<?= $clientes['nome'] ?>">
                                <span class="span-required">O nome precisa de no mínimo 3 caracteres</span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-8 offset-md-2">
                                <label>Sobre Nome</label><br>
                                <input type="text" name="sobrenome" placeholder="Sobrenome" class="inputs required form-control" oninput="validaSobreNome()" value="<?= $clientes['sobrenome'] ?>">
                                <span class="span-required">O nome precisa de no mínimo 3 caracteres</span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-8 offset-md-2">
                                <label>CPF</label><br>
                                <input type="text" name="cpf" placeholder="CPF" class="inputs required form-control" oninput="mascaraCPF()"  maxlength="14"  value="<?= $clientes['cpf'] ?>">
                                <span class="span-required">Digite um CPF válido</span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-8 offset-md-2">
                                <label for="inputEmail4">Email</label><br>
                                <input type="email" name="email" id="inputEmail4" placeholder="Email" class="inputs required form-control" oninput="validaEmail()" value="<?= $clientes['email'] ?>">
                                <span class="span-required">Inclua um @ no e-mail</span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-8 offset-md-2">
                                <label>Gênero</label><br>
                                <select name="genero" class="select custom-select form-control">
                                    <option selected disabled>Gênero</option>
                                    <option value="Masculino" <?php if ($clientes['genero'] == 'Masculino') echo 'selected'; ?>>Masculino</option>
                                    <option value="Feminino" <?php if ($clientes['genero'] == 'Feminino') echo 'selected'; ?>>Feminino</option>
                                    <option value="Outros" <?php if ($clientes['genero'] == 'Outros') echo 'selected'; ?>>Outros</option>
                                </select><br>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-8 offset-md-2">
                                <label>Data de nascimento</label><br>
                                <input type="date" name="dataNascimento" class="inputs form-control" value="<?= $clientes['dataNascimento'] ?>">
                                <!-- <span class="span-required">Digite uma data valida</span> -->
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-8 offset-md-2">
                                <label for="inputPassword4">Alterar Senha</label><br>
                                <input type="password" name="senha"  placeholder="Senha" class="inputs required form-control" oninput="validaSenha()">
                                <span class="span-required">A senha necessita de no minimo 8 caracteres</span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-8 offset-md-2">
                                <label for="inputPassword4">Confirmar Senha</label><br>
                                <input type="password" name="confSenha"  placeholder="Confirmar Senha" class="inputs required form-control" oninput="comparaSenha()">
                                <span class="span-required">As senhas não combinam</span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class=" offset-md-5">
                                <a href="index.php?usuarios_clientes=<?=$clientes['cliente_id']?>"><input  type="submit" class="btn btn-primary" name="editarCliente" id="btn-edicao" value="Confirmar"></a>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class=" offset-md-5">
                                <a href="index.php?usuarios_clientes=<?=$clientes['cliente_id']?>"><input  type="" class="btn btn-primary" name="cancelar" id="btn-cancelar" value="Cancelar"></a>
                            </div>
                        </div>
                    </div>
            <?php endwhile ?>
        </form>
        <!--Fim do formulario de edição de usuários-->
    </section>

     <script src="js/validacoesEditarCliente.js"></script> 
     
</body>

</html>