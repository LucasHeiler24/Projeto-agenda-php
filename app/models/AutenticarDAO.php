<?php


namespace app\models;

use app\abstract\Autenticar;
use app\conexao\Conexao;
use PDO;
use Exception;

class AutenticarDAO extends Autenticar
{
    public function logar(string $email, string $senha)
    {
        try{
            $resultado = Conexao::conectar()->prepare('SELECT * FROM usuario WHERE email = ?');
            $resultado->bindValue(1, $email);
            $resultado->execute();

            if($resultado->rowCount() > 0){
                $dadosUsuario = $resultado->fetchAll(PDO::FETCH_ASSOC);
                if(password_verify($senha, $dadosUsuario[0]['senha'])){
                    session_start();
                    $_SESSION['logado'] = true;
                    $_SESSION['id_usuario'] = $dadosUsuario[0]['id'];
                    header('location: dashboard.php');
                }
                else return 0;
            }
            else return 0;
        }
        catch(Exception $e){
            return 0;
        }
    }

    public function cadastrar(string $nome, string $email, string $senha)
    {
        try {
            $resultado = Conexao::conectar()->prepare('INSERT INTO usuario (nome, email, senha) VALUES
            (?, ?, ?)');
            $resultado->bindValue(1, $nome);
            $resultado->bindValue(2, $email);
            $resultado->bindValue(3, password_hash($senha, PASSWORD_DEFAULT));
            $resultado->execute();

            if ($resultado->rowCount() > 0) {
                session_start();
                $_SESSION['cadastrado'] = true;
                header("location: login.php");
            } else {
                return 0;
            }
        } catch (Exception $e) {
            return 0;
        }
    }

    public function buscaDadosUsuario($id){
        try{
            $resultado = Conexao::conectar()->prepare('SELECT * FROM usuario WHERE id = ?');
            $resultado->bindValue(1, $id);
            $resultado->execute();

            return $resultado->fetchAll(PDO::FETCH_ASSOC);
        }
        catch(Exception $e){
            echo "Erro ao buscar o usuario {$e->getMessage()}";
        }
    }
}