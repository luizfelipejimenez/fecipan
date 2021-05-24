@extends ('layouts.app')

@section('conteudo')

<div class="jumbotron">
@if ($permissoes->visualizar == true)
	<h1 class="display-4">Eventos</h1>
  	<p class="lead">Nomes dos eventos criados no sistema</p>
  	<hr class="my-4">
	@if ($permissoes->inserir == true)
	<a href="{{route('evento.create')}}" class="btn btn-primary">
		<i data-feather="plus-square"></i>
		Cadastrar Evento
	</a><br><br>
	@endif
	<div class="table-responsive">
	<table id="table" class="table table-bordered table-hover table-striped">
	  <thead>
		<tr>
			<th>Título</th>
			<th>Ano/Sem</th>
			<th>Tema</th>
			<th>Período</th>
			<th class='text-right'>Quesitos</th>
			<th class='text-right'>Trabalhos</th>
			<th class='text-right'>Ações</th>
		</tr>
	  </thead>
	  <tbody>
	@forelse($eventos as $e)
		<tr>
			<td>{{ $e->titulo }}</td>
			<td>{{ $e->ano }}/{{ $e->semestre }}</td>
			<td>{{ $e->tema }}</td>
			<td>
				De {{ date('d/m/Y', strtotime($e->data_inicio)) }}
				até {{ date('d/m/Y', strtotime($e->data_fim)) }}
			</td>
			<td class='text-right'>
				<a class="btn btn-primary" href="\evento\quesitos\{{ $e->id }}" title="Visualizar quesitos de avaliação da {{ $e->titulo }}">
					{{ $e->quesitos->count() }}
				</a>
			</td>
			<td class='text-right'>
				<a class="btn btn-primary" href="\evento\trabalhos\{{ $e->id }}" title="Visualizar trabalhos da {{ $e->titulo }}">
					{{ $e->trabalhos->count() }}
				</a>
			</td>
			<td class='text-right'> 
			  <div class="btn-group" role="group">
			  	<!--<a class='btn btn-secondary' href="/evento/listar/{{$e->id}}" title="Listar participantes de {{$e->titulo}}" data-toggle="tooltip" data-placement="top"> 
					<i data-feather="list"></i>
				</a>-->
				@if ($permissoes->alterar)
				  <a class='btn btn-secondary' href="{{route('evento.edit', $e->id)}}" title="Alterar evento {{$e->titulo}}" data-toggle="tooltip" data-placement="top"> 
					<i data-feather="edit"></i>
				  </a>
				@endif
				@if ($permissoes->excluir)
				  <a class='btn btn-danger' href="#" data-toggle="modal" data-target="#m{{$e->id}}"title="Excluir evento {{$e->titulo}}">
					<i data-feather="trash-2"></i>
				  </a>
				@endif
				  <a class="btn btn-primary " href="/ranking/{{ $e->id }}" data-toggle="tooltip" data-placement="top" title="Ver ranking de trabalhos de {{$e->titulo}}">
				  	Ranking
					<i data-feather="star"></i>
				  </a>
			  </div>
			  <div id="m{{$e->id}}" class="modal fade text-justify" role="dialog">
				  <div class="site-wrapper">
					<div class="modal-dialog">                
					  <div class="modal-content">
						  <div class="modal-header">
							<button type="button" class="close" data-dismiss="modal">&times;</button>
							<h4 class="modal-title">
								<span class="glyphicon glyphicon-alert"></span>
								Exclusão de Evento
							</h4>
						  </div>
						  
						  <div class="modal-body">
							<p>Deseja excluir o evento <strong>{{$e->id}} - {{$e->titulo}}</strong>?</p>
						  </div>
						  
						  <div class="modal-footer">
						  	<form method="POST" action="{{route('evento.destroy', $e->id)}}">
 								@method('delete')
 								@csrf
 								<button type="submit" class="btn btn-danger">Sim</button>
 							</form>
 							<a href="/evento" class="btn btn-info" data-dismiss="modal">Não</a>
						</div>
					  </div>
					</div>
				  </div>
			  </div>
			</td>
		  </tr>
	  @empty
	  <tr>
	  	<th colspan="7">
	  		<p class="lead">Não há eventos cadastrados</p>
	  	</th>
	  </tr>
	  @endforelse
	  </tbody>
	</table>
</div>
</div>
@endif
@stop 