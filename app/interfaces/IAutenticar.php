<?php

namespace app\interfaces;


interface IAutenticar{
    public function logar(string $email, string $senha);
    
    public function cadastrar(string $nome, string $email, string $senha);
}