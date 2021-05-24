@extends('layouts.app')

@section('conteudo')

<div class="jumbotron">
	<h1 class="display-4">Avaliador: {{ $avaliador->pessoa->nome }} - {{ $avaliador->area }}</h1>
	<p class="lead">{{ $avaliador->instituicao->sigla }} - {{ $avaliador->instituicao->nome }}</p>
	<p class="lead">Trabalhos Atribuídos:</p>
	<hr class="my-4">
	@if(Auth::user()->isAdmin() || Auth::user()->isOrganizador())
		<div class='text-right'>
	  		<a class='btn btn-primary btn-sm' href="/pessoa/avaliador">
			Voltar
	  	</a>
		</div>
	@endif
	<br>
<div class="table-responsive-sm">
	<table id="table" class="table table-striped table-hover table-bordered">
		<thead>
		  <tr>
			<th scope="col">Código do Trabalho</th>
			<th scope="col">Titulo</th>
			<th scope="col">Tipo de Trabalho</th>
			<th scope="col">Área</th>
			<th scope="col">Categoria</th>
			<th scope="col">Status</th>
		  </tr>
		</thead>
		<tbody>
			
	@forelse($avaliador->avaliacoes->groupBy('trabalho.evento.titulo') as $evento => $trabalhos)
		<tr class="bg-info text-white text-center">
			<th scope="col" colspan="7">
				<h1 class="display-4">{{$evento}}</h1>
			</th>
		</tr>
		  @foreach($trabalhos as $t)
		  	<tr class="bg-{{$t->notas_lancadas ? 'success' : 'danger'}} text-white"onclick="location.href='/avaliacao/notas/{{$t->id}}';" style="cursor: pointer;">
				<td>{{ $t->trabalho->cod }}</td>
				<td>{{ $t->trabalho->titulo }}</td>
				<td>{{ $t->trabalho->tipoTrabalho->nome }}</td>
				<td>{{ $t->trabalho->area->area }}</td>
				<td>{{ $t->trabalho->categoria->descricao }}</td>
				<td class="text-center">
		  			<span class="badge badge-pill badge-light">
		  			@if($t->notas_lancadas)
		  			<i data-feather="check"></i>
		  			Você já avaliou este trabalho.
		  			@else
		  			<i data-feather="corner-up-right"></i>
		  			Clique aqui para avaliar este trabalho
		  			@endif
		  			</span>
		  		</td>
		  </tr>
		  @endforeach
	  @empty 
	  <tr>
	  	<td colspan="6">
	  		Nenhum trabalho atribuído a este avaliador. Entre em contato com o organizador do evento.
	  	</td>
	  </tr>
	  @endforelse
		</tbody>
	</table>
</div>
	@if(Auth::user()->isAdmin() || Auth::user()->isOrganizador())
		<div class='text-right'>
	  		<a class='btn btn-primary btn-sm' href="/pessoa/avaliador">
			Voltar
	  	</a>
		</div>
	@endif
</div>
@stop 