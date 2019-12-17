<?php

namespace App\Services;

use App\Postagem;
use Illuminate\Support\Facades\DB;

class RemovedorDePostagem{

    public function removePostagem(int $postagem_id)
    {
        DB::transaction(function() use ($postagem_id){
            $postagem = Postagem::find($postagem_id);

            $postagem->delete();
        });
    }

}