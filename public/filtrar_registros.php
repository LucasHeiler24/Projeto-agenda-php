<?php
session_start();
require "../config.php";

use app\models\RegistrosDAO;

$dadosFiltrados = new RegistrosDAO;
$data = $_GET['data'];

echo $dadosFiltrados->pegarRegistrosUsuario($_SESSION['id_usuario'], $data);