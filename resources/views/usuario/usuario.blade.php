@extends ('layouts.app')
<!--esta visão irá aparecer dentro da principal.blade-->

@section('conteudo')

<h1>Usuários Cadastrados</h1>
<hr>
<a href="\usuario\create\1" class="btn btn-primary">
	<span class="glyphicon glyphicon-user"></span>
	Cadastrar Usuário
</a><br><br>
<table id="table" class="table table-condensed table-hover table-striped">
	<thead>
		<tr>
			<th>#</th>
			<th>Login</th>
			<th>Nome</th>
			<th>Perfil</th>
			<th>CPF</th>
			<th>Sexo</th>
			<th>Dt. Nascimento</th>
			<th>Email</th>
			<th>Ações</th>
		</tr>
	</thead>
	<tbody>
	@foreach ($usuarios as $usuario)
		<tr>
			<td>{{ $usuario->id }}</td>
			<td>{{ $usuario->login }}</td>
			<td>{{ $usuario->pessoa->nome }}</td>
			<td> @foreach(Auth::user()->perfis as $perfil)
            @if($loop->last)
              {{ $perfil->descricao }}  
            @else
              {{ $perfil->descricao }} |
            @endif
          @endforeach</td>
			<td>{{ $usuario->pessoa->cpf }}</td>
			<td>{{ $usuario->pessoa->sexo }}</td>
			<td>{{ $usuario->pessoa->data_nascimento? date("d/m/Y", strtotime($usuario->pessoa->data_nascimento)): "" }}</td>
			<td>{{ $usuario->pessoa->email }}</td>
			<td>
				<div class="btn-group">
					<a href="\usuario\update\{{ $usuario->id }}" class="btn btn-sm btn-primary" title="Alterar usuario">
						<span class="glyphicon glyphicon-edit"></span>
					</a>
					@if ($usuario->isAdmin())
					<a href="#" data-toggle="modal" data-target="#delete_{{ $usuario->id }}" class="btn btn-sm btn-primary" title="Excluir usuario">
						<span class="glyphicon glyphicon-trash"></span>
					</a>
					@endif
				</div>
				@if ($usuario->isAdmin())
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
@endsection