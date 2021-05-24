@extends('layouts.app')

@section('conteudo')
<div class="panel panel-default">
	<div class="panel-heading">
		<h4>Cadastro de Tipo de Trabalho</h4>
	</div>
	<div class="panel-body">
	
	<form class="form-horizontal" action="/tipoTrabalho/create" method="POST">
		<input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
		<fieldset>

		<div class="form-group">
		  <label class="col-md-3 col-sm-4 control-label" for="nome">Nome</label>  
		  <div class="col-md-6 col-sm-6">
		  	<input id="nome" name="nome" type="text" placeholder="Digite o tipo de trabalho" class="form-control input-md">
		  	@if(count($errors)>0)
		  	 	<div class="alert alert-danger">			
					<h4>{{$errors->first('nome')}}</h4>
				</div>
			@endif	
		  </div>
		</div>

		<div class="form-group">
		  <div class="col-sm-offset-4 col-md-offset-3 col-sm-6 col-md-6">
		    <button class="btn btn-primary" type="submit">Registrar</button>
		    <a href="/tipoTrabalho" class="btn btn-danger">Cancelar</a>
		  </div>
		</div>		

		</fieldset>
	</form>
	</div>
</div>

@stop