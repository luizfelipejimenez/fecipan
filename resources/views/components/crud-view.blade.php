 <div class="btn-group"role="group">
 	@if ($permissoes->alterar)
 	<a class="btn btn-sm btn-outline-secondary" href="{{route($route.'.edit', $a->id)}}" data-toggle="tooltip" data-placement="top" title="Editar {{$model}}"><i data-feather="pen-tool"></i> 
 	</a>
 	@endif
 	@if ($permissoes->excluir)
 	<a href="#" class="btn btn-sm btn-outline-danger" data-toggle="modal" data-target="#modal-{{$a->id}}" title="Excluir {{$model}}"><i data-feather="trash-2"></i>
 	</a>
 	@endif
 </div>
 <div id="modal-{{$a->id}}" class="modal fade text-justify" tabindex="-1" aria-labelledby="ml{{$a->id}}" aria-hidden="true">
 	<div class="modal-dialog">                
 		<div class="modal-content">
 			<div class="modal-header">
 				<h5 class="modal-title" id="ml{{$a->id}}">
 					<i data-feather="alert-triangle"></i> 
 					Exclusão de {{$model}}
 				</h5>
 				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
 					<span aria-hidden="true">&times;</span>
 				</button>
 			</div>

 			<div class="modal-body">
 				<p>Confirma a exclusão de {{$model}} <strong>{{ $a->id }} </strong>?</p>
 			</div>

 			<div class="modal-footer">
 				<form method="POST" action="{{route($route.'.destroy', $a->id)}}">
 					@method('delete')
 					@csrf
 					<button type="submit" class="btn btn-danger">Sim</button>
 				</form>
 				<a href="/{{$route}}" class="btn btn-info" data-dismiss="modal">Não</a>
 			</div>
 		</div>
 	</div>

 </div>