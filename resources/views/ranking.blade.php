@extends('layout.header')

@section('titulo')
    Ranking
@endsection

@section('nomedaturma')
<span class = "text-light mb-0 mt-2 sala-responsiva" style = "font-family: 'Press Start 2P'">{{session('nome')}}</span>
@endsection

@section('menu')
<li class="nav-item">
    <a class="navbar-brand mb-0 nav-link p-3 pt-4 text-light h6" href="/turmas">Turmas</a>
</li>


@if(session('usuario')->tipo_type == "App\Models\Aluno")
    <li class="nav-item">
        <a class="navbar-brand mb-0 nav-link p-3  text-light" href="/loja"><img style = "width: 32px;" src="/img/estrela3.svg" alt="">
        <span class = "h6" style = "font-family: 'Press Start 2P'; color: rgb(253, 217, 11); margin-left: -12px"> {{session('pontuacao') ?? ''}} </span></a>
    </li>
@endif
@if(session('usuario')->tipo_type == 'App\Models\Professor')
<a href="/perfil">
    <img title="Seu Perfil" style="width: 45px; border: solid white 2px; border-radius: 50%" src="/img/professor.jpg" alt="Botão de acessar o perfil">
</a>
@else
<a href="/perfil">
    <img title="Seu Perfil" style="width: 45px; border: solid white 2px; border-radius: 50%" src="{{session('item_equipado')->caminho ?? '/img/outline_account_circle_white_24dp.png'}}" alt="Botão de acessar o perfil">
</a>
@endif
@section('menu_responsivo')
<a class="dropdown-item bg-success text-light" href="/turmas">
    TURMAS
</a>
@if(session('usuario')->tipo_type !== "App\Models\Professor")
<a class="dropdown-item bg-success text-light" href="/loja">LOJA</a>
@endif
<a class="dropdown-item bg-success text-light" href="/perfil">
   PERFIL
</a>
@endsection
@endsection

@section('conteudo_body')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-9 mx-auto">
                <div class="card card-plain">
                    <div class="card-header card-header-primary bg-success" style= "margin-top: 6px">
                        <h4 class="card-title mt-0 text-center h5" style = "font-family: 'Press Start 2P'"> Ranking</h4>
                    </div>
                    <div class="card-body bg-success">
                        <?php $cont = 1; ?>
                        @foreach($alunos as $key => $aluno)
                        <div class="d-flex p-2">
                            <span> <h6 class = "text-light" style = "font-family: 'Press Start 2P'"> {{ $cont }}º - </h5> </span>
                            <span> <h6 class = "text-light" style = "font-family: 'Press Start 2P'; margin-left: 12px"> {{$aluno->usuario->apelido}} </h5> </span>
                            <div class="flex-grow-1"></div>
                            <img style = "width: 22px" src="/img/estrela3.svg" alt="">
                            <span style = "font-family: 'Press Start 2P'; color: rgb(253, 217, 11); font-size: 11px; margin-top: 4px; margin-left: 4px" >{{$aluno->pontuacao}}</span>
                        </div>
                        <?php $cont++ ?>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection