@extends('layout.header')

@section('titulo')
    Pergunta
@endsection
@if ($errors->any())
    <div class="alert text-light m-0" style = "background-color: rgb(231, 17, 17) ">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
@section('menu')
<li class="nav-item">
    <a class="navbar-brand mb-0 nav-link p-3 pt-4 text-light h6" href="/turmas">Turmas</a>
</li>

<li class="nav-item">
    <a class="navbar-brand mb-0 nav-link p-3 pt-4 text-light h6" href="/sala_de_aula/c/sda/{{session('idSalaDeAula')}}">Perguntas</a>
</li>

<li class="nav-item">
    <a class="navbar-brand mb-0 nav-link p-3 pt-4 text-light h6" href="/sala_de_aula/c/par/{{session('idSalaDeAula')}}">Participantes</a>
</li>

@section('menu_responsivo')
<a class="dropdown-item bg-success text-light" href = "/sala_de_aula/c/sda/{{session('idSalaDeAula')}}">{{session('nome')}}</a>
<div class="dropdown-divider"></div>

<a class="dropdown-item bg-success text-light" href="/turmas">TURMAS</a>
<a class="dropdown-item bg-success text-light" href="/sala_de_aula/c/par/{{session('idSalaDeAula')}}">PARTICIPANTES</a>
<a class="dropdown-item bg-success text-light" href="/convite/{{session('idSalaDeAula')}}">CONVIDAR ALUNOS</a>
@endsection
@endsection

@section('conteudo_body')
<div class="col-md-8 mx-auto">
    <div class="card bg-success px-4">
        <div class="card-header px-0">
            <div>
                <div class="d-flex align-items-center ">
                    @if($pergunta->usuario->tipo_type == 'App\Models\Professor')
                    <img style="width: 45px; border-radius: 50%; border: 3px white solid" class = "shadow icone-responsivo" src="/img/professor.jpg" alt="">
                    @else
                    <img style="width: 45px; border-radius: 50%; border: 3px white solid" class = "shadow icone-responsivo" src="{{$item['perguntas'][0]->caminho ?? '/img/outline_account_circle_white_24dp.png'}}" alt="">
                    @endif
                    <p class="m-0 ml-2 text-light usuario-responsivo" maxlength =  "5" style = "font-family: 'Press Start 2P'">{{$usuario->apelido}}</p>
                    <div class="flex-grow-1"></div>
                    @if(session('usuario')->tipo_type == "App\Models\Professor" && $pergunta->nota == null && $pergunta->matricula != session('usuario')->matricula)
                        <form action="/sala_de_aula/c/nP/" method="POST" class="d-flex text-light justify-content-end" style="width: min-content;">
                            {{csrf_field()}}
                            <input class="form-control m-2 p-1 nota-responsiva" type="text" style = " color: white" name="nota">
                            <input class = "mt-5 " type="text" hidden value="{{$pergunta->idPergunta}}" name="idPergunta">
                            <button class="btn  bg-light text-dark atribuir-responsivo" type="submit" max="10" min="0">Atribuir</button> 
                            <button class="btn  bg-light text-dark ok-responsivo" type="submit">OK</button> 
                        </form>
                    @endif
                    @if($pergunta->nota != null)
                        <div class = "p-2 mt-3" style = "box-sizing: border-box">
                            <p>Nota: {{$pergunta->nota}}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="card-body">    
            <div class="row">
                <div class="form-control bg-white rounded p-3" style="height: 240px;">
                    {!!$pergunta->texto!!}
                </div>
            </div>
        </div>
        @if($pergunta->matricula != session('usuario')->matricula)
        <div class="card-body">    
            <form action="/sala_de_aula/c/r/" method="POST" style = "color: black">
                {{csrf_field()}}
                <div class="row align-items-center">
                        <div class = "col-md-12"> 
                            <div class = "d-flex flex-column align-items-center mb-3">
                                @if(session('usuario')->tipo_type == "App\Models\Professor")
                                <img  class = "shadow" style="width: 70px; border: 3px white solid; border-radius: 50%" src="/img/professor.jpg" alt="">
                                @else
                                <img class = "shadow" style="width: 70px; border: 3px white solid; border-radius: 50%" src="{{session('item_equipado')->caminho ?? '/img/outline_account_circle_white_24dp.png'}}" alt="">
                                @endif
                            </div>
                            <div>
                                <textarea placeholder = "Digite aqui a sua resposta para essa pergunta!" name="resposta" class="form-control editor" ></textarea>
                                <input type="text" hidden value="{{$pergunta->idPergunta}}" name="idPergunta">
                            </div>
                            <div class = "d-flex flex-column align-items-end"> 
                                <button type="submit" class="btn btn-secondary btn-sm rounded text-dark mt-2" style="height: 35px; font-family: 'Press Start 2P'">Enviar</button>
                            </div>                            
                        </div>
                    </div>
                </div>
            </form>
        </div>
        @endif
    </div>
