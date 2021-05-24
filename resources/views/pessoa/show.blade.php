@extends('layouts.app')

@section('conteudo')
	{{$pessoa}}

	@foreach($pessoa->perfisNaoVinculados() as $perfil)
		{{$perfil->descricao}}
	@endforeach
@stop
