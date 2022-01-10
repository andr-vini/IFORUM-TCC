@extends('layout.header')

@section('titulo')
    Sala de Aula
@endsection

@section('nomedaturma')
<span class = "text-light mb-0 mt-2 sala-responsiva" style = "font-family: 'Press Start 2P'">{{session('nome')}}</span>
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
    <a class="navbar-brand mb-0 nav-link p-3 pt-4 pl-0 pr-0  text-light h6" href="/turmas">Turmas</a>
</li>


<li class="nav-item">
    <a class="navbar-brand mb-0 mr-1 nav-link p-3 pt-4 pl-0 pr-0 text-light h6"  href="/sala_de_aula/c/par/{{session('idSalaDeAula')}}">Participantes</a>
</li>
@if(session('usuario')->tipo_type == 'App\Models\Professor')
<li class="nav-item">
    <a  class="navbar-brand mb-0 mr-1 nav-link p-3 pt-4  pl-0 pr-0 text-light h6 " href="/convite/{{session('idSalaDeAula')}}">convidar alunos</a>
</li>



@section('menu_responsivo')
<a class="dropdown-item bg-success text-light">{{session('nome')}}</a>
<div class="dropdown-divider"></div>

<a class="dropdown-item bg-success text-light" href="/turmas">TURMAS</a>
<a class="dropdown-item bg-success text-light" href="/sala_de_aula/c/par/{{session('idSalaDeAula')}}">PARTICIPANTES</a>
<a class="dropdown-item bg-success text-light" href="/convite/{{session('idSalaDeAula')}}">CONVIDAR ALUNOS</a>
@endsection

@endif
@section('menu_responsivo')
<a class="dropdown-item bg-success text-light" href="/sala_de_aula/c/sda/{{session('idSalaDeAula')}}">PERGUNTAS</a>
<a class="dropdown-item bg-success text-light" href="/sala_de_aula/c/par/{{session('idSalaDeAula')}}">PARTICIPANTES</a>
@endsection
@endsection
@section('conteudo_body')

