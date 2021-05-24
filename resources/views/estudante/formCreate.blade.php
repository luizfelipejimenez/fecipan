@extends('layouts.app')

@section('conteudo')

<div class="jumbotron">
	<h1 class="display-4">Cadastro de Estudante</h1>
		<hr class="my-4">
		<form class="form-horizontal d-flex flex-column" method="POST" action="{{ route('estudante.store') }}">
			@csrf

			<div class="form-group row">
				<label for="nome" class="col-12 col-form-label">Nome*</label>

				<input id="nome" type="text" class="form-control col-12" name="nome" value="{{ old('nome') }}" autofocus required>
				@if(count($errors)>0)
					<div class="text-danger">			 
						<li style="list-style-type:none">{{$errors->first('nome')}}</li>
					</div>
				@endif
			</div>
			<div class="form-group row">
				<label for="email" class="col-12 col-form-label">Email*</label>

				
				<input id="email" type="email" class="form-control col-12" name="email" value="{{ old('email') }}" autofocus required>
				@if(count($errors)>0)
						<div class="text-danger">			 
						<li style="list-style-type:none">{{$errors->first('email')}}</li>
						</div>
					@endif
				
			</div>
			<div class="form-group row">
				<label for="instituicao_id" class="col-12 col-form-label">Instituição *</label>
					<select id="instituicao_id" name="instituicao_id" title="Escolha a instituição de ensino..." class="selectpicker col-12" required data-live-search="true">
						@foreach ($instituicoes as $instituicao)
						<option value="{{ $instituicao->id }}">{{ $instituicao->sigla }} - {{ $instituicao->nome }}</option>
						@endforeach
					</select>

					@if(count($errors)>0)
						<div class="text-danger">			 
						<li style="list-style-type:none">{{$errors->first('instituicao_id')}}</li>
						</div>
					@endif
			</div>
			<div class="form-group row">
				<label for="categoria_id" class="col-12 col-form-label">Categoria*</label>
				<select id="categoria_id" name="categoria_id" title="Escolha a categoria..." class="selectpicker col-12" required >
						@foreach ($categorias as $categoria)
						<option value="{{ $categoria->id }}">{{ $categoria->descricao }}</option>
						@endforeach
					</select>
					@if(count($errors)>0)
						<div class="text-danger">			 
						<li style="list-style-type:none">{{$errors->first('categoria_id')}}</li>
						</div>
					@endif
			</div>
			
			<!--<div class="form-group{{ $errors->has('ra') ? ' has-error' : '' }}">
				<label for="ra" class="col-sm-4 col-md-3 control-label">RA</label>

				<div class="col-sm-3 col-md-2">
					<input id="ra" type="text" class="form-control" name="ra" value="{{ old('ra') }}" autofocus>

					@if ($errors->has('ra'))
						<span class="help-block">
							<strong>{{ $errors->first('ra') }}</strong>
						</span>
					@endif
				</div>
			</div>-->
			<div class="form-group row">
				<label for="sexo" class="col-12 col-form-label">Sexo</label>

				<div class="col-12 radio">
					<label><input id="sexo" type="radio" value="M" name="sexo" autofocus> Masculino</label>
					<label><input id="sexo" type="radio" value="F" name="sexo" autofocus> Feminino</label>

					@if(count($errors)>0)
						<div class="text-danger">			 
						<li style="list-style-type:none">{{$errors->first('sexo')}}</li>
						</div>
					@endif
				</div>
			</div>
			<!--<div class="form-group{{ $errors->has('cpf') ? ' has-error' : '' }}">
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
			</div>-->
			
			<!--	<div class="form-group{{ $errors->has('telefone_1') ? ' has-error' : '' }}">
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
					<a href="\pessoa\estudantes" class="btn btn-danger">
						Cancelar
					</a>
				</div>
			</div>-->
			<x-form-buttons :route="'pessoa/estudante'"/>
		</form>
	</div>
@endsection
