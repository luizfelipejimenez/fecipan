@extends('layouts.app')

@section('conteudo')

@if ($permissoes->visualizar)
<div class="jumbotron">
  <h1 class="display-4">Quesitos de Avaliação</h1>
  <p class="lead">{{ $evento->titulo }} {{ $evento->ano }}/{{ $evento->semestre }}</p>
  <p class="lead">{{ $evento->tema }}</p>
  <hr class="my-4">
	<div class='text-right'>
	  <a class='btn btn-primary btn-sm' href="/evento">
		Voltar
	  </a>
	</div>
	@if ($permissoes->inserir == true)
	<a href="\quesito\create\{{ $evento->id }}" class="btn btn-primary">
		<i data-feather="plus-square"></i>
		Cadastrar Quesito
	</a>
	@endif
	<br><br>

	<table id="table" class="table table-bordered table-hover table-striped">
		<thead>
		  <tr>
			<th>Científico</th>
			<th>Tecnológico</th>
			<th class="text-right">Peso</th>
			<th>Ações</th>
		  </tr>
		</thead>
		<tbody>
		@forelse($evento->quesitos as $q)
		  <tr>
			<td>{{ $q->cientifico }}</td>
			<td>{{ $q->tecnologico }}</td>
			<td class="text-right">{{ $q->peso }}</td>
			<td> 
			  <x-crud-view :a="$q" :permissoes="$permissoes" :route="'quesito'" :model="'Quesito'"/>
			</td>
		  </tr>
		@empty
			<tr>
			<td colspan="4">Não existem quesitos cadastrados para esse evento</td>
		  </tr>
		@endforelse
		</tbody>
	</table>
@endif
	<div class='text-right'>
	  <a class='btn btn-primary btn-sm' href="/evento">
		Voltar
	  </a>
	</div>

</div>
@stop 