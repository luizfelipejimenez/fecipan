@extends ('layouts.app')
<!--esta visão irá aparecer dentro da principal.blade-->

@section('conteudo')

<h1>Usuários associados a {{$pessoa->nome}}</h1>
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
			<td>
				<div class="btn-group">
					<a href="\usuario\update\{{ $usuario->id }}" class="btn btn-sm btn-primary" title="Alterar usuario">
						<span class="glyphicon glyphicon-edit"></span>
					</a>
					@if ($usuario->perfil->administrador == 0)
					<a href="#" data-toggle="modal" data-target="#delete_{{ $usuario->id }}" class="btn btn-sm btn-primary" title="Excluir usuario">
						<span class="glyphicon glyphicon-trash"></span>
					</a>
					@endif
				</div>
				@if ($usuario->perfil->administrador == 0)
				<!-- Modal -->
				<div id="delete_{{ $usuario->id }}" class="modal fade text-justify" role="dialog">
				  <div class="modal-dialog">

				    <!-- Modal content-->
				    <div class="modal-content">
				      <div class="modal-header">
				        <button type="button" class="close" data-dismiss="modal">&times;</button>
				        <h4 class="modal-title">
				        	<span class="glyphicon glyphicon-alert"></span>
				        	Exclusão de Usuário
				       	</h4>
				      </div>
				      <div class="modal-body">
				        <p>Confirma a exclusão do usuário <strong>{{ $usuario->id }} - {{ $usuario->login }}</strong>?</p>
				      </div>
				      <div class="modal-footer">
				        <a href="\usuario\delete\{{ $usuario->id }}" class="btn btn-danger">Sim</a>
				        <button type="button" class="btn btn-info" data-dismiss="modal">Não</button>
				      </div>
				    </div>

				  </div>
				</div>
				@endif
			</td>
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