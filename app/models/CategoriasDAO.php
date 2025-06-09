<?php

namespace app\models;

use app\conexao\Conexao;
use PDO;

class CategoriasDAO{
    public function buscarCategorias(){
        $resultado = Conexao::conectar()->prepare('SELECT * FROM categorias');
        $resultado->execute();

        return $resultado->fetchAll(PDO::FETCH_ASSOC);
    }

    public function buscarCategoriasRegistro(int $id){
        $resultado = Conexao::conectar()->prepare('SELECT * FROM categorias WHERE id = ?');
        $resultado->bindValue(1, $id);
        $resultado->execute();

        return $resultado->fetchAll(PDO::FETCH_ASSOC);
    }
}