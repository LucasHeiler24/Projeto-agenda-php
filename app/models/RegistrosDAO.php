<?php

namespace app\models;

use app\abstract\Registros;
use app\conexao\Conexao;
use Exception;
use PDO;


class RegistrosDAO extends Registros
{

    public function inserirRegistros(
        string $nomeRegistro,
        string $dataRegistro,
        int $situacao,
        int $id_usuario,
        int $id_categoria
    ) {
        try {
            $resultado = Conexao::conectar()->prepare('INSERT INTO registro (nomeRegistro, dataRegistro,
            situacao, usuario_id, categorias_id) VALUES (?, ?, ?, ?, ?)');
            $resultado->bindValue(1, $nomeRegistro);
            $resultado->bindValue(2, $dataRegistro);
            $resultado->bindValue(3, $situacao);
            $resultado->bindValue(4, $id_usuario);
            $resultado->bindValue(5, $id_categoria);
            $resultado->execute();

            if ($resultado->rowCount() > 0)
                return 1;
            else
                return 0;
        } catch (Exception $e) {
            return 0;
        }
    }

    public function editarRegistros(
        string $nomeRegistro,
        string $dataRegistro,
        int $situacao,
        int $id_usuario,
        int $id_categoria,
        int $id_registro
    ) {
        try {
            $resultado = Conexao::conectar()->prepare('UPDATE registro SET nomeRegistro = ?, dataRegistro = ?,
            situacao = ?, usuario_id = ?, categorias_id = ? WHERE id = ?');
            $resultado->bindValue(1, $nomeRegistro);
            $resultado->bindValue(2, $dataRegistro);
            $resultado->bindValue(3, $situacao);
            $resultado->bindValue(4, $id_usuario);
            $resultado->bindValue(5, $id_categoria);
            $resultado->bindValue(6, $id_registro);
            $resultado->execute();

            if ($resultado->rowCount() > 0)
                return 1;
            else
                return 0;
        } catch (Exception $e) {
            return 0;
        }
    }

    public function pegarRegistrosEditar(int $id)
    {
        try {
            $resultado = Conexao::conectar()->prepare('SELECT * FROM registro WHERE id = ?');
            $resultado->bindValue(1, $id);
            $resultado->execute();

            return $resultado->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return 0;
        }
    }

    public function excluirRegistro(int $id)
    {
        try {
            $resultado = Conexao::conectar()->prepare('DELETE FROM registro WHERE id = ?');
            $resultado->bindValue(1, $id);
            $resultado->execute();

            if ($resultado->rowCount() > 0)
                header("location: dashboard.php");
            else
                return 0;
        } catch (Exception $e) {
            return 0;
        }
    }

    public function pegarRegistrosUsuario(int $id, string $data)
    {
        try {
            $resultado = Conexao::conectar()->prepare("SELECT * FROM registro WHERE 
            dataRegistro LIKE :dataFiltrada AND usuario_id = :id");

            $resultado->bindValue(':dataFiltrada', "%$data%", PDO::PARAM_STR);
            $resultado->bindValue(':id', $id, PDO::PARAM_INT);
            $resultado->execute();

            if ($resultado->rowCount() > 0) {
                $dadosRegistros = $resultado->fetchAll(PDO::FETCH_ASSOC);
                file_put_contents('../json/dados_registros.json', json_encode($dadosRegistros, JSON_UNESCAPED_UNICODE));
                return json_encode($dadosRegistros);
            } else
                return 0;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}