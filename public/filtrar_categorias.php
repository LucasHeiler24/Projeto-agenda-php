<?php

use app\models\CategoriasDAO;

require '../config.php';

$id_categoria = $_GET['idCategoria'];

$categoria = new CategoriasDAO;
echo json_encode($categoria->buscarCategoriasRegistro($id_categoria));

