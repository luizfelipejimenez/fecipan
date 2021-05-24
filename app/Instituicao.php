<?php 

namespace App;

use Illuminate\Database\Eloquent\Model;

class Instituicao extends Model {

	protected $table = 'instituicao';

	protected $fillable = array('nome','sigla','cidade');

	public $timestamps = false;
	
	public function estudante(){
		return $this->hasMany('App\Estudante');
	}
	public function avaliador(){
		return $this->hasMany('App\Avaliador');
	}
	public function orientador(){
		return $this->hasMany('App\Orientador');
	}
}
