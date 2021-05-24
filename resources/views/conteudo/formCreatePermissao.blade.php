@extends('layouts.app')

@section('conteudo')
<div class="panel panel-default">
	<div class="panel-heading">
		<h4>Cadastro de Conteúdo Vinculado ao Perfil {{ $perfil->descricao }}</h4>
	</div>
	<div class="panel-body">
		<form class="form-horizontal" role="form" method="POST" action="{{ url('/permissao/create') }}">
			{{ csrf_field() }}
			
			<input type="hidden" name="perfil_id" value="{{$perfil->id}}">

			<div class="form-group{{ $errors->has('rota') ? ' has-error' : '' }}">
				<label for="rota" class="col-sm-4 col-md-4 control-label">Rota</label>

				<div class="col-sm-4 col-md-6">
					<input id="rota" type="text" class="form-control" name="rota" value="{{ old('rota') }}" required autofocus>

					@if ($errors->has('rota'))
						<span class="help-block">
							<strong>{{ $errors->first('rota') }}</strong>
						</span>
					@endif
				</div>
			</div>

			<div class="form-group{{ $errors->has('rotulo') ? ' has-error' : '' }}">
				<label for="rotulo" class="col-sm-4 col-md-4 control-label">Rótulo</label>

				<div class="col-sm-4 col-md-6">
					<input id="rotulo" type="text" class="form-control" name="rotulo" value="{{ old('rotulo') }}" required>

					@if ($errors->has('rotulo'))
						<span class="help-block">
							<strong>{{ $errors->first('rotulo') }}</strong>
						</span>
					@endif
				</div>
			</div>

			<div class="form-group{{ $errors->has('publica') ? ' has-error' : '' }}">
				<label for="publica" class="col-sm-4 col-md-4 control-label">
					Visibilidade Pública
				</label>
				<div class="col-sm-4 col-md-6">
					<input type="checkbox" id="publica" name="publica" {{ old('publica')? "checked": "" }}>

					@if ($errors->has('publica'))
						<span class="help-block">
							<strong>{{ $errors->first('publica') }}</strong>
						</span>
					@endif
				</div>
			</div>

			<div class="form-group{{ $errors->has('menu') ? ' has-error' : '' }}">
				<label for="menu" class="col-sm-4 col-md-4 control-label">
					Exibir no Menu
				</label>
				<div class="col-sm-4 col-md-6">
					<input type="checkbox" id="menu" name="menu" {{ old('menu')? "checked": "" }}>

					@if ($errors->has('menu'))
						<span class="help-block">
							<strong>{{ $errors->first('menu') }}</strong>
						</span>
					@endif
				</div>
			</div>
			
			<hr>
			<h4 class="col-sm-offset-2 col-md-offset-2">Permissões</h4>
			
			<div class="form-group{{ $errors->has('visualizar') ? ' has-error' : '' }}">
				<label for="visualizar" class="col-sm-4 col-md-4 control-label">
					O usuário pode visualizar
				</label>	
				<div class="col-sm-4 col-md-6">
					<input type="checkbox" id="visualizar" name="visualizar" {{ old('visualizar')? "checked": "" }}>

					@if ($errors->has('visualizar'))
						<span class="help-block">
							<strong>{{ $errors->first('visualizar') }}</strong>
						</span>
					@endif
				</div>
			</div>

			<div class="form-group{{ $errors->has('inserir') ? ' has-error' : '' }}">
				<label for="inserir" class="col-sm-4 col-md-4 control-label">
					O usuário pode inserir
				</label>
				<div class="col-sm-4 col-md-6">
					<input type="checkbox" id="inserir" name="inserir" {{ old('inserir')? "checked": "" }}>

					@if ($errors->has('inserir'))
						<span class="help-block">
							<strong>{{ $errors->first('inserir') }}</strong>
						</span>
					@endif
				</div>
			</div>

			<div class="form-group{{ $errors->has('alterar') ? ' has-error' : '' }}">
				<label for="alterar" class="col-sm-4 col-md-4 control-label">
					O usuário pode alterar
				</label>
				<div class="col-sm-4 col-md-6">
					<input type="checkbox" id="alterar" name="alterar" {{ old('alterar')? "checked": "" }}>

					@if ($errors->has('alterar'))
						<span class="help-block">
							<strong>{{ $errors->first('alterar') }}</strong>
						</span>
					@endif
				</div>
			</div>

			<div class="form-group{{ $errors->has('excluir') ? ' has-error' : '' }}">
				<label for="excluir" class="col-sm-4 col-md-4 control-label">
					O usuário pode excluir
				</label>
				<div class="col-sm-4 col-md-6">
					<input type="checkbox" id="excluir" name="excluir" {{ old('excluir')? "checked": "" }}>

					@if ($errors->has('excluir'))
						<span class="help-block">
							<strong>{{ $errors->first('excluir') }}</strong>
						</span>
					@endif
				</div>
			</div>

			<div class="form-group">
				<div class="col-md-6 col-sm-offset-4 col-md-offset-4">
					<button type="submit" class="btn btn-primary">
						Registrar
					</button>
					<a href="/perfil/permissoes/{{$perfil->id}}" class="btn btn-danger">
						Cancelar
					</a>
				</div>
			</div>
		</form>
	</div>
</div>
@endsection
