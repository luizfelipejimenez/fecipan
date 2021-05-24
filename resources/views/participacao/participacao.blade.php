@extends('layouts.app')

@section('conteudo')

@if ($permissoes->visualizar)
<div class="jumbotron">
	<h1 class="display-4">Estudantes </h1>
	<p class="lead">{{ $trabalho->cod }} - {{ $trabalho->titulo }}</p>
	<p class="lead">{{ $trabalho->evento->titulo }} - {{ $trabalho->evento->ano }}</p>
	<hr class="my-4">
	@if(Auth::user()->isAdmin() || Auth::user()->isOrganizador())
		<div class='text-right'>
			<a class='btn btn-primary' href="/evento/trabalhos/{{ $trabalho->evento_id }}">
				Voltar
			</a>
		</div>
	@endif
	@if ($permissoes->inserir)
	<a href="{{route('participacao.create', $trabalho->id)}}" class="btn btn-primary">
		<i data-feather="plus-square"></i> 
		Vincular Estudantes ao trabalho
	</a>
	<hr class="my-4">
	@endif

	@foreach($trabalho->estudantes as $q)
	<div class='panel panel-default'>
		<div class='panel-heading'>
			<div class='row'>
				<div class='col-10'>
					<h4><strong>Estudante:</strong> {{ $q->pessoa->nome }}</h4>
				</div>
				<div class="col-2 text-right">
					@if ($permissoes->excluir)
					<a class='btn btn-sm btn-outline-danger' href="#" data-toggle="modal" data-target="#m-{{$q->id}}"title="Desvincular participacao de trabalho #{{$q->id}}">
						<i data-feather="trash-2"></i>
						Desvincular participacao de trabalho
					</a>
					@endif
				</div>
			</div>
			<div id="m-{{$q->id}}" class="modal fade text-justify" tabindex="-1" aria-labelledby="m-{{$q->id}}" aria-hidden="true">
				
					<div class="modal-dialog">                
						<div class="modal-content">
							<div class="modal-header">
							<h5 class="modal-title" id="ml{{$q->id}}">
							 	<i data-feather="alert-triangle"></i> 
							 	Exclusão de Estudante
							 </h5>

							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
 								<span aria-hidden="true">&times;</span>
 							</button>
							</div>

							<div class="modal-body">
								<p>Deseja excluir a participação do estudante <strong>{{$q->id}} - {{$q->pessoa->nome}}</strong>?</p>
							</div>

							<div class="modal-footer">
								<form method="POST" action="{{route('participacao.destroy', [$trabalho->id, $q->id])}}">
 									@method('delete')
 									@csrf
 									<button type="submit" class="btn btn-danger">Sim</button>
 								</form>
 								<a href="{{route('participacao.index', $trabalho->id)}}" class="btn btn-info" data-dismiss="modal">Não</a>
							</div>
						</div>
					</div>
				
			</div>
		</div>
		<div class='panel-body'>
			<div><strong>Escola:</strong> {{ $q->instituicao->sigla }} - {{ $q->instituicao->nome }}</div>
			<div><strong>Cidade:</strong> {{ $q->instituicao->cidade }}</div>
		</div>
	</div>
	<hr class="my-4">
	@endforeach

	@if(Auth::user()->isAdmin() || Auth::user()->isOrganizador())
	<div class='text-right'>
		<a class='btn btn-primary' href="/evento/trabalhos/{{ $trabalho->evento_id }}">
			Voltar
		</a>
	</div>
	@endif
</div>
@endif
@stop 