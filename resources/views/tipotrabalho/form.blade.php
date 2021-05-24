@extends('layouts.app')

@section('conteudo')
<div class="jumbotron">
	@if(!empty($tipoTrabalho))
		<h1 class="display-3">Editando Tipo de Trabalho</h1>
	@else
		<h1 class="display-3">Cadastro de Tipo de Trabalho</h1>
	@endif
  
  <hr class="my-4">
	<form class="form-horizontal d-flex flex-column" action="{{$edit ? route('tipoTrabalho.update', $tipoTrabalho->id) : route('tipoTrabalho.store')}}" method="POST">
		@if($edit)
			@method('put')
		@endif
		@csrf
		<div class="form-group row">
		  <label class="col-1 col-form-label" for="nome">Nome</label>  
		  <input class="col-11 form-control @error('nome') is-invalid @enderror" id="nome" name="nome" type="text" placeholder="Digite o tipo de trabalho" value="{{ $edit ? $tipoTrabalho->nome : old('area') }}">
		  <div id="nomeFeedback" class="offset-1 invalid-feedback">
        		{{$errors->first('nome')}}
      	  </div>
		</div>
		<x-form-buttons :route="'tipoTrabalho'"/>		
	</form>

</div>


@stop