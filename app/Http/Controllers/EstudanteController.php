<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use App\Mail\EmailEstudantes;
use App\Pessoa;
use App\Estudante;
use App\Instituicao;
use App\Categoria;
use App\User;
use App\Perfil;

class EstudanteController extends Controller{
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
        	if (Auth::check() == false)
        		return redirect('/login');
            //use o array para testar a rota com whereIn
        	$this->permissoes = Auth::user()->temPermissao(["/pessoa/estudante"]);
        	if ($this->permissoes == null)
        		return redirect('/')->with('erro', 'Você não tem permissão suficiente');
        	return $next($request);
        });
    }    

    public function index(){
		if (Auth::user()->isAdmin() || $this->permissoes->visualizar)
			return view('estudante.estudante')->with(["estudantes" => Estudante::get(), 'permissoes'=>$this->permissoes]);
		return redirect('/home')->with('erro', 'Você não tem permissão suficiente');
    }

    public function trabalhos($estudante_id){
		if (Auth::user()->isAdmin() || $this->permissoes->visualizar){
			$estudante = Estudante::find($estudante_id);
			return view('estudante.trabalhos')->with(["estudante" => $estudante]);
		}
		return redirect('/home')->with('erro', 'Você não tem permissão suficiente');
    }

    public function create(){
		if (Auth::user()->isAdmin() || $this->permissoes->inserir){
			$instituicoes = Instituicao::get();
			$categorias = Categoria::get();
			return view('estudante.formCreate')->with(["instituicoes"=>$instituicoes, "categorias"=>$categorias]);
		}
		return redirect()->route('estudante.index');
    }

    public function store(Request $request){
		if (Auth::user()->isAdmin() || $this->permissoes->inserir){
			$validator = Validator::make($request->all(), [
				'instituicao_id' => 'required',
				'categoria_id' => 'required',
				'nome' => 'required|max:255',
				//'cpf' => 'unique:pessoa|max:11',
				'email' => 'required|unique:users',
			]);

			if($validator->fails()){
                if($validator->errors()->get('email')){
                    $user = User::where('email', $request->email)->first();
                    return redirect('pessoa/pessoa/'.$user->pessoa->id)
                            ->withErrors($validator)
                            ->withInput();
                }else{
                    return redirect()->route('estudante.create')
                    ->withErrors($validator)
					->withInput()
                    ->with('alerta', 'Este usuário já esta cadastrado neste sistema');
                }
            }

			$data = $request->all();
			
			$pessoa = new Pessoa();
			$estudante = new Estudante();
			
			$pessoa->nome = $data['nome'];

			if (isset($data['sexo'])) $pessoa->sexo = $data['sexo'];
			//if ($data['data_nascimento'] != "") $pessoa->data_nascimento = $data['data_nascimento'];
		//	if ($data['cpf'] != "") $pessoa->cpf = $data['cpf'];
			//if ($data['email'] != "") $pessoa->email = $data['email'];
			
			$pessoa->save();
			
			//$estudante->ra = $data['ra'];

			$estudante->pessoa()->associate($pessoa);
			$estudante->categoria()->associate(Categoria::find($data["categoria_id"]));
			$estudante->instituicao()->associate(Instituicao::find($data["instituicao_id"]));
			$estudante->save();

			$user = new User();
			$user->email = $user->login = $data['email'];
            $user->password = bcrypt('mudar123');
            $user->ativo = 0;
            $user->pessoa_id = $pessoa->id;
            $user->save();
            $user->perfis()->attach(Perfil::where('descricao', "=", 'Estudante')->first()->id);       
		}
    	return redirect()->route('estudante.index')->with('sucesso', 'Estudante criado com sucesso!');
    }
	
	public function destroy($estudante_id){
		if (Auth::user()->isAdmin() || $this->permissoes->excluir){
			$estudante = Estudante::find($estudante_id);
			$pessoa = $estudante->pessoa;
			$user = $pessoa->usuario;
			$user->perfis()->detach();
			$estudante->trabalhos()->detach();
			$estudante->delete();
			$user->delete();
			$pessoa->delete();
			return redirect()->route('estudante.index')->with('sucesso', 'Estudante excluido com sucesso!');
		}
    	return redirect()->route('estudante.index')->with('erro', 'Você não tem permissão para excluir esse registro');
	}

  public function email()
    {
        $estudantes = Estudante::with('pessoa.usuario')->get();
        //$avaliadores_ = array();

        foreach ($estudantes as $estudante) {
          Mail::to($estudante->pessoa->usuario->email)->send(new EmailEstudantes($estudante->pessoa->usuario));
       }
        //$user = User::find(1);
        //return $user;
        // Ship order...  

        //Mail::to($request->user())->send(new OrderShipped($order));
        //Mail::to($user->email)->send(new EmailAvaliadores($user));
    }

	public function importar()
	{
		$dados = '[
  {
    "nome": "Fernanda da Silva Echeverria de Souza",
    "email": "Echeverriafernanda12@gmail.com",
    "escola": "22"
  },
  {
    "nome": "Francisco Lima de Queiroz",
    "email": "franciscolq0306@gmail.com",
    "escola": "22"
  },
  {
    "nome": "Yohann Kelwin Silva Nunes",
    "email": "guaritacba@gmail.com",
    "escola": "22"
  },
  {
    "nome": "Horlian Gabriel Ferreira de Souza",
    "email": "horlian.864419@edutec.sed.ms.gov.br",
    "escola": "15"
  },
  {
    "nome": "Karlos Eduardo de Souza",
    "email": "carloscarcano2018@gmail.com",
    "escola": "30"
  },
  {
    "nome": "Letícia Dias Arguello Evora",
    "email": "aluno26@gmail.com",
    "escola": "30"
  },
  {
    "nome": "Tamires Divina Dias Andrade dos Santos",
    "email": "aluno36@gmail.com",
    "escola": "30"
  },
  {
    "nome": "Kamily Arias da Silva",
    "email": "helenbrunadaquebrada@gmail.com",
    "escola": "7"
  },
  {
    "nome": "Gabrielly da Silva Garcia",
    "email": "silvagarciagabrielly733@gmail.com",
    "escola": "7"
  },
  {
    "nome": "Marcelo Rafael de Lacerda Alves",
    "email": "mrlacerda01@gmail.com",
    "escola": "1"
  },
  {
    "nome": "Mayara Emelly Ximenez Carbajal",
    "email": "mayaraximenez1@gmail.com",
    "escola": "1"
  },
  {
    "nome": "Francesco Pagani Galvão",
    "email": "fracesco.galvao@estudante.1.edu.br",
    "escola": "1"
  },
  {
    "nome": "Renan Augusto Monteiro Duarte",
    "email": "renan.duarte@estudante.1.edu.br",
    "escola": "1"
  },
  {
    "nome": "José Henrique Zabala Ramos",
    "email": "aluno110@gmail.com",
    "escola": "3"
  },
  {
    "nome": "Maria José Zabala Ramos",
    "email": "aluno210@gmail.com",
    "escola": "3"
  },
  {
    "nome": "Nardy Zabala Ramos",
    "email": "aluno310@gmail.com",
    "escola": "3"
  },
  {
    "nome": "Laísa Elena de Barros Monteiro",
    "email": "laisabarros97@gmail.com",
    "escola": "1"
  },
  {
    "nome": "Meyson Anderson Santos de Freitas",
    "email": "meyson6603@gamil.com",
    "escola": "1"
  },
  {
    "nome": "Emanoel Gomes do Espirito Santo",
    "email": "emanoelgomes801@gmail.com",
    "escola": "1"
  },
  {
    "nome": "Thiago Fernandes Santos Malta",
    "email": "thiago23malta@gmail.com",
    "escola": "1"
  },
  {
    "nome": "Manoela da Siva Carvalho",
    "email": "manoela.silva.carvalho@gmail.com",
    "escola": "1"
  },
  {
    "nome": "Yasmim Papa",
    "email": "yasmimpapa29@gmail.com",
    "escola": "1"
  },
  {
    "nome": "Luis Guilherme Q. Jacintho",
    "email": "guilhermejjacintho.gg@gmail.com",
    "escola": "1"
  },
  {
    "nome": "Manoela da Siva Carvalho",
    "email": "manoela.silva.carvalho@gmail.com",
    "escola": "1"
  },
  {
    "nome": "Clara Manuela Miranda de Jesus",
    "email": "claramirandajesus10@gmail.com",
    "escola": "31"
  },
  {
    "nome": "Isaac de Jesus Garcia",
    "email": "isaacjgarcia67@gmail.com",
    "escola": "31"
  },
  {
    "nome": "Luiz Guilherme Santiago",
    "email": "aluno116@gmail.com",
    "escola": "23"
  },
  {
    "nome": "Monik Ramos Rodrigues Espinosa",
    "email": "aluno216@gmail.com",
    "escola": "23"
  },
  {
    "nome": "Roger Oliveira dos Santos",
    "email": "aluno316@gmail.com",
    "escola": "23"
  },
  {
    "nome": "mpfl@hotmail.com",
    "email": "Rosaria Casseres Torres",
    "escola": "9"
  },
  {
    "nome": "rossi.caceres18@gmail.com",
    "email": "aluno217@gmail.com",
    "escola": "9"
  },
  {
    "nome": "Izael Pereira dos Santos",
    "email": "izaelsants999@gmail.com",
    "escola": "32"
  },
  {
    "nome": "Mariana Moura do Nascimento",
    "email": "mouramariana671@gmail.com",
    "escola": "32"
  },
  {
    "nome": "Naraline ferreira Martins",
    "email": "naramartins2005@gmail.com",
    "escola": "32"
  },
  {
    "nome": "Allan da Silva Rodrigues Florentino",
    "email": "allan.florentino@estudante.1.edu.br",
    "escola": "1"
  },
  {
    "nome": "Fábio Peinaldo Jimenez",
    "email": "fabio.jimenez@estudante.1.edu.br",
    "escola": "1"
  },
  {
    "nome": "Lynicker Alexandre de Pinho Leite",
    "email": "lampc@corumba.ms.gov.br",
    "escola": "27"
  },
  {
    "nome": "Abel Henrique Patrocínio Vieira da Silva",
    "email": "Abelvieira12@outlook.com",
    "escola": "16"
  },
  {
    "nome": "Dayane Ortiz da Silva",
    "email": "dayane.1040913@edutec.sed.ms.gov.br",
    "escola": "16"
  },
  {
    "nome": "Thayná Cuellar Rodriguez",
    "email": "taynacuell@gmail.com",
    "escola": "17"
  },
  {
    "nome": "Carlos Soares",
    "email": "carlos.soares@estudante.1.edu.br",
    "escola": "1"
  },
  {
    "nome": "Allan Florentino",
    "email": "allan.florentino@estudante.1.edu.br",
    "escola": "1"
  },
  {
    "nome": "Maria França",
    "email": "maria.franca3@estudante.1.edu.b",
    "escola": "1"
  },
  {
    "nome": "Sheila Rodrigues Santana",
    "email": "sheilarodrigues248@gmail.com",
    "escola": "1"
  },
  {
    "nome": "Maria Aparecida da Silva Noe",
    "email": "mariavanderson.20@gmail.com",
    "escola": "1"
  },
  {
    "nome": "Stephany Gomides de Andrade",
    "email": "stephanygmandrade@gmail.com",
    "escola": "1"
  },
  {
    "nome": "Daniel Alves Da Silva",
    "email": "daniel.silva8@estudante.1.edu.br",
    "escola": "1"
  },
  {
    "nome": "Ana Elis Gimenes Rosário",
    "email": "ana.rosario@estudante.1.edu.br",
    "escola": "1"
  },
  {
    "nome": "Esther Santiago",
    "email": "esthersbsantiago@outlook.com",
    "escola": "1"
  },
  {
    "nome": "Rafaella Mattos dos Santos",
    "email": "rafabela0803@gmail.com",
    "escola": "1"
  },
  {
    "nome": "Miguel Gonçalves",
    "email": "mtiger67098@gmail.com",
    "escola": "1"
  }
]';
	$dados = json_decode($dados);
	foreach ($dados as $dado) :
		$user = User::where('email', $dado->email)->first();
		if(!$user){
			$pessoa = new Pessoa();
			$estudante = new Estudante();
			//$estudante->categoria_id =  $dado->categoria;
			$pessoa->nome = $dado->nome;
			$pessoa->save();
			
			$estudante->pessoa()->associate($pessoa);
			$estudante->categoria()->associate(Categoria::find(1));
			$estudante->instituicao()->associate(Instituicao::find($dado->escola));
			$estudante->save();
			$user = new User();
            $user->email = $user->login = $dado->email;
            $user->password = bcrypt('mudar123');
            $user->ativo = 0;
            $user->pessoa_id = $pessoa->id;
            $user->save();
            $user->perfis()->attach(Perfil::where('descricao', "=", 'Estudante')->first()->id);
		}
	endforeach;
	}
}
