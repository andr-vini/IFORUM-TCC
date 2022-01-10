

@extends('layout.header')

@section('titulo')
    Loja
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
        
        <img style="width: 45px; border: solid white 2px; border-radius: 50%" class = "shadow" src="{{session('item_equipado')->caminho ?? '/img/outline_account_circle_white_24dp.png'}}" alt="">
    </a>
</li>
@section('menu_responsivo')
<a class="dropdown-item bg-success text-light" href="/turmas">
   TURMAS
</a>
<a class="dropdown-item bg-success text-light" href="/sala_de_aula/c/ran/{{session('idSalaDeAula')}}">RANKING</a>
<a class="dropdown-item bg-success text-light" href="/perfil">
    PERFIL
</a>
@endsection
@endsection


@section('conteudo_body')
<div class="d-flex col mt-5 ">
    <nav class = "col-md-3 " style = "box-shadow: none; margin-top: 100px;">
        
     
        <ul class="list-group align-items-center ul-loja " style = " font-family: 'Press Start 2P';  position: fixed; border: green 5px solid; border-radius: 15px">
           
            <li class="list-group-item pontos-responsivos" >
                <a class="navbar-brand  p-0 text-light " ><img style = "width: 32px;" src="/img/estrela3.svg" alt="">
                <span class = "h6" style = "font-family: 'Press Start 2P'; color: rgb(224, 192, 7); margin-left: -12px"> {{session('pontuacao') ?? ''}} </span></a>
            </li>
            
            <li class="list-group-item ">
                <a href="/loja/{{1}}" class="btn btn-primary bg-success botao-loja" style = "border-radius: 15px">Icones</a>
            </li>
            <li class="list-group-item">
                <a href="/loja/{{2}}" class="btn btn-primary bg-success botao-loja" style = "border-radius: 15px">Medalhas</a>
            </li>

        </ul>
    </nav>
    <div class="content col-md-9 card-resp "  id="iconesCollapse">
        <div class="container-fluid">
            <div class="row">
                @foreach($items as $item)
                <div class="col-lg-3 col-md-6">
                    <div class="card mb-0 align-items-center " style = "background-color: #eeeeee; box-shadow: none">
                        <div class="w-100 card-header card-header-warning card-header-icon align-items-center d-flex flex-column">
                            <img src="{{$item->caminho}}" class="icone-loja" alt="">  
                            <h3 class="card-title text-center" style = "font-family: 'Press Start 2P'; font-size: 16px">{{$item->nome}}</h3>
                            <a href="/loja/comprar/{{$item->idItem}}" class="btn bg-success" style = "font-family: 'Press Start 2P'; margin-top: 10px; border-radius: 15px; font-size: 10px; border: black solid 2px">Comprar </a>
                        </div>
                        <div class="card-footer">
                            <div class="stats">
                                <img style = "width: 26px;" src="/img/estrela3.svg" alt="">
                                <span style = " font-family: 'Press Start 2P'; color: rgb(231, 198, 8); font-size: 13px; margin-left: 3px">{{$item->preco}}</span>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    <div class="content col-md-9 card-resp collapse "  id="medalhasCollapse">
        <div class="container-fluid">
            <div class="row">
                @foreach($items as $item)
                <div class="col-lg-3 col-md-6">
                    <div class="card mb-0 align-items-center " style = "background-color: #eeeeee; box-shadow: none">
                        <div class="w-100 card-header card-header-warning card-header-icon align-items-center d-flex flex-column">
                            <img src="{{$item->caminho}}" class="icone-loja" alt="">  
                            <h3 class="card-title text-center" style = "font-family: 'Press Start 2P'; font-size: 16px">{{$item->nome}}</h3>
                            <a href="/loja/comprar/{{$item->idItem}}" class="btn bg-success" style = "font-family: 'Press Start 2P'; margin-top: 10px; border-radius: 15px; font-size: 10px; border: black solid 2px">Comprar </a>
                        </div>
                        <div class="card-footer">
                            <div class="stats">
                                <img style = "width: 26px;" src="/img/estrela3.svg" alt="">
                                <span style = " font-family: 'Press Start 2P'; color: rgb(231, 198, 8); font-size: 13px; margin-left: 3px">{{$item->preco}}</span>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection