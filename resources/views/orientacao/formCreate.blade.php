@extends('layouts.app')

@section('conteudo')

<div class="jumbotron">
	<h1 class="display-4">Associar Orientadores ao Trabalho {{ $trabalho->cod }} </h1>
	<p class="lead">{{ $trabalho->titulo }}</p>
	<hr class="my-4">
	<form class="form-horizontal d-flex flex-column" action="{{route('orientacao.store')}}" method="POST">
		@csrf
		<input type="hidden" name="trabalho_id" value="{{ $trabalho->id }}" />
		
	    @if (!$tem_orientador)
		<div class="form-group row">
		  <label class="col-12 col-form-label" for="orientador_id">Orientador</label>  
		  	<select id="orientador" name="orientador_id" title="Selecione o orientador..." class="selectpicker col-12" required data-live-search="true">
				@foreach ($orientadores as $orientador)
				<option value="{{ $orientador->id }}">{{ $orientador->instituicao->sigla }} - {{ $orientador->pessoa->nome }}</option>
				@endforeach
			</select>
		  	@if(count($errors)>0)
		  	 	<div class="text-danger">			
					<li style="list-style-type:none">{{$errors->first('orientador_id')}}</li>
				</div>
			@endif	
		  
		</div>
		@endif
		@if (!$tem_coorientador)
	    <div class="form-group row">
		  <label class="col-12 col-form-label" for="coorientadores">Coorientador</label>  
		  	<select id="coorientadores" name="coorientadores[]" title="Selecione o coorientador..." class="selectpicker col-12" data-live-search="true">
				@foreach ($orientadores as $orientador)
				<option value="{{ $orientador->id }}">{{ $orientador->instituicao->sigla }} - {{ $orientador->pessoa->nome }}</option>
				@endforeach
			</select>
		  	@if(count($errors)>0)
		  	 	<div class="text-danger">			
					<li style="list-style-type:none">{{$errors->first('orientadores')}}</li>
				</div>
			@endif	
		  
		</div>
		@endif
		@php $url = "trabalho/orientadores/".$trabalho->id; @endphp

		<x-form-buttons :route="$url"/>	

		
	</form>
	</div>

@stop