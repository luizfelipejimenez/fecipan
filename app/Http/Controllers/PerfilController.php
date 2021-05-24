<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Perfil;
use Illuminate\Support\Facades\Auth;

class PerfilController extends Controller
{
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
            if (Auth::check() == false)
                return redirect('/login');
            //use o array para testar a rota com whereIn
            $this->permissoes = Auth::user()->temPermissao(["/perfil"], true);
            if ($this->permissoes == null)
                return redirect('/')->with('erro', 'Você não tem permissão suficiente');
            return $next($request);
        });
    }    

    public function index(){
    	$perfis = Perfil::get();
    	return view('perfil.perfil')->with(["perfis"=>$perfis]);
    }

    public function formCreate($perfil_pai){
    	return view('perfil.formCreate')->with(['perfil_pai'=>Perfil::find($perfil_pai)]);    	
    }

    public function create(Request $request){
	    $this->validate($request, [
            'perfil_pai' => 'required',
	        'descricao' => 'required|unique:perfil|max:255',
	    ]);

	    $data = $request->all();
        $perfil = new Perfil();
        $perfil->descricao = $data['descricao'];
        $perfil->perfil_id = $data['perfil_pai'];
        $perfil->save();    	

        return redirect('perfil'); 
    }

    public function delete($perfil_id){
        Perfil::find($perfil_id)->delete();

        return redirect('perfil');
    }

    public function vinculos($perfil_id){
        return view('perfil.vinculos')->with(['perfil'=>Perfil::find($perfil_id)]);
    }

    public function usuarios($perfil_id){
        return view('perfil.usuarios')->with(['perfil'=>Perfil::find($perfil_id)]);
    }

    public function permissoes($perfil_id){
        return view('perfil.permissoes')->with(['perfil'=>Perfil::find($perfil_id)]);
    }
}
