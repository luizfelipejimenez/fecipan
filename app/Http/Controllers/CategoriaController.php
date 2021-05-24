<?php 

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Categoria;

class CategoriaController extends Controller {
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
            if (Auth::check() == false){
                return redirect('/login');
            }
			$conteudo = Auth::user()->perfil->conteudos->where("rota", "/categoria")->first();
			        
			if ($conteudo == null){
                return redirect('/');
            }
			
			$this->permissoes = $conteudo->pivot;
			
            return $next($request);
        });
    }    

	public function index(){
		$categorias = Categoria::get();
		return view('categoria.categoria')->with(['categorias'=>$categorias, 'permissoes'=>$this->permissoes]);
	}
	
	public function formCreate(){
		if ($this->permissoes->inserir){
			return view('categoria.formCreate');
		}
		else{
			return redirect('/categoria');
		}
	}
	
	public function Create(Request $request){
		$this->validate($request, [
	        'descricao' => 'required',
	    ]);

		$params = $request->all();
		
		$categoria = new Categoria($params);
		$categoria->save();
		return redirect('/categoria');
	}
	
	public function formUpdate($categoria_id){
		if ($this->permissoes->alterar){
			$categoria = Categoria::find($categoria_id);
			return view('categoria.formUpdate')->with('categoria', $categoria);
		}
		else{
			return redirect('/categoria');
		}
	}
	
	public function update(Request $request){
		$this->validate($request, [
	        'descricao' => 'required',
	    ]);

	    $data = $request->all();
		
		$categoria = Categoria::find($data['categoria_id']);
		$categoria->update($data);
		return redirect('/categoria');
	}
	
	public function delete($categoria_id){
		if ($this->permissoes->excluir){
			$categoria = Categoria::find($categoria_id);
			$categoria->delete();
		}
		return redirect('/categoria');
	}
}
