<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Perfil;

class Pessoa extends Model
{
    protected $table = "pessoa";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nome', 'sexo', 'cpf', 'data_nascimento', 'email', 'telefone1', 'telefone2'
    ];

     /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
	
    public function usuario()
    {
        return $this->hasOne('App\User');
    }

    public function orientador()
    {
        return $this->hasOne('App\Orientador');
    }
    public function avaliador()
    {
        return $this->hasOne('App\Avaliador');
    }

    public function estudante()
    {
        return $this->hasOne('App\Estudante');
    }

    public function perfisNaoVinculados()
    {
        $vinculados = $this->usuario->perfis->pluck('id');
        return Perfil::whereNotIn('id', $vinculados)
        ->where('descricao','<>', 'Administrador')
        ->get();
    }
}
