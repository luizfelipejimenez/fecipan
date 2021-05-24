@extends('layouts.app')

@section('conteudo')
	<div class="jumbotron">
  		<h1 class="display-4">Cadastro de Avaliador</h1>
  		<hr class="my-4">
		<form class="form-horizontal d-flex flex-column" method="POST" action="{{route('avaliador.store')}}">
			@csrf

			<div class="form-group row">
				<label for="nome">Nome</label>
				<input id="nome" type="text" class="form-control @error('nome') is-invalid @enderror" name="nome" value="{{ old('nome') }}" autofocus>
				<div id="nomeFeedback" class="invalid-feedback">
        				{{$errors->first('nome')}}
      	  		</div>
			</div>
			<div class="form-group row">
				<label for="cpf" >CPF</label>
				<input id="cpf" type="text" class="form-control @error('cpf') is-invalid @enderror" name="cpf" value="{{ old('cpf') }}" autofocus>
				<div id="cpfFeedback" class="invalid-feedback">
        			{{$errors->first('cpf')}}
      	  		</div>
			</div>

			<div class="form-group row">
				<label for="instituicao_id">Instituição</label>
					<select id="instituicao_id" name="instituicao_id" data-placeholder="Escolha a instituição de ensino..." class="chosen-select form-control @error('instituicao_id') is-invalid @enderror">
						<option value=""></option>
						@foreach ($instituicoes as $instituicao)
							<option value="{{ $instituicao->id }}">{{ $instituicao->sigla }} - {{ $instituicao->nome }}</option>
						@endforeach
					</select>
					<div id="instituicao_idFeedback" class="invalid-feedback">
        				{{$errors->first('instituicao_id')}}
      	  			</div>
			</div>

			<div class="row">
				<div class="col-6">
					<div class="form-group row">
						<label for="area">Área</label>
						<input id="area" type="text" class="form-control @error('area') is-invalid @enderror" name="area" value="{{ old('area') }}" autofocus>
						<div id="areaFeedback" class="invalid-feedback">
		        				{{$errors->first('area')}}
      	  				</div>
					</div>
				</div>
				<div class="col-6">
					<label for="sexo">Sexo</label>
					<div class="form-group">
						<div class="form-check form-check-inline">
							<label class="form-check-label">
							<input id="sexo" type="checkbox" value="M" name="sexo" autofocus class="@error('sexo') is-invalid @enderror form-check-input"> Masculino</label>
						</div>
						<div class="form-check form-check-inline">
							<label class="form-check-label">
							<input id="sexo" type="checkbox" value="F" name="sexo" autofocus class="@error('sexo') is-invalid @enderror form-check-input" > Feminino</label>
						</div>
						<div id="sexoFeedback" class="invalid-feedback">
        					{{$errors->first('sexo')}}
      	  				</div>
					</div>
				</div>
			</div>
			<div class="form-group row">
				<label for="email">Email</label>
				<input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" autofocus>
				<div id="emailFeedback" class="invalid-feedback">
        			{{$errors->first('email')}}
      	  		</div>
			</div>
			<div class="form-group row">
				<label for="telefone_1">Telefone</label>
				<input id="telefone_1" type="text" class="form-control @error('telefone_1') is-invalid @enderror" name="telefone_1" value="{{ old('telefone_1') }}" autofocus>
				<div id="telefone_1Feedback" class="invalid-feedback">
        			{{$errors->first('telefone_1')}}
      	  		</div>
			</div>
			<x-form-buttons :route="'pessoa/avaliador'"/>
		</form>
	</div>
@endsection
