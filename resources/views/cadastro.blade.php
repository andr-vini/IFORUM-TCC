@extends('layout.basico')
@section('titulo')
    Cadastro
@endsection
@section('conteudo')

@if ($errors->any())
    <div class="alert text-light" style = "background-color: rgb(231, 17, 17) ">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<!-- Modal -->
<div class="modal fade show" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="display: block;">
    <div class="modal-dialog" role="document">
        <div class="modal-content " style = "border: 3px solid #009f0d; margin-top: 160px">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel" style = "font-family: 'Press Start 2P'; color: #009f0d;">Cadastro</h5>
                <a href="/">
                    <span aria-hidden="true">&times;</span>
                </a>
            </div>
            <div class="modal-body">
                <form action="/cadastro" method="POST">
                {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="bmd-label-floating" style = "color:#009f0d ">Apelido</label>
                                <input type="text" name="apelido" class="form-control" style = "padding-left: 5px">
                            </div>
                        </div>
                    </div>
                    @yield('email_professor')
                    @if($vinculo == 'Professor')
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="bmd-label-floating" style = " color: #009f0d">E-mail</label>
                                <input type="text" name="email" class="form-control" style = "padding-left: 5px">
                            </div>
                        </div>
                    </div>
                    @endif
                    <button type="submit" class="btn btn-primary pull-right bg-success" >Tudo certo!</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection