<?php 
namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoTrabalho extends Model {

	protected $table = 'tipo_trabalho';

	protected $fillable = array('nome');

	public $timestamps = false;
	
  	public function trabalhos(){
  		return $this->hasMany('App\Trabalho');
  	}  	
}
