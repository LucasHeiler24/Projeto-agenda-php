<?php
session_start();
use app\models\AutenticarDAO;

require "../config.php";
require "../app/functions/funcoes.php";

if(isset($_POST['cadastrar'])){
    $retorno = validarCadastro($_POST['nome'], $_POST['email'], $_POST['senha']);

    if($retorno == 1){
        $usuarioCadastrar = new AutenticarDAO;
        $situacaoCadastrar = $usuarioCadastrar->cadastrar($_POST['nome'], $_POST['email'], $_POST['senha']);
        
        if($situacaoCadastrar == 0) echo "<div class='alert alert-danger'>Erro ao cadastrar</div>";
    }
    else{
        foreach($retorno as $erros) echo "<div class='alert alert-danger'>$erros</div>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/css/cadastro.css">
</head>

<body>

    <main>
        <section class="container">
            <div class="content-form p-4">
                <h1>Tela de Cadastro</h1>
                <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                    <div class="mb-3">
                        <label class="form-label">Informe seu nome completo</label>
                        <input class="form-control" type="text" name="nome" placeholder="Informe seu nome completo:">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Informe seu e-mail</label>
                        <input class="form-control" type="email" name="email" placeholder="Informe seu e-mail:">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Informe uma senha de cadastro</label>
                        <input class="form-control" type="password" name="senha" placeholder="Informe uma senha:">
                        <div class="form-text">
                            <p>Insira uma senha de no mínimo 6 digitos!</p>
                        </div>
                    </div>
                    <input type="submit" value="Cadastrar" name="cadastrar" class="btn btn-primary">
                </form>
            </div>
        </section>
    </main>

</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
    crossorigin="anonymous"></script>
<script
  src="https://code.jquery.com/jquery-3.7.1.js"
  integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
  crossorigin="anonymous"></script>
</html>