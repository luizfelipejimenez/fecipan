<?php 

namespace App;

use Illuminate\Database\Eloquent\Model;

class Trabalho extends Model {

	protected $table = 'trabalho';
	
	protected $fillable = array('titulo', 'cod', 'maquete','video','arquivo', 'area_id', 'tipo_trabalho_id', 'categoria_id', 'evento_id');

	public $timestamps = false;
	
  	public function evento(){
  		return $this->belongsTo('App\Evento');
  	}

	public function tipoTrabalho(){
			return $this->belongsTo('App\TipoTrabalho');
	}

	public function categoria(){
  			return $this->belongsTo('App\Categoria');
  	}

  	public function area(){
  			return $this->belongsTo('App\Area');
  	}

  	public function avaliacoes(){
  			return $this->hasMany('App\Avaliacao');
  	}
	
	  public function notas(){
        return $this->hasManyThrough('App\Nota', 'App\Avaliacao');
    }


    public function media2()
    {
       $media = $this->notas()
       ->selectRaw('sum(valor * peso) as media')
       ->join('quesito','quesito.id', '=', 'nota.quesito_id')
       ->join('trabalho','trabalho.id','=', 'avaliacao.trabalho_id')
       ->join('categoria','categoria.id', '=', 'trabalho.categoria_id')
       ->where('notas_lancadas', TRUE)
       ->groupBy('trabalho_id')->orderBy('media', 'DESC')
       ->limit(5);
       return ($media);
    }
     public function media()
    {
      return $this->notas()
        ->join('quesito','quesito.id', '=', 'nota.quesito_id')
        ->join('trabalho','trabalho.id','=', 'avaliacao.trabalho_id')
        ->join('categoria','categoria.id', '=', 'trabalho.categoria_id')
        ->where('notas_lancadas', TRUE)
        ->groupBy('trabalho_id')
        ->selectRaw('SUM(valor) as media')
        ->where('notas_lancadas', TRUE)
        ->where('quesito.peso', 1);
    }

    public function video()
    {
      return $this->notas()
       ->join('quesito','quesito.id', '=', 'nota.quesito_id')
       ->join('trabalho','trabalho.id','=', 'avaliacao.trabalho_id')
       ->join('categoria','categoria.id', '=', 'trabalho.categoria_id')
       ->groupBy('trabalho_id')
       ->selectRaw('round(sum(valor)/count(distinct(avaliacao_id)),2) as media')
       ->where('notas_lancadas', TRUE)
       ->where('quesito.peso', 1);
    }
     public function resumo()
    {
      return $this->notas()
       ->join('quesito','quesito.id', '=', 'nota.quesito_id')
       ->join('trabalho','trabalho.id','=', 'avaliacao.trabalho_id')
       ->join('categoria','categoria.id', '=', 'trabalho.categoria_id')
       ->groupBy('trabalho_id')
       ->selectRaw('round(sum(valor)/count(distinct(avaliacao_id)),2) as media')
       ->where('notas_lancadas', TRUE)
       ->where('quesito.peso', 2);
    }

    public function mediaPorTrabalho(Builder $builder)
    {
      dd( $builder);
    }

  	public function orientadores(){
  			return $this->belongsToMany('App\Orientador', 'orientacao')->withPivot('tipo_orientacao');
  	}

    public function orientador(){
        return $this->belongsToMany('App\Orientador', 'orientacao')->withPivot('tipo_orientacao')->having('pivot_tipo_orientacao','=','1');
    }

    public function coorientador(){
        return $this->belongsToMany('App\Orientador', 'orientacao')->withPivot('tipo_orientacao')->having('pivot_tipo_orientacao','=','2');
    }

  	public function estudantes(){
  			return $this->belongsToMany('App\Estudante', 'participacao');
  	}

    public function isCientifico(){
       return !empty($this->tipoTrabalho()->where('tipo_trabalho.nome', 'Pesquisa Científica')->first());
    }

}
