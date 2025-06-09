<?php

namespace app\conexao;

use PDO;

class Conexao{
    private static $instancia;

    public static function conectar(){
        if(!isset(self::$instancia)){
            self::$instancia = new PDO('mysql:host=localhost;dbname=agendaphp;charset=utf8', 'root', '');
        }
        return self::$instancia;
    }

}