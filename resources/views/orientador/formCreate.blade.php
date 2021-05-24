@extends('layouts.app')

@section('conteudo')
<div class="jumbotron">
	@if(!empty($orientador))
	<h1 class="display-4">Editando orientador {{$orientador->nome}}</h1>
	<p class="lead">Página para edição de evento</p>
	@else
	<h1 class="display-4">Cadastro de Orientador</h1>
	@endif

	<hr class="my-4">
	<form class="form-horizontal d-flex flex-column" method="POST" action="{{route('orientador.store')}}">
		@if(!empty($orientador))
			@method('put')
		@endif
		@csrf

		<div class="form-group row">
			<label for="instituicao_id" class="col-12 col-form-label">Instituição*</label>
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
			<label for="nome" class="col-12 col-form-label">Nome*</label>
			<input id="nome" type="text" class="form-control col-12" name="nome" value="{{ old('nome') }}" autofocus>
				@if(count($errors)>0)
				<div class="text-danger">			 
					<li style="list-style-type:none">{{$errors->first('nome')}}</li>
				</div>
				@endif
		</div>
		<div class="form-group row">
			<label for="email"  class="col-12 col-form-label">Email*</label>
			<input id="email" type="email" class="form-control col-12" name="email" value="{{ old('email') }}" autofocus>

			@if ($errors->has('email'))
			<span class="help-block">
				<strong>{{ $errors->first('email') }}</strong>
			</span>
			@endif
		</div>
		<!--<div class="row">
		<div class="form-group col-6">
			<label for="sexo">Sexo</label>

			<div class="radio">
				<label><input id="sexo" type="radio" value="M" name="sexo" autofocus> Masculino</label>
				<label><input id="sexo" type="radio" value="F" name="sexo" autofocus> Feminino</label>

				@if(count($errors)>0)
				<div class="text-danger">			 
					<li style="list-style-type:none">{{$errors->first('sexo')}}</li>
				</div>
				@endif
			</div>
		</div>
		<div class="form-group col-6">
			<label for="cpf" >CPF*</label>
			<input id="cpf" type="text" class="form-control" name="cpf" value="{{ old('cpf') }}" autofocus>

			@if ($errors->has('cpf'))
				<span class="help-block">
					<strong>{{ $errors->first('cpf') }}</strong>
				</span>
			@endif
			
		</div>
		
		<div class="form-group col-6">
			<label for="data_nascimento" class="col-sm-4 col-md-3 control-label">Data de Nascimento</label>

			<input id="data_nascimento" type="date" class="form-control" name="data_nascimento" value="{{ old('data_nascimento') }}" autofocus>

				@if ($errors->has('data_nascimento'))
				<span class="help-block">
					<strong>{{ $errors->first('data_nascimento') }}</strong>
				</span>
				@endif
			
		</div>
		</div>-->
		
		<div class="form-group row">
			<label for="telefone_1"  class="col-12 col-form-label">Telefone</label>

			<input id="telefone_1" type="text" class="form-control col-12" name="telefone_1" value="{{ old('telefone_1') }}" autofocus>

			@if(count($errors)>0)
				<div class="text-danger">			 
					<li style="list-style-type:none">{{$errors->first('telefone_1')}}</li>
				</div>
				@endif
			
		</div>
		
			<x-form-buttons :route="'pessoa/orientador'"/>
	</form>
</div>
@endsection
