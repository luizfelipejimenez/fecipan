<!doctype html>
<html lang="pt_br">
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="icon" href="/imagens/favicon.svg">
  <link rel="mask-icon" href="/imagens/favicon.svg" color="#000000">
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.css">
  <link rel="stylesheet" type="text/css" href="/css/app.css">
  <!--<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">-->

  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.21/datatables.min.css"/>

  <!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
 

  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<!--<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.js"></script>-->

<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.21/datatables.min.js"></script>


  <title>{{ config('app.name') }}</title>
</head>
<body>

  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
     <a class="navbar-brand" href="#">
        <img src="/imagens/nav-logo.svg" height="30" class="d-inline-block align-top" alt="" loading="lazy">
        FrEvO
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#myNavbar" aria-controls="myNavbar" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse " id="myNavbar">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item">
          <a class="nav-link" href="/">
            <i data-feather="home"></i>
            Início
          </a>
        </li>
        @if (Auth::check())
      
          @if(Auth::user()->isAdmin())
            @php $menus = App\Conteudo::where(['menu' => '1', 'publica' => '1'])->OrderBy('menu_pai', 'ASC')->orderBy('rotulo','ASC')->get()->groupBy('menu_pai');@endphp
          @else
            @php $menus = Auth::user()->menu()->groupBy('menu_pai');@endphp
          @endif
          @foreach($menus as $menu_pai => $menus)
              <li class="nav-item dropdown">
            <a id="{{$menu_pai}}" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
              {{ $menu_pai }}
            </a>

            <div class="dropdown-menu dropdown-menu-left" aria-labelledby="{{$menu_pai}}">
               @foreach($menus as $menu)
                  @if($menu->menu)
                    <a class="dropdown-item" href="{{$menu->rota}}">{{$menu->rotulo}}</a>
                  @endif
                @endforeach
            </div>
          </li>
            @endforeach
        @endif

    </div>
    <ul class="navbar-nav ml-auto">
      <!-- Authentication Links -->
      @guest
      <li class="nav-item">
        <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
      </li>
      @if (Route::has('register'))
      <li class="nav-item">
        <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
      </li>
      @endif
      @else
      <li class="nav-item dropdown">
        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
          {{ Auth::user()->pessoa->nome }} -
          @foreach(Auth::user()->perfis as $perfil)
            @if($loop->last)
              {{ $perfil->descricao }}  
            @else
              {{ $perfil->descricao }} |
            @endif
          @endforeach
          <span class="caret"></span>
        </a>

        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="{{ route('logout') }}"
          onclick="event.preventDefault();
          document.getElementById('logout-form').submit();">
          <i data-feather="log-out"></i> {{ __('Logout') }}
        </a>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
          @csrf
        </form>
      </div>
    </li>
    @endguest
  </ul>
</nav>
 
    @if(session('sucesso'))
    <div class="container-fluid mt-3">
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <p>{{session('sucesso')}}</p>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
    </div>
    </div>
@endif
@if(session('erro'))
 <div class="container-fluid mt-3">
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <p>{{session('erro')}}</p>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
    </div>
    </div>
@endif
  

<div class="container-fluid h-100 d-flex flex-column mt-3">
  @yield('conteudo')
</div>

<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.js"></script>
<script src="/js/bootstrap-datepicker.pt-BR.js" charset="UTF-8"></script>
<!-- Latest compiled and minified JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>

<!-- (Optional) Latest compiled and minified JavaScript translation files -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/i18n/defaults-pt_BR.min.js"></script>

<script>
  $(function () {
    feather.replace();
    $('.input-daterange').datepicker({
      autoclose: true,
      language : 'pt-BR',
      clearBtn : true,
      todayHighlight : true,
      format: "dd/mm/yyyy",
    });
    //$('[data-toggle="tooltip"]').tooltip();
    $('.my-select').selectpicker();
    $('.custom-file-input').on('change', function() { 
        let fileName = $(this).val().split('\\').pop(); 
        $(this).next('.custom-file-label').addClass("selected").html(fileName); 
    });
  })
  
</script>

</body>
</html>