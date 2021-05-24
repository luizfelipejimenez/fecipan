@extends('layouts.app')

@section('conteudo')
<div class="panel panel-default">
	<div class="panel-heading">
		<h4>
			Alterar o Trabalho #{{ $trabalho->id }} - {{ $trabalho->cod }}  na {{ $trabalho->evento->titulo }}
		</h4>
		<p>{{ $trabalho->evento->tema }}</p>
	</div>
	<div class="panel-body">
	<form class="form-horizontal" action="{{route('trabalho.update')}}" method="POST">
		@method('put')
    		@csrf
		<input type="hidden" name="trabalho_id" value="{{ $trabalho->id }}" />
		<fieldset>
	    <div class="form-group">
		  <label class="col-sm-4 col-md-3 control-label" for="categoria_id">Categoria</label>  

		  <div class="col-sm-6 col-md-4">
		  	<select id="categoria_id" name="categoria_id" data-placeholder="Escolha a categoria" class="chosen-select form-control input-md">
				<option value=""></option>
				@foreach ($categorias as $categoria)
				<option value="{{ $categoria->id }}" {{ $trabalho->categoria_id == $categoria->id? "selected": "" }}>{{ $categoria->descricao }}</option>
				@endforeach
			</select>
		  	@if(count($errors)>0)
		  	 	<div class="text-danger">			
					<li style="list-style-type:none">{{$errors->first('categoria_id')}}</li>
				</div>
			@endif	
		  </div>
		</div>

	    <div class="form-group">
		  <label class="col-sm-4 col-md-3 control-label" for="tipo_trabalho_id">Tipo</label>  

		  <div class="col-sm-8 col-md-6">
		  	<select id="tipo_trabalho_id" name="tipo_trabalho_id" data-placeholder="Escolha o tipo" class="chosen-select form-control input-md">
				<option value=""></option>
				@foreach ($tiposTrabalho as $tipoTrabalho)
				<option value="{{ $tipoTrabalho->id }}" {{ $trabalho->tipo_trabalho_id == $tipoTrabalho->id? "selected": "" }}>{{ $tipoTrabalho->nome }}</option>
				@endforeach
			</select>
		  	@if(count($errors)>0)
		  	 	<div class="text-danger">			
					<li style="list-style-type:none">{{$errors->first('tipo_trabalho_id')}}</li>
				</div>
			@endif	
		  </div>
		</div>

		<div class="form-group">
		  <label class="col-sm-4 col-md-3 control-label" for="titulo">Título</label>  
		  
		  <div class="col-sm-8 col-md-6">
			<input type="text" id="titulo" name="titulo" value="{{ $trabalho->titulo }}" class="form-control input-md" placeholder="Título do Trabalho">
		  </div>
		  	@if(count($errors)>0)
		  	 	<div class="text-danger">			
					<li style="list-style-type:none">{{$errors->first('titulo')}}</li>
				</div>
			@endif	
		</div>

		<div class="form-group">
			<label class="col-sm-4 col-md-3 control-label" for="area_id">Área</label>  
			<div class="col-sm-8 col-md-6">
		  	<select id="area_id" name="area_id" data-placeholder="Escolha a área" class="chosen-select form-control input-md">
				<option value=""></option>
				@foreach ($areas as $area)
				<option value="{{ $area->id }}"  {{ $trabalho->area_id == $area->id? "selected": "" }}>{{ $area->area }}</option>
				@endforeach
			</select>
		  	@if(count($errors)>0)
		  	 	<div class="text-danger">			
					<li style="list-style-type:none">{{$errors->first('area_id')}}</li>
				</div>
			@endif	
		  </div>
		</div>

		<div class="form-group">
		  <label class="col-sm-4 col-md-3 control-label" for="cod">Código</label>  
		  
		  <div class="col-sm-3 col-md-2">
			<input type="text" id="cod" name="cod" value="{{ $trabalho->cod }}" class="form-control input-md" placeholder="Título do Trabalho">
		  </div>
		  	@if(count($errors)>0)
		  	 	<div class="text-danger">			
					<li style="list-style-type:none">{{$errors->first('cod')}}</li>
				</div>
			@endif	
		</div>
		
		<div class="form-group">
		  <div class="col-sm-offset-4 col-md-offset-3 col-sm-8 col-md-6">
			<label class="control-label" for="maquete">
				<input type="checkbox" id="maquete" name="maquete" value="1" {{ $trabalho->maquete? "checked": "" }}>
				Este trabalho possui maquete
			</label>			
		  </div>
		</div>

		<div class="form-group">
		  <div class="col-sm-offset-4 col-md-offset-3 col-sm-10">
		    <button class="btn btn-primary" type="submit">Editar</button>
		    <a href="/evento/trabalhos/{{ $trabalho->evento->id }}" class="btn btn-danger">Cancelar</a>
		  </div>
		</div>		

		</fieldset>
	</form>
	</div>
</div>

@stop