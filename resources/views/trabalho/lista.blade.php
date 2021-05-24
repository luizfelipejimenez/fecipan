@extends('layouts.app')

@section('conteudo')

@if ($permissoes->visualizar)
	<h1>
		Trabalhos Cadastrados na
		{{ $evento->titulo }} {{ $evento->ano }}/{{ $evento->semestre }}
	</h1>
	<p>
		{{ $evento->tema }}
	</p>
	<hr>
	<div class='text-right'>
	  <a class='btn btn-primary btn-sm' href="/evento">
		Voltar
	  </a>
	</div>
	<br><br>

        <script>
$(document).ready( function () {
    $('#tableTrabalhos').DataTable(
		{
			"order": [[ 7, "desc" ]]
		} );
} );
		</script>
	<table id="tableTrabalhos" class="table table-condensed table-hover table-striped">
		<thead>
		  <tr>
			<th>Cod</th>
			<th>Trabalho</th>
			<th>Categoria</th>
			<th>Área</th>
			<th>Escola</th>
			<th class='text-right'>Orientadores</th>
			<th class='text-right'>Alunos</th>
		  </tr>
		</thead>
		<tbody>
		@foreach($evento->trabalhos->sortBy('categoria_id') as $t)
		  <tr>
			<td>{{ $t->cod }}</td>
			<td>{{ $t->titulo }}</td>
			<td>{{ $t->categoria->descricao }}</td>
			<td>{{ $t->area->sigla }}</td>
			<td>{{ $t->orientador()->first()->instituicao->nome }}</td>
			<td class='text-right'>
				@foreach($t->orientadores as $key => $orientador)
					@if(count($t->orientadores) > 1 && $key == count($t->orientadores)-1 )
					 e 
					@endif
					{{ ucwords(strtolower($orientador->pessoa->nome)) }}
					
				@endforeach
			</td>
			<td class='text-right'>
				@foreach($t->estudantes as $key => $estudante)
					@if(count($t->estudantes) > 1 && $key == count($t->estudantes)-1 )
					 e 
					@endif
					{{ ucwords(strtolower($estudante->pessoa->nome)) }}
					
				@endforeach
			</td>
			
		  </tr>
		@endforeach
		</tbody>
	</table>
	<div class='text-right'>
	  <a class='btn btn-primary btn-sm' href="/evento">
		Voltar
	  </a>
	</div>
@endif
@stop 