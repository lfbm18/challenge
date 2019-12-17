@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-14">
            <div class="card">
            <div class="card-header" align="center" style="background-color: darkkhaki"><h1>{{ $postagem->titulo }}</h1></div>
        
            <div class="card-body" align="center" style="width: 100%; background-color:darkgreen">
                <div class="card" align="center" style="width: 90%;" >
                    <div class="card-body" style="background-color: darkslategrey">
                        <li class="list-group-item align-items-center" style="background-color:lightgray">
                            <p style="font-size: 20px; text-justify: auto">{{ $postagem->descricao }}</p>
                            @if ($postagem->imagem != "")
                                <img class="imagem_post" style="border-width: 5px; border-style: solid; border-color: black" src="{{ URL::to("/") . "/" . $postagem->imagem }}" alt="">    
                            @endif
                        </li>
                        <br>
                </div>
            </div>
                
            </div>
        </div>
    </div>
</div>
@endsection
