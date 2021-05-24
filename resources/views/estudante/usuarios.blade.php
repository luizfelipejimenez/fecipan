@extends ('layouts.app')
<!--esta visão irá aparecer dentro da principal.blade-->

@section('conteudo')

<h1>Usuários associados a #{{$pessoa->id}} - {{$pessoa->nome}}</h1>
	<div class='text-right'>
	  <a class='btn btn-primary btn-sm' href="/pessoa">
		Voltar
	  </a>
	</div>
<hr>
<a href="\pessoa\usuario\create\{{$pessoa->id}}" class="btn btn-primary">
	<span class="glyphicon glyphicon-file"></span>
	Cadastrar Usuário
</a><br><br>
<table id="table" class="table table-condensed table-hover table-striped">
	<thead>
		<tr>
			<th>#</th>
			<th>Login</th>
			<th>Perfil</th>
			<th>Status</th>
			<th>Ações</th>
		</tr>
	</thead>
	<tbody>
	@foreach ($pessoa->usuarios as $usuario)
		<tr>
			<td>{{ $usuario->id }}</td>
			<td>{{ $usuario->login }}</td>
			<td>{{ $usuario->perfil->descricao }}</td>
			<td>{{ $usuario->ativo? "Ativo": "Inativo" }}</td>
			<td>...</td>
		</tr>
	@endforeach
	</tbody>
</table>
<hr>
<!--
<a href="\perfil\create" class="btn btn-primary">
	<span class="glyphicon glyphicon-file"></span>
	Cadastrar Perfil
</a>
-->
@endsection