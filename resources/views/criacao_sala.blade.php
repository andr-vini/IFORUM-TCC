@extends('layout.basico')
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
<div class = "d-flex mx-auto p-5 align-items-center criar-sala-responsivo " style = "text-align: center; height: 100vh"> 
    <form class = "d-flex flex-column mx-auto w-100 p-4 bg-success" action="/_criar_sala" method="get" style = "border: solid 3px black">
        {{ csrf_field() }}
        <div> 
            <input type="text" class = "w-75 mt-1" maxlength="200" minlength="10" name="nome" style = "border-color: black" placeholder="nome da sala de aula">
                <select name="diario" class = "text-light w-75 mt-1 "  style = "background-color: #006400; border: solid black 2px; ">
                    @for($i = 0; $i < count($diarios); $i++)
                        <option style = "font-size: 10px" value="{{$i}}">{{$diarios[$i]['componente_curricular']}}</option>
                    @endfor
                </select>
            <button type="submit" class = " mt-2  text-light botoes-criar-sala" style ="background-color: red; border: solid black 2.5px"> <a class = "text-light" href = "/turmas"> VOLTAR </a></button>
            <button type="submit" class = " mt-2  text-light botoes-criar-sala" style ="background-color: green; border: solid black 2.5px">CRIAR</button>
        </div>
    </form>
</div>
@endsection
