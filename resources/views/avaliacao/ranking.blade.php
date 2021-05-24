@extends ('layouts.app')

@section('conteudo')

@if ($permissoes->visualizar == true)
<div class="jumbotron">
	<h1 class="display-4">Ranking da {{ $evento->titulo }} {{ $evento->ano }}/{{ $evento->semestre }}</h1>
	<p class="lead">{{ $evento->tema }}</p>
	<div class='text-right'>
		<a class='btn btn-primary btn-sm' href="/evento">
			Voltar
		</a>
	</div>
	
	<ul class="nav nav-pills nav-fill mt-2	" id="myTab" role="tablist">
		<li class="nav-item" role="presentation">
			<a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Melhores da feira</a>
		</li>
		@foreach($evento->categorias as $categoria)
		<li class="nav-item" role="presentation">
			<a class="nav-link" id="categoria-tab-{{$categoria->id}}" data-toggle="tab" href="#categoria-{{$categoria->id}}" role="tab" aria-controls="categoria-{{$categoria->id}}" aria-selected="false">{{$categoria->descricao}}</a>
		</li>
		@endforeach
	</ul>
	<div class="tab-content" id="myTabContent">
		<hr class="my-4">
		<div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
			Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
			tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
			quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
			consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
			cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
			proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
		</div>


		@foreach($evento->categorias as $categoria)
		<div class="tab-pane fade" id="categoria-{{$categoria->id}}" role="tabpanel" aria-labelledby="categoria-{{$categoria->id}}-tab">
			@php 
			$c = "c".$loop->index;
			@endphp
			
			<script>
				$(document).ready( function () {
					$('#table-{{$c}}').DataTable({
						"order": [[ 4, "desc" ]],
						paging: false,
						language: {
							search : "Buscar na tabela",
							info:  "Exibindo os trabalhos de _START_ &agrave; _END_ de _TOTAL_ trabalhos",
							infoEmpty: "Nenhum elemento encontrado com esse parâmetro de busca",
							infoFiltered:   "(filtrado de _MAX_ trabalhos no total)",
							zeroRecords:    "Nenhum item para exibir",
						}
					});
				} );
			</script>
			<hr class="my-4">
			<div class="row row-cols-1">
				@foreach($categoria->areas as $area)
				<div class="col mb-1">
					<div class="card">
						<div class="card-header">
							<a class="btn btn-link" data-toggle="collapse" href="#{{$c}}-card-{{$loop->index}}" role="button" aria-expanded="false" aria-controls="collapseExample">
								{{$area->area}}
							</a>
						</div>
						<div class="card-body collapse table-responsive" id="{{$c}}-card-{{$loop->index}}">
							<table id="table-{{$c}}" class="table table-condensed table-hover table-striped">
								<thead>
									<tr>
										<th>Cod</th>
										<th>Título</th>
										<th>Tipo</th>
										<th>Escola</th>
										<th>Média</th>
										<th>Video</th>
										<th>Resumo</th>
									</tr>
								</thead>
								<tbody>
									@forelse($area->trabalhos as $t)
									<tr>
										<td>{{ $t->cod }}</td>
										<td>{{ $t->titulo }}</td>
										<td>{{ $t->tipoTrabalho->nome }}</td>
										<td>@foreach($t->estudantes as $estudante)
											<div>
												{{$estudante->instituicao->nome}}
											</div>
											@break
											@endforeach
										</td>
										<td>
											{{$t->notas_count}}
										</td>
										<td>
											{{$t->video_count}}
										</td>
										<td>
											{{$t->resumo_count}}
										</td>
									</tr>
									@empty
									<tr>
										<td colspan="7">
										Sem notas atribuidas para esta área
										</td>
									</tr>
									@endforelse
								</tbody>
							</table>
						</div>
					</div>
				</div>
				@endforeach
			</div>
		</div>
		@endforeach
	</div>


	<div class='text-right'>
		<a class='btn btn-primary btn-sm' href="/evento">
			Voltar
		</a>
	</div>
</div>

@endif
@stop 