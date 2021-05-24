<?php 

namespace App;

use Illuminate\Database\Eloquent\Model;

class Avaliacao extends Model {

	protected $table = 'avaliacao';

	protected $fillable = array('avaliador_id','trabalho_id');

	public $timestamps = false;

	public function avaliador(){
		return $this->belongsTo('App\Avaliador');
	}
	public function trabalho(){
		return $this->belongsTo('App\Trabalho');
	}
	public function notas(){
		return $this->hasMany('App\Nota');
	}	
}
