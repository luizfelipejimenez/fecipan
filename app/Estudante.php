<?php 
namespace App;

use Illuminate\Database\Eloquent\Model;

class Estudante extends Model {

	protected $table = 'estudante';

	protected $fillable = array('ra','categoria_id','instituicao_id','pessoa_id');

	public $timestamps = false;
	
	public function categoria(){
   		return $this->belongsTo('App\Categoria');
  	}
  	public function instituicao(){
  		return $this->belongsTo('App\Instituicao');
  	}
  	public function pessoa(){
  		return $this->belongsTo('App\Pessoa');
  	}
  	public function trabalhos(){
  		return $this->belongsToMany('App\Trabalho', 'participacao');
  	}
}
