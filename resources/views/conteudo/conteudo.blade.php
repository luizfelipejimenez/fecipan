@extends ('layouts.app')

@section('conteudo')

<div class="jumbotron">
  <h1 class="display-4">Conteúdos Cadastrados</h1>
  <p class="lead">Regras utilizadas para acesso dos perfis às áreas cadastradas na rota</p>
  <hr class="my-4">
<a href="\conteudo\create" class="btn btn-primary"><span class="glyphicon glyphicon-file"></span> Cadastrar Conteúdo</a><br><br>
<table id="table" class="table table-condensed table-hover table-striped">
	<thead>
		<tr>
			<th>#</th>
			<th>Rota</th>
			<th>Rótulo</th>
			<th>Visibilidade</th>
			<th>Menu</th>
			<th class="text-right">Permissões</th>
			<th class="text-right">Ações</th>
		</tr>
	</thead>
	<tbody>
	@foreach ($conteudos as $conteudo)
		<tr>
			<td>{{ $conteudo->id }}</td>
			<td>{{ $conteudo->rota }}</td>
			<td>{{ $conteudo->rotulo }}</td>
			<td>{{ $conteudo->publica == true? 'Público': 'Privado' }}</td>
			<td>{{ $conteudo->menu == true? 'Sim': 'Não' }}</td>
			<td class="text-right">
				<a class="btn btn-primary btn-sm" href="\conteudo\permissoes\{{ $conteudo->id }}" title="Visualizar perfis com acesso a este conteúdo">
					{{ $conteudo->perfis->count() }}
				</a>
			</td>
			<td class="text-right">
				<div class="btn-group">
					<a href="\conteudo\update\{{ $conteudo->id }}" class="btn btn-sm btn-primary" title="Alterar conteúdo">
						<span class="glyphicon glyphicon-edit"></span>
					</a>
					<a href="#" data-toggle="modal" data-target="#delete_{{ $conteudo->id }}" class="btn btn-sm btn-primary" title="Excluir usuario">
						<span class="glyphicon glyphicon-trash"></span>
					</a>
				</div>
				<!-- Modal -->
				<div id="delete_{{ $conteudo->id }}" class="modal fade text-justify" role="dialog">
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
				        <p>Confirma a exclusão do conteúdo <strong>{{ $conteudo->id }} - {{ $conteudo->rotulo }}</strong>?</p>
				      </div>
				      <div class="modal-footer">
				        <a href="\conteudo\delete\{{ $conteudo->id }}" class="btn btn-danger">Sim</a>
				        <button type="button" class="btn btn-info" data-dismiss="modal">Não</button>
				      </div>
				    </div>

				  </div>
				</div>
			</td>
		</tr>
	@endforeach
	</tbody>
</table>
</div>

@endsection