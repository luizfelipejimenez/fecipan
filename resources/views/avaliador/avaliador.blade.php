@extends ('layouts.app')
<!--esta visão irá aparecer dentro da principal.blade-->

@section('conteudo')

<div class="jumbotron">
  <h1 class="display-4">Avaliadores Cadastrados</h1>
  <p class="lead">Todos os avaliadores cadastrados no sistema.</p>
  <hr class="my-4">
@if ($permissoes->inserir)
<a href="{{route('avaliador.create')}}" class="btn btn-primary">
	<i data-feather="plus-square"></i>
	Cadastrar Avaliador
</a>
@endif
<hr class="my-4">
<div class="table-responsive">
<table id="table" class="table table-bordered table-hover table-striped">
	<thead>
		<tr>
			<th>#</th>
			<th>Nome</th>
			<th>Email</th>
			<th>Área</th>
			
			<th class="text-right">Avaliações</th>
			<th>Ações</th>
		</tr>
	</thead>
	<tbody>
	@foreach ($avaliadores as $q)
		<tr style="{{ $q->pessoa->usuario->ativo ? 'border-right: 5px solid green': 'border-right: 5px solid red' }}">
			<td>{{ $q->id }}</td>
			<td>{{ $q->pessoa->nome }}</td>
			<td>{{ $q->pessoa->usuario->email }}</td>
			<td>{{ $q->area }}</td>
			
			<td class="text-right">
				
					{{ $q->avaliacoes->count() }}
				
			</td>
			<td class="text-right">
			 	<x-crud-view :a="$q" :permissoes="$permissoes" :route="'avaliador'" :model="'Avaliador'"/>
			</td>
		</tr>
	@endforeach
	</tbody>
</table>
</div>
</div>
@endsection