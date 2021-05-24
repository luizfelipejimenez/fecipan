@extends('layouts.app')

@section('conteudo')

@if ($permissoes->visualizar)
	<div class="jumbotron">
	  <h1 class="display-4">Questionário de Avaliação</h1>
	 	<p class="lead"><strong>Código:</strong> {{ $avaliacao->trabalho->cod }}</p>
  		<p class="lead"><strong>Trabalho:</strong>
			{{ $avaliacao->trabalho->titulo }}</p>
		<p class="lead"><strong>Categoria:</strong> {{ $avaliacao->trabalho->categoria->descricao }}</p>
		<p class="lead"><strong>Avaliador:</strong> {{ $avaliacao->avaliador->pessoa->nome }}</p>
		<div class="row">
			<div class="col-6">
				<a href="{{$avaliacao->trabalho->video}}" target="_blank" class="btn btn-outline-danger btn-lg btn-block">
					<i data-feather="youtube" width="120" height="120"></i><br>
					Assistir video do trabalho 
				</a>
			</div>
			<div class="col-6">
				<a href="{{route('trabalho.download', $avaliacao->trabalho->id )}}" target="_blank" class="btn btn-outline-info btn-lg btn-block">
					<i data-feather="file-text" width="120" height="120"></i><br>
					Download do projeto
				</a>
			</div>
		</div>
  		<hr class="my-4">
  		@if(!$avaliacao->trabalho->evento->finalizado)
		<form class="form-horizontal d-flex flex-column" action="/avaliacao/notas" method="POST">
			@csrf
			<input type="hidden" name="avaliacao_id" value="{{ $avaliacao->id }}" />
			  <div class="form-group row">
			  	<div class="col-6">
				@foreach($avaliacao->trabalho->orientadores as $o)
					<b>{{ $o->pivot->tipo_orientacao == 1? "Orientador": "Coorientador" }}:</b> {{ $o->pessoa->nome }}
				@endforeach
				</div>
				<div class="col-6">
				@foreach($avaliacao->trabalho->estudantes as $es)
					<b>Estudante:</b> {{ $es->pessoa->nome }}<br>
				@endforeach
				</div>
			  </div>
			  <?php $i = 1 ?>
			  @foreach ($avaliacao->notas as $n)
			  <hr>
			  <div class="form-group row">
			  	<label class="col-12 col-form-label" for="notas[{{ $n->id }}]">
			  		@if($avaliacao->trabalho->isCientifico())
			  			{{$i++}} - {{$n->quesito->cientifico}} 
			  		@else
			  			{{$i++}} - {{$n->quesito->tecnologico}} 
			  		@endif
			  	</label>
		  	 	
		  	 	<div class="col-10"> 
		  	 	 	<input name="notas[{{ $n->id }}]" id="notas[{{ $n->id }}]"  type="range" identification="{{ $n->id }}" value="{{ is_null($n->valor)? 0 : $n->valor }}" min="0" max="10" step="0.1" class="notas form-control input-xs" placeholder="De 0.0 até 10.0" required>
		  	 	</div>
		  	 	<div class="col-2">
		  	 		<strong id="snotas{{ $n->id }}" class='text-info'></strong>
		  	 	</div>
			  </div>
			  <div class="form-group row">
			  	<div class="col-12">
			  		<label for="comentarios[{{$n->id}}]">
			  			<i data-feather="info"></i>
			  			Gostaria de deixar alguma dica ou informação sobre este quesito ?
			  		</label>
			  	</div>
			  	<div class="col-12">
			  		<textarea class="form-control" id="comentarios[{{$n->id}}]" name="comentarios[{{$n->id}}]" rows="3" placeholder="Sinta-se à vontade a deixar um comentário ao estudante sobre o quesito acima">{{$n->comentario != '' ? $n->comentario : ""}}</textarea>
			  	</div>
			  </div>
			  <div class="col-12">
			  	<hr class="my-4">
			  </div>
			  @endforeach
			  <x-form-buttons :route="'avaliador/minhas-avaliacoes'"/>	
		</form>
		@else
			<h1 class="display-2 text-center text-danger">Avaliação encerrada!</h1>
		@endif
	  
	</div>
		<!--<div class="text-center">
			<a href="javascript: window.print();" class="hidden-print btn btn-primary no-print" class="btn btn-primary"><span class="glyphicon glyphicon-print"></span> Imprimir</a>
		</div>-->
	<script type="text/javascript">
		$(document).ready(function(){
			const notas = $('.notas');
			//console.log(notas);
			notas.each(function (index, nota) {
				nota = $(nota);
				snota = $('#snotas'+nota.attr("identification"));
				snota.html(nota.val());
				nota.on('input change', () => {
					$('#snotas'+nota.attr("identification")).html(nota.val());
				});
			});
		});
	</script>
@endif
@stop
