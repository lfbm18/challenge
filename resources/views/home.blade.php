@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-14">
            <div class="card">
                
                <div class="card-header" align="center" style="background-color: darkkhaki">
                    <h1>ADMIN</h1>
                    <br>
                    <button type="button" class="btn btn-dark" onclick="window.location='{{ URL::to('posts/novo') }}'">
                        NOVO POST
                    </button>
                </div>
                    <div class="card-body" align="center" style="width: 100%; background-color:darkgreen">
                        <div class="card" align="center" style="width: 90%;" >
                            <div class="card-body" style="background-color: darkslategrey">
                                @foreach ($postagens as $postagem)
                                    <div>
                                        <li class="list-group-item align-items-center" style="background-color:lightgray">

                                            <span class="d-flex justify-content-between row">
                                                <div class="col-3"></div>    
                                                <h1><b id="titulo_{{ $postagem->id }}"> {{ $postagem->titulo }}</b></h1>
                                                <div class="col-3">
                                                    
                                                    <button type="button" class="btn btn-light mr-2 btn-sm" id="botao_ativo_{{ $postagem->id }}" onclick="ativaPost({{ $postagem->id }})">
                                                            @if ($postagem->ativa == "S")
                                                                <i class="fa fa-eye" aria-hidden="true"></i>
                                                            @else
                                                                <i class="fa fa-eye-slash" aria-hidden="true"></i>
                                                            @endif
                                                    </button>
                                                        <button class="btn btn-primary dropdown-toggle btn-sm mr-2" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            <i class="fas fa-pencil-alt"></i>
                                                        </button>
                                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                            <a class="dropdown-item" href="#" onclick="editaTitulo({{ $postagem->id }})">Título</a>
                                                            <a class="dropdown-item" href="#" onclick="editaDescricao({{ $postagem->id }})">Descrição</a>
                                                            <a class="dropdown-item" href="#" onclick="mostraEditaImagem({{ $postagem->id }})">Imagem</a>
                                                        </div>                                                    
                                                    <button type="button" class="btn btn-danger mr-2 btn-sm" id="botao_remove_{{ $postagem->id }}" onclick="removePost({{ $postagem->id }})">
                                                            <i class="far fa-trash-alt"></i>
                                                    </button>

                                                </div>
                                            </span>
                                            <div>
                                                <p style="font-size: 20px; text-justify: auto" id="descricao_{{ $postagem->id }}">{{ $postagem->descricao }}</p>
                                            </div>
                                            <div id="div_edita_imagem_{{ $postagem->id }}" style="display: none;" class="mb-3">
                                                <input hidden type="file" class="mb-3 mr-4" id="edita_imagem_{{ $postagem->id }}" onchange="editaImagem(event, {{$postagem->id}})">
                                                <button id="btn_edita_imagem_{{ $postagem->id }}" disabled type="button" class="btn btn-warning btn-sm" onclick="salvaImagem({{$postagem->id}})">
                                                    <b>Trocar imagem</b>
                                                </button>
                                                <img class="spinner" src="{{ URL::to("/") . "/images/" . "spinner.gif" }}" id="spinner_{{$postagem->id}}" style="display: none" alt="">
                                            </div>
                                            
                                            <div id="div_imagem_{{$postagem->id}}">
                                                {{-- @if ($postagem->imagem != "") --}}
                                                    <img id="imagem_{{ $postagem->id }}" class="imagem_post" src="{{ URL::to("/") . "/" . $postagem->imagem }}" alt="">    
                                                {{-- @endif --}}
                                            </div>
                                            
                                        </li>
                                        <br>
                                    </div>     
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
$(document).ready(function(){

});

function editaTitulo(id){
    event.preventDefault();
    var titulo = $("#titulo_"+id).text();
    var textarea = '<textarea class="edita-texto" id="text_area_edicao_' + id + '">';

    $("#titulo_"+id).parent().append(textarea);
    $("#titulo_"+id).css("display", "none");
   
    $("#text_area_edicao_"+id).val(titulo);
    $("#text_area_edicao_"+id).on("focus", autosize);
    $("#text_area_edicao_"+id).focus();
    $("#text_area_edicao_"+id).on("keydown", autosize);

    $("#text_area_edicao_"+id).on("focusout", function(){
        
        var novo_titulo = $(this).val();
        $(this).remove();
        $("#titulo_"+id).text(novo_titulo);
        $("#titulo_"+id).css("display", "block");
        if (titulo != novo_titulo){

            data = {
                'id' : id,
                'titulo' : novo_titulo
            };

            reqAjax = $.ajax({
                url : "{{URL::to('postagem/edita/titulo')}}" + "/" + id,
                type: "POST",
                headers : {'X-CSRF-Token': '{{ csrf_token() }}'},
                data : data,
                function(){}
            });

            reqAjax.done(function(){
                Swal.fire({
                icon: 'success',
                title: 'Título alterado com sucesso',
                text: "",
                showConfirmButton: false,
                timer: 1500   
                });
            });
        }
    });
}

