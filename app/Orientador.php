<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Orientador extends Model {

	protected $table = 'orientador';

	protected $fillable = array('pessoa_id','instituicao_id');

	public $timestamps = false;
	
	public function instituicao(){
		return $this->belongsTo('App\Instituicao');
	}
	
	public function pessoa(){
		return $this->belongsTo('App\Pessoa', 'pessoa_id');
	}
	
	public function trabalhos(){
		return $this->belongsToMany('App\Trabalho', 'orientacao')->withPivot('tipo_orientacao');
	}
}
