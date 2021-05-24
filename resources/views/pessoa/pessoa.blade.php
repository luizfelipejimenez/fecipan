@extends ('layouts.app')
<!--esta visão irá aparecer dentro da principal.blade-->

@section('conteudo')

<h1>Dados Pessoais Cadastrados</h1>
<hr>
<!--
<a href="\pessoa\create" class="btn btn-primary">
	<span class="glyphicon glyphicon-file"></span>
	Cadastrar Pessoa
</a>--><br><br>

<table id="table" class="table table-condensed table-hover table-striped">
	<thead>
		<tr>
			<th>#</th>
			<th>Nome</th>
			<th>Sexo</th>
			<th>Data de Nascimento</th>
			<th>Email</th>
			<th>Telefone 1</th>
			<th>Telefone 2</th>
			<th class="text-right">Usuários</th>
			<th>Ações</th>
		</tr>
	</thead>
	<tbody>
	@foreach ($pessoas as $pessoa)
		<tr>
			<td>{{ $pessoa->id }}</td>
			<td>{{ $pessoa->nome }}</td>
			<td>{{ $pessoa->sexo }}</td>
			<td>{{ $pessoa->data_nascimento }}</td>
			<td>{{ $pessoa->email }}</td>
			<td>{{ $pessoa->telefone_1 }}</td>
			<td>{{ $pessoa->telefone_2 }}</td>
			<td class="text-right">
				<a class="btn btn-primary btn-sm" href="\pessoa\usuarios\{{ $pessoa->id }}" title="Visualizar usuários cadastrados para esta pessoa">
					{{ $pessoa->usuarios->count() }}
				</a>
			</td>
			<td>
				<div class="btn-group">
					<a href="#" data-toggle="modal" data-target="#delete_{{ $pessoa->id }}" class="btn btn-sm btn-primary" title="Excluir dados pessoais">
						<span class="glyphicon glyphicon-trash"></span>
					</a>
				</div>
				<!-- Modal -->
				<div id="delete_{{ $pessoa->id }}" class="modal fade text-justify" role="dialog">
				  <div class="modal-dialog">

				    <!-- Modal content-->
				    <div class="modal-content">
				      <div class="modal-header">
				        <button type="button" class="close" data-dismiss="modal">&times;</button>
				        <h4 class="modal-title">
				        	<span class="glyphicon glyphicon-alert"></span>
				        	Exclusão dos Dados Pessoais de {{$pessoa->nome}}
				       	</h4>
				      </div>
				      <div class="modal-body">
				        <p>Confirma a exclusão dos dados de <strong>{{ $pessoa->id }} - {{ $pessoa->nome }}</strong>?</p>
				      </div>
				      <div class="modal-footer">
				        <a href="\pessoa\delete\{{ $pessoa->id }}" class="btn btn-danger">Sim</a>
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
<hr>
@endsection