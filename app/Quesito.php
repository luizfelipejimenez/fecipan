<?php 

namespace App;

use Illuminate\Database\Eloquent\Model;

class Quesito extends Model {

	protected $table = 'quesito';

	protected $fillable = array('tecnologico','cientifico', 'peso');

	public $timestamps = false;

	public function evento(){
		return $this->belongsTo('App\Evento');
	}

	public function notas(){
		return $this->hasMany('App\Nota');
	}
}
