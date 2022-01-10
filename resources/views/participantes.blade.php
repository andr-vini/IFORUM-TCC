@extends('layout.header')

@section('titulo')
    Participantes
@endsection

@section('nomedaturma')
<span class = "text-light mb-0 mt-2 sala-responsiva" style = "font-family: 'Press Start 2P'">{{session('nome')}}</span>
@endsection

@section('menu')
<li class="nav-item">
    <a class="navbar-brand mb-0 nav-link p-3 pt-4 text-light h6" href="/turmas">Turmas</a>
</li>

<li class="nav-item">
    <a class="navbar-brand mb-0 nav-link p-3 pt-4 text-light h6" href="/sala_de_aula/c/sda/{{session('idSalaDeAula')}}">Perguntas</a>
</li>

@if(session('usuario')->tipo_type == 'App\Models\Professor')
<li class="nav-item">
    <a  class="navbar-brand mb-0 mr-1 nav-link p-3 pt-4  pl-0 pr-0 text-light h6 " href="/convite/{{session('idSalaDeAula')}}">convidar alunos</a>
</li>
@endif
@section('menu_responsivo')
<a class="dropdown-item bg-success text-light" href = "/sala_de_aula/c/sda/{{session('idSalaDeAula')}}">{{session('nome')}}</a>
<div class="dropdown-divider"></div>

<a class="dropdown-item bg-success text-light" href="/turmas">TURMAS</a>

<a class="dropdown-item bg-success text-light" href="/convite/{{session('idSalaDeAula')}}">CONVIDAR ALUNOS</a>
@endsection
@endsection

@section('conteudo_body')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-9 mx-auto">
                <div class="card my-3 mt-5" >
                    <div class="card-header pb-0">
                        <h5 class="my-0" style = "font-family: 'Press Start 2P'">Moderadores</h5>
                    </div>
                    <div class="card-body">
                    @foreach($alunos['mod'] as $aluno)
                        <div class="d-flex bg-success px-3 align-items-center justify-content-around" style="height: 60px;">
                            <span class="text-white participante-responsivo" maxlength =  "5" style = "font-family: 'Press Start 2P' ; font-size: 14px" >{{$aluno->usuario->apelido}}</span>
                            <div class="flex-grow-1"></div>
                            @if(session('usuario')->tipo_type == "App\Models\Professor")
                            <a href="/sala_de_aula/c/mod/{{$aluno->idAluno}}/{{session('idSalaDeAula')}}">
                                <img title =  "Despromover" style = "width: 45px" src="/img/estrelamoderador.svg" alt="">
                            </a>
                            <a href="/sala_de_aula/c/rem/{{session('idSalaDeAula')}}/{{$aluno->idAluno}}">
                                <img title = "Remover Participante" style = "width: 45px" src="/img/remover1.svg"  alt="">
                            </a>
                            @endif
                        </div> 
                        <div style="height: 3px;"></div>
                    @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-9 mx-auto">
                <div class="card my-2">
                    <div class="card-header pb-0">
                        <div class="d-flex">
                            <h5 class="my-0" style = "font-family: 'Press Start 2P'">Participantes</h5>
                            <div class="flex-grow-1"></div>
                        </div>
                    </div>
                    <div class="card-body">
                        @foreach($alunos['aluno'] as $aluno)
                        <div class="d-flex bg-success px-3 align-items-center justify-content-around" style="height: 60px;">
                            <span class="text-white participante-responsivo" maxlength =  "5" style = "font-family: 'Press Start 2P' ; font-size: 14px"   > {{$aluno->usuario->apelido}} </span>
                            <div class="flex-grow-1"></div>
                            @if(session('usuario')->tipo_type == "App\Models\Professor")
                            <a href="/sala_de_aula/c/mod/{{$aluno->idAluno}}/{{session('idSalaDeAula')}}">
                                <img title = "Promover à Moderador" style = "width: 45px" src="/img/estrelamoderadorvazia.svg" alt="">
                            </a>
                            <a href="/sala_de_aula/c/rem/{{session('idSalaDeAula')}}/{{$aluno->idAluno}}">
                                <img title = "Remover Participante" style = "width: 45px" src="/img/remover1.svg" alt="">
                            </a>
                            @endif
                        </div>
                        <div style="height: 3px;"></div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection