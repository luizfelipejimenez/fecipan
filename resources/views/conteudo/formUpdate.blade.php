@extends('layouts.app')

@section('conteudo')
<div class="panel panel-default">
	<div class="panel-heading">
		<h4>Alteração do Conteúdo #{{ $conteudo->id }}</h4>
	</div>
	<div class="panel-body">
		<form class="form-horizontal" role="form" method="POST" action="{{ url('/conteudo/update') }}">
			{{ csrf_field() }}
			
			<input type="hidden" name="conteudo_id" value="{{ $conteudo->id }}">

			<div class="form-group{{ $errors->has('rota') ? ' has-error' : '' }}">
				<label for="rota" class="col-md-3 col-sm-4 control-label">Rota</label>

				<div class="col-md-6">
					<input id="rota" type="text" class="form-control" name="rota" value="{{ $conteudo->rota }}" required autofocus>

					@if ($errors->has('rota'))
						<span class="help-block">
							<strong>{{ $errors->first('rota') }}</strong>
						</span>
					@endif
				</div>
			</div>

			<div class="form-group{{ $errors->has('rotulo') ? ' has-error' : '' }}">
				<label for="rotulo" class="col-md-3 col-sm-4 control-label">Rótulo</label>

				<div class="col-md-6">
					<input id="rotulo" type="text" class="form-control" name="rotulo" value="{{ $conteudo->rotulo }}" required>

					@if ($errors->has('rotulo'))
						<span class="help-block">
							<strong>{{ $errors->first('rotulo') }}</strong>
						</span>
					@endif
				</div>
			</div>

			<div class="form-group{{ $errors->has('publica') ? ' has-error' : '' }}">
				<label for="publica" class="col-md-3 col-sm-4 control-label">
					Visibilidade Pública
				</label>
				<div class="col-md-6">
					<input type="checkbox" id="publica" name="publica" {{ $conteudo->publica? "checked": "" }}>

					@if ($errors->has('publica'))
						<span class="help-block">
							<strong>{{ $errors->first('publica') }}</strong>
						</span>
					@endif
				</div>
			</div>

			<div class="form-group{{ $errors->has('menu') ? ' has-error' : '' }}">
				<label for="menu" class="col-md-3 col-sm-4 control-label">
					Exibir no Menu
				</label>
				<div class="col-md-6">
					<input type="checkbox" id="menu" name="menu" {{ $conteudo->menu? "checked": "" }}>

					@if ($errors->has('menu'))
						<span class="help-block">
							<strong>{{ $errors->first('menu') }}</strong>
						</span>
					@endif
				</div>
			</div>

			<div class="form-group">
				<div class="col-md-6 col-sm-offset-4 col-md-offset-3">
					<button type="submit" class="btn btn-primary">
						Editar
					</button>
					<a href="\conteudo" class="btn btn-danger">
						Cancelar
					</a>
				</div>
			</div>
		</form>
	</div>
</div>
@endsection
