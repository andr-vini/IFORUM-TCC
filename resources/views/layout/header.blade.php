@extends('layout.basico')

@section('conteudo')

<header class=" d-flex bg-success px-5 align-items-center justify-content-around" style="height: 90px;">
    <span class="text-white my-0 h3 mr-5 responsive-iforum iforum-responsivo-sa" style = "font-family: 'Press Start 2P'" > 
        <span class= "my-0 h3 responsive-iforum iforum-responsivo-sa" style = "color: rgb(231, 17, 17); font-family: 'Press Start 2P'">IF</span>orum
    </span>
    @yield('nomedaturma')
 
    <nav class="dropdown navbar-expand-lg m-0 mt-2 bg-success">
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav " style = "font-family: 'Press Start 2P';">
                @yield('menu')
            </ul>
          </div>
    </nav>
    <!-- menu dropdown (min: 992px) -->
    <div class="btn-group mt-3 menu-escondido" >
        <button type="button" class="btn bg-success dropdown-toggle dropdown-toggle-split" data-toggle= "dropdown" aria-haspopup="true" aria-expanded="false">Menu</button>
        <span class="sr-only">Toggle Dropdown</span>
        </button>
        <div class="dropdown-menu dropdown-menu-right" style = "background-color: green">
            @yield('menu_responsivo')
        </div>
    </div>

</header>

@yield('conteudo_body')
@endsection