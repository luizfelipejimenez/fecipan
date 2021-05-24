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


class OrientadorController extends Controller{
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
            //use o array para testar a rota com whereIn
        	$this->permissoes = Auth::user()->temPermissao(["/pessoa/orientador"]);
        	if ($this->permissoes == null)
        		return redirect('/')->with('erro', 'Você não tem permissão suficiente');
        	return $next($request);
        });
    }    

    public function index(){
		if (Auth::user()->isAdmin() || $this->permissoes->visualizar){
			$orientadores = Orientador::get();
			return view('orientador.orientador')->with(["orientadores"=>$orientadores, 'permissoes' => $this->permissoes]);
		}
		return redirect('/home');
    }

    public function trabalhos($orientador_id){
		if (Auth::user()->isAdmin() || $this->permissoes->visualizar){
			$orientador = Orientador::find($orientador_id);
			return view('orientador.trabalhos')->with(["orientador"=>$orientador]);
		}
		return redirect('/home');
    }
	
    public function create(){
		if (Auth::user()->isAdmin() || $this->permissoes->inserir){
			$instituicoes = Instituicao::get();
			return view('orientador.formCreate')->with(["instituicoes"=>$instituicoes]);
		}
		return redirect('/pessoa/orientadores');
    }

    public function store(Request $request){
		if (Auth::user()->isAdmin() || $this->permissoes->inserir){
			$validator = Validator::make($request->all(), [
				'instituicao_id' => 'required',
				'nome' => 'required|max:255',
				'email' => 'required|unique:users',
			]);

			if($validator->fails()){
                if($validator->errors()->get('email')){
                    $user = User::where('email', $request->email)->first();
                    if(!Orientador::where('pessoa_id', $user->pessoa->id)->first()){
                    	$user->perfis()->attach(Perfil::where('descricao', 'Orientador')->first()->id);
                    	Orientador::create([
    						'pessoa_id' => $user->pessoa->id,
    						'instituicao_id' => $request->instituicao_id,
						]);
                    }
                    return redirect()->route('orientador.index')->with('sucesso', 'Este usuário já estava no sistema e agora também é um orientador');
                   // return redirect('pessoa/pessoa/'.$user->pessoa->id)
                        //    ->withErrors($validator)
                           // ->withInput();
                }/*else{
                    return redirect()->route('avaliador.create')
                    ->with('alerta', 'Este usuário já esta cadastrado neste sistema');
                }*/
            }

			$data = $request->all();
			
			$pessoa = new Pessoa();
			$orientador = new Orientador();
			
			$pessoa->nome = $data['nome'];

			//if (isset($data['sexo'])) $pessoa->sexo = $data['sexo'];
			//if ($data['data_nascimento'] != "") $pessoa->data_nascimento = $data['data_nascimento'];
			//if ($data['cpf'] != "") $pessoa->cpf = $data['cpf'];
			//$pessoa->email = $data['email'];
			
			$pessoa->save();
			
			$orientador->pessoa()->associate($pessoa);
			$orientador->instituicao()->associate(Instituicao::find($data["instituicao_id"]));

			$orientador->save();
			$user = new User();
            $user->email = $user->login = $data['email'];
            $user->password = bcrypt('mudar123');
            $user->ativo = 0;
            $user->pessoa_id = $pessoa->id;
            $user->save();
            $user->perfis()->attach(Perfil::where('descricao', "=", 'orientador')->first()->id);
            return redirect('/pessoa/orientador')->with('sucesso', 'Orientador cadastrado com sucesso!');    
		}
    	return redirect('/pessoa/orientador')->with('erro', 'Você não tem permissão suficiente');
    }
	
	public function destroy($orientador_id){
		if (Auth::user()->isAdmin() || $this->permissoes->excluir){
			$orientador = Orientador::find($orientador_id);
			$pessoa = $orientador->pessoa;
			$user = $pessoa->usuario;
			$user->perfis()->detach();
			$orientador->trabalhos()->detach();
			$orientador->delete();
			$user->delete();
			$pessoa->delete();
			return redirect('/pessoa/orientador')->with('sucesso', 'Orientador excluido com sucesso!');
		}
    	return redirect('/pessoa/orientador')->with('erro', 'Você não tem permissão para excluir esse registro');
	}
}