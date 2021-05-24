@extends ('layouts.app')
<!--esta visão irá aparecer dentro da principal.blade-->

@section('conteudo')

<div class="jumbotron">
  <h1 class="display-4">Orientadores </h1>
  <p class="lead">Orientadores cadastrados no evento</p>
  <hr class="my-4">
  @if ($permissoes->inserir)
	<a href="{{route('orientador.create')}}" class="btn btn-primary">
		<i data-feather="plus-square"></i> 
		Cadastrar Orientador
	</a>
  @endif

<br><br>
<div class="table-responsive">
<table id="table" class="table table-condensed table-hover table-striped">
	<thead>
		<tr>
			<th>Nome</th>
			<th>Instituição</th>
			<th class="text-right">Trabalhos</th>
			<th class="text-right">Ações</th>
		</tr>
	</thead>
	<tbody>
	@forelse ($orientadores as $q)
		<tr>
			<td>{{ $q->pessoa->nome }}</td>
			<td>{{ $q->instituicao->sigla }} - {{ $q->instituicao->nome }}</td>
			<td class="text-right">
				<a class="btn btn-primary" href="\orientador\trabalhos\{{ $q->id }}" title="Visualizar trabalhos cadastrados para este orientador">
					{{ $q->trabalhos->count() }}
				</a>
			</td>
			<td class="text-right">
				<x-crud-view :a="$q" :permissoes="$permissoes" :route="'orientador'" :model="'Orientador'"/>
			</td>
		</tr>
	@empty
		<tr>
			<th colspan="4">
				<p class="lead">Nenhum registro encontrado </p>
			</th>
		</tr>
	@endforelse
	</tbody>
</table>
</div>
</div>
@endsection