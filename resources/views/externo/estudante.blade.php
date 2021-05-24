@extends('layouts.app')

@section('conteudo')

<div class="jumbotron">
	
	<h1 class="display-4">Estudante: {{ $estudante->pessoa->nome }}</h1>
	<p class="lead">{{ $estudante->instituicao->sigla }} - {{ $estudante->instituicao->nome }}</p>
	<p class="lead">Trabalhos vinculados</p>
	<hr class="my-4">
@if(Auth::user()->isAdmin() || Auth::user()->isOrganizador())
	<div class='text-right'>
	  <a class='btn btn-primary btn-sm' href="/pessoa/estudante">
		Voltar
	  </a>
	</div>
@endif
<br><br>
<div class="table-responsive">
	<table id="table" class="table table-condensed table-hover table-striped">
		<thead>
		  <tr>
			<th>Código do Trabalho</th>
			<th>Evento</th>
			<th>Titulo</th>
			<th>Tipo de Trabalho</th>
			<th>Área</th>
			<th>Categoria</th>
			<th></th>
		  </tr>
		</thead>
		<tbody>
		@forelse($estudante->trabalhos as $t)
		  <tr onclick="location.href='/visualizar/estudante/trabalho/{{$t->id}}';" style="cursor: pointer;">
			<td>{{ $t->cod }}</td>
			<td>{{ $t->evento->ano }}/{{ $t->evento->semestre }} {{ $t->evento->titulo }}</td>
			<td>{{ $t->titulo }}</td>
			<td>{{ $t->tipoTrabalho->nome }}</td>
			<td>{{ $t->area->area }}</td>
			<td>{{ $t->categoria->descricao }}</td>
			<td>
				<span class="badge badge-pill badge-light">
		  			<i data-feather="corner-up-right"></i>
		  			Clique aqui para ver as avaliações deste trabalho
		  		</span>
		  	</td>
		  </tr>
		  @empty
		  <tr>
		  	<td colspan="6">
		  		<p class="lead">Nenhum trabalho encontrado no sistema</p>
		  	</td>
		  </tr>
		@endforelse
		</tbody>
	</table>
	</div>
	@if(Auth::user()->isAdmin() || Auth::user()->isOrganizador())
	<div class='text-right'>
	  <a class='btn btn-primary btn-sm' href="/pessoa/estudante">
		Voltar
	  </a>
	</div>
	@endif
</div>
@stop 