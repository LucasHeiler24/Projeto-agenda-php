<?php


namespace app\models;

use app\abstract\Autenticar;
use app\conexao\Conexao;
use Exception;

class Usuario{
    public $id, $nome;

    public function __construct(int $id, string $nome) {
        $this->id = $id;
        $this->nome = $nome;
    }

    public function getId(){
        return $this->id;
    }

    public function getNome(){
        return $this->nome;
    }
}