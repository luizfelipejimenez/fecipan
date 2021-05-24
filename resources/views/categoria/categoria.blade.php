@extends('layouts.app')

@section('conteudo')

@if ($permissoes->visualizar)
	<h1>Categoria</h1>
	<hr>
	@if ($permissoes->inserir)
	  <a href="/categoria/create" class="btn btn-primary"><span class="glyphicon glyphicon-file"></span> Cadastrar Categoria</a><br><br>
	@endif
	<table id="table" class="table table-striped table-hover">
	  <thead>
		<tr>
			<th>#</th>
			<th>Descrição</th>
			<th class="text-right">Ações</th>
		</tr>
	  </thead>
	  <tbody>
	@foreach($categorias as $a)
		<tr>
			<td>{{ $a->id }}</td>
			<td>{{ $a->descricao }}</td>
			<td class="text-right">
			  <div class="btn-group">
			  @if ($permissoes->alterar)
				  <a class="btn btn-sm btn-primary" href="/categoria/update/{{$a->id}}" title="Alterar categoria"><span class="glyphicon glyphicon-pencil"></span></a>
			  @endif
			  @if ($permissoes->excluir)
			    <a href="#" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#{{$a->id}}" title="Excluir categoria"><span class="glyphicon glyphicon-trash"></span></a>
			  @endif
			  </div>
				<div id="{{$a->id}}" class="modal fade text-justify" role="dialog">
				  <div class="site-wrapper">
					<div class="modal-dialog">                
					  <div class="modal-content">
						  <div class="modal-header">
							<button type="button" class="close" data-dismiss="modal">&times;</button>
							<h4 class="modal-title">
								<span class="glyphicon glyphicon-alert"></span>
								Exclusão de Categoria
							</h4>
						  </div>
						  
						  <div class="modal-body">
							<p>Confirma a exclusão da categoria <strong>{{ $a->id }} - {{ $a->descricao }}</strong>?</p>
						  </div>
						  
						  <div class="modal-footer">
							<a href="/categoria/delete/{{$a->id}}" class="btn btn-danger">Sim</a>
							<a href="/categoria" class="btn btn-info" data-dismiss="modal">Não</a>
						</div>
					  </div>
					</div>
				  </div>
				</div>
			  </td>
			</td>
		</tr>
	  @endforeach
	  </tbody>
	</table>
@endif
@stop