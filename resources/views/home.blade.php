@extends('layouts.app')

@section('conteudo')
<div class="row vh-100">
    <div class="col">
        <div class="jumbotron text-center text-white bg-success h-75">
          <h1 class="display-4">
            <img src="/imagens/nav-logo.svg" class="h-100" class="d-inline-block align-top" alt="" loading="lazy"> 
                FrEvO - IFMS
          </h1>
          <p class="lead">Framework para Gerenciamento e Controle de Eventos do IFMS</p>
          <hr class="my-4">
          <p>
            @if (Auth::check())
                    Olá, {{ Auth::user()->pessoa->nome }} 
                    ( @foreach(Auth::user()->perfis as $perfil)
                        @if($loop->last)
                          {{ $perfil->descricao }}  
                        @else
                          {{ $perfil->descricao }} |
                        @endif
                        @endforeach)
                    <i data-feather="user"></i> 
                @else
                    Você precisa estar logado para acessar as partes privadas do sistema
                @endif
            </p>
      </div>

        
    </div>
    </div>
@endsection
