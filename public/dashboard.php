<?php
session_start();

use app\models\CategoriasDAO;
use app\models\RegistrosDAO;

use app\models\AutenticarDAO;
use app\models\Usuario;

require "../config.php";
require "../app/functions/funcoes.php";
vereficarAutenticado();

$autenticado = new AutenticarDAO;
$dadosUsuario = $autenticado->buscaDadosUsuario($_SESSION['id_usuario']);
$usuario = new Usuario($dadosUsuario[0]['id'], $dadosUsuario[0]['nome']);
$categorias = new CategoriasDAO;
$dadosCategorias = $categorias->buscarCategorias();
$registro = new RegistrosDAO;

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="assets/css/dashboard.css">
</head>

<body>
    <header class="container-fluid">
        <div class="row">
            <div class="col">
                <h1><?php echo $usuario->getNome(); ?></h1>
            </div>
            <div class="col">
                <h1 id="diaAtual"></h1>
            </div>
        </div>
    </header>
    <?php
    function mostrarAlerts(int $num)
    {
        if ($num == 1) {
            echo "<div class='cadastro-registro'><div class='alert alert-success mt-2'>Registro feito com sucesso!</div></div>";
        } else if ($num == 2) {
            echo "<div class='cadastro-registro'><div class='alert alert-success mt-2'>Registro editado com sucesso!</div></div>";
        } else {
            echo "<div class='cadastro-registro'><div class='alert alert-danger mt-2'>Erro ao fazer o registro!</div></div>";
        }
    }
    if (isset($_POST['enviar_registro'])) {
        $validar = validarRegistro($_POST['nome_registro'], $_POST['data_registro']);
        $situacao = 0;
        if (isset($_POST['situacao']) == 1)
            $situacao = 1;

        if ($validar == 1) {
            $dadosRegistros = $registro->inserirRegistros(
                $_POST['nome_registro'],
                $_POST['data_registro'],
                $situacao,
                $_POST['id_usuario'],
                $_POST['id_categoria']
            );

            if ($dadosRegistros == 1)
                mostrarAlerts(1);
            else
                mostrarAlerts(0);

        } else {
            foreach ($validar as $erro) {
                echo "<div class='cadastro-registro'><div class='alert alert-danger mt-2'>$erro</div></div>";
            }
        }
    }
    ?>
    <main>
        <section class="container-fluid">
            <div class="container-btn">
                <button class="btn btn-dark" id="btnRegistro">Novo registro</button>
            </div>
            <div id="telaRegistro" class="container cadastro-registro mt-2 p-4 rounded bg-dark">
                <i id="fecharRegistro" class="bi bi-x-lg fs-3"></i>
                <div class="content-form">
                    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                        <input type="hidden" name="id_usuario" value="<?php echo $usuario->getId(); ?>">
                        <div class="mb-3">
                            <label class="form-label">Informe o nome do registro</label>
                            <input class="form-control" type="text" name="nome_registro" id="inNome"
                                placeholder="Informe o nome do registro">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Informe a data do registro</label>
                            <input class="form-control" type="date" name="data_registro" id="inData">
                        </div>
                        <div class="mb-3">
                            <div class="row content-categorias d-block m-2">
                                <?php
                                foreach ($dadosCategorias as $dados) {
                                    ?>
                                    <div class="col d-flex justify-content-between align-items-center mb-2 p-2 border">
                                        <div class="circulo-categoria"
                                            style="width: 50px; display:flex; justify-content: center; align-items: center;
                                        height: 50px; border-radius: 50%; background: <?php echo $dados['corCategoria'] ?>">
                                            <img src="assets/img/<?php echo $dados['iconeCategoria']; ?>">
                                        </div>
                                        <h3><?php echo $dados['nomeCategoria']; ?></h3>
                                        <input checked style="cursor: pointer;" type="radio" name="id_categoria"
                                            value="<?php echo $dados['id']; ?>">
                                    </div>
                                <?php } ?>
                                <h3>Já foi realizado? <input type="checkbox" name="situacao" value="1" checked></h3>
                                <input class="btn btn-primary" type="submit" name="enviar_registro" value="Registrar">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="container content-data">
                <i id="diminuirMes" class="bi bi-arrow-left-circle-fill fs-3"></i>
                <h1 id="dataEscolhida">Maio - 2025</h1>
                <i id="aumentarMes" class="bi bi-arrow-right-circle-fill fs-3"></i>
            </div>
            <div class="container-fluid content-table rounded">
                <h1>Seus registros</h1>
                <p id="possuiRegistros">Você ainda não possui registros!</p>
                <div class="table-responsive-md">
                    <table class="table text-center table-bordered table-md mt-3"
                        id="tabelaRegistros">
                        <thead>
                            <tr>
                                <th>Categoria</th>
                                <th>Nome</th>
                                <th>Data</th>
                                <th>Situação</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
            <?php
            if (isset($_POST['enviar_editado'])) {
                $validar = validarRegistro($_POST['nome_registro'], $_POST['data_registro']);
                $situacao = 0;
                if (isset($_POST['situacao']) == 1)
                    $situacao = 1;

                if ($validar == 1) {
                    $editado = $registro->editarRegistros(
                        $_POST['nome_registro'],
                        $_POST['data_registro'],
                        $situacao,
                        $_POST['id_usuario'],
                        $_POST['id_categoria'],
                        $_POST['id_registro']
                    );

                    if ($editado == 1)
                        mostrarAlerts(2);
                    else
                        mostrarAlerts(0);
                } else {
                    foreach ($validar as $erro) {
                        echo "<div class='alert alert-danger'>$erro</div>";
                    }
                }
            }
            ?>
            <div id="formEditar" class="container cadastro-editar mt-2 p-4 rounded bg-dark">
                <i id="fecharRegistro" class="bi bi-x-lg fs-3"></i>
                <div class="content-form">
                    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                        <input type="hidden" name="id_usuario" value="<?php echo $usuario->getId(); ?>">
                        <input type="hidden" name="id_registro" id="inIdEditar">
                        <div class="mb-3">
                            <label class="form-label">Informe o nome do registro</label>
                            <input class="form-control" type="text" name="nome_registro" id="inNomeEditar"
                                placeholder="Informe o nome do registro">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Informe a data do registro</label>
                            <input class="form-control" type="date" name="data_registro" id="inDataEditar">
                        </div>
                        <div class="mb-3">
                            <div class="row content-categorias d-block m-2">
                                <?php
                                foreach ($dadosCategorias as $dados) {
                                    ?>
                                    <div class="col d-flex justify-content-between align-items-center mb-2 p-2 border">
                                        <div class="circulo-categoria"
                                            style="width: 50px; display:flex; justify-content: center; align-items: center;
                                        height: 50px; border-radius: 50%; background: <?php echo $dados['corCategoria'] ?>">
                                            <img src="assets/img/<?php echo $dados['iconeCategoria']; ?>">
                                        </div>
                                        <h3><?php echo $dados['nomeCategoria']; ?></h3>
                                        <input checked style="cursor: pointer;" type="radio" name="id_categoria"
                                            value="<?php echo $dados['id']; ?>">
                                    </div>
                                <?php } ?>
                                <h3>Já foi realizado? <input type="checkbox" name="situacao" value="1" checked></h3>
                                <input class="btn btn-primary" type="submit" name="enviar_editado" value="Editar">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="container-graficos mt-3 rounded">
                <div class="content-graficos">
                    <h2>Seu gráfico!</h2>
                    <button class="btn btn-primary" id="btnGraficos">Gerar gráfico</button>
                </div>
                <div class="tela-graficos">
                    <div class="tamanho-grafico">
                        <canvas id="grafico1"></canvas>
                    </div>
                </div>
            </div>
        </section>
    </main>

</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
    crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
    crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="assets/js/dashboard.js"></script>

</html>