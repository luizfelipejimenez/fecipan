<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Perfil extends Model
{
    protected $table = "perfil";
    
    protected $fillable = [
        'descricao', 'administrador'
    ];

    public $timestamps = false;

    //public function usuarios(){
    //	 return $this->hasMany('App\User');
   // }

    public function usuarios()
    {
        return $this->belongsToMany('App\User', 'perfil_user', 'perfil_id', 'user_id');
    }
	
	# Perfis Filhos
	public function perfis_vinculados(){
		return $this->hasMany('App\Perfil');
	}

	# Perfil Pai
	public function perfil(){
		return $this->belongsTo('App\Perfil');
	}
	
	public function conteudos(){
		#   ________         ___________         __________ 
		#  |        |       |           |       |          |
		#  | PERFIL |+-----<| PERMISSAO |>-----+| CONTEUDO |
		#  |________|       |___________|       |__________|
		#
		return $this->belongsToMany('App\Conteudo', 'permissao')->withPivot("visualizar", "inserir", "alterar", "excluir");
	}
	public function menu(){
		//migrado para o user
		#   ________         ___________         __________ 
		#  |        |       |           |       |          |
		#  | PERFIL |+-----<| PERMISSAO |>-----+| CONTEUDO |
		#  |________|       |___________|       |__________|
		#
		return $this->belongsToMany('App\Conteudo', 'permissao')->withPivot("visualizar", "inserir", "alterar", "excluir")->where('menu', '=' , '1');
	}
}
