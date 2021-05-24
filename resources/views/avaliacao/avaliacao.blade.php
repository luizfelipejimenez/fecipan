@extends('layouts.app')

@section('conteudo')

@if ($permissoes->visualizar)
<div class="jumbotron">
	<h1 class="display-4 text-center">Avaliações</h1>
	<h1 class="display-4 text-center">{{ $trabalho->cod }} - {{ $trabalho->titulo }}</h1>
	<p class="lead">{{ $trabalho->evento->titulo }} - {{ $trabalho->evento->ano }}</p>
	<hr class="my-4">
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
<hr class="my-4">
	@if(Auth::user()->isAdmin() || Auth::user()->isOrganizador())
	<div class='text-right'>
		<a class='btn btn-primary' href="/evento/trabalhos/{{ $trabalho->evento_id }}">
			Voltar
		</a>
	</div>
	@endif
	@if ($permissoes->inserir)
	<a href="\avaliacao\create\{{ $trabalho->id }}" class="btn btn-primary">
		<i data-feather="plus-square"></i>
		Vincular Avaliadores a este trabalho
	</a>
	@endif
	<br><br>

	<?php $somatorio = 0 ?>
	<?php $num_avaliacoes = 0 ?>
	<?php 
		# Ordena as avaliações pelos nomes dos avaliadores
	$avaliacoes = $trabalho->avaliacoes->sortBy(function($avaliacao, $key){
		return ($avaliacao->avaliador->pessoa->nome);
	});	
	?>
	@foreach($avaliacoes as $q)	
	<div class='card border-{{ $q->notas_lancadas? "success": "danger" }} mb-2'>
		<div class='card-header'>
			<div class='row'>
				<div class='col-9'>
					<h4><strong>Avaliador:</strong> {{ $q->avaliador->pessoa->nome }}</h4>
					<div><strong>Área:</strong> {{ $q->avaliador->area }}</div>
				</div>
				<div class="col-3">
					<div class='btn-group' role="group">
						@if ($permissoes->alterar)
							<a class='btn btn-outline-warning' href="/avaliacao/notas/{{ $q->id }}" title="Lançar notas"><i data-feather="pen-tool">
							</i> Alterar notas manualmente
							</a>
						@endif
						@if ($permissoes->excluir)
						<a class='btn btn-outline-danger' href="#" data-toggle="modal" data-target="#modal-{{$q->id}}"title="Excluir avaliacao #{{$q->id}}">
							<i data-feather="trash-2"></i>
							Excluir todos os registros desta avaliação
						</a>
						@endif
					</div>
				</div>

			<div id="modal-{{$q->id}}" class="modal fade text-justify" role="dialog">
				<div class="site-wrapper">
					<div class="modal-dialog">                
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal">&times;</button>
								<h4 class="modal-title">
									<span class="glyphicon glyphicon-alert"></span>
									Exclusão de Avaliação
								</h4>
							</div>

							<div class="modal-body">
								<p>Deseja excluir as notas do avaliador <strong>{{$q->id}} - {{$q->avaliador->pessoa->nome}}</strong>?</p>
							</div>

							<div class="modal-footer">
								<a href="/avaliacao/delete/{{$q->id}}" class="btn btn-danger">Sim</a>
								<button class="btn btn-info" data-dismiss="modal">Não</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
		<div class='card-body table-responsive' id="table_{{$q->id}}"  >
			<table class="table table-condensed table-hover table-striped">
				<tr>
					<th>#</th>
					<th>Quesito</th>
					<th class='text-right'>Nota</th>
				</tr>
				<?php $subtotal = 0 ?>
				<?php $i = 1 ?>
				@foreach ($q->notas as $nota)
				<tr>
					<td>{{ $i++ }}</td>
					<td>{{ $trabalho->isCientifico() ? $nota->quesito->cientifico : $nota->quesito->tecnologico }}</td>
					<td class='text-right'>
						<?php printf(is_null($nota->valor)? "?":"%.2f", $nota->valor)  ?>

					</td>
				</tr>
				<?php $subtotal += /*$nota->quesito->peso * */ $nota->valor ?>
				@endforeach
			</table>
		</div>
		<div class='card-footer'>
			<div class="text-right">
				@if ($q->notas_lancadas == true)
				<h4>
					<span class="badge badge-info">
						Somatório da notas lançadas: <?php printf("%.2f", $subtotal) ?>
					</span>
				</h4>
				<?php $somatorio += $subtotal ?>
				<?php $num_avaliacoes++ ?>
				@else
				<h4>
					<span class="badge badge-danger">
						Ainda não avaliado
					</span>
				</h4>
				@endif
			</div>
		</div>
	</div>

	@endforeach
	<div class='alert alert-info'>
		<h3>Número de Avaliações Lançadas: {{ $num_avaliacoes }} de {{ $trabalho->avaliacoes->count() }}</h3>
		<h4><?php printf("Média Total: %.2f", $num_avaliacoes >0 ? $somatorio/$num_avaliacoes: 0) ?></h4>
	</div>
		@if(Auth::user()->isAdmin() || Auth::user()->isOrganizador())
			<div class='text-right'>
				<a class='btn btn-primary' href="/evento/trabalhos/{{ $trabalho->evento_id }}">
					Voltar
				</a>
			</div>
		@endif
	@endif
	@stop 