<?php

namespace App\Http\Controllers;

use App\Postagem;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    public function __construct(){
        
    }

    public function index(){
        
        $array['postagens'] = Postagem::where('ativa', '=', 'S')->get();
        
        return view('public', $array);
    }

    public function postagem(Request $request){
        $postagem = Postagem::find($request->id);
        return view('public_post', compact('postagem'));
    }
}