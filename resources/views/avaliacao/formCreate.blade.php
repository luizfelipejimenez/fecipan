@extends('layouts.app')

@section('conteudo')
<div class="jumbotron">
  <h1 class="display-3">Associar Avaliadores ao Trabalho {{ $trabalho->cod }}</h1>
  	<p class="lead">{{ $trabalho->titulo}}</p>
  	<hr class="my-4">
	<form class="form-horizontal d-flex flex-column" action="{{route('avaliacao.store')}}" method="POST">
		@csrf
		<input type="hidden" name="trabalho_id" value="{{ $trabalho->id }}" />
		<div class="form-group row">
		  <label class="col-12 col-form-label" for="avaliadores">Avaliadores</label>  

		  <select id="avaliadores" name="avaliadores[]" title="Selecione os avaliadores..." multiple class="selectpicker col-12" required data-live-search="true">
				@foreach ($avaliadores as $avaliador)
				<option value="{{ $avaliador->id }}">{{ $avaliador->pessoa->nome }} - {{ $avaliador->area }}</option>
				@endforeach
			</select>
		  	@if(count($errors)>0)
		  	 	<div class="text-danger">			
					<li style="list-style-type:none">{{$errors->first('avaliadores')}}</li>
				</div>
			@endif	
		</div>

		@php 
			$url = "trabalho/avaliacoes/".$trabalho->id ;
		@endphp
		<x-form-buttons :route="$url"/>		
	</form>
</div>
@stop