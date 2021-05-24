<?php 

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Trabalho;

class Categoria extends Model {

	protected $table = 'categoria';

	protected $fillable = array('descricao');

	public $timestamps = false;
	
	public function trabalho(){
   return $this->hasMany('App\Trabalho');
 }
 public function estudante(){
  return $this->hasMany('App\Estudante');
}
public function avaliadorcategoria(){
  return $this->hasMany('App\AvaliadorCategoria');
}

public static function rankingTrabalhosPorCategoria(Evento $evento, Categoria $categoria)
{
  return Trabalho::with(['estudantes.pessoa', 'orientadores.pessoa'])
  ->join('avaliacao','trabalho.id', '=', 'avaliacao.trabalho_id')
  ->join('nota', 'nota.avaliacao_id', '=', 'avaliacao.id' )
  ->join('quesito','quesito.id', '=', 'nota.quesito_id')
  ->where('trabalho.evento_id', '=', $evento->id)
  ->where('categoria_id', '=', $categoria->id)
  ->where('avaliacao.notas_lancadas', TRUE)
  ->selectRaw('trabalho.*, round(sum(valor)/count(distinct(avaliacao.avaliador_id)),2) as media, avaliacao.id as avaliacao_id')
  ->groupBy('trabalho.id', 'trabalho.titulo')
  ->orderBy('media', 'DESC')
  ->limit(5)
  ->get(['*']);
}
}
