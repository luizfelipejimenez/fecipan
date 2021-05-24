@extends('layouts.app')

@section('conteudo')
<div class="panel panel-default">
	<div class="panel-heading">
		<h4>Cadastro de Perfil Vinculado a "{{ $perfil_pai->descricao }}"</h4>
	</div>
	<div class="panel-body">
		<form class="form-horizontal" role="form" method="POST" action="{{ url('/perfil/create') }}">
			{{ csrf_field() }}

			<input id="perfil_pai" type="hidden" name="perfil_pai" value="{{ $perfil_pai->id }}">

			<div class="form-group{{ $errors->has('descricao') ? ' has-error' : '' }}">
				<label for="descricao" class="col-sm-4 col-md-3 control-label">Descrição</label>

				<div class="col-sm-8 col-md-6">
					<input id="descricao" type="text" class="form-control" name="descricao" value="{{ old('descricao') }}" autofocus>

					@if ($errors->has('descricao'))
						<span class="help-block">
							<strong>{{ $errors->first('descricao') }}</strong>
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
