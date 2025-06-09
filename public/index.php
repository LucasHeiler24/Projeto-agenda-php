<a?php
require "../config.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página principal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="assets/css/index.css">
</head>

<body>
    <header class="container-fluid container-1">
        <div class="row w-100">
            <div class="col-sm coluna-1">
                <img src="assets/img/logo-php.png" class="img-fluid">
            </div>
            <div class="col-sm coluna-2">
                <a class="btn btn-primary" href="login.php">Logar-se</a>
                <a class="btn btn-danger" href="cadastro.php">Cadastrar-se</a>
            </div>
        </div>
    </header>
    <main>
        <section class="container container-2 mt-5">
            <div class="row">
                <div class="col-md p-2">
                    <img src="assets/img/agenda-logo.png" class="img-fluid rounded">
                </div>
                <div class="col pt-2">
                    <h1>Bem vindo(a) ao meu sistema</h1>
                    <p>Um projeto feito a fins educativos com HTML-5, CSS, Bootstrap, JavaScript e PHP, a fim de
                        reforçar o meu conhecimento nas tais linguagens.</p>
                    <div class="content-btns">
                        <a href="https://github.com/LucasHeiler24" target="_blank" class="btn btn-primary"><i class="bi bi-linkedin"></i>Meu Linkedin</a>
                        <a href="https://www.linkedin.com/in/lucas-heiler-656318291/" target="_blank" class="btn btn-github"><i class="bi bi-github"></i>Meu GitHub</a>
                    </div>
                </div>
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