<?php

use app\models\RegistrosDAO;

require '../config.php';

$id_registro = $_GET['id'];

$registro = new RegistrosDAO;
$excluir = $registro->excluirRegistro($id_registro);