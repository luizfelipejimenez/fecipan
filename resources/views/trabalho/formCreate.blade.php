@extends('layouts.app')

@section('conteudo')


<div class="jumbotron">
  <h1 class="display-4">Cadastrar Trabalho na {{ $evento->titulo }} - {{ $evento->ano }}</h1>
  <p class="lead">{{ $evento->tema }}</p>
  <hr class="my-4">


	<form class="form-horizontal d-flex flex-column" action="{{route('trabalho.store')}}" method="POST" enctype="multipart/form-data">
		@csrf
		<input type="hidden" name="evento_id" value="{{ $evento->id }}" />

		<div class="form-group row">
		  <label class="col-12 col-form-label" for="titulo">Título</label>
		  <input type="text" id="titulo" name="titulo" class="form-control col-12" placeholder="Título do Trabalho" required>
		  	@if(count($errors)>0)
		  	 	<div class="text-danger">			
					<li style="list-style-type:none">{{$errors->first('titulo')}}</li>
				</div>
			@endif	
		</div>
		<div class="form-group row">
			<label class="col-12 col-form-label" for="non">Arquivo</label>
			<div class="custom-file">
  				<input type="file" class="custom-file-input" id="arquivo" name="arquivo" accept=".pdf" required>
  				<label class="custom-file-label" for="arquivo">Escolha o arquivo</label>
			</div>

		  
		  	@if(count($errors)>0)
		  	 	<div class="text-danger">			
					<li style="list-style-type:none">{{$errors->first('arquivo')}}</li>
				</div>
			@endif	
		</div>
		<div class="form-group row">
		  <label class="col-12 col-form-label" for="video">Video</label>
		  <input type="url" id="video" name="video" class="form-control col-12" placeholder="Link do video do trabalho">
		  	@if(count($errors)>0)
		  	 	<div class="text-danger">			
					<li style="list-style-type:none">{{$errors->first('video')}}</li>
				</div>
			@endif	
		</div>

	    <div class="form-group row">
		  <label for="categoria_id" class="col-12 col-form-label">Categoria</label>  
		  	<select id="categoria_id" name="categoria_id" data-placeholder="Escolha a categoria" class="selectpicker col-12" required title="Escolha a categoria">
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

	    <div class="form-group row">
		  <label class="col-12 col-form-label" for="tipo_trabalho_id">Tipo</label>  

		  	<select id="tipo_trabalho_id" name="tipo_trabalho_id" data-placeholder="Escolha o tipo" class="selectpicker col-12" required title="Escolha o tipo do trabalho">
				@foreach ($tiposTrabalho as $tipoTrabalho)
				<option value="{{ $tipoTrabalho->id }}">{{ $tipoTrabalho->nome }}</option>
				@endforeach
			</select>
		  	@if(count($errors)>0)
		  	 	<div class="text-danger">			
					<li style="list-style-type:none">{{$errors->first('tipo_trabalho_id')}}</li>
				</div>
			@endif	
		  
		</div>

		<div class="form-group row">
			<label class="col-12 col-form-label" for="area_id">Área</label>  
			
		  	<select id="area_id" name="area_id" data-placeholder="Escolha a área" class="selectpicker col-12" required title="Escolha a área do trabalho">
				@foreach ($areas as $area)
				<option value="{{ $area->id }}">{{ $area->sigla }} - {{ $area->area }}</option>
				@endforeach
			</select>
		  	@if(count($errors)>0)
		  	 	<div class="text-danger">			
					<li style="list-style-type:none">{{$errors->first('area_id')}}</li>
				</div>
			@endif	
		  
		</div>

		<!--<div class="form-group">
		  <label class="col-sm-4 col-md-3 control-label" for="cod">Código</label>  
		  
		  <div class="col-sm-3 col-md-2">
			<input type="text" id="cod" name="cod" class="form-control input-md" placeholder="Título do Trabalho">
		  </div>
		  	@if(count($errors)>0)
		  	 	<div class="text-danger">			
					<li style="list-style-type:none">{{$errors->first('cod')}}</li>
				</div>
			@endif	
		</div>-->
		
	    <div class="form-group row">
		  <label class="col-12 col-form-label" for="orientador_id">Orientador</label>  
		  <select id="orientador" name="orientador_id" data-placeholder="Escolha o Orientador" class="selectpicker col-12" required title="Escolha um orientador para o trabalho" data-live-search="true">
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
		
	    <div class="form-group row">
		  <label class="col-12 col-form-label" for="coorientador_id">Coorientador</label>  
		  <select id="coorientador_id" name="coorientador_id" class="selectpicker col-12" title="Escolha um coorientador para o trabalho" data-live-search="true">
				@foreach ($orientadores as $orientador)
				<option value="{{ $orientador->id }}">{{ $orientador->instituicao->sigla }} - {{ $orientador->pessoa->nome }}</option>
				@endforeach
			</select>
		  	@if(count($errors)>0)
		  	 	<div class="text-danger">			
					<li style="list-style-type:none">{{$errors->first('coorientador_id')}}</li>
				</div>
			@endif	
		</div>

		<div class="form-group row">
		  <label class="col-12 col-form-label" for="estudantes">Estudantes</label>  
		  	<select id="estudantes" name="estudantes[]" title="Escolha os Estudantes" class="selectpicker col-12" data-live-search="true" data-max-options="3" multiple>
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

		<!--<div class="form-group row">
		  <div class="col-sm-offset-4 col-md-offset-3 col-sm-8 col-md-6">
			<label class="control-label" for="maquete">
				<input type="checkbox" id="maquete" name="maquete" value="1">
				Este trabalho possui maquete
			</label>			
		  </div>
		</div>-->
		@php 
			$url = "evento/trabalhos/".$evento->id ;
		@endphp
		<x-form-buttons :route="$url"/>	

	</form>
	</div>

@stop