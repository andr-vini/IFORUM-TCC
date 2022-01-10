@extends('layout.basico')
@section('titulo')
    Convidar Alunos
@endsection
<div class = "d-flex mx-auto align-items-center text-light convite-responsivo" style = " text-align: center; height: 100vh">
<form action="/convite/enviarConvite/{{$idSalaDeAula}}" style = "border: 10px green solid" method="POST" class = "d-flex flex-column mx-auto w-100 p-4 bg-success">
    {{csrf_field()}}
    <p class = "titulos-responsivo">Convites Não Enviados</p>
    @foreach($participantes['participantesNaoEnviado'] as $key => $participante)
    <div class="d-flex flex-row align-items-center">
        <input class="form-check-input bg-light m-2" style = "height: 4vh; width: 30px; position: relative; opacity: 1;  z-index: 4; " name="{{$key}}" type="checkbox" value="{{$participante->tipo_id}}" id="{{$key}}form">
        <div class="form-check text-light w-100 text-center" style = "border: green 5px solid" >
            <label class="font-responsiva-convite form-check-label text-light p-0 w-100 mt-3 " for="{{$key}}form">
                @foreach($participantes['dadosApiNaoEnviado'] as $aluno)
                    @if($participante->matricula == $aluno['matricula'])
                    <p>Matrícula: {{$participante->matricula}} </p>
                    <p>Nome: {{$aluno['nome']}} </p>
                    <p>Apelido: {{$participante->apelido}}</p>
                    @endif
                @endforeach
            </label>
        </div>
    </div>
    @endforeach
    <div class = "text-center p-2 enviar-visible">  
    <button class = "btn btn-sm btn-responsivo-convite w-25 text-light" style = "background-color: green; border: 1px solid white"  type="submit">Enviar</button>
    </div>

    <div class = "text-center p-2 enviar-hidden">  
    <button class = "btn btn-sm btn-responsivo-convite w-25 text-light" style = "background-color: green; border: 1px solid white"  type="submit">Ok!</button>
    </div>

    <a href="/sala_de_aula/c/sda/{{$idSalaDeAula}}" class = "text-light mb-3">voltar</a>
    <p class = "titulos-responsivo ">Convites Enviados</p>
    @foreach($participantes['participantesEnviado'] as $key => $participante)
    <div class = " font-responsiva-convite" style = "border: white 5px solid; border-radius: 5px; background-color: green">     
        @foreach($participantes['dadosApiEnviado'] as $aluno)
            @if($participante->matricula == $aluno['matricula'])
              <p class = "mt-3" >Matrícula: {{$participante->matricula}} </p>
              <p>Nome: {{$aluno['nome']}} </p>
              <p>Apelido: {{$participante->apelido}}</p>
            @endif
        @endforeach
    </div>
    @endforeach
</form>
</div>