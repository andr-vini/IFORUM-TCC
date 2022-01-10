@extends('layout.basico')
@section('titulo')
    Turmas
@endsection
@section('conteudo')
@if ($errors->any())
    <div class="alert text-light m-0" style = "background-color: rgb(231, 17, 17) ">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<header class="d-flex bg-success px-5 align-items-center justify-content-around" style="height: 80px;">
    
    <span class="text-white h3" style = "font-family: 'Press Start 2P'" > 
        <span class="text-danger h3" style="color: rgb(231, 17, 17); font-family: 'Press Start 2P'">IF</span>orum
    </span>
    <div class="flex-grow-1"></div>
    @if(session('usuario')->tipo_type == "App\Models\Professor")
    
    <!-- Button trigger modal -->
    <button type="button" data-toggle="modal" data-target="#criar_sala" style="background-color: transparent; border:none;">
        <img title="Criar Sala de Aula"  style="width: 45px" src="/img/outline_add_white_24dp.png" alt="Botão de criar turma">
    </button>
    <!-- Modal -->
    <div class="modal fade" id="criar_sala" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content bg-success">
                <div class="modal-header">
                    <h5 class="modal-title text-light tela-criacao" style = "font-family: 'Press Start 2P'">Bem-vindo a tela de criação de turmas!</h5>
                    <button type="button" class="close text-light" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="/criar_sala" style = "text-align: center" method="get">
                    {{ csrf_field() }}
                    <input type="number" max="2022" min="2000" class = "py-2 tela-criacao w-75" style = "text-align: center; border-color: white" name="ano" placeholder="ano do diário">
                    <div></div>
                    <input type="number" max="2" min="1" class = "py-2 tela-criacao w-75" name="periodo"  style = "text-align: center; border-color: white" placeholder="período do diário">
                    <div class="modal-footer">
                       <button type="submit"class="btn btn-primary" style = "background-color: green"> Criar turma</button>
                    </div> 
                </form>
            </div>
        </div>
    </div>
    @endif
    <div class = "turmas-responsivas">
    <a class="navbar-brand mb-0 nav-link p-3 pt-4 text-light h6" href="/sala_de_aula/c/ran"> Ranking</a>
    @if(session('usuario')->tipo_type == "App\Models\Aluno")
    
    <a title="Sua Pontuação" href="/loja" >
        <img style = "width: 32px;" src="img/estrela3.svg" alt="">
        <span style = " font-family: 'Press Start 2P'; color: rgb(253, 217, 11); font-size: 10px">{{session('pontuacao') ?? ''}}</span>
    </a>
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
    <a class = "text-light" href="/encerrar_sessao">Sair</a>
    </div>

    <div class="btn-group mt-4 turmas-dropdown" >
        <button type="button" class="btn bg-success dropdown-toggle dropdown-toggle-split" data-toggle= "dropdown" aria-haspopup="true" aria-expanded="false">Menu</button>
            <span class="sr-only">Menu Responsivo</span>
        </button>
        <div class="dropdown-menu dropdown-menu-right" style = "background-color: green">
            <a class="dropdown-item bg-success text-light" href="/sala_de_aula/c/ran">RANKING</a>
            @if(session('usuario')->tipo_type !== "App\Models\Professor")
            <a class="dropdown-item bg-success text-light" href="/loja">LOJA</a>
            @endif

            <a class="dropdown-item bg-success text-light" href="/perfil">PERFIL</a>

            <a class = "dropdown-item bg-success text-light " href="/encerrar_sessao">SAIR</a>

        </div>
    </div>
</header>


<div class="row mx-0 mt-5">
    @if(isset($salaDeAula) && count($salaDeAula) > 0)
        @for($i = 0; $i < count($salaDeAula); $i++)
        <div class="col-md-4 px-0">
            <a href="/sala_de_aula/c/sda/{{$salaDeAula[$i]->idSalaDeAula}}">
                <div class="card card-chart">
                    <div class="card-header card-header-success">
                        <div>
                            <img class="card-header card-header-warning rounded-circle p-0 mx-auto" style="width: 70px; left: 40%; top: -22px;" src="/img/if.jpg" alt="">
                        </div>
                        <h4 class="ct-chart m-0" id="dailySalesChart" style = "font-family: 'Press Start 2P'; text-align: center">{{ $salaDeAula[$i]->nome}}</h3>
                        <div></div>
                    </div>
                    <div class="card-body">
                        <div class="d-flex">
                            <h6 class="m-1" style="font-family: 'Press Start 2P'">{{ $professores[$i]->apelido}}</h6>
                            <span class="flex-grow-1"></span>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        @endfor
        @else
        @if(session('usuario')->tipo_type == 'App\Models\Professor')
        <p class="mx-auto mt-5">Você ainda não tem nenhuma turma cadastrada. Cadastre sua primeira turma!</p>
        @endif
    @endif
</div>

@if(session('usuario')->tipo_type == "App\Models\Aluno")
<div class="row mx-0 mt-5">    
    @for($i = 0; $i < count($professoresPendentes); $i++)
    <div class="col-md-4 px-0">
        <div class="card card-chart" style = "background-color: rgb(235, 235, 235)">
            <div class="card-header card-header-success" style = "background-color: rgb(3, 155, 3)">
                <div>
                    <img class="card-header card-header-warning rounded-circle p-0 mx-auto" style="width: 70px; left: 40%; top: -22px;" src="img/if.jpg" alt="">
                </div>
                <h4 class="ct-chart m-0" id="dailySalesChart" style = "font-family: 'Press Start 2P'; text-align: center">Convite para a turma {{$salaDeAulasPendentes[$i]->nome}}</h3>
            </div>

            <div class="card-body pb-0">
                <div class="d-flex flex-column align-items-center">
                    <h6 class="m-1" style="font-family: 'Press Start 2P'; color:  rgb(3, 155, 3)">{{$professoresPendentes[$i]->apelido}}</h5>
                </div>
            </div>

            <div class="card-footer" style="height: 100%">
            
            <form action="/turmas/c/{{1}}/{{$convites[$i]->idVinculo}}" class="w-50 rounded align-items-center d-flex justify-content-center">
                <button type="submit" style="background-color: transparent; border: none;">
                    <div style=" font-family: 'Press Start 2P'">    
                        <img title = "Aceitar Pergunta" style="width: 40px;" src="/img/aceitar.svg" alt="">
                    </div>
                </button>    
            </form>

            <form action="/turmas/c/{{0}}/{{$convites[$i]->idVinculo}}" class="w-50 rounded align-items-center d-flex justify-content-center">
                <button type="submit" style="background-color: transparent; border: none;">
                    <div style= " font-family: 'Press Start 2P' ">
                        <img title = "Recusar Pergunta" style="width: 40px;" src="/img/recusar.svg" alt="">
                    </div>
                </button>    
            </form>
            </div>
        </div>
    </div>
    @endfor
</div> 
@endif
@endsection