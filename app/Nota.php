<?php 

namespace App;

use Illuminate\Database\Eloquent\Model;

class Nota extends Model {

	protected $table = 'nota';
	
	protected $fillable = array('valor','comentario', 'quesito_id', 'avaliacao_id', 'notas_lancadas');
	
	public $timestamps = false;
	
	public function quesito(){
		return $this->belongsTo('App\Quesito');
	}
	public function avaliacao(){
		return $this->belongsTo('App\Avaliacao');
	}

}
