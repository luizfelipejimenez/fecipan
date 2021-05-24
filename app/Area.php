<?php 

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Trabalho;
use DB;

class Area extends Model {

	protected $table = 'area';

	protected $fillable = array('sigla', 'area');

	public $timestamps = false;
	
	public function trabalho(){
		return $this->hasMany('App\Trabalho');
	}
	
	public function avaliadores(){
		return $this->belongsToMany('App\Avaliador', 'avaliador_area', 'area_id', 'avaliador_id');
	}

	public static function rankingTrabalhosPorAreaCategoria(Evento $evento, Categoria $categoria, Area $area)
	{
		return Trabalho::with(['estudantes.pessoa', 'orientadores.pessoa'])
		->join('avaliacao','trabalho.id', '=', 'avaliacao.trabalho_id')
		->join('nota', 'nota.avaliacao_id', '=', 'avaliacao.id' )
		->join('quesito','quesito.id', '=', 'nota.quesito_id')
		->where('trabalho.evento_id', '=', $evento->id)
		->where('area_id', '=', $area->id)
		->where('categoria_id', '=', $categoria->id)
		->where('avaliacao.notas_lancadas', TRUE)
		->selectRaw('trabalho.id, trabalho.titulo, round(sum(valor)/count(distinct(avaliacao.avaliador_id)),2) as media, avaliacao.id as avaliacao_id')
		->groupBy('trabalho.id', 'trabalho.titulo')
		->orderBy('media', 'DESC')
        ->limit(3)
		->get(['*']);
	}
	public static function rankingTrabalhosPorAreaCategoria2(Evento $evento, Categoria $categoria, Area $area, $limite = 3)
	{
		return Trabalho::withCount(
			['notas' => function($query){
				$query->join('avaliacao as ava','ava.id', '=', 'nota.avaliacao_id');
				$query->where('ava.notas_lancadas', TRUE);
				$query->select(DB::raw('round(sum(valor)/count(distinct(avaliacao_id)),2)'));
			},
			'video' => function($query){
				$query->join('quesito','quesito.id', '=', 'nota.quesito_id');
				$query->where('quesito.peso', 1);
				$query->select(DB::raw('round(sum(valor)/count(distinct(avaliacao_id)),2)'));
			},
			'resumo' => function($query){
				$query->join('quesito','quesito.id', '=', 'nota.quesito_id');
				$query->where('quesito.peso', 2);
				$query->select(DB::raw('round(sum(valor)/count(distinct(avaliacao_id)),2)'));
			},
			])
		->join('avaliacao','trabalho.id', '=', 'avaliacao.trabalho_id')
		->join('nota', 'nota.avaliacao_id', '=', 'avaliacao.id' )
		->join('quesito','quesito.id', '=', 'nota.quesito_id')
		->where('trabalho.evento_id', '=', $evento->id)
		->where('area_id', '=', $area->id)
		->where('categoria_id', '=', $categoria->id)
		->where('avaliacao.notas_lancadas', TRUE)
		->selectRaw('trabalho.titulo')
		->groupBy('trabalho.id', 'trabalho.titulo')
		->orderBy('notas_count', 'DESC')
		->orderBy('video_count', 'DESC')
		->orderBy('resumo_count', 'DESC')
        ->limit($limite)
		->get(['*']);
	}

	public static function teste(Evento $evento, Categoria $categoria, Area $area){
	$vencedores =  
	DB::select('SELECT trabalho.id, trabalho.titulo, round(sum(valor)/count(distinct(avaliacao.avaliador_id)),2) as media FROM trabalho INNER JOIN avaliacao ON avaliacao.trabalho_id = trabalho.id INNER JOIN nota ON nota.avaliacao_id = avaliacao.id INNER JOIN quesito ON nota.quesito_id = quesito.id where trabalho.evento_id = ? and trabalho.area_id = ? AND trabalho.categoria_id = ? AND avaliacao.notas_lancadas = 1 
       GROUP BY trabalho.id, trabalho.titulo ORDER BY media DESC limit 3', [
       	$evento->id, $area->id, $categoria->id
       ]);

	foreach ($vencedores as $vencedor) {
		$vencedor->nota_video = DB::select('SELECT round(sum(nota.valor)/count(distinct(avaliacao.avaliador_id)),2) as nota from nota INNER JOIN avaliacao ON nota.avaliacao_id = avaliacao.id INNER JOIN trabalho on avaliacao.trabalho_id = trabalho.id INNER JOIN quesito ON nota.quesito_id = quesito.id WHERE trabalho.id = ? AND avaliacao.notas_lancadas = 1 
			AND quesito.peso = 1', [$vencedor->id])[0]->nota;
		$vencedor->nota_resumo = DB::select('SELECT round(sum(nota.valor)/count(distinct(avaliacao.avaliador_id)),2) as nota from nota INNER JOIN avaliacao ON nota.avaliacao_id = avaliacao.id INNER JOIN trabalho on avaliacao.trabalho_id = trabalho.id INNER JOIN quesito ON nota.quesito_id = quesito.id WHERE trabalho.id = ? AND avaliacao.notas_lancadas = 1 
			AND quesito.peso = 2', [$vencedor->id])[0]->nota;
	}
	return $vencedores;
}
}
