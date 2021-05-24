<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Conteudo extends Model
{
    protected $table="conteudo";

    protected $fillable = [
        'rota', 'rotulo', 'publica', 'menu'
    ];

     /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    public function perfis(){
    	 return $this->belongsToMany('App\Perfil', 'permissao')->withPivot("visualizar", "inserir", "alterar", "excluir");
    }
}
