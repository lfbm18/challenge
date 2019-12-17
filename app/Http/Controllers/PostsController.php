<?php

namespace App\Http\Controllers;

use App\Postagem;
use App\Services\CriadorDePostagem;
use App\Services\RemovedorDePostagem;
use Illuminate\Http\Request;

class PostsController extends Controller
{

    public function __construct(){
        $this->middleware('auth');
    }

    public function novo(){
        return view('novo');
    }

    public function cria_post(Request $request, CriadorDePostagem $criadorDePostagem){

        $titulo = $request->titulo;
        $descricao = $request->descricao;
        $ativa = $request->publicar;

        if ($ativa == "false"){
            $ativa = "N";
        }else{
            $ativa = "S";
        }

        if ($descricao == null){
            $descricao = "";
        }

        if ($request->hasFile('imagem')){
            $imagem = $request->file("imagem");
            $extensao_imagem = $imagem->getClientOriginalExtension();
            $nome_imagem = time() . "." . $extensao_imagem;
            $imagem->move("images", $nome_imagem);
            $caminho_imagem = "images/$nome_imagem";
        }else{
            $caminho_imagem = "";
        }
        $postagem = $criadorDePostagem->criaPostagem($titulo, $descricao, $caminho_imagem, $ativa);
    }

    public function ativa_post(Request $request){
        $postagem = Postagem::find($request->id);

        $postagem->ativa = $request->ativa;
        $postagem->save();
    }

    public function destroy(Request $request, RemovedorDePostagem $removedorDePostagem){
        $removedorDePostagem->removePostagem($request->id);
    }

    public function edita_titulo(Request $request){
        $postagem = Postagem::find($request->id);
        $titulo = $request->titulo;

        if ($titulo == null){
            $titulo = "";
        }

        $postagem->titulo = $titulo;
        $postagem->save();
    }

    public function edita_descricao(Request $request){
        $postagem = Postagem::find($request->id);
        $descricao = $request->descricao;
        if($descricao == null){
            $descricao = "";
        }

        $postagem->descricao = $descricao;
        $postagem->save();
    }

    public function edita_imagem(Request $request)
    {
        $postagem = Postagem::find($request->id);

        $imagem = $request->file("imagem");
        $extensao_imagem = $imagem->getClientOriginalExtension();
        $nome_imagem = time().$extensao_imagem;
        $imagem->move("images", $nome_imagem);
        $caminho_imagem = "images/$nome_imagem";

        $postagem->imagem = $caminho_imagem;
        $postagem->save();
    }

}
