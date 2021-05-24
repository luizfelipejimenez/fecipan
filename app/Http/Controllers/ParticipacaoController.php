<?php

namespace App\Http\Controllers;

//use fecipan\Area;
//use fecipan\Categoria;
//use fecipan\Evento;
//use fecipan\Http\Controllers\Controller;
//use fecipan\Http\Requests\TrabalhoRequest;
//use fecipan\TipoTrabalho;
//use fecipan\Trabalho;
//use Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Trabalho;
use App\Participacao;
use App\Estudante;

class ParticipacaoController extends Controller {
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
        	$this->permissoes = Auth::user()->temPermissao(["/participacao"]);
        	if ($this->permissoes == null)
        		return redirect('/')->with('erro', 'Você não tem permissão suficiente');
        	return $next($request);
        });
    }    

	public function index($trabalho_id){
		$trabalho = Trabalho::find($trabalho_id);
		return view('participacao.participacao')->with(['trabalho'=>$trabalho, 'permissoes'=>$this->permissoes]);
	}

	public function create($trabalho_id){
		if ($this->permissoes->inserir){
			$trabalho = Trabalho::find($trabalho_id);
			$estudantes = Estudante::whereNotIn('id', $trabalho->estudantes()->pluck('estudante_id')->toArray())->get();
		
			return view('participacao.formCreate')->with(["estudantes"=>$estudantes, "trabalho"=>$trabalho]);
		}else{
			return redirect("/trabalho/estudantes/{$trabalho_id}")->with('erro', 'Você não tem permissão suficiente');;
		}
	}
	
	public function store(Request $request){
		if ($this->permissoes->inserir){
			$this->validate($request, [
				'estudantes' => 'required',
			]);
			$params = $request->all();
			
			foreach($params["estudantes"] as $estudante_id){
				$trabalho = Trabalho::find($params['trabalho_id']);
				$estudante = Estudante::find($estudante_id);
				
				$trabalho->estudantes()->attach($estudante);
			}
		}
		return redirect("/trabalho/estudantes/{$params['trabalho_id']}");
	}

	public function destroy($trabalho_id, $estudante_id){
		# Ao excluir uma avaliação, as notas são excluídas
		#	em cascata (ON DELETE CASCADE no BD)
		if ($this->permissoes->excluir){
			$trabalho = Trabalho::find($trabalho_id);
			$trabalho_id = $trabalho->id;
			$trabalho->estudantes()->detach($estudante_id);
			return redirect("/trabalho/estudantes/{$trabalho_id}")->with('sucesso', 'Participação excluida com sucesso!');
		}
		return redirect('/')->with('erro', 'Você não tem permissão suficiente');
	}
/*	
	public function trabalho(){
		$trabalho = Trabalho::orderBy('id')->get();
		return view('trabalho.trabalho')->with('trabalho',$trabalho);
	}
	
	public function form_trabalho(){
		return view ('trabalho.formtrabalho')->with('categorias', Categoria::orderBy('id')->get())->with('evento', Evento::orderBy('id')->get())->with('tipotrabalho', TipoTrabalho::orderBy('id')->get())->with('area', Area::orderBy('id')->get());
	}
	public function cadastrartrabalho(TrabalhoRequest $request){
		$params = $request->all();
		$trabalho = new Trabalho($params);
		$trabalho->save();
		return redirect('/trabalho')->withInput();
	}
	public function formeditartrabalho($id){
		$trabalho = Trabalho::find($id);
		return view ('trabalho.formeditartrabalho')->with('t', $trabalho)->with('evento', Evento::orderBy('id')->get())->with('categorias', Categoria::orderBy('id')->get())->with('tipotrabalho', TipoTrabalho::orderBy('id')->get())->with('area', Area::orderBy('id')->get());
	}
	public function editartrabalho(TrabalhoRequest $request, $id){
		$trabalho = Trabalho::find($id);
		$params = Request::all();
		$trabalho->update($params);
		return redirect('/trabalho');
	}
	public function deletartrabalho($id){
		$trabalho = Trabalho::find($id);
		$titulo = $trabalho['nome'];
		$trabalho->delete();
		return redirect('/trabalho')->with('deletartrabalho', $titulo);
	}
*/
}
