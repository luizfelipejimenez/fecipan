<?php

namespace App\Http\Controllers;

use App\Evento;
use App\Area;
use App\Categoria;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;
/*use fecipan\Http\Controllers\Controller;
use fecipan\Http\Requests\EventoRequest;
use Request;
*/
class EventoController extends Controller {
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
        	$this->permissoes = Auth::user()->temPermissao(["/evento"]);
        	if ($this->permissoes == null)
        		return redirect('/')->with('erro', 'Você não tem permissão suficiente');
        	return $next($request);
        });
    }    

	// A função index é executada para a rota /evento
	public function index(){
		$eventos = Evento::orderBy('id')->get();
				
		return view('evento.evento')->with(['eventos'=>$eventos, 'permissoes'=>$this->permissoes]);
	}

	public function listar(Evento $evento)
	{
		return view('evento.listar', ['trabalhos' => $evento->trabalhos]);
	}
	
	public function create(){
		if ($this->permissoes->inserir){
			return view('evento.formCreate');
		}
		else{
			return redirect('evento');
		}
	}
	
	public function store(Request $request){
		//return Carbon::createFromFormat('d/m/Y', $request->data_inicio)->format('Y/m/d');
		if ($this->permissoes->inserir){
			$this->validate($request, [
				'titulo' => 'required',
				'ano' => 'required',
				'semestre' => 'required',
				'tema' => 'required',
				'data_inicio' => 'required',
				'data_fim' => 'required',
			]);
			$data = $request->all();
			$data['data_inicio'] = Carbon::createFromFormat('d/m/Y', $request->data_inicio)->format('Y/m/d');
			$data['data_fim'] = Carbon::createFromFormat('d/m/Y', $request->data_fim)->format('Y/m/d');
			$evento = new Evento($data);
			$evento->ativo = true;
			if($evento->save())
				return redirect('/evento')->with('sucesso', 'Evento cadastrado com sucesso!');
    		return redirect('/evento')->with('erro', 'Algo deu errado!');    	
		}
        return redirect('evento')->with('erro', 'Você não tem permissão suficiente'); 
	}

	public function edit(Evento $evento){
		if ($this->permissoes->alterar){
			return view ('evento.formCreate', ['evento' => $evento]);
		}
		else{
			return redirect('evento');
		}

	}
	public function update(Request $request, Evento $evento){
		if ($this->permissoes->alterar){
			$this->validate($request, [
				'titulo' => 'required',
				'ano' => 'required',
				'semestre' => 'required',
				'tema' => 'required',
				'data_inicio' => 'required',
				'data_fim' => 'required',
			]);

			$data = $request->all();
			$data['data_inicio'] = Carbon::createFromFormat('d/m/Y', $request->data_inicio)->format('Y/m/d');
			$data['data_fim'] = Carbon::createFromFormat('d/m/Y', $request->data_fim)->format('Y/m/d');
			//$evento = Evento::find($data["evento_id"]);
			$evento->update($data);
		}
		return redirect('/evento');
//		return redirect()->action('EventoController@evento',['pagina' => 1])->with('titulo',$params['titulo']);
	}
	public function destroy($evento_id){
		if ($this->permissoes->excluir){
			$evento = Evento::find($evento_id);
			$evento->quesitos()->delete();
			$evento->trabalhos()->delete();
			$evento->delete();
		}
		return redirect('/evento');
	}
	
	public function ranking($evento_id){
		$evento = Evento::find($evento_id);
		$areas = Area::get();
		$categorias = Categoria::get();
		return view("evento.ranking")->with(["evento"=>$this->exportarRanking($evento_id), "permissoes"=>$this->permissoes]);
	}

	public function ranking2(Evento $evento){
		return view("evento.ranking2")->with(["evento"=>$evento, "permissoes"=>$this->permissoes]);
	}

	public function exportarRanking($evento_id)
	{
		$evento = Evento::find($evento_id);
		$evento->melhores_feira = Evento::rankingTrabalhosPorCategoria($evento);
		$evento->categorias = Categoria::all();
		foreach ($evento->categorias as $categoria) :
			$categoria->melhores_categoria = Categoria::rankingTrabalhosPorCategoria($evento, $categoria);
			$categoria->areas = Area::get();
			foreach ($categoria->areas as $area) :
				$area->trabalhos = Area::rankingTrabalhosPorAreaCategoria2($evento, $categoria, $area, 50);
			endforeach;
		endforeach;
		return $evento;
	}

	public function importar(){
		$dados = '[
		  {
		    "titulo": "A IMPORTÂNCIA DE UMA VIDA ATIVA E SAUDÁVEL EM TEMPOS DE PANDEMIA",
		    "categoria": "Ensino Fundamental",
		    "area": "CBS - Ciências Biológicas e da Saúde",
		    "serie": "oitavo ano",
		    "link": "https://youtu.be/Jz570BXdfMU",
		    "orientador_nome": "Aline Rodrigues Guedes da Silva",
		    "orientador_email": "nortonaline@hotmail.com",
		    "coorientador_nome": "",
		    "coorientador_email": "",
		    "aluno1_nome": "Fernanda da Silva Echeverria de Souza",
		    "aluno1_email": "Echeverriafernanda12@gmail.com",
		    "aluno2_nome": "Francisco Lima de Queiroz",
		    "aluno2_email": "franciscolq0306@gmail.com",
		    "aluno3_nome": "Yohann Kelwin Silva Nunes",
		    "aluno3_email": "guaritacba@gmail.com",
		    "escola_nome": "Escola Municipal Izabel Corrêa de Oliveira"
		  },
		  {
		    "titulo": "OBSERVAÇÃO DO CICLO DE VIDA DA MOSCA DOMÉSTICA NO PERÍODO DE SETEMBRO A OUTUBRO DE 2020 NA CIDADE DE CORUMBÁ-MS",
		    "categoria": "Ensino Fundamental",
		    "area": "CBS - Ciências Biológicas e da Saúde",
		    "serie": "sexto ano",
		    "link": "https://www.youtube.com/watch?v=vmHQjfJeyNA",
		    "orientador_nome": "Cristiane da Silva Siqueira",
		    "orientador_email": "cristiane.130619@edutec.sed.ms.gov.b",
		    "coorientador_nome": "Hosana Teixeira Ferreira",
		    "coorientador_email": "hosana.55573@edutec.sed.ms.gov.br",
		    "aluno1_nome": "Horlian Gabriel Ferreira de Souza",
		    "aluno1_email": "horlian.864419@edutec.sed.ms.gov.br",
		    "aluno2_nome": "",
		    "aluno2_email": "",
		    "aluno3_nome": "",
		    "aluno3_email": "",
		    "escola_nome": "E. E. Maria Leite"
		  },
		  {
		    "titulo": "USO DE SEMENTES DE MANDUVI (Sterculia striata) E DE ABÓBORA (Curcubita sp.) NO PREPARO DE LANCHES PRÁTICOS",
		    "categoria": "Ensino Fundamental",
		    "area": "CBS - Ciências Biológicas e da Saúde",
		    "serie": "nono ano",
		    "link": "https://youtu.be/-tXtoYBEBtw",
		    "orientador_nome": "Edima Ramos Minzão",
		    "orientador_email": "luizminzao@gmail.com",
		    "coorientador_nome": "Waldize Diniz Gonçalves de Freitas",
		    "coorientador_email": "",
		    "aluno1_nome": "Karlos Eduardo de Souza",
		    "aluno1_email": "carloscarcano2018@gmail.com",
		    "aluno2_nome": "Letícia Dias Arguello Evora",
		    "aluno2_email": "",
		    "aluno3_nome": "Tamires Divina Dias Andrade dos Santos",
		    "aluno3_email": "",
		    "escola_nome": "EMR Polo e Extensões Carlos Cárcano"
		  },
		  {
		    "titulo": "Produção de games para o ensino remoto de matemática",
		    "categoria": "Ensino Fundamental",
		    "area": "CET - Ciências Exatas e da Terra",
		    "serie": "oitavo ano",
		    "link": "https://youtu.be/yC-aM3bevTU",
		    "orientador_nome": "ODAIR GONCALVES MARQUEZ",
		    "orientador_email": "omarquez.marquez@gmail.com",
		    "coorientador_nome": "Diego Rodrigues da Silva",
		    "coorientador_email": "diegorodrigues.32@hotmail.com",
		    "aluno1_nome": "Kamily Arias da Silva",
		    "aluno1_email": "helenbrunadaquebrada@gmail.com",
		    "aluno2_nome": "Gabrielly da Silva Garcia",
		    "aluno2_email": "silvagarciagabrielly733@gmail.com",
		    "aluno3_nome": "",
		    "aluno3_email": "",
		    "escola_nome": "Escola Municipal José de Souza Damy"
		  },
		  {
		    "titulo": "MAPEAMENTO DE MODELOS DE PROCESSO PARA REDES DE PETRI",
		    "categoria": "Ensino médio",
		    "area": "CET - Ciências Exatas e da Terra",
		    "serie": "Terceiro ano",
		    "link": "https://www.youtube.com/watch?v=_Gy0bddOLaw",
		    "orientador_nome": "ANDERSON PEREIRA DAS NEVES",
		    "orientador_email": "anderson.neves@ifms.edu.br",
		    "coorientador_nome": "Hildo Anselmo Galter Dalmonech",
		    "coorientador_email": "hildo.dalmonech@ifms.edu.br",
		    "aluno1_nome": "Marcelo Rafael de Lacerda Alves",
		    "aluno1_email": "mrlacerda01@gmail.com",
		    "aluno2_nome": "Mayara Emelly Ximenez Carbajal",
		    "aluno2_email": "mayaraximenez1@gmail.com",
		    "aluno3_nome": "",
		    "aluno3_email": "",
		    "escola_nome": "IFMS"
		  },
		  {
		    "titulo": "Dagda - Software de Auxílio ao Ensino de Música na Educação Básica",
		    "categoria": "Ensino médio",
		    "area": "CET - Ciências Exatas e da Terra",
		    "serie": "sétimo semestre",
		    "link": "https://www.youtube.com/watch?v=aHEs3W3tkzY",
		    "orientador_nome": "Luiz Felipe de Souza Jimenez",
		    "orientador_email": "luiz.jimenez@ifms.edu.br",
		    "coorientador_nome": "Dorgival Pereira da Silva Netto",
		    "coorientador_email": "dorgival.silva@ifms.edu.br",
		    "aluno1_nome": "Francesco Pagani Galvão",
		    "aluno1_email": "fracesco.galvao@estudante.ifms.edu.br",
		    "aluno2_nome": "Renan Augusto Monteiro Duarte",
		    "aluno2_email": "renan.duarte@estudante.ifms.edu.br",
		    "aluno3_nome": "",
		    "aluno3_email": "",
		    "escola_nome": "IFMS"
		  },
		  {
		    "titulo": "A importância da reciclagem do vidro para a natureza",
		    "categoria": "Ensino Fundamental",
		    "area": "CAE - Ciências Agrárias e Engenharia",
		    "serie": "oitavo ano",
		    "link": "https://www.youtube.com/watch?v=XXHff-AnVdM",
		    "orientador_nome": "Marcia Aparecida Campos Chaparro",
		    "orientador_email": "marciaapchaparro@gmail.com",
		    "coorientador_nome": "",
		    "coorientador_email": "",
		    "aluno1_nome": "José Henrique Zabala Ramos",
		    "aluno1_email": "",
		    "aluno2_nome": "Maria José Zabala Ramos",
		    "aluno2_email": "",
		    "aluno3_nome": "Nardy Zabala Ramos",
		    "aluno3_email": "",
		    "escola_nome": "Escola Mun Rural de Educação Integral Eutrópia Gomes Pedroso"
		  },
		  {
		    "titulo": "DESENVOLVIMENTO DE UM SISTEMA DE CONTROLE DE ACESSO AOS LABORATÓRIOS BASEADO EM IOT",
		    "categoria": "Ensino Médio",
		    "area": "CAE - Ciências Agrárias e Engenharia",
		    "serie": "Sétimo Semestre",
		    "link": "https://youtu.be/QkjaH5Zt_eU",
		    "orientador_nome": "Luiz Felipe de Souza Jimenez",
		    "orientador_email": "luiz.jimenez@ifms.edu.br",
		    "coorientador_nome": "Dorgival Pereira da Silva Netto",
		    "coorientador_email": "dorgival.silva@ifms.edu.br",
		    "aluno1_nome": "Laísa Elena de Barros Monteiro",
		    "aluno1_email": "laisabarros97@gmail.com",
		    "aluno2_nome": "Meyson Anderson Santos de Freitas",
		    "aluno2_email": "meyson6603@gamil.com",
		    "aluno3_nome": "",
		    "aluno3_email": "",
		    "escola_nome": "IFMS"
		  },
		  {
		    "titulo": "OBTENÇÃO DE PÓS NANOESTRUTURADOS DE BIFEO3 POR  SÍNTESE POR COMBUSTÃO E A CARACTERIZAÇÃO DAS FASES  CRISTALINAS",
		    "categoria": "Ensino médio",
		    "area": "CAE - Ciências Agrárias e Engenharia",
		    "serie": "Sétimo Semestre",
		    "link": "https://youtu.be/YudiDrEUZ-g",
		    "orientador_nome": "Felipe Fernandes de Oliveira",
		    "orientador_email": "felipe.oliveira@ifms.edu.br",
		    "coorientador_nome": "",
		    "coorientador_email": "",
		    "aluno1_nome": "Emanoel Gomes do Espirito Santo",
		    "aluno1_email": "emanoelgomes801@gmail.com",
		    "aluno2_nome": "Thiago Fernandes Santos Malta",
		    "aluno2_email": "thiago23malta@gmail.com",
		    "aluno3_nome": "",
		    "aluno3_email": "",
		    "escola_nome": "IFMS"
		  },
		  {
		    "titulo": "Resíduo descartado pela Siderúrgica de Corumbá-MS como potencial para  reaproveitamento na construção civil",
		    "categoria": "Ensino Médio",
		    "area": "CAE - Ciências Agrárias e Engenharia",
		    "serie": "Sétimo Semestre",
		    "link": "https://youtu.be/VPKjidHkhrc",
		    "orientador_nome": "Robson Fleming Ribeiro",
		    "orientador_email": "robson.ribeiro@ifms.edu.br",
		    "coorientador_nome": "Felipe Fernandes de Oliveira",
		    "coorientador_email": "felipe.oliveira@ifms.edu.br",
		    "aluno1_nome": "Manoela da Siva Carvalho",
		    "aluno1_email": "manoela.silva.carvalho@gmail.com",
		    "aluno2_nome": "",
		    "aluno2_email": "",
		    "aluno3_nome": "",
		    "aluno3_email": "",
		    "escola_nome": "IFMS"
		  },
		  {
		    "titulo": "SOLUÇÕES AMBIENTAIS E ECONÔMICAS: UTILIZAÇÃO DE REJEITOS  DA MINERAÇÃO EM ARGAMASSAS CONVENCIONAIS",
		    "categoria": "Ensino médio",
		    "area": "CAE - Ciências Agrárias e Engenharia",
		    "serie": "Sétimo Semestre",
		    "link": "https://youtu.be/x3IeyWamrRw",
		    "orientador_nome": "Robson Fleming Ribeiro",
		    "orientador_email": "robson.ribeiro@ifms.edu.br",
		    "coorientador_nome": "Felipe Fernandes de Oliveira",
		    "coorientador_email": "felipe.oliveira@ifms.edu.br",
		    "aluno1_nome": "Yasmim Papa",
		    "aluno1_email": "yasmimpapa29@gmail.com",
		    "aluno2_nome": "Luis Guilherme Q. Jacintho",
		    "aluno2_email": "guilhermejjacintho.gg@gmail.com",
		    "aluno3_nome": "Manoela da Siva Carvalho",
		    "aluno3_email": "manoela.silva.carvalho@gmail.com",
		    "escola_nome": "IFMS"
		  },
		  {
		    "titulo": "O ESTUDANTE COMO PROTAGONISTA NA APRENDIZAGEM",
		    "categoria": "Ensino Fundamental",
		    "area": "MDIS - Multidisciplinar",
		    "serie": "Sexto Ano",
		    "link": "https://youtu.be/V_hbcpiHcOs",
		    "orientador_nome": "RODRIGO CABRAL DA SILVA",
		    "orientador_email": "rodrigo.cbs01@gmail.com",
		    "coorientador_nome": "Cristiane Maria de Jesus Garcia",
		    "coorientador_email": "crisss.mariaa@gmail.com",
		    "aluno1_nome": "Clara Manuela Miranda de Jesus",
		    "aluno1_email": "claramirandajesus10@gmail.com",
		    "aluno2_nome": "Isaac de Jesus Garcia",
		    "aluno2_email": "isaacjgarcia67@gmail.com",
		    "aluno3_nome": "",
		    "aluno3_email": "",
		    "escola_nome": "Escola Pedro Paulo de Medeiros"
		  },
		  {
		    "titulo": "IMPACTO EMOCIONAL NOS ALUNOS DE UMA ESCOLA DA REDE PÚBLICA (LADÁRIO-MS) DURANTE A PANDEMIA.",
		    "categoria": "Ensino Fundamental",
		    "area": "MDIS - Multidisciplinar",
		    "serie": "oitavo ano",
		    "link": "https://www.youtube.com/watch?v=zoBi68gtgwA",
		    "orientador_nome": "Dáleth Fernanda da Silva Santos",
		    "orientador_email": "daleth_bio@hotmail.com",
		    "coorientador_nome": "",
		    "coorientador_email": "",
		    "aluno1_nome": "Luiz Guilherme Santiago",
		    "aluno1_email": "",
		    "aluno2_nome": "Monik Ramos Rodrigues Espinosa",
		    "aluno2_email": "",
		    "aluno3_nome": "Roger Oliveira dos Santos",
		    "aluno3_email": "",
		    "escola_nome": "Escola Municipal Marquês de Tamandaré"
		  },
		  {
		    "titulo": "MUDANÇAS NA ROTINA DE ESTUDOS EM TEMPOS DE CORONAVÍRUS: UM ESTUDO DE CASO NA ESCOLA MUNICIPAL TILMA FERNANDES VEIGA",
		    "categoria": "CORUMBÁ-MS",
		    "area": "Ensino Fundamental",
		    "serie": "MDIS - Multidisciplinar",
		    "link": "nono ano",
		    "orientador_nome": "https://www.youtube.com/watch?v=RXfs5F8b2ao",
		    "orientador_email": "Fernanda Maria de Russo Godoy",
		    "coorientador_nome": "fernandagodoy518@gmail.com",
		    "coorientador_email": "Maria da Piedade Figueiredo Baptista da Silva",
		    "aluno1_nome": "mpfl@hotmail.com",
		    "aluno1_email": "Rosaria Casseres Torres",
		    "aluno2_nome": "rossi.caceres18@gmail.com",
		    "aluno2_email": "",
		    "aluno3_nome": "",
		    "aluno3_email": "",
		    "escola_nome": "ESCOLA MUNICIPAL TILMA FERNANDES VEIGA"
		  },
		  {
		    "titulo": "Corumbá Virtual Tour",
		    "categoria": "Ensino Médio",
		    "area": "MDIS - Multidisciplinar",
		    "serie": "Primeiro ano",
		    "link": "https://www.youtube.com/watch?v=7agwN1guwGs",
		    "orientador_nome": "Edxerlin dos Santos Costa",
		    "orientador_email": "edxerlin25@gmail.com",
		    "coorientador_nome": "Rosilvana Melgar Salcedo",
		    "coorientador_email": "rosilvaniamelgar@hotmail.com",
		    "aluno1_nome": "Izael Pereira dos Santos",
		    "aluno1_email": "izaelsants999@gmail.com",
		    "aluno2_nome": "Mariana Moura do Nascimento",
		    "aluno2_email": "mouramariana671@gmail.com",
		    "aluno3_nome": "Naraline ferreira Martins",
		    "aluno3_email": "naramartins2005@gmail.com",
		    "escola_nome": "Colégio Adventista de Corumbá"
		  },
		  {
		    "titulo": "Produção de energia elétrica e dessalinização de água salobra por concentrador solar",
		    "categoria": "Ensino Médio",
		    "area": "MDIS - Multidisciplinar",
		    "serie": "Segundo Ano",
		    "link": "https://youtu.be/184K8fSGiwU",
		    "orientador_nome": "Afonso Henriques Silva Leite",
		    "orientador_email": "afonso.leite@ifms.edu.br",
		    "coorientador_nome": "",
		    "coorientador_email": "",
		    "aluno1_nome": "Allan da Silva Rodrigues Florentino",
		    "aluno1_email": "allan.florentino@estudante.ifms.edu.br",
		    "aluno2_nome": "Fábio Peinaldo Jimenez",
		    "aluno2_email": "fabio.jimenez@estudante.ifms.edu.br",
		    "aluno3_nome": "",
		    "aluno3_email": "",
		    "escola_nome": "IFMS"
		  },
		  {
		    "titulo": "#NãopiraNão - Autocuidados durante o Distanciamento Social.",
		    "categoria": "Ensino Fundamental",
		    "area": "CHCSA - Ciências Humanas; Sociais Aplicadas e Linguística",
		    "serie": "oitavo ano",
		    "link": "https://youtu.be/l-V2RrYfwJ4",
		    "orientador_nome": "Mayara Mayda Vaz Coutinho",
		    "orientador_email": "mayara_mayda@hotmail.com",
		    "coorientador_nome": "",
		    "coorientador_email": "",
		    "aluno1_nome": "Lynicker Alexandre de Pinho Leite",
		    "aluno1_email": "lampc@corumba.ms.gov.br",
		    "aluno2_nome": "",
		    "aluno2_email": "",
		    "aluno3_nome": "",
		    "aluno3_email": "",
		    "escola_nome": "Luiz de Albuquerque de Melo Pereira e Cáceres e Extensões."
		  },
		  {
		    "titulo": "LIMITACOES E DESAFIOS A SEREM SUPERADOS NA EDUCACAO BASICA EM TEMPOS DE PANDEMIA",
		    "categoria": "Ensino Fundamental",
		    "area": "CHCSA - Ciências Humanas; Sociais Aplicadas e Linguística",
		    "serie": "nono ano",
		    "link": "https://youtu.be/rRuYVNl2IJU",
		    "orientador_nome": "Cristiane Maria de Jesus Garcia",
		    "orientador_email": "crisss.mariaa@gmail.com",
		    "coorientador_nome": "Jennyclaudia Fernanda Souza Campos",
		    "coorientador_email": "jennyclaudia27@gmail.com",
		    "aluno1_nome": "Abel Henrique Patrocínio Vieira da Silva",
		    "aluno1_email": "Abelvieira12@outlook.com",
		    "aluno2_nome": "Dayane Ortiz da Silva",
		    "aluno2_email": "dayane.1040913@edutec.sed.ms.gov.br",
		    "aluno3_nome": "",
		    "aluno3_email": "",
		    "escola_nome": "Escola Estadual Nathércia Pompeo dos Santos"
		  },
		  {
		    "titulo": "PODCAST - Uma Ferramenta de Interação Social",
		    "categoria": "Ensino Fundamental",
		    "area": "CHCSA - Ciências Humanas; Sociais Aplicadas e Linguística",
		    "serie": "sétimo ano",
		    "link": "https://youtu.be/XLEWrlzCWvc",
		    "orientador_nome": "Ethiene torres",
		    "orientador_email": "ethytorres@gmail.com",
		    "coorientador_nome": "",
		    "coorientador_email": "",
		    "aluno1_nome": "Thayná Cuellar Rodriguez",
		    "aluno1_email": "taynacuell@gmail.com",
		    "aluno2_nome": "",
		    "aluno2_email": "",
		    "aluno3_nome": "",
		    "aluno3_email": "",
		    "escola_nome": "E.E ROTARY CLUB"
		  },
		  {
		    "titulo": "DE OLHOS ABERTOS PARA A REALIDADE: ESTUDO E SUPERAÇÃO DO BULLYING NO IFMS-CB",
		    "categoria": "Ensino Médio",
		    "area": "CHCSA - Ciências Humanas; Sociais Aplicadas e Linguística",
		    "serie": "Quinto semestre",
		    "link": "https://youtu.be/tDg-XdKZ2ps",
		    "orientador_nome": "Maicon Martta",
		    "orientador_email": "maicon.martta@ifms.edu.br",
		    "coorientador_nome": "",
		    "coorientador_email": "",
		    "aluno1_nome": "Carlos Soares",
		    "aluno1_email": "carlos.soares@estudante.ifms.edu.br",
		    "aluno2_nome": "Allan Florentino",
		    "aluno2_email": "allan.florentino@estudante.ifms.edu.br",
		    "aluno3_nome": "Maria França",
		    "aluno3_email": "maria.franca3@estudante.ifms.edu.b",
		    "escola_nome": "IFMS"
		  },
		  {
		    "titulo": "História Oral: memória de idosos do município de Corumbá - MS",
		    "categoria": "Ensino Médio",
		    "area": "CHCSA - Ciências Humanas; Sociais Aplicadas e Linguística",
		    "serie": "Sexto Semestre",
		    "link": "https://www.youtube.com/watch?v=7obx9-9b0Cc",
		    "orientador_nome": "Cryseverlin Dias Pinheiro Santos",
		    "orientador_email": "cryseverlin.santos@ifms.edu.br",
		    "coorientador_nome": "Fabio Henrique Noboru Abe",
		    "coorientador_email": "fabio.abe@ifms.edu.br",
		    "aluno1_nome": "Sheila Rodrigues Santana",
		    "aluno1_email": "sheilarodrigues248@gmail.com",
		    "aluno2_nome": "Maria Aparecida da Silva Noe",
		    "aluno2_email": "mariavanderson.20@gmail.com",
		    "aluno3_nome": "",
		    "aluno3_email": "",
		    "escola_nome": "IFMS"
		  },
		  {
		    "titulo": "IMPACTOS DO ENSINO REMOTO NO PROCESSO PEDAGÓGICO VIVENCIADO POR DISCENTES E DOCENTES EM TEMPOS DE PANDEMIA",
		    "categoria": "Ensino Médio",
		    "area": "CHCSA - Ciências Humanas; Sociais Aplicadas e Linguística",
		    "serie": "Sexto Semestre",
		    "link": "https://www.youtube.com/watch?v=0GW1RoWViLc",
		    "orientador_nome": "Cryseverlin Dias Pinheiro Santos",
		    "orientador_email": "cryseverlin.santos@ifms.edu.br",
		    "coorientador_nome": "Renata de Oliveira Costa",
		    "coorientador_email": "renata.costa@ifms.edu.br",
		    "aluno1_nome": "Stephany Gomides de Andrade",
		    "aluno1_email": "stephanygmandrade@gmail.com",
		    "aluno2_nome": "",
		    "aluno2_email": "",
		    "aluno3_nome": "",
		    "aluno3_email": "",
		    "escola_nome": "IFMS"
		  },
		  {
		    "titulo": "O ENSINO DE HISTÓRIA E CULTURA AFRO-BRASILEIRA E AFRICANA: A PARTIR DAS REPRESENTAÇÕES DOS ESTUDANTES DO IFMS CAMPUS CORUMBÁ",
		    "categoria": "Ensino Médio",
		    "area": "CHCSA - Ciências Humanas; Sociais Aplicadas e Linguística",
		    "serie": "Quinto Semestre",
		    "link": "https://www.youtube.com/watch?v=vxggsYNsDBE",
		    "orientador_nome": "Cryseverlin Dias Pinheiro Santos",
		    "orientador_email": "cryseverlin.santos@ifms.edu.br",
		    "coorientador_nome": "",
		    "coorientador_email": "",
		    "aluno1_nome": "Daniel Alves Da Silva",
		    "aluno1_email": "daniel.silva8@estudante.ifms.edu.br",
		    "aluno2_nome": "Ana Elis Gimenes Rosário",
		    "aluno2_email": "ana.rosario@estudante.ifms.edu.br",
		    "aluno3_nome": "",
		    "aluno3_email": "",
		    "escola_nome": "IFMS"
		  },
		  {
		    "titulo": "REDESCOBRINDO O PANTANAL RUPESTRE: UM RETRATO DA NOSSA HISTÓRIA APARTIR DE ELEMENTOS DA REALIDADE AUMENTADA E DA TÉCNICA DE FROTAGEM",
		    "categoria": "Ensino Médio",
		    "area": "CHCSA - Ciências Humanas; Sociais Aplicadas e Linguística",
		    "serie": "Sexto Semestre",
		    "link": "https://www.youtube.com/watch?v=yA9-cO-Kw1Q",
		    "orientador_nome": "Maicon Martta",
		    "orientador_email": "maicon.martta@ifms.edu.br",
		    "coorientador_nome": "Fábio Henrique Noboru Abe",
		    "coorientador_email": "fabio.abe@ifms.edu.br",
		    "aluno1_nome": "Esther Santiago",
		    "aluno1_email": "esthersbsantiago@outlook.com",
		    "aluno2_nome": "Rafaella Mattos dos Santos",
		    "aluno2_email": "rafabela0803@gmail.com",
		    "aluno3_nome": "Miguel Gonçalves",
		    "aluno3_email": "mtiger67098@gmail.com",
		    "escola_nome": "IFMS"
		  }
		]';
		$dados = json_decode($dados);
		return $dados;
		$alunos = array();
	foreach ($dados as $key => $trabalho ) :
		 array_push($alunos,
		 	array ('nome' => $trabalho->aluno1_nome,
		 		   'categoria' => $trabalho->categoria == "Ensino Fundamental" ? "1" : "2",
		 		   'email'=> ($trabalho->aluno1_email != "" ? $trabalho->aluno1_email : "aluno1" . ($key+4). "@gmail.com"),
		 		   'escola' => $trabalho->escola_nome));
		 if($trabalho->aluno2_nome != "")
		 array_push($alunos,
		 	array ('nome' => $trabalho->aluno2_nome,
		 		'categoria' => $trabalho->categoria == "Ensino Fundamental" ? "1" : "2",
		 		   'email'=> ($trabalho->aluno2_email != "" ? $trabalho->aluno2_email : "aluno2" . ($key+4). "@gmail.com"),
		 		   'escola' => $trabalho->escola_nome));
		if($trabalho->aluno3_nome != "")
			array_push($alunos,
				array ('nome' => $trabalho->aluno3_nome,
					'categoria' => $trabalho->categoria == "Ensino Fundamental" ? "1" : "2",
		 		   	'email'=> ($trabalho->aluno3_email != "" ? $trabalho->aluno3_email : "aluno3" . ($key+4). "@gmail.com"),
		 		   	'escola' => $trabalho->escola_nome));
	endforeach;
	return $alunos;
	}
	
}
