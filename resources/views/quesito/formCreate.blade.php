@extends('layouts.app')

@section('conteudo')
<div class="jumbotron">
  <h1 class="display-4">Cadastro de Quesito em {{$evento->titulo}}</h1>
  <hr class="my-4">
	<form class="form-horizontal d-flex flex-column" action="{{route('quesito.store')}}" method="POST">
		@csrf
		<input type="hidden" name="evento_id" value="{{ $evento->id }}" />
		
		<div class="form-group row">
    			<label class="col-2 col-form-label" for="cientifico">Quesito científico</label>
    			<input type="text" class="form-control col-10" id="cientifico"  placeholder="Digite o quesito cientifico" name="cientifico" required value="{{ old('cientifico') }}">
    			@if(count($errors)>0)
					<div class="text-danger">			
						<li style="list-style-type:none">{{$errors->first('cientifico')}}</li>
					</div>
				@endif
  		</div>

  		<div class="form-group row">
    			<label class="col-2 col-form-label" for="tecnologico">Quesito tecnológico</label>
    			<input type="text" class="form-control col-10" id="tecnologico"  placeholder="Digite o quesito tecnológico" name="tecnologico" required value="{{ old('tecnologico') }}">
    			@if(count($errors)>0)
					<div class="text-danger">			
						<li style="list-style-type:none">{{$errors->first('tecnologico')}}</li>
					</div>
				@endif
  		</div>

		<div class="form-group row">
		  <label class="col-2 col-form-label" for="peso">Peso</label>  
		  <input id="peso" name="peso" type="number" min="0" placeholder="Peso do Quesito" class="form-control col-10" value="{{ old('peso') }}" min="1" max="10" step="1">
		  	@if(count($errors)>0)
		  	 	<div class="text-danger">			
					<li style="list-style-type:none">{{$errors->first('peso')}}</li>
				</div>
			@endif	
		</div>
		<x-form-buttons :route="'quesito'"/>	
	</form>
</div>

@stop