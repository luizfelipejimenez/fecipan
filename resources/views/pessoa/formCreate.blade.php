@extends('layouts.app')

@section('conteudo')
<div class="panel panel-default">
	<div class="panel-heading">
		<h4>Cadastro de Pessoa</h4>
	</div>
	<div class="panel-body">
		<form class="form-horizontal" role="form" method="POST" action="{{ url('/pessoa/create') }}">
			{{ csrf_field() }}

			<div class="form-group{{ $errors->has('nome') ? ' has-error' : '' }}">
				<label for="nome" class="col-sm-4 col-md-3 control-label">Nome</label>

				<div class="col-sm-8 col-md-6">
					<input id="nome" type="text" class="form-control" name="nome" value="{{ old('nome') }}" autofocus>

					@if ($errors->has('nome'))
						<span class="help-block">
							<strong>{{ $errors->first('nome') }}</strong>
						</span>
					@endif
				</div>
			</div>
			<div class="form-group{{ $errors->has('sexo') ? ' has-error' : '' }}">
				<label for="sexo" class="col-sm-4 col-md-3 control-label">Sexo</label>

				<div class="col-sm-8 col-md-6 radio">
					<label><input id="sexo" type="radio" value="M" name="sexo" autofocus> Masculino</label>
					<label><input id="sexo" type="radio" value="F" name="sexo" autofocus> Feminino</label>

					@if ($errors->has('sexo'))
						<span class="help-block">
							<strong>{{ $errors->first('sexo') }}</strong>
						</span>
					@endif
				</div>
			</div>
			<div class="form-group{{ $errors->has('cpf') ? ' has-error' : '' }}">
				<label for="cpf" class="col-sm-4 col-md-3 control-label">CPF</label>

				<div class="col-sm-4 col-md-3">
					<input id="cpf" type="text" class="form-control" name="cpf" value="{{ old('cpf') }}" autofocus>

					@if ($errors->has('cpf'))
						<span class="help-block">
							<strong>{{ $errors->first('cpf') }}</strong>
						</span>
					@endif
				</div>
			</div>
			<div class="form-group{{ $errors->has('data_nascimento') ? ' has-error' : '' }}">
				<label for="data_nascimento" class="col-sm-4 col-md-3 control-label">Data de Nascimento</label>

				<div class="col-sm-4 col-md-3">
					<input id="data_nascimento" type="date" class="form-control" name="data_nascimento" value="{{ old('data_nascimento') }}" autofocus>

					@if ($errors->has('data_nascimento'))
						<span class="help-block">
							<strong>{{ $errors->first('data_nascimento') }}</strong>
						</span>
					@endif
				</div>
			</div>
			<div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
				<label for="email" class="col-sm-4 col-md-3 control-label">Email</label>

				<div class="col-sm-8 col-md-6">
					<input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" autofocus>

					@if ($errors->has('email'))
						<span class="help-block">
							<strong>{{ $errors->first('email') }}</strong>
						</span>
					@endif
				</div>
			</div>
			<div class="form-group{{ $errors->has('telefone_1') ? ' has-error' : '' }}">
				<label for="telefone_1" class="col-sm-4 col-md-3 control-label">Telefone 1</label>

				<div class="col-sm-6 col-md-4">
					<input id="telefone_1" type="text" class="form-control" name="telefone_1" value="{{ old('telefone_1') }}" autofocus>

					@if ($errors->has('telefone_1'))
						<span class="help-block">
							<strong>{{ $errors->first('telefone_1') }}</strong>
						</span>
					@endif
				</div>
			</div>
			<div class="form-group{{ $errors->has('telefone_2') ? ' has-error' : '' }}">
				<label for="telefone_2" class="col-sm-4 col-md-3 control-label">Telefone 2</label>

				<div class="col-sm-6 col-md-4">
					<input id="telefone_2" type="text" class="form-control" name="telefone_2" value="{{ old('telefone_2') }}" autofocus>

					@if ($errors->has('telefone_2'))
						<span class="help-block">
							<strong>{{ $errors->first('telefone_2') }}</strong>
						</span>
					@endif
				</div>
			</div>

			<div class="form-group">
				<div class="col-md-6 col-sm-offset-4 col-md-offset-3">
					<button type="submit" class="btn btn-primary">
						Registrar
					</button>
					<a href="\perfil" class="btn btn-danger">
						Cancelar
					</a>
				</div>
			</div>
		</form>
	</div>
</div>
@endsection
