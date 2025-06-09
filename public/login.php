<?php
session_start();
use app\models\AutenticarDAO;

require "../config.php";
require "../app/functions/funcoes.php";

if(isset($_SESSION['cadastrado']) == true) echo "<div class='alert alert-success'>Cadastrado com sucesso</div>";

if(isset($_POST['logar'])){
    $validarLogin = validarLogin($_POST['email'], $_POST['senha']);

    if($validarLogin == 1){
        $login = new AutenticarDAO;
        $situacaoLogin = $login->logar($_POST['email'], $_POST['senha']);

        if($situacaoLogin == 0) echo "<div class='alert alert-danger'>Credênciais inválidas</div>";
    }
    else{
        foreach($validarLogin as $erros) echo "<div class='alert alert-danger'>$erros</div>";
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tela de login</title>
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/css/login.css">
</head>

<body>

    <main>
        <section class="container">
            <div class="content-form p-4">
                <h1>Tela de login</h1>
                <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                    <div class="mb-3">
                        <label class="form-label">Informe seu e-mail</label>
                        <input class="form-control" type="email" name="email" placeholder="Informe seu e-mail:">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Informe sua senha</label>
                        <input class="form-control" type="password" name="senha" placeholder="Informe uma senha:">
                    </div>
                    <input type="submit" value="Logar" name="logar" class="btn btn-primary">
                </form>
            </div>
        </section>
    </main>

</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
    crossorigin="anonymous"></script>

</html>