function editaDescricao(id){
    event.preventDefault();
    var descricao = $("#descricao_"+id).text();
    var textarea = '<textarea class="edita-texto" id="text_area_edicao_' + id + '">';

    $("#descricao_"+id).parent().append(textarea);
    $("#descricao_"+id).css("display", "none");
   
    $("#text_area_edicao_"+id).val(descricao);
    $("#text_area_edicao_"+id).on("focus", autosize);
    $("#text_area_edicao_"+id).focus();
    $("#text_area_edicao_"+id).on("keydown", autosize);

    $("#text_area_edicao_"+id).on("focusout", function(){
        
        var nova_descricao = $(this).val();
        $(this).remove();
        $("#descricao_"+id).text(nova_descricao);
        $("#descricao_"+id).css("display", "block");

        if (nova_descricao != descricao){            
            data = {
                'id' : id,
                'descricao' : nova_descricao
            }

            reqAjax = $.ajax({
                url : "{{URL::to('postagem/edita/descricao')}}" + "/" + id,
                type: "POST",
                headers : {'X-CSRF-Token': '{{ csrf_token() }}'},
                data : data,
                function(){}
            });
            
            reqAjax.done(function(){
                Swal.fire({
                icon: 'success',
                title: 'Descrição alterada com sucesso',
                text: "",
                showConfirmButton: false,
                timer: 1500   
                });
            });
        }
    }); 
}

function editaImagem(event, id){
    $("#btn_edita_imagem_"+id).prop("disabled", false);
    var reader = new FileReader();
    reader.onload = function(){   
        $("#imagem_"+id).fadeOut(300);
        setTimeout(function(){
            $("#imagem_"+id).attr("src", reader.result);
            $("#imagem_"+id).fadeIn();
        }, 300)
    }
    reader.readAsDataURL(event.target.files[0]);
}

function salvaImagem(id){
    Swal.fire({
        title: 'Alterar a imagem?',
        text: "Não há como desfazer a operação",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sim, alterar!'
    }).then((result) => {
        if (result.value) {

            var imagem = $("#edita_imagem_"+id)[0].files[0];
            var form_data = new FormData();
            form_data.append('imagem', imagem);
            form_data.append("id", id)
            $("#spinner_"+id).show();

            reqAjax = $.ajax({
                url : "{{URL::to('postagem/edita/imagem')}}" + "/" + id,
                type: "POST",
                headers : {'X-CSRF-Token': '{{ csrf_token() }}'},
                data : form_data,
                cache : false,
                contentType : false,
                processData: false
            });

            reqAjax.done(function(){
                $("#spinner_"+id).hide();
                Swal.fire({
                    icon: 'success',
                    title: 'Imagem alterada com sucesso',
                    text: "",
                    showConfirmButton: false,
                    timer: 1500   
                    });

            })
        }
    })

}

function mostraEditaImagem(id){
    event.preventDefault();
    $("#edita_imagem_"+id).trigger("click");
    $("#div_edita_imagem_"+id).css("display", "block");
}

function autosize(){
    var element = this;
    setTimeout(function(){
      element.style.cssText = 'height:auto; padding:0';
      element.style.cssText = 'height:' + element.scrollHeight + 'px';
    },0);
}

function removePost(id){
    
    Swal.fire({
        title: 'Deletar a postagem?',
        text: "Não há como desfazer a operação",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sim, deletar!'
    }).then((result) => {
        if (result.value) {
            Swal.fire(
            'Feito!',
            'A postagem foi deletada!',
            'success'
            )

            $("#botao_remove_" + id).parent().parent().parent().parent().fadeOut(1000);
            var reqAjax = $.ajax({
                url : "{{URL::to('postagem/remove')}}" + "/" + id,
                type : "POST",
                headers : {'X-CSRF-Token': '{{ csrf_token() }}'},
                data : {'id' : id},
                function(){}
            });
        }
    })
}

function ativaPost(id_botao){
    var icone = $("#botao_ativo_" + id_botao).children();
    var ativa = "";

    if (icone.hasClass("fa fa-eye")){
        ativa = "N";
        icone.removeClass("fa fa-eye").addClass("fa fa-eye-slash");
    }else{
        ativa = "S";
        icone.removeClass("fa fa-eye-slash").addClass("fa fa-eye");
    }

    var data = {
        'id' : id_botao,
        'ativa' : ativa
    }

    var reqAjax = $.ajax({
        url : "{{URL::to('postagem/ativa')}}" + "/" + id_botao,
        type: "POST",
        headers: {'X-CSRF-Token': '{{ csrf_token() }}'},
        data: data,
        function(){}
    });
}

</script>

@endsection