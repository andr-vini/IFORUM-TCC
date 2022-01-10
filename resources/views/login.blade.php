@extends('layout.basico')
@section('titulo')
    Login
@endsection
@section('conteudo')
@if (\Session::has('erro_msg'))
    <div class="alert alert-danger">
        <ul>
            <li>{!! \Session::get('erro_msg') !!}</li>
        </ul>
    </div>
@endif

@if (\Session::has('success_cad'))
    <div class="alert alert-success">
        <ul>
            <li>{!! \Session::get('success_cad') !!}</li>
        </ul>
    </div>
@endif
<div class=" d-flex">
    <div class=" w-50  logo-responsiva ">
        <img class="w-100" style="height: 100vh;" src="img/logoif2.png" alt="">
    </div>
    
    <div class="  bg-light text-center d-flex justify-content-center align-items-center flex-column login-responsivo" style = "">
        <h1 class = " iforum-responsivo" style="font-family: 'Press Start 2P', cursive; color: green;">  
            <span class="text-danger h1 iforum-responsivo" style = "font-family: 'Press Start 2P'"> IF</span>orum
        </h1>
        <div class="content w-75">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body" style = "border: solid green 3px; border-radius:5px">
                                <form action="/autenticacao" method="POST">
                                    {{ csrf_field() }}
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group text-left">
                                                <label class="h6" style="font-family: 'Press Start 2P'; color: green">Matricula:</label>
                                                <input type="text" class="form-control" name="matricula">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group text-left">
                                                <label class="h6" style="font-family: 'Press Start 2P'; color: green;">Senha:</label>
                                                <input type="password" class="form-control" name="senha">
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn pull-right button-responsivo" style="font-family: 'Press Start 2P'; background-color: green"> Entrar </button>
                                    <div class="clearfix"></div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    
</div>
</div>
@endsection