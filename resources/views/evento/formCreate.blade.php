@extends('layouts.app')

@section('conteudo')
<div class="jumbotron">
	@if(!empty($evento))
		<h1 class="display-4">Editando evento {{$evento->titulo}}</h1>
		<p class="lead">Página para edição de evento</p>
	@else
		<h1 class="display-4">Cadastro de Evento</h1>
		<p class="lead">Página para cadastrar novo evento</p>
	@endif
	
	<hr class="my-4">
	<form class="form-horizontal d-flex flex-column" action="{{empty($evento) ? route('evento.store') : route('evento.update', $evento->id)}}" method="POST">
			@if(!empty($evento))
				@method('put')
			@endif
			@csrf
			<div class="form-group">
				<label for="titulo">Título</label>  
				<input class="form-control" id="titulo" name="titulo" type="text" placeholder="Título do evento" value="{{empty($evento) ? old('titulo') : $evento->titulo}}" required>
				@if(count($errors)>0)
				<div class="text-danger">			 
					<li style="list-style-type:none">{{$errors->first('titulo')}}</li>
				</div>
				@endif	
			</div>
			<div class="row">
				<div class="col-6 form-group">
					<label  for="ano">Ano</label>
					<input id="ano" name="ano" type="number" placeholder="Ano do evento" class="form-control" value="{{empty($evento) ? old('ano') : $evento->ano}}" required>
					@if(count($errors)>0)
					<div class="text-danger">			
						<li style="list-style-type:none">{{$errors->first('ano')}}</li>
					</div>
					@endif	
				</div>
				<div class="col-6 form-group">
					<label for="semestre">Semestre</label>
					<input id="semestre" name="semestre" type="text" placeholder="Semestre do evento" class="form-control" value="{{empty($evento) ? old('semestre') : $evento->semestre}}" required>
					@if(count($errors)>0)
					<div class="text-danger">			
						<li style="list-style-type:none">{{$errors->first('semestre')}}</li>
					</div>
					@endif
				</div>
			</div>

			<div class="row ">
				<div class="col-6 form-group ">
					<label  for="tema">Tema</label>
					<input id="tema" name="tema" type="text" placeholder="Digite o tema do evento" class=" form-control" value="{{empty($evento) ? old('tema') : $evento->tema}}" required>
					@if(count($errors)>0)
					<div class="text-danger">			
						<li style="list-style-type:none">{{$errors->first('tema')}}</li>
					</div>
					@endif	
				</div>
				<div class="col-6 form-group">
					<label for="cidade">Cidade</label>
					<input id="cidade" name="cidade" type="text" placeholder="Cidade do evento" class="form-control" value="{{empty($evento) ? old('cidade') : $evento->cidade}}" required>
					@if(count($errors)>0)
					<div class="text-danger">			
						<li style="list-style-type:none">{{$errors->first('cidade')}}</li>
					</div>
					@endif
				</div>
			</div>

			<div class="form-group row flex-row d-flex justify-content-center mt-3">
				<div class="col-lg-6 col-12">
					<div class="input-group input-daterange"> 
						<input type="text" class="form-control input1" name="data_inicio" placeholder="Data do início do evento" readonly value="{{empty($evento) ? old('data_inicio') : $evento->data_inicio->format('d/m/Y')}}"> 
						<input type="text" class="form-control input2" name="data_fim" placeholder="Data do Fim do evento" readonly value="{{empty($evento) ? old('data_fim') : $evento->data_fim->format('d/m/Y')}}"> 
					</div>
					@if(count($errors)>0)
					<div class="text-danger">			
						<li style="list-style-type:none">{{$errors->first('data_inicio')}}</li>
					</div>
					@endif
					@if(count($errors)>0)
					<div class="text-danger">			
						<li style="list-style-type:none">{{$errors->first('data_fim')}}</li>
					</div>
					@endif
				</div>
			</div>
			<div class="row"></div>		
			<x-form-buttons :route="'evento'"/>
		</form>
	</div>
	@stop