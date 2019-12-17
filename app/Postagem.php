<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Postagem extends Model
{
    use SoftDeletes;

    protected $fillable = ['titulo', 'descricao', 'imagem', 'ativa'];

    protected $table = 'postagem';
    protected $primaryKey = "id";
}
