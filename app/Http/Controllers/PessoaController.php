<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

use App\Pessoa;
use App\Perfil;
use App\User;

class PessoaController extends Controller
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
            $this->permissoes = Auth::user()->temPermissao(["/pessoa/avaliador"]);
            if ($this->permissoes == null)
                return redirect('/')->with('erro', 'Você não tem permissão suficiente');
            return $next($request);
        });
    }    

    public function index(){
    	$pessoas = Pessoa::
			whereNotExists(function ($query) {
                $query->select(DB::raw(1))
                      ->from('estudante')
                      ->whereRaw('estudante.pessoa_id = pessoa.id');
            })
			->whereNotExists(function ($query) {
                $query->select(DB::raw(1))
                      ->from('avaliador')
                      ->whereRaw('avaliador.pessoa_id = pessoa.id');
            })
			->whereNotExists(function ($query) {
                $query->select(DB::raw(1))
                      ->from('orientador')
                      ->whereRaw('orientador.pessoa_id = pessoa.id');
            })
			->get();
    	return view('pessoa.pessoa')->with(["pessoas"=>$pessoas]);
    }

    public function formCreate(){
    	return view('pessoa.formCreate');    	
    }

    public function create(Request $request){
	
    $this->validate($request, [
	        'nome' => 'required|max:255',
	        'sexo' => 'max:1',
	        'cpf' => 'unique:pessoa|max:11',
	        'email' => 'required|unique:pessoa',
	    ]);

	    $data = $request->all();
        $pessoa = new Pessoa();
		
        $pessoa->nome = $data['nome'];
        $pessoa->email = $data['email'];
        $pessoa->sexo = isset($data['sexo'])? $data['sexo']: null;
        $pessoa->data_nascimento = isset($data['data_nascimento'])? $data['data_nascimento']: "0";
        $pessoa->telefone_1 = isset($data['telefone_1'])? $data['telefone_1']: null;
        $pessoa->telefone_2 = isset($data['telefone_2'])? $data['telefone_2']: null;
        $pessoa->save();    	

        return redirect('pessoa'); 
    }

    public function formCreateUsuario($pessoa_id){
    	return view('pessoa.formCreateUsuario')->with(["pessoa"=>Pessoa::find($pessoa_id), "perfis"=>Perfil::get()]);    	
    }

    public function createUsuario(Request $request){
	    $data = $request->all();
	    
		$this->validate($request, [
	        'email' => [
				'required',
				Rule::unique('pessoa')->ignore($data['pessoa_id'])
			  ],
	        'login' => 'required|unique:users',
	        'password' => 'required|confirmed|min:6',
	        'perfil_id' => 'required',
	        'pessoa_id' => 'required',
	    ]);

        
        $pessoa = Pessoa::find($data['pessoa_id']);
        
        $pessoa->email = $data['email'];
		
		$pessoa->save();
        
        $usuario = new User();
		$usuario->login = $data['login'];
        $usuario->password = bcrypt($data['password']);

	    $usuario->perfil()->associate(Perfil::find($data['perfil_id']));
		$usuario->pessoa()->associate($pessoa);

        $usuario->save();       

        return redirect("/pessoa/usuarios/{$pessoa->id}"); 
    }

    public function delete($pessoa_id){
        Pessoa::find($pessoa_id)->delete();

        return redirect('pessoa');
    }
	
	public function usuarios($pessoa_id){
		$pessoa = Pessoa::find($pessoa_id);
		
		return view('pessoa.usuarios')->with(['pessoa'=>$pessoa]);
	}

    public function show(Pessoa $pessoa)
    {
        return view('pessoa.show', ['pessoa' => $pessoa]);
    }
}
