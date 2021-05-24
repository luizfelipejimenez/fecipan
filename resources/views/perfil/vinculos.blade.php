@extends ('layouts.app')
<!--esta visão irá aparecer dentro da principal.blade-->

@section('conteudo')

<h1>Perfis Vinculados ao Perfil {{ $perfil->descricao }}</h1>
<hr>
<div class='text-right'>
  <a class='btn btn-primary btn-sm' href="/perfil">
	Voltar
  </a>
</div>
<a href="\perfil\create\{{ $perfil->id }}" class="btn btn-primary">
	<span class="glyphicon glyphicon-link"></span>
	Vincular Perfil a {{ $perfil->descricao }}
</a><br><br>
<table id="table" class="table table-condensed table-hover table-striped">
	<thead>
		<tr>
			<th>#</th>
			<th>Descrição</th>
			<th class="text-right">Usuários</th>
			<th class="text-right">Perfis Vinculados</th>
			<th class="text-right">Ações</th>
		</tr>
	</thead>
	<tbody>
	@foreach ($perfil->perfis_vinculados as $vinculo)
		<tr>
			<td>{{ $vinculo->id }}</td>
			<td>{{ $vinculo->descricao }}</td>
			<td class="text-right">
				<a class="btn btn-primary btn-sm" href="\perfil\usuarios\{{ $vinculo->id }}" title="Visualizar perfis vinculados">
					{{ $vinculo->usuarios->count() }}
				</a>
			</td>
			<td class="text-right">
				<a class="btn btn-primary btn-sm" href="\perfil\vinculos\{{ $vinculo->id }}" title="Visualizar perfis vinculados">
					{{ $vinculo->perfis_vinculados->count() }}
				</a>
			</td>
			<td class="text-right">
				<div class="btn-group">
					<a href="\perfil\create\{{ $vinculo->id }}" class="btn btn-sm btn-primary" title="Vincular perfil a {{ $vinculo->descricao }}">
						<span class="glyphicon glyphicon-link"></span>
					</a>
					@if ($vinculo->administrador == 0)
					<a href="#" data-toggle="modal" data-target="#delete_{{ $vinculo->id }}" class="btn btn-sm btn-primary" title="Excluir perfil">
						<span class="glyphicon glyphicon-trash"></span>
					</a>
					@endif
				</div>
				<!-- Modal -->
				@if ($vinculo->administrador == 0)
				<div id="delete_{{ $vinculo->id }}" class="modal fade text-justify" role="dialog">
				  <div class="modal-dialog">

				    <!-- Modal content-->
				    <div class="modal-content">
				      <div class="modal-header">
				        <button type="button" class="close" data-dismiss="modal">&times;</button>
				        <h4 class="modal-title">
				        	<span class="glyphicon glyphicon-alert"></span>
				        	Exclusão de Perfil
				       	</h4>
				      </div>
				      <div class="modal-body">
				        <p>Confirma a exclusão do perfil <strong>{{ $vinculo->id }} - {{ $vinculo->descricao }}</strong>?</p>
				      </div>
				      <div class="modal-footer">
				        <a href="\perfil\delete\{{ $vinculo->id }}" class="btn btn-danger">Sim</a>
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
<div class='text-right'>
  <a class='btn btn-primary btn-sm' href="/perfil">
	Voltar
  </a>
</div><br><br>
@stop