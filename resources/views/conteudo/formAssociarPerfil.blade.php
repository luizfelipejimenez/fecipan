@extends('layouts.app')

@section('conteudo')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4>Associar Conteúdo {{ $conteudo->rotulo }} a Outros Perfis</h4>
                </div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/conteudo/associar') }}">
                        {{ csrf_field() }}
                        <input type="hidden" name="conteudo_id" value="{{ $conteudo->id }}" readonly required autofocus>
						
                        <div class="form-group{{ $errors->has('rota') ? ' has-error' : '' }}">
                            <label for="rota" class="col-md-4 control-label">Rota</label>

                            <label class="col-md-6 text-info bg-info">
                                {{ $conteudo->rota }}
                            </label>
                        </div>

                        <div class="form-group{{ $errors->has('rotulo') ? ' has-error' : '' }}">
                            <label for="rotulo" class="col-md-4 control-label">Rótulo</label>

                            <label class="col-md-6 text-info bg-info">
                                {{ $conteudo->rotulo }}
                            </label>
                        </div>

                        <div class="form-group{{ $errors->has('publica') ? ' has-error' : '' }}">
                            <label for="publica" class="col-md-4 control-label">
                                Visibilidade Pública
                            </label>
                            <label class="col-md-6 text-info bg-info">
								{{ $conteudo->publica? "Sim": "Não" }}
							</label>
                        </div>

                        <div class="form-group{{ $errors->has('menu') ? ' has-error' : '' }}">
                            <label for="menu" class="col-md-4 control-label">
                                Exibir no Menu
                            </label>
                            <label class="col-md-6 text-info bg-info">
								{{ $conteudo->menu? "Sim": "Não" }}
							</label>
                        </div>
						
						<hr>
						<h4>Escolha o Perfil para Associar</h5>
                        <div class="form-group{{ $errors->has('perfil_id') ? ' has-error' : '' }}">
                            <label for="perfil_id" class="col-md-4 control-label">
                                Perfil
                            </label>
                            <div class="col-md-6">
                                <select id="perfil_id" data-placeholder="Selecione o perfil..." class="chosen-select form-control" name="perfil_id">
									<option value=""></option>
									@foreach($perfis as $perfil)
									<option value="{{$perfil->id}}">{{$perfil->descricao}}</option>
									@endforeach
								</select>
                                @if ($errors->has('perfil_id'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('perfil_id') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
						<hr>
						<h4>Permissões</h5>
						
                        <div class="form-group{{ $errors->has('visualizar') ? ' has-error' : '' }}">
                            <label for="visualizar" class="col-md-4 control-label">
                                O usuário pode visualizar
                            </label>
                            <div class="col-md-6">
                                <input type="checkbox" id="visualizar" name="visualizar" {{ old('visualizar')? "checked": "" }}>

                                @if ($errors->has('visualizar'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('visualizar') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('inserir') ? ' has-error' : '' }}">
                            <label for="inserir" class="col-md-4 control-label">
                                O usuário pode inserir
                            </label>
                            <div class="col-md-6">
                                <input type="checkbox" id="inserir" name="inserir" {{ old('inserir')? "checked": "" }}>

                                @if ($errors->has('inserir'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('inserir') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('alterar') ? ' has-error' : '' }}">
                            <label for="alterar" class="col-md-4 control-label">
                                O usuário pode alterar
                            </label>
                            <div class="col-md-6">
                                <input type="checkbox" id="alterar" name="alterar" {{ old('alterar')? "checked": "" }}>

                                @if ($errors->has('alterar'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('alterar') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('excluir') ? ' has-error' : '' }}">
                            <label for="excluir" class="col-md-4 control-label">
                                O usuário pode excluir
                            </label>
                            <div class="col-md-6">
                                <input type="checkbox" id="excluir" name="excluir" {{ old('excluir')? "checked": "" }}>

                                @if ($errors->has('excluir'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('excluir') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Registrar
                                </button>
                                <a href="/conteudo/permissoes/{{$conteudo->id}}" class="btn btn-danger">
                                    Cancelar
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
