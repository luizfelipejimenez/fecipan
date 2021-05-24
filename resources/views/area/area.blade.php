@extends('layouts.app')

@section('conteudo')
@if ($permissoes->visualizar)

<div class="jumbotron">
  <h1 class="display-4">Área</h1>
  <p class="lead">Áreas do conhecimento humano relacionadas no edital de abertura do evento.</p>
  <hr class="my-4">
  @if(Auth::user()->isAdmin() || Auth::user()->isOrganizador())
		<div class='text-right'>
	  		<a class='btn btn-primary' href="/evento">
			Voltar
	  	</a>
		</div>
	@endif
  @if ($permissoes->inserir)
	  <a href="/area/create" class="btn btn-primary">
		<i data-feather="plus-square"></i> 
	   Cadastrar Área
	</a>
  @endif
  <div class="table-responsive">
	<table id="table" class="table table-striped table-bordered table-hover">
	  <thead>
		<tr>
			<th scope="col">#</th>
			<th scope="col">Sigla</th>
			<th scope="col">Descrição</th>
			<th scope="col" class="text-right">Ações</th>
		</tr>
	  </thead>
	  <tbody>
	@foreach($areas as $a)
		<tr>
			<td>{{ $a->id }}</td>
			<td>{{ $a->sigla }}</td>
			<td>{{ $a->area }}</td>
			<td class="text-right">
			 	<x-crud-view :a="$a" :permissoes="$permissoes" :route="'area'" :model="'Área'"/>
			</td>
		</tr>
	  @endforeach
	  </tbody>
	</table>
</div>
@endif
@if(Auth::user()->isAdmin() || Auth::user()->isOrganizador())
		<div class='text-right'>
	  		<a class='btn btn-primary' href="/evento">
			Voltar
	  	</a>
		</div>
	@endif
</div>
@stop