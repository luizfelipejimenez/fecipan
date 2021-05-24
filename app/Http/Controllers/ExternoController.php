<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Pessoa;
use App\Instituicao;
use App\Orientador;
use App\User;
use App\Perfil;
use App\Trabalho;


class ExternoController extends Controller{
	private $permissoes;
	
    public function __construct()
    {
        /**
         *  O sistema verifica primeiramente se o usuário está logado no sistema. Caso não esteja, 
         *      ele é direcionado para a tela de login. Caso o usuário esteja logado, o sistema
         *      verifica se ele tem perfil de administrador. Caso não tenha, ele é redirecionado
         *      para a tela inicial do sistema
         *
         */

        $this->middleware(function($request, $next){
        	if (!Auth::check())
        		return redirect('/login');
            if(!Auth::user()->ativo)
                return redirect()->route('auth.nova_senha');
            //use o array para testar a rota com whereIn
        	$this->permissoes = Auth::user()->temPermissao(["/visualizar/orientador", "/visualizar/estudante" ]);
        	if ($this->permissoes == null)
        		return redirect('/')->with('erro', 'Você não tem permissão suficiente');
        	return $next($request);
        });
    }

    public function estudante()
    {
        return view('externo.estudante', ['estudante' => Auth::user()->pessoa->estudante]);
    }
    public function orientador()
    {
        return view('externo.orientador', ['orientador' => Auth::user()->pessoa->orientador]);
    }

    public function trabalho($trabalho_id){
        return view('externo.trabalho', ['trabalho' => Trabalho::find($trabalho_id)]);
    }
}