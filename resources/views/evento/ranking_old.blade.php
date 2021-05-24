@extends ('layouts.app')

@section('conteudo')

@if ($permissoes->visualizar == true)
<div class="jumbotron">
	<h1 class="display-4">Ranking da {{ $evento->titulo }} {{ $evento->ano }}/{{ $evento->semestre }}</h1>
	<p class="lead">{{ $evento->tema }}</p>
	<div class='text-right'>
		<a class='btn btn-primary btn-sm' href="/evento">
			Voltar
		</a>
	</div>
	<br><br>
	@foreach($categorias as $c)
	<h3>{{$c->descricao}}</h3>
	<div class="panel-group" id="accordion{{$c->id}}">
		<script>
			$(document).ready( function () {
				$('#table{{$c->id}}').DataTable(
				{
					"order": [[ 4, "desc" ]]
				} );
			} );
		</script>
		<?php 
		$trabalhos = $evento->trabalhos()
		->where('trabalho.categoria_id', $c->id)
		->get()
		?>
		<div class="panel panel-default">
			<div class="panel-heading">
				<h4 class="panel-title">
					<a data-toggle="collapse" data-parent="#accordion{{$c->id}}" href="#collapse{{$c->id}}">
						Geral ( {{$trabalhos->count()}} )
						<span class="caret"></span>
					</a>
				</h4>
			</div>
			<div id="collapse{{$c->id}}" class="panel-collapse collapse">
				<div class="panel-body">
					<table id="table{{$c->id}}" class="table table-condensed table-hover table-striped">
						<thead>
							<tr>
								<th>Cod</th>
								<th>Área</th>
								<th>Título</th>
								<th>Tipo</th>
								<th>Escola</th>
								<th>Média</th>
							</tr>
						</thead>
						<tbody>
							@foreach($trabalhos as $t)
							<tr>
								<td>{{ $t->cod }}</td>
								<td>{{ $t->area->area }}</td>
								<td>{{ $t->titulo }}</td>
								<td>{{ $t->tipoTrabalho->nome }}</td>
								<td>@foreach($t->estudantes as $estudante)
									<div>
										{{$estudante->instituicao->nome}}
									</div>
									@break
									@endforeach
								</td>
								<td>
									<?php 
									$avaliacoes = $t->avaliacoes->where('notas_lancadas', 1)->count();
									$somatorio= 0;
									foreach ($t->avaliacoes->where('notas_lancadas', 1) as $a):
										foreach ($a->notas as $nota):
											$somatorio += $nota->valor * $nota->quesito->peso;
										endforeach;
									endforeach;
									$media = $avaliacoes == 0? "0": $somatorio/$avaliacoes;
									
									printf("<h5>%.2f</h5>", $media); 
									?>
								</td>
							</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<br>
		@foreach($areas as $a)
		<script>
			$(document).ready( function () {
				$('#table{{$c->id}}_{{$a->id}}').DataTable(
				{
					"order": [[ 3, "desc" ]]
				} );
			} );
		</script>
		<?php 
		$trabalhos = $evento->trabalhos()
		->where('trabalho.categoria_id', $c->id)
		->whereIn('trabalho.area_id', [$a->id])
		->get()
		?>
		<div class="panel panel-default">
			<div class="panel-heading">
				<h4 class="panel-title">
					<a data-toggle="collapse" data-parent="#accordion{{$c->id}}" href="#collapse{{$c->id}}_{{$a->id}}">
						{{ $a->sigla }} - {{ $a->area }} ( {{$trabalhos->count()}} )
						<span class="caret"></span>
					</a>
				</h4>
			</div>
			<div id="collapse{{$c->id}}_{{$a->id}}" class="panel-collapse collapse">
				<div class="panel-body">
					<table id="table{{$c->id}}_{{$a->id}}" class="table table-condensed table-hover table-striped">
						<thead>
							<tr>
								<th>Cod</th>
								<th>Título</th>
								<th>Tipo</th>
								<th>Escola</th>
								<th>Média</th>
							</tr>
						</thead>
						<tbody>
							@foreach($trabalhos as $t)
							<tr>
								<td>{{ $t->cod }}</td>
								<td>{{ $t->titulo }}</td>
								<td>{{ $t->tipoTrabalho->nome }}</td>
								<td>@foreach($t->estudantes as $estudante)
									<div>
										{{$estudante->instituicao->nome}}
									</div>
									@break
									@endforeach
								</td>
								<td>
									<?php 
									$avaliacoes = $t->avaliacoes->where('notas_lancadas', 1)->count();
									$somatorio= 0;
									foreach ($t->avaliacoes->where('notas_lancadas', 1) as $a):
										foreach ($a->notas as $nota):
											$somatorio += $nota->valor * $nota->quesito->peso;
										endforeach;
									endforeach;
									$media = $avaliacoes == 0? "0": $somatorio/$avaliacoes;
									printf("<h5>%.2f</h5>", $media); 
									?>
								</td>
							</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<br>
		@endforeach
		<hr>
	</div>	
	@endforeach
	<div class='text-right'>
		<a class='btn btn-primary btn-sm' href="/evento">
			Voltar
		</a>
	</div>
</div>
@endif
@stop 