@extends('layout.principal')

@section('conteudo')

<div class="row">
	<div class="col-sm-offset-2 col-sm-8 col-sm-offset-2">
	<h3 style="text-align:center">Editar o Tipo de Trabalho</h3>
	<hr>
	<form class="form-horizontal" action="/editartipotrabalho/{{$t->id}}" method="POST">
		<input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
		<fieldset>
		<div class="form-group">
		  <label for="text">Nome</label>  
		  <div>
		  	<input id="nome" name="nome" type="text" value="{{$t->nome}}" placeholder="Tipo de trabalho" class="form-control input-md">
		  	  <!-- DIV PARA MOSTRAR OS ERROS -->
		  	 @if(count($errors)>0)
		  	 	<div class="text-danger">			
					<li style="list-style-type:none">{{$errors->first('nome')}}</li>
				</div>
			@endif	
		  </div>
		</div>
		<div class="form-group">
		  <label class="col-md-5 control-label" for="submit"></label>
		  <div >
		    <button class="btn btn-primary" type="submit">Editar</button>
		    <a href="/tipotrabalho" class="btn btn-default">Voltar</a>
		  </div>
		</div>			
	</form>
	</div>
</div>

@stop