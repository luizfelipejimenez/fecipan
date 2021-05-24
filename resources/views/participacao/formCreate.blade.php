@extends('layouts.app')

@section('conteudo')

<div class="jumbotron">
	<h1 class="display-4">Associar Estudante ao Trabalho {{ $trabalho->cod }} </h1>
	<p class="lead">{{ $trabalho->titulo }}</p>
	<hr class="my-4">
	<form class="form-horizontal d-flex flex-column" action="{{route('participacao.store')}}" method="POST">
		@csrf
		<input type="hidden" name="trabalho_id" value="{{ $trabalho->id }}" />
		<div class="form-group row">
		  <label class="col-12 col-form-label" for="estudantes">Estudantes</label>  
		  <select id="estudantes" name="estudantes[]" title="Selecione os estudantes..." multiple class="selectpicker col-12" required data-live-search="true">
				@foreach ($estudantes as $estudante)
				<option value="{{ $estudante->id }}">{{ $estudante->instituicao->sigla }} - {{ $estudante->pessoa->nome }}</option>
				@endforeach
			</select>
		  	@if(count($errors)>0)
		  	 	<div class="text-danger">			
					<li style="list-style-type:none">{{$errors->first('estudantes')}}</li>
				</div>
			@endif	
		</div>
		@php $url = "trabalho/estudantes/".$trabalho->id; @endphp
		
		<x-form-buttons :route="$url"/>
	</form>
	</div>

@stop