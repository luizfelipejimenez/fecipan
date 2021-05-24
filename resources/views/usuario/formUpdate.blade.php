@extends('layouts.app')

@section('conteudo')
<div class="panel panel-default">
	<div class="panel-heading">
		<h4>
			Alteração de Dados do Usuário {{ $usuario->pessoa->nome }}
		</h4>
		<strong>Perfil:</strong> {{ $usuario->perfil->descricao }}
	</div>
	<div class="panel-body">
		<form class="form-horizontal" role="form" method="POST" action="{{ url('/usuario/update') }}">
			{{ csrf_field() }}
			<input type="hidden" name="usuario_id" value="{{ $usuario->id }}">
			<div class="form-group{{ $errors->has('nome') ? ' has-error' : '' }}">
				<label for="nome" class="col-sm-4 col-md-3 control-label">Nome</label>

				<div class="col-sm-8 col-md-6">
					<input id="nome" type="text" class="form-control" name="nome" value="{{ old('nome')? old('nome'): $usuario->pessoa->nome }}" required autofocus>

					@if ($errors->has('nome'))
						<span class="help-block">
							<strong>{{ $errors->first('nome') }}</strong>
						</span>
					@endif
				</div>
			</div>

			<div class="form-group{{ $errors->has('cpf') ? ' has-error' : '' }}">
				<label for="cpf" class="col-sm-4 col-md-3 control-label">CPF</label>

				<div class="col-sm-4 col-md-3 ">
					<input id="cpf" type="text" class="form-control" name="cpf" value="{{ old('cpf')? old('cpf'): $usuario->pessoa->cpf }}">

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
						<input id="sexo" type="radio" value="F" name="sexo" {{ $usuario->pessoa->sexo == 'F'? 'checked': '' }}>
						Feminino
					</label>
					<label class="label-inline">
						<input id="sexo" type="radio" value="M" name="sexo" {{ $usuario->pessoa->sexo == 'M'? 'checked': '' }}>
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
					<input id="data_nascimento" type="date" class="form-control" name="data_nascimento" value="{{ old('data_nascimento')? old('data_nascimento'): $usuario->pessoa->data_nascimento }}">

					@if ($errors->has('data_nascimento'))
						<span class="help-block">
							<strong>{{ $errors->first('data_nascimento') }}</strong>
						</span>
					@endif
				</div>
			</div>

			<div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
				<label for="email" class="col-sm-4 col-md-3 control-label">E-Mail</label>

				<div class="col-sm-8 col-md-6">
					<input id="email" type="email" class="form-control" name="email" value="{{ old('email')? old('email'): $usuario->pessoa->email }}" required>

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
					<input id="login" type="text" class="form-control" name="login" value="{{ old('login')? old('login'): $usuario->login }}" required>

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
					<input id="password" type="password" class="form-control" name="password">

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
					<input id="password-confirm" type="password" class="form-control" name="password_confirmation">
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
