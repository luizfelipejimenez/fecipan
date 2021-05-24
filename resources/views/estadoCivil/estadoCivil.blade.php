@extends ('layouts.app')
<!--esta visão irá aparecer dentro da principal.blade-->

@section('conteudo')

<h1>Estados Civis</h1>
<table class="table table-condensed table-hover table-striped">
	<thead>
		<tr>
			<th>#</th>
			<th>Descrição</th>
			<th>Pessoas</th>
		</tr>
	</thead>
	<tbody>
	@foreach ($estadosCivis as $estadoCivil)
		<tr>
			<td>{{ $estadoCivil->id }}</td>
			<td>{{ $estadoCivil->descricao }}</td>
			<td>{{ $estadoCivil->usuarios->count() }}</td>
		</tr>
	@endforeach
	</tbody>
</table>

@endsection