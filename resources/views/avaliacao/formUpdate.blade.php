@extends('layouts.app')

@section('conteudo')
<div class="panel panel-default">
	<div class="panel-heading">
		<h4>Editar de Evento #{{ $e->id }}</h4>
	</div>
	<div class="panel-body">
	<form class="form-horizontal" action="/evento/update" method="POST">
		<input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
		<input type="hidden" name="evento_id" value="{{$e->id}}" />
		<fieldset>

		<div class="form-group">
		  <label class="col-sm-4 col-md-3 control-label" for="titulo">Título</label>  
		  <div class="col-sm-8 col-md-6">
		  	<input id="titulo" name="titulo" type="text"  value="{{$e->titulo}}" placeholder="Digite o título do evento" class="form-control input-md">
		  	@if(count($errors)>0)
		  	 	<div class="text-danger">			
					<li style="list-style-type:none">{{$errors->first('titulo')}}</li>
				</div>
			@endif	
		  </div>
		</div>

		<div class="form-group">
		  <label class="col-sm-4 col-md-3 control-label" for="ano">Ano</label>  
		  <div class="col-sm-3 col-md-2">
		  	<input id="ano" name="ano" type="number" value="{{$e->ano}}" placeholder="Digite o ano do evento" class="form-control input-md">
		  	@if(count($errors)>0)
		  	 	<div class="text-danger">			
					<li style="list-style-type:none">{{$errors->first('ano')}}</li>
				</div>
			@endif	
		  </div>
		</div>


		<div class="form-group">
		  <label class="col-sm-4 col-md-3 control-label" for="semestre">Semestre</label>  
		  <div class="col-sm-3 col-md-2">
		  	<input id="semestre" name="semestre" type="text" value="{{$e->semestre}}" placeholder="Digite o semestre do evento" class="form-control input-md">
		  	@if(count($errors)>0)
		  	 	<div class="text-danger">			
					<li style="list-style-type:none">{{$errors->first('semestre')}}</li>
				</div>
			@endif	
		  </div>
		</div>

		<div class="form-group">
		  <label class="col-sm-4 col-md-3 control-label" for="tema">Tema</label>  
		  <div class="col-sm-8 col-md-6">
		  	<input id="tema" name="tema" type="text" value="{{$e->tema}}" placeholder="Digite o tema do evento" class="form-control input-md">
		  	@if(count($errors)>0)
		  	 	<div class="text-danger">			
					<li style="list-style-type:none">{{$errors->first('tema')}}</li>
				</div>
			@endif	
		  </div>
		</div>

		<div class="form-group">
		  <label class="col-sm-4 col-md-3  control-label" for="cidade">Cidade</label>  
		  <div class="col-sm-8 col-md-6">
		  	<input id="cidade" name="cidade" type="text" value="{{$e->cidade}}" placeholder="Digite a cidade do evento" class="form-control input-md">
		  	@if(count($errors)>0)
		  	 	<div class="text-danger">			
					<li style="list-style-type:none">{{$errors->first('cidade')}}</li>
				</div>
			@endif	
		  </div>
		</div>

		<div class="form-group">
		  <label class="col-sm-4 col-md-3 control-label" for="data_inicio">Data de Início</label>  
		  <div class="col-sm-4 col-md-3">
		  	<input id="data_inicio" name="data_inicio" type="date" value="{{$e->data_inicio}}" placeholder="Digite a data de ínicio do evento" class="form-control input-md">
		  	@if(count($errors)>0)
		  	 	<div class="text-danger">			
					<li style="list-style-type:none">{{$errors->first('data_inicio')}}</li>
				</div>
			@endif	
		  </div>
		</div>	

		<div class="form-group">
		  <label class="col-sm-4 col-md-3 control-label" for="data_fim">Data do Fim</label>  
		  <div class="col-sm-4 col-md-3">
		  	<input id="data_fim" name="data_fim" type="date" value="{{$e->data_fim}}" placeholder="Digite a data do fim do evento" class="form-control input-md">
		  	@if(count($errors)>0)
		  	 	<div class="text-danger">			
					<li style="list-style-type:none">{{$errors->first('data_fim')}}</li>
				</div>
			@endif	
		  </div>
		</div>

		<div class="form-group">
		  <div class="col-sm-offset-4 col-md-offset-3 col-sm-10">
		    <button class="btn btn-primary" type="submit">Editar</button>
		    <a href="/evento" class="btn btn-danger">Cancelar</a>
		  </div>
		</div>		

		</fieldset>
	</form>
	</div>
</div>

@stop