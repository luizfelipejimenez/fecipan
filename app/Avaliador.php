<?php 

namespace App;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Avaliador extends Authenticatable {
	use Notifiable;

	protected $table = 'avaliador';

	protected $fillable = array('area','instituicao_id','pessoa_id');

	public $timestamps = false;

	public function instituicao(){
		return $this->belongsTo('App\Instituicao');
	}
	public function pessoa(){
		return $this->belongsTo('App\Pessoa');
	}
	public function avaliacoes(){
		return $this->hasMany('App\Avaliacao');
	}
//	public function avaliadorcategoria(){
//		return $this->hasMany('App\AvaliadorCategoria');
//	}
//	public function avaliador(){
//		return $this->hasMany('App\Avaliador');
//	}
//	public function area(){
//		return $this->hasMany('App\Area');
//	}
}
