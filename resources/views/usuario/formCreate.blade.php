@extends('layouts.app')

@section('conteudo')
<div class="panel panel-default">
	<div class="panel-heading">
		<h4>
			Cadastro de Usuário
			@if ($perfis->count() == 1)
				com Perfil de {{ $perfis[0]->descricao }}
			@endif
		</h4>
	</div>
	<div class="panel-body">
		<form class="form-horizontal" role="form" method="POST" action="{{ url('/usuario/create') }}">
			{{ csrf_field() }}

			<div class="form-group{{ $errors->has('nome') ? ' has-error' : '' }}">
				<label for="nome" class="col-sm-4 col-md-3 control-label">Nome</label>

				<div class="col-sm-8 col-md-6">
					<input id="nome" type="text" class="form-control" name="nome" value="{{ old('nome') }}" required autofocus>

					@if ($errors->has('nome'))
						<span class="help-block">
							<strong>{{ $errors->first('nome') }}</strong>
						</span>
					@endif
				</div>
			</div>

			<div class="form-group{{ $errors->has('instituicao_id') ? ' has-error' : '' }}">
				<label for="instituicao_id" class="col-sm-4 col-md-3 control-label">Instituicao</label>

				<div class="col-sm-4 col-md-3">
					<select id="instituicao_id" class="form-control" name="instituicao_id">
						<option>Selecione...</option>
						@foreach ($instituicoes as $instituicao)
						<option value="{{ $instituicao->id }}" {{ old('instituicao_id') == $instituicao->id? 'selected': '' }}>
							{{ $instituicao->nome }}
						</option>
						@endforeach                                    
					</select>

					@if ($errors->has('perfil_id'))
						<span class="help-block">
							<strong>{{ $errors->first('perfil_id') }}</strong>
						</span>
					@endif
				</div>
			</div>
			<div class="form-group{{ $errors->has('area') ? ' has-error' : '' }}">
				<label for="cpf" class="col-sm-4 col-md-3 control-label">Área</label>

				<div class="col-sm-4 col-md-3 ">
					<input id="area" type="text" class="form-control" name="area" value="{{ old('area') }}" required>

					@if ($errors->has('area'))
						<span class="help-block">
							<strong>{{ $errors->first('area') }}</strong>
						</span>
					@endif
				</div>
			</div>

			<div class="form-group{{ $errors->has('cpf') ? ' has-error' : '' }}">
				<label for="cpf" class="col-sm-4 col-md-3 control-label">CPF</label>

				<div class="col-sm-4 col-md-3 ">
					<input id="cpf" type="text" class="form-control" name="cpf" value="{{ old('cpf') }}" required>

					@if ($errors->has('cpf'))
						<span class="help-block">
							<strong>{{ $errors->first('cpf') }}</strong>
						</span>
					@endif
				</div>
			</div>

			<div class="form-group{{ $errors->has('sexo') ? ' has-error' : '' }}">
				<label class="col-sm-4 col-md-3 control-label">Sexo</label>

				<div class="col-sm-4 col-md-3">
					<label class="label-inline">
						<input id="sexo" type="radio" value="F" name="sexo" {{ old('sexo') == 'F'? 'checked': '' }}>
						Feminino
					</label>
					<label class="label-inline">
						<input id="sexo" type="radio" value="M" name="sexo" {{ old('sexo') == 'M'? 'checked': '' }}>
						Masculino
					</label>

					@if ($errors->has('sexo'))
						<span class="help-block">
							<strong>{{ $errors->first('sexo') }}</strong>
						</span>
					@endif
				</div>
			</div>

			<div class="form-group{{ $errors->has('data_nascimento') ? ' has-error' : '' }}">
				<label for="data_nascimento" class="col-sm-4 col-md-3 control-label">Data de Nascimento</label>

				<div class="col-sm-4 col-md-3">
					<input id="data_nascimento" type="date" class="form-control" name="data_nascimento" value="{{ old('data_nascimento') }}">

					@if ($errors->has('data_nascimento'))
						<span class="help-block">
							<strong>{{ $errors->first('data_nascimento') }}</strong>
						</span>
					@endif
				</div>
			</div>

			@if ($perfis->count() == 1)
			<input type="hidden" name="perfil_id" value="{{$perfis[0]->id}}">
			@else
			<div class="form-group{{ $errors->has('perfil_id') ? ' has-error' : '' }}">
				<label for="perfil_id" class="col-sm-4 col-md-3 control-label">Perfil</label>

				<div class="col-sm-4 col-md-3">
					<select id="perfil_id" class="form-control" name="perfil_id">
						<option>Selecione...</option>
						@foreach ($perfis as $perfil)
						<option value="{{ $perfil->id }}" {{ old('perfil_id') == $perfil->id? 'selected': '' }}>
							{{ $perfil->descricao }}
						</option>
						@endforeach                                    
					</select>

					@if ($errors->has('perfil_id'))
						<span class="help-block">
							<strong>{{ $errors->first('perfil_id') }}</strong>
						</span>
					@endif
				</div>
			</div>
			@endif

			<div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
				<label for="email" class="col-sm-4 col-md-3 control-label">E-Mail</label>

				<div class="col-sm-8 col-md-6">
					<input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

					@if ($errors->has('email'))
						<span class="help-block">
							<strong>{{ $errors->first('email') }}</strong>
						</span>
					@endif
				</div>
			</div>

			<div class="form-group{{ $errors->has('login') ? ' has-error' : '' }}">
				<label for="login" class="col-sm-4 col-md-3 control-label">Login</label>

				<div class="col-sm-6 col-md-4">
					<input id="login" type="text" class="form-control" name="login" value="{{ old('login') }}" required>

					@if ($errors->has('login'))
						<span class="help-block">
							<strong>{{ $errors->first('login') }}</strong>
						</span>
					@endif
				</div>
			</div>

			<div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
				<label for="password" class="col-sm-4 col-md-3 control-label">Senha</label>

				<div class="col-sm-6 col-md-4">
					<input id="password" type="password" class="form-control" name="password" required>

					@if ($errors->has('password'))
						<span class="help-block">
							<strong>{{ $errors->first('password') }}</strong>
						</span>
					@endif
				</div>
			</div>

			<div class="form-group">
				<label for="password-confirm" class="col-sm-4 col-md-3 control-label">Confirmar Senha</label>

				<div class="col-sm-6 col-md-4">
					<input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
				</div>
			</div>

			<div class="form-group">
				<div class="col-md-6 col-sm-offset-4 col-md-offset-3">
					<button type="submit" class="btn btn-primary">
						Registrar
					</button>
					<a href="\usuario" class="btn btn-danger">
						Cancelar
					</a>
				</div>
			</div>
		</form>
	</div>
</div>
@endsection
