<?php

function validarCadastro($nome, $email, $senha){
    $erros = [];

    if(empty($nome) || empty($email) || empty($senha)){
        $erros[] = "Preencher os campos corretamente!";
    }
    else if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
        $erros[] = "Informe um e-mail válido";
    }
    else if(strlen($senha) < 6){
        $erros[] = "Informe uma senha de pelo menos 6 digitos!";
    }
    else if($nome != htmlspecialchars($nome) || $email != htmlspecialchars($email)
    || $senha != htmlspecialchars($senha)){
        $erros[] = "Não informe tags especiais!";
    }
    else{
        return 1;
    }
    return $erros;
}

function validarLogin($email, $senha){
    $erros = [];
    if(empty($email) || empty($senha)){
        $erros[] = "Preencher os campos corretamente!";
    }
    else if($email != htmlspecialchars($email) || $senha != htmlspecialchars($senha)){
        $erros[] = "Não informe tags especiais!";
    }
    else{
        return 1;
    }
    return $erros;
}

function validarRegistro($nome, $data){
    $erros = [];
    if(empty($nome) || empty($data)){
        $erros[] = "Preencher os campos corretamente!";
    }
    else if($nome != htmlspecialchars($nome)){
        $erros[] = "Não informe tags especiais!";
    }
    else{
        return 1;
    }
    return $erros;
}

function vereficarAutenticado(){
    if(!isset($_SESSION['logado']) == true) 
        header('location: index.php');
    else{

    }
}