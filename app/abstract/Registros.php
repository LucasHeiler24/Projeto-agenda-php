<?php

namespace app\abstract;

abstract class Registros{

    abstract public function inserirRegistros(string $nomeRegistro, string $dataRegistro,
    int $situacao, int $id_usuario, int $id_categoria);

    abstract public function editarRegistros(string $nomeRegistro, string $dataRegistro,
    int $situacao, int $id_usuario, int $id_categoria, int $id_registro);

}

