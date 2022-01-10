@extends('layout.header')

@section('titulo')
    Perfil
@endsection

@section('menu')
<li class="nav-item">
    <a class="navbar-brand mb-0 nav-link p-3 pt-4 text-light h6" href="/turmas">Turmas</a>
</li>
<li class="nav-item">
    <a class="navbar-brand mb-0 nav-link p-3 pt-4 text-light h6" href="/sala_de_aula/c/ran"> Ranking</a>
</li>


@if(session('usuario')->tipo_type == "App\Models\Aluno")
    <li class="nav-item">
        <a class="navbar-brand mb-0 nav-link p-3  text-light" href="/loja"><img style = "width: 32px;" src="/img/estrela3.svg" alt="">
        <span class = "h6" style = "font-family: 'Press Start 2P'; color: rgb(253, 217, 11); margin-left: -12px"> {{session('pontuacao') ?? ''}} </span></a>
    </li>
@endif

<li class="nav-item">
    <a href="/perfil">
        @if(session('usuario')->tipo_type == "App\Models\Professor")
        <img class = "shadow" style = "width: 48px; border: white solid 4px; border-radius: 50% "  src="/img/professor.jpg"/>
        @else
        <img class = "shadow" style = "width: 48px; border: white solid 4px; border-radius: 50% "  src="{{session('item_equipado')->caminho ?? '/img/outline_account_circle_white_24dp.png'}}"/>
        @endif
    </a>
</li>

@section('menu_responsivo')
<a class="dropdown-item bg-success text-light" href="/turmas">
    TURMAS
    </a>
<a class="dropdown-item bg-success text-light" href="/sala_de_aula/c/ran/{{session('idSalaDeAula')}}">RANKING</a>
@if(session('usuario')->tipo_type !== "App\Models\Professor")
<a class="dropdown-item bg-success text-light" href="/loja">LOJA</a>
@endif

@endsection
@endsection

@section('conteudo_body')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-10 mx-auto">
                <div class="card card-profile py-5">
                    <div class="d-flex align-items-center mx-auto mb-3">
                        <div class="d-flex align-items-center justify-content-between w-100">
                            @if(session('usuario')->tipo_type == "App\Models\Aluno")
                            <div  style="width: 33%;" class = "est-resp mr-4">
                                <p class>Medalhas</p>
                                @if(!empty($items))
                                    @foreach($items as $item)
                                        @if($item->categoria == 2)
                                            <img style="width: 35px" src="{{$item->caminho}}" alt="">
                                        @endif
                                    @endforeach
                                @else
                                <p title = "Medalhas podem ser compradas na loja" style = "color: rgb(172, 172, 172);  "> Você ainda não tem medalhas!</p>
                                @endif
                            </div>
                            @endif
                            <div  style="width: 33%;">
                                @if(session('usuario')->tipo_type == "App\Models\Professor")
                                <img style = " border: rgb(1, 172, 1) solid 5px; border-radius: 50% "  src="/img/professor.jpg"/>
                                @else
                                <img class="w-50" style = " border: rgb(1, 172, 1) solid 5px; border-radius: 50% "  src="{{session('item_equipado')->caminho ?? '/img/outline_account_circle_green_24dp.png'}}"/>
                                @endif
                                <p class="apelido-resp" style = "font-family: 'Press Start 2P'; margin-top: 5px">{{$usuario->apelido}}</p>
                            </div>
                            @if(session('usuario')->tipo_type == "App\Models\Aluno")
                            <div style="width: 33%;" class = "d-flex flex-column est-resp ml-4">
                                <p>Ícones</p>
                                <p data-toggle = "modal" data-target = "#selecionar_icone" style = "color: rgb(187, 187, 187) ; font-family: 'Press Start 2P';  text-decoration: underline">(Aperte para editar o ícone)</p>
                            </div>
                        </div>
                            <!-- Modal -->
                            <div class="modal fade" style = " margin-top: 120px " id="selecionar_icone" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content bg-success mt-5">
                                        <div class="modal-header">
                                            <h5 class="modal-title text-light" style = "font-family: 'Press Start 2P'">Selecione o ícone que deseja usar</h5>
                                            <button type="button text-light" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            @foreach($items as $item)
                                            @if($item->categoria == 1)
                                            <button type="button" class="btn btn-secondary" style="background-color: green">
                                                <a href="/perfil/equipar/{{$item->idItem}}">
                                                    <img title = "Mudar ícone" style="width: 45px;" src="{{$item->caminho}}" alt="">
                                                </a>
                                            </button>
                                            @endif
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                    @if(session('usuario')->tipo_type == "App\Models\Aluno")
                    <div class="d-flex justify-content-around w-75 my-5 mx-auto" style = "font-family: 'Press Start 2P'">
                        <div class = "pontuacao-resp" >
                            <p>Pontuação</p>
                            <img style = "width: 32px;" src="img/estrela3.svg" alt="">
                            <span class = "h6" style = " font-family: 'Press Start 2P'; color: rgb(218, 186, 5); margin-left: -6px">{{session('pontuacao')}}</span>
                        </div>
                    
                    </div>
                    @endif
                    @if(session('usuario')->tipo_type == "App\Models\Professor")
                    <div class="my-5 mx-auto" style = "font-family: 'Press Start 2P'">
                        <div>
                            <p>E-mail</p>
                            <p title="Email do professor" style = "color: rgb(172, 172, 172); font-size: 10px; ">{{$email}}</p>
                        </div>
                    </div>
                    @endif
                    <div class="card-body " >
                        <div class="content ">
                            <div class="container-fluid py-0">
                                <div class="row ">
                                    <div class="col-md-9 mx-auto  ">
                                        <div class="card card-plain bg-success ">

                                            
                                            <div class="card-header est-none" style = "background-color: green">
                                                <div class="d-flex justify-content-around align-items-center " style="height: 50px ; background-color: green ">
                                                    <div class="py-2">
                                                        <h6 class="text-center m-1 est-resp " style = "font-family: 'Press Start 2P'"> Pergs: {{$contPerguntas}}</h6>
                                                    </div>
                                                    <div class="border" style="height: 100%;"></div>
                                                    <div class="py-2">
                                                        <h6 class="text-center m-1 est-resp " style = "font-family: 'Press Start 2P'">  Resps: {{$contRespostas}}</h6>
                                                    </div>
                                                    <div class="border" style="height: 100%;"></div>
                                                    <div class="py-2">
                                                        <h6 class="text-center m-1 est-resp" style = "font-family: 'Press Start 2P'"> Likes: {{count($usuario->likes)}}</h6>
                                                    </div>
                                                
                                                </div>
                                            </div>





                                            <div class="card-header est-visible" style = "background-color: green">
                                                <div class="d-flex justify-content-around align-items-center " style="height: 50px ; background-color: green ">
                                                    <div class="py-2">
                                                        <h6 class="text-center m-1 est-resp " style = "font-family: 'Press Start 2P'"> Perguntas: {{$contPerguntas}}</h6>
                                                    </div>
                                                    <div class="border" style="height: 100%;"></div>

                                                    <div class="py-2">
                                                        <h6 class="text-center m-1 est-resp " style = "font-family: 'Press Start 2P'"> Respostas: {{$contRespostas}}</h6>
                                                    </div>
                                                    <div class="border" style="height: 100%;"></div>

                                                    <div class="py-2">
                                                        <h6 class="text-center m-1 est-resp" style = "font-family: 'Press Start 2P'"> Curtidas: {{count($usuario->likes)}}</h6>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection