@extends('layouts.app')

@section('conteudo')
@if ($permissoes->visualizar)
<div class="jumbotron">
  <h1 class="display-4">Trabalhos Cadastrados na {{ $evento->titulo }} {{ $evento->ano }}/{{ $evento->semestre }}</h1>
  <p class="lead">{{ $evento->tema }}</p>
	<div class='text-right'>
	  <a class='btn btn-primary btn-sm' href="/evento">
		Voltar
	  </a>
	</div>
	@if ($permissoes->inserir == true)
	<a href="\trabalho\create\{{ $evento->id }}" class="btn btn-primary">
		<i data-feather="plus-square"></i>
		Cadastrar Trabalho
	</a>
	@endif
	<br><br>

        <script>
$(document).ready( function () {
    $('#tableTrabalhos').DataTable(
		{
			"order": [[ 7, "desc" ]],
			paging: false,
					language: {
						search : "Buscar na tabela",
						info:  "Exibindo os trabalhos de _START_ &agrave; _END_ de _TOTAL_ trabalhos",
						infoEmpty: "Nenhum elemento encontrado com esse parâmetro de busca",
						infoFiltered:   "(filtrado de _MAX_ trabalhos no total)",
						zeroRecords:    "Nenhum item para exibir",
					}
		} );
} );
		</script>
	<table id="tableTrabalhos" class="table table-condensed table-hover table-striped">
		<thead>
		  <tr>
			<th>Cod</th>
			<th>Trabalho</th>
			<th>Tipo</th>
			<th>Categoria</th>
			<th class='text-right'>Avaliações Feitas</th>
			<th class='text-right'>Estudantes</th>
			<th class='text-right'>Orientadores</th>
			<!--<th class='text-right'>Média</th>-->
			<th class='text-right'>Ações</th>
		  </tr>
		</thead>
		<tbody>
		@forelse($evento->trabalhos as $t)
		  <tr>
			<td>{{ $t->cod }}</td>
			<td>{{ $t->titulo }}</td>
			<td>{{ $t->tipoTrabalho->nome }}</td>
			<td>{{ $t->categoria->descricao }}</td>
			<td class='text-center	'>
				<a class="btn  {{$t->avaliacoes->where('notas_lancadas', 1)->count() == $t->avaliacoes->count() &&  $t->avaliacoes->count() != 0 ? 'btn-success' : 'btn-warning'}}" href="\trabalho\avaliacoes\{{ $t->id }}" title="Visualizar avaliações para o trabalho {{ $t->cod }}">
					{{ $t->avaliacoes->where("notas_lancadas", 1)->count() }} de {{ $t->avaliacoes->count() }}
				</a>
			</td>
			<td class='text-center'>
				<a class="btn btn-primary btn-xs" href="\trabalho\estudantes\{{ $t->id }}" title="Visualizar estudantes do trabalho {{ $t->cod }}">
					{{ $t->estudantes->count() }}
				</a>
			</td>
			<td class='text-center'>
				<a class="btn btn-primary btn-xs" href="\trabalho\orientadores\{{ $t->id }}" title="Visualizar orientadores do trabalho {{ $t->cod }}">
					{{ $t->orientadores->count() }}
				</a>
			</td>
			<!--<td class="text-right">
			<?php 
			//	$avaliacoes = $t->avaliacoes->where('notas_lancadas', 1)->count();
			//	$somatorio= 0;
			//	foreach ($t->avaliacoes->where('notas_lancadas', 1) as $a):
			//		foreach ($a->notas as $nota):
			//			$somatorio += $nota->valor * $nota->quesito->peso;
			//		endforeach;
			//	endforeach;
			//	$media = $avaliacoes == 0? "0": $somatorio/$avaliacoes;
			//	printf("<h5>%.2f</h5>", $media); 
			?>
			</td>-->
			<td class="text-right">
			 	<x-crud-view :a="$t" :permissoes="$permissoes" :route="'trabalho'" :model="'Trabalho'"/>
			</td>
		  </tr>
		@empty
		<tr>
			<td colspan="9">Nenhum trabalho vinculado a este evento</td>
		</tr>
		@endforelse
		</tbody>
	</table>
	<div class='text-right'>
	  <a class='btn btn-primary btn-sm' href="/evento">
		Voltar
	  </a>
	</div>
</div>
@endif
@stop 