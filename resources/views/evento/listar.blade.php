<!DOCTYPE html>
<html>
<head>
	<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
	<title></title>
</head>
<body>
	<table class="table table-striped">
		<thead>
			<tr>
				<th>Código</th>
			<th>Nome</th>
			<th>Orientadores</th>
			<th>Estudantes</th>
			<th>Escola</th>
			<th>Nivel</th>
		</tr>
		</thead>
		<tbody>
			@foreach($trabalhos as $trabalho)
				<tr>
					<td>{{$trabalho->cod}}</td>
					<td>{{$trabalho->titulo}}</td>
					<td>
						@foreach($trabalho->orientadores as $orientador)
							@if($orientador->pivot->tipo_orientacao == 1)
								<p>{{$orientador->pessoa->nome}} (Orientador)</p>
								@php $escola = $orientador->instituicao->nome @endphp
							@else
								<p>{{$orientador->pessoa->nome}} (Coorientador)</p>
							@endif
							
						@endforeach
					</td>
					<td>
						@foreach($trabalho->estudantes as $estudante)
							<p>{{$estudante->pessoa->nome}}</p>
						@endforeach
					</td>
					<td>
						{{$escola}}
					</td>
					<td>
						@foreach($trabalho->estudantes as $estudante)
							<p>{{$estudante->categoria->descricao}}</p>
							@break
						@endforeach
					</td>
				</tr>
			@endforeach
			
		</tbody>
	</table>

</body>
</html>