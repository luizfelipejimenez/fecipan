@extends('layouts.app')

@section('conteudo')
<div class="container-fluid">
    <div class="alert alert-danger" role="alert">
        <i data-feather="alert-triangle"></i>
        Para utilizar o sistema é necessário que você crie uma nova senha de acesso. Este procedimento só é exigido uma vez. 
    </div>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card  bg-transparent mb-3">
                <div class="card-header text-white bg-success"><img src="/imagens/nav-logo.svg" height="30" class="d-inline-block align-top" alt="" loading="lazy"> {{ __('Criar nova Senha') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('auth.salvarSenha') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="senha" class="col-md-4 col-form-label text-md-right">{{ __('Senha') }}</label>

                            <div class="col-md-6">
                                <input id="senha" type="password" class="form-control @error('senha') is-invalid @enderror" name="senha" required autocomplete="new-senha">

                                @error('senha')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="senha-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirme sua Senha') }}</label>

                            <div class="col-md-6">
                                <input id="senha-confirm" type="password" class="form-control" name="senha_confirmation" required autocomplete="new-senha">
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-outline-success btn-lg btn-block">
                                    {{ __('Criar nova Senha') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
