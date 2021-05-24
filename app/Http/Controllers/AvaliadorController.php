<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Mail\EmailAvaliadores;
use Illuminate\Support\Facades\Mail;
use App\Pessoa;
use App\Instituicao;
use App\Avaliador;
use App\User;
use App\Perfil;

class AvaliadorController extends Controller{
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
            if(!Auth::user()->ativo)
                return redirect()->route('auth.nova_senha');
            //use o array para testar a rota com whereIn
            $this->permissoes = Auth::user()->temPermissao(["/pessoa/avaliador", "/avaliador/minhas-avaliacoes"]);
            if ($this->permissoes == null)
                return redirect('/')->with('erro', 'Você não tem permissão suficiente');
            return $next($request);
        });
    }    

    public function index(){
    	if (Auth::user()->isAdmin() || $this->permissoes->visualizar){
    		$avaliadores = Avaliador::get();
    		return view('avaliador.avaliador')->with(["avaliadores"=>$avaliadores, 'permissoes'=>$this->permissoes]);
    	}
    	return redirect('/home');
    }

    public function avaliacoes($avaliador_id){
    	if ($this->permissoes->visualizar){
    		$avaliador = Avaliador::find($avaliador_id);
    		return view('avaliador.avaliacoes')->with(["avaliador"=>$avaliador]);
    	}
    	return redirect('/home');
    }
    //bloquear avaliador de ver avaliacoes de outros avaliadores
    public function minhas_avaliacoes(){
    	return redirect('/avaliador/avaliacoes/'.Auth::user()->pessoa->avaliador->id);
    }

    public function create(){
    	if ($this->permissoes->inserir){
    		$instituicoes = Instituicao::get();
    		return view('avaliador.formCreate')->with(["instituicoes"=>$instituicoes]);
    	}
    	return redirect('/pessoa/avaliadores');
    }

    public function store(Request $request){
    	if ($this->permissoes->inserir){
    		$validator = Validator::make($request->all(),[
    			'instituicao_id' => 'required',
    			'nome' => 'required|max:255',
                'area' => 'required',
                'email' => 'required|unique:users'
    		]);

            if($validator->fails()){
                if($validator->errors()->get('email')){
                    $user = User::where('email', $request->email)->first();

                    $user = User::where('email', $request->email)->first();
                    if(!Avaliador::where('pessoa_id', $user->pessoa->id)->first()){
                        $user->perfis()->attach(Perfil::where('descricao', 'Avaliador')->first()->id);
                        Avaliador::create([
                            'pessoa_id' => $user->pessoa->id,
                            'instituicao_id' => $request->instituicao_id,
                            'area' => $request->area,
                        ]);
                    }
                    return redirect()->route('avaliador.index')->with('sucesso', 'Este usuário já estava no sistema e agora também é um avaliador');


                    //return redirect('pessoa/pessoa/'.$user->pessoa->id)
                    //        ->withErrors($validator)
                    //        ->withInput();
                }/*else{
                    
                    return redirect()->route('avaliador.create')
                    ->with('alerta', 'Este usuário já esta cadastrado neste sistema');
                }*/
            }

    		$data = $request->all();
    		
    		$pessoa = new Pessoa();
    		$avaliador = new Avaliador();
    		
    		$pessoa->nome = $data['nome'];

    		if (isset($data['sexo'])) $pessoa->sexo = $data['sexo'];
    		//if ($data['data_nascimento'] != "") $pessoa->data_nascimento = $data['data_nascimento'];
    		if ($data['cpf'] != "") $pessoa->cpf = $data['cpf'];
    		//if ($data['email'] != "") $pessoa->email = $data['email'];
    		$pessoa->save();
    		$avaliador->area = $data['area'];
    		$avaliador->pessoa()->associate($pessoa);
    		$avaliador->instituicao()->associate(Instituicao::find($data["instituicao_id"]));
    		$avaliador->save();
            $user = new User();
            $user->email = $user->login = $data['email'];
            $user->password = bcrypt('mudar123');
            $user->ativo = 0;
            $user->pessoa_id = $pessoa->id;
            $user->save();
            $user->perfis()->attach(Perfil::where('descricao', "=", 'avaliador')->first()->id);
            return redirect('/pessoa/avaliador')->with('sucesso', 'Avaliador cadastrado com sucesso!');
    	}
    	return redirect('/pessoa/avaliador')->with('erro', 'Você não tem permissão suficiente');
    }
    
    public function destroy(Avaliador $avaliador){
        //return $avaliador;
    	if (Auth::user()->isAdmin() || $this->permissoes->excluir){
    		//$avaliador = Avaliador::find($avaliador_id);

    		$pessoa = $avaliador->pessoa;
    		$user = $pessoa->usuario;
            $user->perfis()->detach();
    		$avaliador->delete();
            $user->delete();
    		$pessoa->delete();
    	}
    	return redirect('/pessoa/avaliador');
    }

    public function recuperar($codigo)
    {
    	return Avaliador::where('cod', '=', $codigo)->firstOrFail();
    	
    }

    public function email()
    {
        $avaliadores = Avaliador::with('pessoa.usuario')->get();
        foreach ($avaliadores as $avaliador) {
          Mail::to($avaliador->pessoa->usuario->email)->send(new EmailAvaliadores($avaliador->pessoa->usuario));
        }
    }


   /* public function importar()
    {
        $dados = '
  [
  {
    "nome": "Edson Rodrigo dos Santos da Silva",
    "email": "edson_r_silva@yahoo.com",
    "area_formacao": "CET - Ciências Exatas e da Terra"
  },
  {
    "nome": "ANGELICA ESPERANZA CHOQUELUQUE ROMAN",
    "email": "achoqueluque@unsa.edu.pe",
    "area_formacao": "CET - Ciências Exatas e da Terra"
  },
  {
    "nome": "Daniela da Silva Pereira Alcamim",
    "email": "danielaalcamim@gmail.com",
    "area_formacao": "CHCSA - Ciências Humanas; Sociais Aplicadas e Linguística"
  },
  {
    "nome": "Emerson André de Godoy",
    "email": "emersonandredegodoy@outlook.com",
    "area_formacao": "CHCSA - Ciências Humanas; Sociais Aplicadas e Linguística"
  },
  {
    "nome": "VÍNCLER FERNANDES RIBEIRO DE OLIVEIRA",
    "email": "vinclerfernandes@hotmail.com",
    "area_formacao": "CET - Ciências Exatas e da Terra"
  },
  {
    "nome": "Anita Baraldi Rolim",
    "email": "anita.baraldi@hotmail.com",
    "area_formacao": "CHCSA - Ciências Humanas; Sociais Aplicadas e Linguística"
  },
  {
    "nome": "Fabiola Xavier Vieira Garcia",
    "email": "fabiolaxvg@aqdv.oabsp.org.br",
    "area_formacao": "CHCSA - Ciências Humanas; Sociais Aplicadas e Linguística"
  },
  {
    "nome": "Thalita Pereira da Silva",
    "email": "thalitatls@hotmail.com",
    "area_formacao": "CHCSA - Ciências Humanas; Sociais Aplicadas e Linguística"
  },
  {
    "nome": "Jaime Edmundo Apaza Rodriguez",
    "email": "jaime.rodriguez@unesp.br",
    "area_formacao": "CET - Ciências Exatas e da Terra"
  },
  {
    "nome": "Regiane Silvestrini",
    "email": "regianesilvestrini@gmail.com",
    "area_formacao": "CHCSA - Ciências Humanas; Sociais Aplicadas e Linguística, MDIS - Multidisciplinar"
  },
  {
    "nome": "Erika Carla Nogueira da Silva",
    "email": "Erikacarlatl@gmail.com",
    "area_formacao": "CHCSA - Ciências Humanas; Sociais Aplicadas e Linguística"
  },
  {
    "nome": "Igor Thiago Minari Ramos",
    "email": "igorminari@gmail.com",
    "area_formacao": "CET - Ciências Exatas e da Terra, CAE - Ciências Agrárias e Engenharia"
  },
  {
    "nome": "LUANA FERNANDA LUIZ",
    "email": "luana_fernanda@hotmail.com",
    "area_formacao": "CHCSA - Ciências Humanas; Sociais Aplicadas e Linguística"
  },
  {
    "nome": "Amanda Emiliana Santos Baratelli",
    "email": "baratelli46@gmail.com",
    "area_formacao": "CHCSA - Ciências Humanas; Sociais Aplicadas e Linguística"
  },
  {
    "nome": "Mauro Henrique Soares da silva",
    "email": "mauro.soares@ufms.br",
    "area_formacao": "CET - Ciências Exatas e da Terra, CHCSA - Ciências Humanas; Sociais Aplicadas e Linguística"
  },
  {
    "nome": "Fernanda Luciano Rodrigues",
    "email": "fer.fmrp5@gmail.com",
    "area_formacao": "CBS - Ciências Biológicas e da Saúde"
  },
  {
    "nome": "SILVIA REGINA VIEIRA DA SILVA",
    "email": "silvia.regina@unesp.br",
    "area_formacao": "CHCSA - Ciências Humanas; Sociais Aplicadas e Linguística"
  },
  {
    "nome": "Andressa Luiza Montanha de Araujo",
    "email": "luisa.tlufms@yahoo.com.br",
    "area_formacao": "CHCSA - Ciências Humanas; Sociais Aplicadas e Linguística"
  },
  {
    "nome": "Juliana dos Santos Silva",
    "email": "judsantossilva@gmail.com",
    "area_formacao": "CHCSA - Ciências Humanas; Sociais Aplicadas e Linguística"
  },
  {
    "nome": "Ana Elisa Tonetti de Almeida",
    "email": "ana.elisa_toneti@hotmail.com",
    "area_formacao": "CHCSA - Ciências Humanas; Sociais Aplicadas e Linguística"
  },
  {
    "nome": "André Luiz Dos Santos",
    "email": "andre.santos@ifg.edu.br",
    "area_formacao": "CHCSA - Ciências Humanas; Sociais Aplicadas e Linguística"
  },
  {
    "nome": "Ronilson Lopes Brito",
    "email": "ronilson.brito@ifma.edu.br",
    "area_formacao": "CET - Ciências Exatas e da Terra"
  },
  {
    "nome": "Lucas Gazarini",
    "email": "lucas.gazarini@ufms.br",
    "area_formacao": "CBS - Ciências Biológicas e da Saúde"
  },
  {
    "nome": "FLAVIO FACCIONI",
    "email": "faccioniufms@gmail.com",
    "area_formacao": "CHCSA - Ciências Humanas; Sociais Aplicadas e Linguística, MDIS - Multidisciplinar"
  },
  {
    "nome": "Sandra Cristina Marchiori de Brito",
    "email": "sandracm@ufms.br",
    "area_formacao": "CET - Ciências Exatas e da Terra, CAE - Ciências Agrárias e Engenharia"
  },
  {
    "nome": "Reuvia de Oliveira Ribeiro",
    "email": "reuvia.ribeiro@ifto.edu.br",
    "area_formacao": "CHCSA - Ciências Humanas; Sociais Aplicadas e Linguística, MDIS - Multidisciplinar"
  },
  {
    "nome": "Douglas Matheus Gavioli Dias",
    "email": "mgaviolidias@gmail.com",
    "area_formacao": "CET - Ciências Exatas e da Terra, CHCSA - Ciências Humanas; Sociais Aplicadas e Linguística"
  },
  {
    "nome": "Suellen Moura de Paiva",
    "email": "sm.paiva@unesp.br",
    "area_formacao": "CET - Ciências Exatas e da Terra, CHCSA - Ciências Humanas; Sociais Aplicadas e Linguística"
  },
  {
    "nome": "Beatriz Mussio Magalhães de Paula",
    "email": "biaamussio@gmail.com",
    "area_formacao": "CHCSA - Ciências Humanas; Sociais Aplicadas e Linguística"
  },
  {
    "nome": "Andréia Rodrigues Alves",
    "email": "andreia.alves@ifal.edu.br",
    "area_formacao": "CET - Ciências Exatas e da Terra, MDIS - Multidisciplinar"
  },
  {
    "nome": "Matheus Guimarães Lima",
    "email": "mgl.geopp@gmail.com",
    "area_formacao": "CHCSA - Ciências Humanas; Sociais Aplicadas e Linguística, MDIS - Multidisciplinar"
  },
  {
    "nome": "Caio Fernando Ramalho de Oliveira",
    "email": "oliveiracfr@gmail.com",
    "area_formacao": "CBS - Ciências Biológicas e da Saúde"
  },
  {
    "nome": "Janaina gazarini",
    "email": "jgazarini@gmail.com",
    "area_formacao": "CBS - Ciências Biológicas e da Saúde, MDIS - Multidisciplinar"
  },
  {
    "nome": "Uiliam Nelson Lendzion Tomaz Alves",
    "email": "uiliam.alves@ifpr.edu.br",
    "area_formacao": "CAE - Ciências Agrárias e Engenharia"
  },
  {
    "nome": "Leonardo Ataide Carniato",
    "email": "leonardo@ifsp.edu.br",
    "area_formacao": "CAE - Ciências Agrárias e Engenharia"
  },
  {
    "nome": "Marco Antonio Leite Beteto",
    "email": "marcobeteto@gmail.com",
    "area_formacao": "CAE - Ciências Agrárias e Engenharia"
  },
  {
    "nome": "Bruno Sereni",
    "email": "bruno.sereni@unesp.br",
    "area_formacao": "CAE - Ciências Agrárias e Engenharia"
  },
  {
    "nome": "Haislan Ranelli Santana Bernardes",
    "email": "haislan@ifsp.edu.br",
    "area_formacao": "CAE - Ciências Agrárias e Engenharia"
  },
  {
    "nome": "Mariana Costa Falcão",
    "email": "marianacostafalcao@gmail.com",
    "area_formacao": "CAE - Ciências Agrárias e Engenharia"
  },
  {
    "nome": "ALLISON CAMARGO CANOA",
    "email": "allisoncanoatl@hotmail.com",
    "area_formacao": "CET - Ciências Exatas e da Terra, CAE - Ciências Agrárias e Engenharia"
  },
  {
    "nome": "Tiago Veronese Ortunho",
    "email": "tiago.veronese@ifsp.edu.br",
    "area_formacao": "CAE - Ciências Agrárias e Engenharia"
  },
  {
    "nome": "Lucas Henrique Lozano Dourado de Matos",
    "email": "englhmatos@gmail.com",
    "area_formacao": "CET - Ciências Exatas e da Terra, CAE - Ciências Agrárias e Engenharia"
  },
  {
    "nome": "Mariana Costa Falcão",
    "email": "marianacostafalcao@gmail.com",
    "area_formacao": "CAE - Ciências Agrárias e Engenharia"
  },
  {
    "nome": "Thiago Raniel",
    "email": "31497@aems.edu.br",
    "area_formacao": "CET - Ciências Exatas e da Terra, CAE - Ciências Agrárias e Engenharia"
  },
  {
    "nome": "Celia Santos de Souza Pereira",
    "email": "armcelia1@gmail.com",
    "area_formacao": "CAE - Ciências Agrárias e Engenharia"
  },
  {
    "nome": "Gilberto Rodrigues dos Santos",
    "email": "gilberto.rodrigues@ufms.br",
    "area_formacao": "CET - Ciências Exatas e da Terra, CAE - Ciências Agrárias e Engenharia"
  },
  {
    "nome": "Kelly Regina Torres da Silva",
    "email": "kellytorresdasilva1@gmail.com",
    "area_formacao": "CBS - Ciências Biológicas e da Saúde"
  },
  {
    "nome": "Juliana dos Santos Silva",
    "email": "judsantossilva@gmail.com",
    "area_formacao": "CHCSA - Ciências Humanas; Sociais Aplicadas e Linguística"
  }
]
';
    $dado = json_decode($dados);
    
    foreach ($dado as $dados) :
        $user = User::where('email', $dados->email)->first();
        if(!$user){
            $pessoa = new Pessoa();        
            $pessoa->nome = $dados->nome;
            $pessoa->save();

            $avaliador = new Avaliador();
            $avaliador->area = $dados->area_formacao;
            $avaliador->pessoa()->associate($pessoa);
            $avaliador->instituicao_id = 1;
            $avaliador->save();

            $user = new User();
            $user->email = $user->login = $dados->email;
            $user->password = bcrypt('mudar123');
            $user->ativo = 0;
            $user->pessoa_id = $pessoa->id;
            $user->save();
            $user->perfis()->attach(Perfil::where('descricao', "=", 'Avaliador')->first()->id); 
        }else{
            $user->perfis()->attach(Perfil::where('descricao', "=", 'Avaliador')->first()->id);
        }
    endforeach;


    }*/
}
