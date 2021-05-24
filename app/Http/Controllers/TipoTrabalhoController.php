<?php 

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\TipoTrabalhoRequest;
use App\TipoTrabalho;

class TipoTrabalhoController extends Controller {
	private $permissoes;

    public function __construct()
    {
		
        /**
         *  O sistema verifica primeiramente se o usuário está logado. 
		 *		Caso não esteja, 
         *      ele é direcionado para a tela de login. 
		 *
		 *		Caso o usuário esteja logado, o sistema
         *      verifica se ele tem perfil para acessar este controller. 
		 *
		 *		Caso não tenha, ele é redirecionado
         *      para a tela inicial do sistema
         *
         */

        $this->middleware(function($request, $next){
        	if (!Auth::check())
        		return redirect('/login');
            //use o array para testar a rota com whereIn
        	$this->permissoes = Auth::user()->temPermissao(["/tipoTrabalho"]);
        	if ($this->permissoes == null)
        		return redirect('/')->with('erro', 'Você não tem permissão suficiente');
        	return $next($request);
        });
    }    
	
	public function index(){
		$tiposTrabalho = TipoTrabalho::get();
		return view('tipotrabalho.tipotrabalho')->with(['tiposTrabalho' => $tiposTrabalho, 'permissoes' => $this->permissoes]);
	}
	
	public function create(){
		if ($this->permissoes->inserir)
			return view('tipotrabalho.form', ['edit' => false]);
		else
			return redirect('/tipoTrabalho')->with('erro', 'Você não tem permissão suficiente');
		
	}
	
	public function store(Request $request){
		if ($this->permissoes->inserir){
			$request->validate([
    			'nome' => 'required|unique:tipo_trabalho|max:255',
			]);
			$tipotrabalho = new TipoTrabalho($request->all());
			if($tipotrabalho->save())
				return redirect('/tipoTrabalho')->with('sucesso', 'Tipo cadastrado com sucesso!');
		}
    	return redirect('/tipoTrabalho')->with('erro', 'Algo deu errado!');
	}
	
	public function edit(TipoTrabalho $tipoTrabalho){
		if ($this->permissoes->alterar)
			return view('tipotrabalho.form', ['tipoTrabalho' => $tipoTrabalho, 'edit' => true]);
		else
			return redirect('/tipoTrabalho')->with('erro', 'Você não tem permissão suficiente');	
	}
	
	public function update(Request $request, TipoTrabalho $tipoTrabalho){
		if ($this->permissoes->alterar){
			if($tipoTrabalho->update($request->all()))
				return redirect('/tipoTrabalho')->with('sucesso', 'Tipo atualizado com sucesso!');
			return redirect ('/tipoTrabalho')->with('erro', 'Algo deu errado!');
		}else
			return redirect('/tipoTrabalho')->with('erro', 'Você não tem permissão suficiente');	
		
	}
	
	public function destroy(TipoTrabalho $tipoTrabalho){
		if ($this->permissoes->excluir){
			if($tipoTrabalho->delete())
				return redirect('/tipoTrabalho')->with('sucesso', 'Tipo excluído com sucesso!');
			else
				return redirect ('/tipoTrabalho')->with('erro', 'Algo deu errado!');
		}
		redirect('/tipoTrabalho')->with('erro', 'Você não tem permissão suficiente');
	}
}
