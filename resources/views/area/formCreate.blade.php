@extends('layouts.app')

@section('conteudo')

<div class="jumbotron">
  <h1 class="display-3">Cadastro de Área</h1>
  <hr class="my-4">
  	<form class="form-horizontal d-flex flex-column" action="{{route('area.store')}}" method="POST">
			@csrf
			<div class="form-group row">
    			<label class="col-1 col-form-label" for="sigla">Sigla</label>
    			<input type="text" class="form-control col-11" id="sigla"  placeholder="Digite a sigla da área" name="sigla" required value="{{ old('sigla') }}">
    			@if(count($errors)>0)
					<div class="text-danger">			
						<li style="list-style-type:none">{{$errors->first('sigla')}}</li>
					</div>
				@endif
  			</div>

			<div class="form-group row">
			  <label class="col-1 col-form-label" for="text">Descrição</label>  
				<input id="area" name="area" type="text" placeholder="Digite a descrição da área" class="form-control col-11" required value="{{ old('area') }}">
				  <!-- DIV PARA MOSTRAR OS ERROS -->
				 @if(count($errors)>0)
					<div class="text-danger">			
						<li style="list-style-type:none">{{$errors->first('area')}}</li>
					</div>
				@endif	
			</div>
			<x-form-buttons :route="'area'"/>	
		</form>
</div>

@stop