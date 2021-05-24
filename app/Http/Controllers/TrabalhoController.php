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

use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Evento;
use App\Trabalho;
use App\Estudante;
use App\Orientador;
use App\Area;
use App\TipoTrabalho;
use App\Categoria;

class TrabalhoController extends Controller {
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
        	if (Auth::check() == false)
        		return redirect('/login');
            //use o array para testar a rota com whereIn
        	$this->permissoes = Auth::user()->temPermissao(["/trabalho"]);
        	if ($this->permissoes == null)
        		return redirect('/')->with('erro', 'Você não tem permissão suficiente');
        	return $next($request);
        });
    }    

	public function index($evento_id){
		$evento = Evento::find($evento_id);

		return view('trabalho.trabalho')->with(['evento'=>$evento, 'permissoes'=>$this->permissoes]);
	}

	public function listaDeTrabalhos(Evento $evento){
		//$evento = Evento::find($evento_id);

		return view('trabalho.lista')->with(['evento'=>$evento, 'permissoes'=>$this->permissoes]);
	}
	
	public function create($evento_id){
		$evento = Evento::find($evento_id);
		$estudantes = Estudante::get();
		$orientadores = Orientador::get();
		$categorias = Categoria::get();
		$areas = Area::get();
		$tiposTrabalho = TipoTrabalho::get();
		
		return view('trabalho.formCreate')->with(['evento'=>$evento, 'categorias'=>$categorias, 'estudantes'=>$estudantes, 'orientadores'=>$orientadores, 'areas'=>$areas, 'tiposTrabalho'=>$tiposTrabalho]);
	}

	public function store(Request $request){
		//return $request->all();
		if ($this->permissoes->inserir){
			$params = $request->all();
			
			global $evento_id;
			$evento_id = $params['evento_id'];
			
			$this->validate($request, [
				'titulo' => 'required',
				/*'cod' => [
					'required',
					Rule::unique('trabalho')->where(function($query){
							global $evento_id;
							$query->where('evento_id', $evento_id); 
						})
					],*/
				'area_id' => 'required',
				'tipo_trabalho_id' => 'required',
				'categoria_id' => 'required',
				'orientador_id' => 'required',
				'estudantes' => 'required',
				'video' => 'required',
				'arquivo' => 'required'
			]);

			$trabalho = new Trabalho($params);
			$trabalho->save();
			$trabalho->cod  = "CB/".Area::find($trabalho->area_id)->sigla."-".$trabalho->id;
			$trabalho->arquivo = $request->file('arquivo')->storeAs(
    			'public/trabalhos', $trabalho->cod .".". $request->file('arquivo')->extension()
			);
			$trabalho->save();
			foreach ($params["estudantes"] as $estudante_id){
				$trabalho->estudantes()->attach($estudante_id);
			}

			$trabalho->orientadores()->attach($params['orientador_id'], ['tipo_orientacao'=>1]);
			if (isset($params["coorientador_id"]))
				$trabalho->orientadores()->attach($params['coorientador_id'], ['tipo_orientacao'=>2]);

			/*if (isset($params["coorientadores"])){
				foreach ($params["coorientadores"] as $coorientador_id){
					$trabalho->orientadores()->attach($coorientador_id, ['tipo_orientacao'=>2]);
				}
			}*/

			
			return redirect("/evento/trabalhos/{$trabalho->evento->id}")->with('sucesso', 'Trabalho cadastrado com sucesso!');
		}
		return redirect("/evento/trabalhos/{$trabalho->evento->id}")->with('erro', 'Você não tem permissão suficiente');
	}

	public function formUpdate($trabalho_id){
		$trabalho = Trabalho::find($trabalho_id);
		$estudantes = Estudante::get();
		$orientadores = Orientador::get();
		$categorias = Categoria::get();
		$areas = Area::get();
		$tiposTrabalho = TipoTrabalho::get();
		
		return view('trabalho.formUpdate')->with(['trabalho'=>$trabalho, 'categorias'=>$categorias, 'estudantes'=>$estudantes, 'orientadores'=>$orientadores, 'areas'=>$areas, 'tiposTrabalho'=>$tiposTrabalho]);
	}
	
	public function update(Request $request){
		if ($this->permissoes->alterar){
			$params = $request->all();
			global $trabalho;
			$trabalho = Trabalho::find($params['trabalho_id']);
			
			$this->validate($request, [
				'titulo' => 'required',
				'cod' => [
					'required',
					Rule::unique('trabalho')->where(function($query){
							global $trabalho;
							$query
								->where('evento_id', $trabalho->evento_id) 
								->where('id', '<>', $trabalho->id);
						})
					],
				'area_id' => 'required',
				'tipo_trabalho_id' => 'required',
				'categoria_id' => 'required',
			]);

			$params["maquete"] = isset($params["maquete"])? '1': '0';	
			$trabalho->update($params);
		}
		return redirect("/evento/trabalhos/{$trabalho->evento->id}");
	}
	
	public function destroy($trabalho_id){
		if ($this->permissoes->excluir){
			$trabalho = Trabalho::find($trabalho_id);
			$trabalho->orientadores()->detach();
			$trabalho->estudantes()->detach();
			$trabalho->avaliacoes()->delete();
			if($trabalho->delete())
				return redirect("/evento/trabalhos/{$trabalho->evento->id}")->with('sucesso', 'Trabalho apagado com sucesso!');
			return redirect("/evento/trabalhos/{$trabalho->evento->id}")->with('erro', 'Algo deu errado');	

		}
		return redirect("/evento/trabalhos/{$trabalho->evento->id}")->with('erro', 'Você não tem permissão suficiente');
	}

	public function download(Trabalho $trabalho)
	{
		//return $trabalho;
		return Storage::download('public/trabalhos/'.$trabalho->cod.".pdf");
	}
}


		
		