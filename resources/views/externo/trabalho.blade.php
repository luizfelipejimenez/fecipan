@extends('layouts.app')

@section('conteudo')

<div class="jumbotron">
	<p class="lead">{{$trabalho->evento->titulo}} - {{$trabalho->evento->ano}}</p>
	<h1 class="display-4">Trabalho: {{ $trabalho->titulo }}</h1>
	
	<div class="row">
		<div class="col-6 border"><p class="lead">{{$trabalho->tipoTrabalho->nome}}</p></div>
		<div class="col-6 border"><p class="lead">{{$trabalho->categoria->descricao}}</p></div>
	</div>
	<div class="row">
		<div class="col-6 border">
			<p class="lead">Orientador(es)</p>

			@foreach($trabalho->orientadores as $orientador)
			<p class="lead">
				<i data-feather="chevrons-right"></i>
				{{$orientador->pessoa->nome}}
			</p>
			@endforeach
		</div>
		<div class="col-6 border">
			<p class="lead">Estudante(s):</p>
			@foreach($trabalho->estudantes as $estudante)
			<p class="lead">
				<i data-feather="chevrons-right"></i>
				{{$estudante->pessoa->nome}}
			</p>
			@endforeach
		</div>
	</div>
	<br/>
@if(!$trabalho->evento->ativo)
	<div class="row">
		<div class="col-12">
			<h3 class="text-center"> Foram encontradas {{$trabalho->avaliacoes()->where(['notas_lancadas' => 1])->count()}} avaliações registradas para este trabalho
			</h3>
		</div>
	</div>
	<br><br>
	
	@foreach($trabalho->avaliacoes as $key => $avaliacao)
	
	@if($avaliacao->notas_lancadas)
	<div class="row">
		<div class="col-12 text-center">
			<button class="btn btn-info  btn-lg" type="button" data-toggle="collapse" data-target="#collapse{{$avaliacao->id}}" aria-expanded="false" aria-controls="collapse{{$avaliacao->id}}">
				Visualizar avaliação #{{$avaliacao->id}} <i data-feather="chevrons-down"></i>
			</button>
		</div>

	</div>
	<div class="collapse row border" id="collapse{{$avaliacao->id}}">
		@foreach($avaliacao->notas as $nota)
		<div class="col-10">
			<p class="lead">
				<strong>Quesito</strong>
			</p>
		</div>
		<div class="col-2">
			<p class="lead">
				<strong>Nota</strong>
			</p>
		</div>
		<div class="col-10">
			<p class="lead">
				{{$trabalho->isCientifico() ? $nota->quesito->cientifico : $nota->quesito->tecnologico}}
			</p>
		</div>
		<div class="col-2">
			<p class="lead">
				<span class="badge badge-pill badge-info">{{$nota->valor}}</span>

			</p>
		</div>
		<div class="col-12">
			<p class="lead">
				<strong>Comentário</strong>
			</p>
		</div>
		<div class="col-12">
			<p class="lead">
				{{$nota->comentario != '' ? $nota->comentario : 'O avaliador não disponibilizou comentário'}}
			</p>
		</div>
		<div class="col-12"><hr class="my-4"></div>
		@endforeach
	</div>
	<br>
	@endif
	
	@endforeach
	@else
	<h4 class="display-4 text-center">Notas ainda não disponíveis</h4>
@endif

</div>
@stop 