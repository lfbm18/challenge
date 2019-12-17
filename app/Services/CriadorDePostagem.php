<?php

namespace App\Services;

use App\Postagem;
use Illuminate\Support\Facades\DB;
use phpDocumentor\Reflection\Types\Boolean;

class CriadorDePostagem
{

    public function criaPostagem(
        string $titulo,
        string $descricao,
        string $imagem,
        string $ativa
    ){
        DB::beginTransaction();
        $postagem = Postagem::create(['titulo' => $titulo, 'descricao' => $descricao, 'imagem' => $imagem, 'ativa' => $ativa]);
        DB::commit();
        return $postagem;
    }

}