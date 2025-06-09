<?php
require '../config.php';

use app\models\RegistrosDAO;


$id_registro = $_GET['idRegistro'];

$registro = new RegistrosDAO;
echo json_encode($registro->pegarRegistrosEditar($id_registro));
