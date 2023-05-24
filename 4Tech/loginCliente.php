<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/TeladeLoginCliente.css">
    <title>Login Cliente</title>
</head>
<body>

    <header>
        <div class="logo">

        <a href="index.php"><img src="img/Logo.png" alt="Logo da 4Tech"></a> 
        </div>
    </header>

    <section class="area-login">
        <!--Inicio do formulario de login-->
        <form id="form-login" action="verificaCliente.php" method="POST">
            <h1>Faça seu Login</h1>
            <?php
            if(isset($_GET['error'])){ ?>

            <p class="error"><?php echo $_GET['error']; ?></p>

           <?php }?>
            <div class="dados-login">
                <input type="text" name="email" id="email" placeholder="E-mail" class="inputs required">
                <input type="password" name="senha" id="senha" placeholder="Senha" class="inputs required">
            </div>
           <input class="inputSubmit" type="submit" name="submit" value="Entrar">           
    <div class="esquece">
        <a href="cadastroCliente.html">Já sou cadastrado</a>
        <a href="">Esqueceu a senha?</a>
    </div>
        </form> 
    </section>
</body>
</html>
