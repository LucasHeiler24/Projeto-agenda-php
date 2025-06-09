<?php


namespace app\abstract;

use app\interfaces\IAutenticar;


abstract class Autenticar implements IAutenticar{
    abstract public function logar(string $email, string $senha);
    
    abstract public function cadastrar(string $nome, string $email, string $senha);
}