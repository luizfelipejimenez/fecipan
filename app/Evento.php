<?php 

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Evento extends Model {

	protected $table = 'evento';

	protected $fillable = array('titulo','ano','semestre','tema','cidade','data_inicio','data_fim', 'ativo');

	public $timestamps = false;

	protected $dates = [
		'data_inicio',
		'data_fim'
	];

	public function trabalhos(){
		return $this->hasMany('App\Trabalho');
	}
	
	public function trabalhosPorUsuario($avaliador_id){
		return $this->hasMany('App\Trabalho')->join('avaliacao','avaliacao.trabalho_id', '=', 'trabalho.id')->where(['avaliacao.avaliador_id' => $avaliador_id]);
	}
	public function quesitos(){
		return $this->hasMany('App\Quesito');
	}

	public function trabalhosCategoriaArea(){
		return $this->trabalhos()->with(['area', 'categoria']);
	}

	public static function rankingTrabalhosPorCategoria(Evento $evento)
	{
		return Trabalho::with(['estudantes.pessoa', 'orientadores.pessoa'])
		->join('avaliacao','trabalho.id', '=', 'avaliacao.trabalho_id')
		->join('nota', 'nota.avaliacao_id', '=', 'avaliacao.id' )
		->join('quesito','quesito.id', '=', 'nota.quesito_id')
		->where('trabalho.evento_id', '=', $evento->id)
		->where('avaliacao.notas_lancadas', TRUE)
		->selectRaw('trabalho.*, round(sum(valor)/count(distinct(avaliacao.avaliador_id)),2) as media, avaliacao.id as avaliacao_id')
		->groupBy('trabalho.id', 'trabalho.titulo')
		->orderBy('media', 'DESC')
		->limit(15)
		->get(['*']);
	}
}
