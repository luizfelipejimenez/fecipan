<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Conteudo;
use App\Perfil;
use Illuminate\Support\Facades\Auth;

class ConteudoController extends Controller
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
        	$this->permissoes = Auth::user()->temPermissao(["/conteudo"], true);
        	if ($this->permissoes == null)
        		return redirect('/')->with('erro', 'Você não tem permissão suficiente');
        	return $next($request);
        });
    }

    //
    public function index(){
    	return view ("conteudo.conteudo")->with(["conteudos" => Conteudo::get()]);
    }

    public function formCreate(){
    	return view ("conteudo.formCreate");
    }

    public function formCreatePermissao($perfil_id){
    	return view ("conteudo.formCreatePermissao")->with(["perfil"=>Perfil::find($perfil_id)]);
    }
	
    public function formAssociarPerfil($conteudo_id){
		$conteudo = Conteudo::find($conteudo_id);
		
		$ids = array(1);
		foreach ($conteudo->perfis as $perfil){
			$ids[] = $perfil->id;
		}

		$perfis = DB::table("perfil")
			->whereNotIn("id", $ids)
			->get();
    	return view ("conteudo.formAssociarPerfil")->with(["conteudo"=>Conteudo::find($conteudo_id), "perfis"=>$perfis]);
    }

    public function formUpdate($conteudo_id){
    	return view ("conteudo.formUpdate")->with(["conteudo"=>Conteudo::find($conteudo_id)]);
    }

    public function associarPerfil(Request $request){
		$this->validate($request, [
            'perfil_id' => 'required',
	        'conteudo_id' => 'required',
	    ]);

	    $data = $request->all();

		$conteudo = Conteudo::find($data["conteudo_id"]);
		
		$permissao = [
			"visualizar" => isset($data['visualizar']),
			"inserir" => isset($data['inserir']),
			"alterar" => isset($data['alterar']),
			"excluir" => isset($data['excluir']),
		];

		$conteudo->perfis()->attach($data["perfil_id"], $permissao);

		return redirect ("/conteudo/permissoes/{$conteudo->id}");
	}

	public function create(Request $request){
		$this->validate($request, [
	        'rota' => 'required',
	        'rotulo' => 'required',
	    ]);

	    $data = $request->all();
        $conteudo = new Conteudo();
        $conteudo->rota = $data['rota'];
        $conteudo->rotulo = $data['rotulo'];
        $conteudo->publica = isset($data['publica']);
        $conteudo->menu = isset($data['menu']);
        $conteudo->save();
		
		return redirect ("/conteudo");
	}

	public function createPermissao(Request $request){
		$this->validate($request, [
            'perfil_id' => 'required',
	        'rota' => 'required',
	        'rotulo' => 'required',
	    ]);

	    $data = $request->all();
        $conteudo = new Conteudo();
        $conteudo->rota = $data['rota'];
        $conteudo->rotulo = $data['rotulo'];
        $conteudo->publica = isset($data['publica']);
        $conteudo->menu = isset($data['menu']);
        $conteudo->save();
		
		$permissao = [
			"visualizar" => isset($data['visualizar']),
			"inserir" => isset($data['inserir']),
			"alterar" => isset($data['alterar']),
			"excluir" => isset($data['excluir']),
		];

		$conteudo->perfis()->attach($data["perfil_id"], $permissao);
		
		return redirect ("/perfil/permissoes/{$data["perfil_id"]}");
	}

	public function update(Request $request){
		$this->validate($request, [
	        'rota' => 'required',
	        'rotulo' => 'required',
	    ]);

	    $data = $request->all();
        $conteudo = Conteudo::find($data["conteudo_id"]);
        $conteudo->rota = $data['rota'];
        $conteudo->rotulo = $data['rotulo'];
        $conteudo->publica = isset($data['publica']);
        $conteudo->menu = isset($data['menu']);
        $conteudo->save();
		
		return redirect ("/conteudo");
	}

    public function permissoes($conteudo_id){
        return view('conteudo.permissoes')->with(['conteudo'=>Conteudo::find($conteudo_id)]);
    }
	
	public function delete($conteudo_id){
		$conteudo = Conteudo::find($conteudo_id);
		$conteudo->delete();
		return redirect ("/conteudo");
	}
}
