@extends ('layouts.app')

@section('conteudo')

<div class="jumbotron">
@if ($permissoes->visualizar)
<h1 class="display-4">Tipos de Trabalho</h1>
	<p class="lead">Tipos de trabalho cadastrados nos eventos</p>
  <hr class="my-4">
  @if(Auth::user()->isAdmin() || Auth::user()->isOrganizador())
		<div class='text-right'>
	  		<a class='btn btn-primary' href="/evento">
			Voltar
	  	</a>
		</div>
	@endif
@if ($permissoes->inserir == true)
	<a href="{{route('tipoTrabalho.create')}}" class="btn btn-primary">
		<i data-feather="plus-square"></i>
		Cadastrar Tipo
	</a><br><br>
	@endif
	<div class="table-responsive">
	<table id="table" class="table table-striped table-hover table-bordered">
	  <thead>
		<tr>
			<th>Nome</th>
			<th>Ações</th>
		</tr>
	  </thead>
	  <tbody>
	  @foreach($tiposTrabalho as $t)
		<tr>
			<td>{{ $t->nome }}</td>
			<td> 
			  <x-crud-view :a="$t" :permissoes="$permissoes" :route="'tipoTrabalho'" :model="'Tipo'"/>
			</td>
		  </tr>
	  @endforeach
	  </tbody>
	</table>
</div>
@if(Auth::user()->isAdmin() || Auth::user()->isOrganizador())
		<div class='text-right'>
	  		<a class='btn btn-primary' href="/evento">
			Voltar
	  	</a>
		</div>
	@endif
</div>
@endif
@stop 