</div>
@for($i = 0; $i < count($resposta); $i++)
<div class="col-md-8 mx-auto">
    <div class="card  px-4" style = "background-color: green">
        <div class="card-header px-0">
            <div class="h4 m-0 text-light" style = "font-family: 'Press Start 2P'">Resposta</div>
            <hr class="border-light">
            <div class="d-flex align-items-center">
                @if($resposta[$i]->usuario->tipo_type == 'App\Models\Professor')
                <img style="width: 45px; border: 3px solid white; border-radius: 50%" class = "icone-responsivo ml-2 shadow"  src="/img/professor.jpg" alt="">
                @else
                <img style="width: 45px; border: 3px solid white; border-radius: 50%" class = "shadow" src="{{$item['respostas'][$i]->caminho ?? '/img/outline_account_circle_white_24dp.png'}}" alt="">
                @endif
                <p class="m-0 ml-3 text-light  usuario-responsivo" maxlength =  "5"  style = "font-family: 'Press Start 2P'">{{$resposta[$i]->usuario->apelido}}</p>
                <div class="flex-grow-1"></div>

                @if(session('usuario')->tipo_type == "App\Models\Professor" && $resposta[$i]->nota == null && $resposta[$i]->matricula != session('usuario')->matricula)
                    <form action="/sala_de_aula/c/nR/" method="POST" class="d-flex text-light justify-content-end" style="width: min-content;">
                        {{csrf_field()}}
                        <input class="form-control" type="text" style = "width: 40px; color: white" name="nota">
                        <input type="text" value="{{$resposta[$i]->idResposta}}" hidden name="idResposta">
                        <button class="btn btn-sm bg-light text-dark ml-3 atribuir-responsivo" type="submit" max="10" min="1">Atribuir</button> 
                        <button class="btn  bg-light text-dark ok-responsivo" type="submit">OK</button> 

                    </form>
                @endif
                @if($resposta[$i]->nota != null)
                    <div>
                        <p class="text-light">Nota: {{$resposta[$i]->nota}}</p>
                    </div>
                @endif
            </div>
        </div>
        <div class="card-body">    
            <div class="row">
                <div class="form-control bg-white rounded p-3" style="height: 240px;">
                    {!! $resposta[$i]->texto !!}
                </div>
            </div>
        </div>
        <div class="card-body"> 
            <div class="card-body" style = "background-color: rgb(2, 114, 2)">

            @foreach($comentarios[$i] as $key => $comentario)
                <div class="row d-flex flex-row align-items-end mb-3">
                    <div style="width: 100%">
                        @if(count($item['comentarios']['autor']) >= 1)
                            @for($j = 0; $j < count($item['comentarios']['autor']); $j++)
                                @if($comentario->usuario->tipo_type == "App\Models\Professor")
                                    <img style="width: 45px; margin-bottom: 15px; border: 3px solid white; border-radius: 50%" class = "shadow"  src="/img/professor.jpg" alt="">
                                    @break
                                @endif
                                @if($comentario->matricula == $item['comentarios']['autor'][$j]->matricula)
                                    <img style="width: 45px; margin-bottom: 15px; border: 3px solid white; border-radius: 50%" class = "shadow"  src="{{$item['comentarios']['item'][$j]->caminho ?? '/img/outline_account_circle_white_24dp.png'}}" alt="">
                                    @break
                                @endif
                            @endfor
                        @else
                            @if($comentario->usuario->tipo_type == "App\Models\Professor")
                                <img style="width: 45px; margin-bottom: 15px; border: 3px solid white; border-radius: 50% " class = "shadow ml-3"  src="/img/professor.jpg" alt="">
                            @else
                                <img style="width: 45px; margin-bottom: 15px; border: 3px solid white; border-radius: 50%" class = "shadow ml-3" src="/img/outline_account_circle_white_24dp.png" alt="">
                            @endif
                        @endif
                        <label class = "text-light" for="coment" style = "font-family: 'Press Start 2P'">{{$comentario->usuario->apelido}}</label>
                        <p style="height: 137px;" class=" form-control bg-white rounded p-4">{{$comentario->texto}}</p>
                    </div>
                </div>
            @endforeach
                <form action="/sala_de_aula/c/p/c" method="POST">
                    {{csrf_field()}}
                    <div class="row d-flex flex-row">

                        <div class = "col d-flex flex-column align-items-center">
                            @if(session('usuario')->tipo_type == "App\Models\Professor")
                            <img style="width: 70px; margin-bottom: 15px; border: 3px solid white; border-radius: 50%" class = "shadow" src="/img/professor.jpg" alt="">
                            @else
                            <img style="width: 70px; margin-bottom: 15px; border: 3px solid white; border-radius: 50%" class = "shadow" src="{{session('item_equipado')->caminho ?? '/img/outline_account_circle_white_24dp.png'}}" alt="">
                            @endif
                        </div>
                                                
                        <textarea style = "border: none" id = "coment-responsivo" placeholder = "Digite aqui o seu comentário!" name="comentario" class="w-75 form-control bg-white rounded p-3 mx-auto coment-responsivo"></textarea>
                        <input type="hidden" name="idResposta" value="{{$resposta[$i]->idResposta}}">
                        <div class = " rounded col d-flex flex-column align-items-center ">
                            <button type="submit" class="btn btn-secondary btn-sm rounded text-dark  mt-3" style="height: 35px; font-family: 'Press Start 2P'">Enviar</button>
                        </div>
                
                    </div>
                     </div>
                </form>
            </div>   
        </div>
        
    </div>
</div>
@endfor
@endsection