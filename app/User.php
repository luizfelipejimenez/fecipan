<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use DB;
use App\Notifications\ResetPassword;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'login', 'email','password', 'ativo', 'created_at', 'updated_up', 'remember_token', 'cod'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function pessoa(){
        return $this->belongsTo('App\Pessoa');
    }    

    /**
     *  
     *
     */
    //public function perfil(){
     //   return $this->belongsTo('App\Perfil');
    //}  

    public function perfis(){
        return $this->belongsToMany('App\Perfil', 'perfil_user', 'user_id', 'perfil_id');
    }
    
    public function isAdmin()
    {
        return !empty($this->perfis()->where('perfil.administrador', 1)->first());
    }

    public function isOrganizador()
    {
        return !empty($this->perfis()->where('perfil.descricao', 'Organizador')->first());
    }

    public function menu()
    {
     return DB::table('conteudo')
     ->join('permissao', 'conteudo.id', '=', 'permissao.conteudo_id')
     ->whereIn('permissao.perfil_id', $this->perfis()->pluck('perfil.id'))
     ->where('conteudo.menu', '=' , '1')
     ->distinct()
     ->orderBy('menu_pai', 'ASC')
     ->orderBy('rotulo','ASC')
     ->get();
 }

 public function temPermissao($rotas, $rotaAdministrador = false)
 { 
    if($rotaAdministrador){
        if($this->isAdmin())
            return (object) [
                'visualizar' => true,
                'inserir' => true, 
                'alterar' => true,
                'excluir' => true
            ];
        }

        $result = DB::table('conteudo')
        ->join('permissao', 'conteudo.id', '=', 'permissao.conteudo_id')
        ->whereIn("conteudo.rota", $rotas)
        ->whereIn('permissao.perfil_id', $this->perfis()->pluck('perfil.id'))
        ->select('permissao.*')
        ->first();
        if($result)
            return (object) $result;
        else
            return null;
    }

    public function permissoesAdministrador()
    {
        # code...
    }

    public function sendPasswordResetNotification($token)
    {
       $this->notify(new ResetPassword($token));
    }

}
