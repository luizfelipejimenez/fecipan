@extends('layouts.app')

@section('conteudo')
<div class="panel panel-default">
	<div class="panel-heading">
		<h4>Cadastro de Categoria</h4>
	</div>
	<div class="panel-body">
		<form class="form-horizontal" action="/categoria/create" method="POST">
			<input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
			<fieldset>

			<div class="form-group">
			  <label class="col-md-3 col-sm-4 control-label" for="descricao">Descrição</label>  
			  <div class="col-md-6 col-sm-8">
				<input id="descricao" name="descricao" type="text" placeholder="Digite a descrição da categoria" class="form-control input-md">
				  <!-- DIV PARA MOSTRAR OS ERROS -->
				 @if(count($errors)>0)
					<div class="text-danger">			
						<li style="list-style-type:none">{{$errors->first('descricao')}}</li>
					</div>
				@endif	
			  </div>
			</div>

			<div class="form-group">
			  <div class="col-sm-offset-4 col-md-offset-3 col-sm-6 col-md-6">
				<button class="btn btn-primary" type="submit">Registrar</button>
				<a href="/categoria" class="btn btn-danger">Cancelar</a>
			  </div>
			</div>			
		</form>
	</div>
</div>
@stop