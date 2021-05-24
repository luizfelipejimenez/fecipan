@extends ('layouts.app')
<!--esta visão irá aparecer dentro da principal.blade-->

@section('conteudo')

<h1>Permissões para o Conteudo {{ $conteudo->rotulo }}</h1>
<hr>
<div class='text-right'>
  <a class='btn btn-primary btn-sm' href="/conteudo">
	Voltar
  </a>
</div>
<a href="\conteudo\associar\{{ $conteudo->id }}" class="btn btn-primary">
	<span class="glyphicon glyphicon-link"></span>
	Associar Conteúdo {{$conteudo->rotulo}} a outro Perfil
</a><br><br>
<table id="table" class="table table-condensed table-hover table-striped">
	<thead>
		<tr>
			<th>#</th>
			<th>Perfil</th>
			<th>Visualizar</th>
			<th>Inserir</th>
			<th>Alterar</th>
			<th>Excluir</th>
			<th>Ações</th>
		</tr>
	</thead>
	<tbody>
	@foreach ($conteudo->perfis as $perfil)
		<tr>
			<td>{{ $perfil->id }}</td>
			<td>{{ $perfil->descricao }}</td>
			<td>{{ $perfil->pivot->visualizar? "Sim": "Não" }}</td>
			<td>{{ $perfil->pivot->inserir? "Sim": "Não" }}</td>
			<td>{{ $perfil->pivot->alterar? "Sim": "Não" }}</td>
			<td>{{ $perfil->pivot->excluir? "Sim": "Não" }}</td>
			<td>
				<div class="btn-group">
					<a href="\permissao\update\{{ $conteudo->id }}\{{ $perfil->id }}" class="btn btn-sm btn-primary" title="Alterar permissões">
						<span class="glyphicon glyphicon-edit"></span>
					</a>
					<a href="#" data-toggle="modal" data-target="#delete_{{ $perfil->id }}" class="btn btn-sm btn-primary" title="Excluir usuario">
						<span class="glyphicon glyphicon-trash"></span>
					</a>
				</div>
				<!-- Modal -->
				<div id="delete_{{ $perfil->id }}" class="modal fade text-justify" role="dialog">
				  <div class="modal-dialog">

				    <!-- Modal content-->
				    <div class="modal-content">
				      <div class="modal-header">
				        <button type="button" class="close" data-dismiss="modal">&times;</button>
				        <h4 class="modal-title">
				        	<span class="glyphicon glyphicon-alert"></span>
				        	Exclusão de Permissão
				       	</h4>
				      </div>
				      <div class="modal-body">
				        <p>Confirma a exclusão das permissões do perfil <strong>{{ $perfil->id }} - {{ $perfil->descricao }}</strong> para este conteúdo?</p>
				      </div>
				      <div class="modal-footer">
				        <a href="\permissao\delete\{{ $conteudo->id }}\{{ $perfil->id }}" class="btn btn-danger">Sim</a>
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
<div class='text-right'>
  <a class='btn btn-primary btn-sm' href="/conteudo">
	Voltar
  </a>
</div>
@stop