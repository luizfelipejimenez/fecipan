@extends ('layouts.app')

@section('conteudo')

<h1>Perfis Cadastrados</h1>
<hr>
<table id="table" class="table table-condensed table-hover table-striped">
	<thead>
		<tr>
			<th>#</th>
			<th>Descrição</th>
			<th>Perfil Pai</th>
			<th class="text-right">Perfis Vinculados</th>
			<th class="text-right">Permissões</th>
			<th class="text-right">Usuários</th>
			<th class="text-right">Ações</th>
		</tr>
	</thead>
	<tbody>
	@foreach ($perfis as $perfil)
		<tr>
			<td>{{ $perfil->id }}</td>
			<td>{{ $perfil->descricao }}</td>
			<td>
				@if ($perfil->perfil)
				{{ $perfil->perfil->descricao }}
				@else
				--
				@endif
			</td>
			<td class="text-right">
				<a class="btn btn-primary btn-sm" href="\perfil\vinculos\{{ $perfil->id }}" title="Visualizar perfis vinculados ao perfil {{ $perfil->descricao }}">
					{{ $perfil->perfis_vinculados->count() }}
				</a>
			</td>
			<td class="text-right">
				<a class="btn btn-primary btn-sm" href="\perfil\permissoes\{{ $perfil->id }}" title="Visualizar permissões atribuídas ao perfil {{ $perfil->descricao }}">
					{{ $perfil->conteudos->count() }}
				</a>
			</td>
			<td class="text-right">
				<a class="btn btn-primary btn-sm" href="\perfil\usuarios\{{ $perfil->id }}" title="Visualizar usuários cadastrados com o perfil {{ $perfil->descricao }}">
					{{ $perfil->usuarios->count() }}
				</a>
			</td>
			<td class="text-right">
				<div class="btn-group">
					<a href="\perfil\create\{{ $perfil->id }}" class="btn btn-sm btn-primary" title="Cadastrar novo perfil vinculado a {{ $perfil->descricao }}">
						<span class="glyphicon glyphicon-link"></span>
					</a>
					@if ($perfil->administrador == 0 && $perfil->perfis_vinculados->count() == 0)
					<a href="#" data-toggle="modal" data-target="#delete_{{ $perfil->id }}" class="btn btn-sm btn-primary" title="Excluir perfil">
						<span class="glyphicon glyphicon-trash"></span>
					</a>
					@endif
				</div>
				<!-- Modal -->
				@if ($perfil->administrador == 0 && $perfil->perfis_vinculados->count() == 0)
				<div id="delete_{{ $perfil->id }}" class="modal fade text-justify" role="dialog">
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
				        <p>Confirma a exclusão do perfil <strong>{{ $perfil->id }} - {{ $perfil->descricao }}</strong>?</p>
				      </div>
				      <div class="modal-footer">
				        <a href="\perfil\delete\{{ $perfil->id }}" class="btn btn-danger">Sim</a>
				        <button class="btn btn-info" data-dismiss="modal">Não</button>
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