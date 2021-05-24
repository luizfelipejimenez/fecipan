@extends ('layouts.app')
<!--esta visão irá aparecer dentro da principal.blade-->

@section('conteudo')

<div class="jumbotron">
  <h1 class="display-4">Estudantes Cadastrados</h1>
  <p class="lead">Todos os estudantes cadastrados no sistema</p>
  <hr class="my-4">
@if ($permissoes->inserir)
<a href="{{route('estudante.create')}}" class="btn btn-primary">
	<i data-feather="plus-square"></i>
	Cadastrar Estudante
</a>
@endif
<br><br>
<div class="table-responsive">
<table id="table" class="table table-condensed table-hover table-striped">
	<thead>
		<tr>
			<th>#</th>
			<th>Nome</th>
			<th>Instituição</th>
			<th class="text-right">Trabalhos</th>
			<th class="text-right">Ações</th>
		</tr>
	</thead>
	<tbody>
	@forelse ($estudantes as $q)
		<tr>
			<td>{{ $q->id }}</td>
			<td>{{ $q->pessoa->nome }}</td>
			<td>{{ $q->instituicao->sigla }} - {{ $q->instituicao->nome }}</td>
			<td class="text-right">
				<a class="btn {{$q->trabalhos->count() > 0 ? 'btn-primary' : 'btn-outline-warning'}}" href="\estudante\trabalhos\{{ $q->id }}" title="Visualizar trabalhos cadastrados para este estudante">
					<i data-feather="eye"></i>
					&nbsp
					{{ $q->trabalhos->count() }}
				</a>
			</td>
			<td class="text-right">
				<x-crud-view :a="$q" :permissoes="$permissoes" :route="'estudante'" :model="'Estudante'"/>
			</td>
		</tr>
	@empty
	<tr>
		<td colspan="5">Nenhum estudante registrado no sistema </td>
	</tr>
	@endforelse
	</tbody>
</table>
</div>
</div>
@endsection