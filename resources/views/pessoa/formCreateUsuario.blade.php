@extends('layouts.app')

@section('conteudo')
<div class="panel panel-default">
	<div class="panel-heading">
		<h4>Cadastro de Usuário para {{ $pessoa->nome }}</h4>
	</div>
	<div class="panel-body">
		<form class="form-horizontal" role="form" method="POST" action="{{ url('/pessoa/usuario/create') }}">
			{{ csrf_field() }}
			<input type="hidden" name="pessoa_id" value="{{ $pessoa->id }}">

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
					<input id="email" type="email" class="form-control" name="email" value="{{ old('email')? old('email'): $pessoa->email }}" required>

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
					<a href="\pessoa\usuarios\{{ $pessoa->id }}" class="btn btn-danger">
						Cancelar
					</a>
				</div>
			</div>
		</form>
	</div>
</div>
@endsection