<main class="content w-75 mx-auto">
    <div class="col-md-12 p-0">
        <div class="card mx-auto w-100">
            <div class="card-body">
                <form action="/sala_de_aula/c/p/{{session('idSalaDeAula')}}" method="POST">
                    {{csrf_field()}}
                    <div class = "row " >
                        <div class="col-md-12">
                            <fieldset>
                                <textarea name="pergunta" placeholder = "Está com dúvidas? Faça a sua pergunta aqui!"  class="form-control editor" ></textarea>
                            </fieldset>
                        </div>
                    </div>
                    <button type="submit" class="btn bg-success pull-right " style = "font-family: 'Press Start 2P'">Enviar</button>
                </form>
            </div>
        </div>
    </div>
    <div class="container-fluid p-0">
        <div class="row w-100 m-0">
            @for($i = 0; $i < count($perguntas['perguntas_aceitas']['pergunta']); $i++)
                <?php
                $perg = $perguntas['perguntas_aceitas']['pergunta'];
                $user = $perguntas['perguntas_aceitas']['usuario'];
                $likes = $perguntas['perguntas_aceitas']['likes'];
                $respostas = $perguntas['perguntas_aceitas']['respostas'];
                ?>
                <div class="col-lg-3 col-md-6 col-sm-6 p-0">
                    <a href="/sala_de_aula/c/per/{{$perg[$i]->idPergunta}}">
                        <div class="card card-stats text-center bg-success mx-auto" style="height: 252px;">
                            <img  class="card-header card-header-warning rounded-circle p-0 mx-auto shadow-none" style="width: 70px; top:-13px; background: transparent;" src="/img/if.jpg" alt="">
                            <h5 style = "font-family: 'Press Start 2P'" class = "text-light">{{$user[$i]->apelido}}</h5>
                            <div class ="p-3 text-light" style = "overflow: hidden; height: 150%; ">{!!$perg[$i]->texto!!}</div>
                            <div class="card-footer m-0" style="height: 100%">
                                <div class="w-50 rounded align-items-center d-flex justify-content-center" style="height: 20%; font-family: 'Press Start 2P'">
                                 
                                        <a href="/pergunta/like/{{session('usuario')->matricula}}/{{$perg[$i]->idPergunta}}">
                                            <img style="width: 35px;" src="/img/like1.svg" alt="">
                                        </a>
                                    <span title = "Número de Curtidas" style = "color: rgba(228, 6, 6, 0.76)">{{$likes[$i]}}</span>
                                </div>
                                <div class="w-50 rounded align-items-center d-flex justify-content-center" style="height: 20% ; font-family: 'Press Start 2P' ">
                                    <img style="width: 35px;" src="/img/resposta1.svg" alt="">
                                    <span title = "Número de Respostas" style = "color: rgba(228, 6, 6, 0.76)">{{$respostas[$i]}}</span>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            @endfor
        </div>
    </div>
    @if(session('usuario')->tipo_type == 'App\Models\Professor' || $moderador == 1)
    
            <div class="container-fluid p-0">
                <div class="row w-100 m-0">
                    @for($i = 0; $i < count($perguntas['perguntas_pendentes']['pergunta']); $i++)
                    <?php
                    $perg = $perguntas['perguntas_pendentes']['pergunta'];
                    $user = $perguntas['perguntas_pendentes']['usuario'];
                    ?>
                    <div class="col-lg-3 col-md-6 col-sm-6 p-0" onclick="mostrarPergunta('{{$perg[$i]->texto}}')">
                        <div class="card card-stats text-center mx-auto text-light" style="height: 252px; background: rgb(2, 100, 2)">
                            <img  class="card-header card-header-warning rounded-circle p-0 mx-auto" style="width: 70px; top:-13px; background: transparent;" src="/img/if.jpg" alt="">
                            <h5 style = "font-family: 'Press Start 2P'">{{$user[$i]->apelido}}</h5>
                                <!-- Button trigger modal -->
                                    <p data-toggle = "modal" class = "mt-4" data-target = "#visualizar_pergunta" style = "font-size: 10px ; text-decoration: underline"> 
                                    Visualizar texto da pergunta
                                    </p>
                                <div class="card-footer m-0" style="height: 100%">
                                <form action="/sala_de_aula/p/{{1}}/{{$perg[$i]->idPergunta}}" class="w-50 rounded align-items-center d-flex justify-content-center" method="GET">
                                    <button type="submit" style="background-color: transparent; border: none;">
                                        <div  style=" font-family: 'Press Start 2P'">    
                                            <img title = "Aceitar Pergunta" style="width: 40px;" src="/img/aceitar.svg" alt="">
                                        </div>
                                    </button>
                                </form>
                                <form action="/sala_de_aula/p/{{0}}/{{$perg[$i]->idPergunta}}" class="w-50 rounded align-items-center d-flex justify-content-center">
                                    <button type="submit" style="background-color: transparent; border: none;">
                                        <div  style= " font-family: 'Press Start 2P' ">
                                            <img title = "Recusar Pergunta" style="width: 40px;" src="/img/recusar.svg" alt="">
                                        </div>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endfor
                    <!-- Modal -->
                    <div class="modal fade" id="visualizar_pergunta" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content bg-success">
                                <div class="modal-header">
                                    <button type="button" class="close text-light" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body text-light" id="pergunta">
                                    
                                </div>
                                <div class="modal-footer">
                                    <button type="button" style = "background-color: green " class="btn btn-secondary  text-light" data-dismiss="modal">Fechar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <script>
                        function mostrarPergunta(texto) {
                            document.getElementById('pergunta').innerHTML = texto;
                        }
                    </script>
                </div>
            </div>
        @endif
</main>
@endsection