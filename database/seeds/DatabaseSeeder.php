<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		
		DB::table('perfil')->insert([
			['descricao' => 'Administrador','perfil_id' => NULL,'administrador' => '1'],
			['descricao' => 'Organizador','perfil_id' => '1','administrador' => '0'],
			['descricao' => 'Avaliador','perfil_id' => '1','administrador' => '0'],
			['descricao' => 'Orientador','perfil_id' => '1','administrador' => '0'],
			['descricao' => 'Estudante','perfil_id' => '1','administrador' => '0'],
			['descricao' => 'Auxiliar de Avaliação','perfil_id' => '1','administrador' => '0'],
		]);
		
		
		DB::table('area')->insert([
			['sigla'=>'CHSA', 'area'=>'Ciências Humanas e Sociais Aplicadas'],
			['sigla'=>'CET', 'area'=>'Ciências Exatas e da Terra'],
			['sigla'=>'CBS', 'area'=>'Ciências Biológicas e da Saúde'],
			['sigla'=>'ECA', 'area'=>'Engenharias e Ciências Agrárias'],
			['sigla'=>'MULT', 'area'=>'Multidisciplinar'],
		]);
		
		
		DB::table('instituicao')->insert([
			['nome'=>'Instituto Federal de Mato Grosso do Sul','sigla'=>'IFMS','cidade'=>'Corumbá'],
			['nome'=>'Universidade Federal de Mato Grosso do Sul','sigla'=>'UFMS','cidade'=>'Corumbá'],
			['nome'=>'Escola Municipal Rural Experimental de Educação Integral Eutrópia Gomes Pedroso','sigla'=>'EMREEIEGP','cidade'=>'Corumbá'],
			['nome'=>'Colegio Imaculada Conceição Cenic','sigla'=>'CENIC','cidade'=>'Corumbá'],
			['nome'=>'Colégio Salesiano de Santa Teresa','sigla'=>'CSST','cidade'=>'Corumbá'],
			['nome'=>'Escola Municipal Francisco Mendes Sampaio','sigla'=>'EMFMS','cidade'=>'Corumbá'],
			['nome'=>'Escola Municipal José de Souza Damy','sigla'=>'EMJSD','cidade'=>'Corumbá'],
			['nome'=>'Escola Municipal Luiz Feitosa Rodrigues','sigla'=>'EMLFR','cidade'=>'Corumbá'],
			['nome'=>'Escola Municipal Tilma Fernandes Veiga e CEI Valódia Serra','sigla'=>'EMTFVCVS','cidade'=>'Corumbá'],
			['nome'=>'Escola Estadual 2 de Setembro','sigla'=>'EE2S','cidade'=>'Corumbá'],
			['nome'=>'Escola Estadual Dom Bosco','sigla'=>'EEDB','cidade'=>'Corumbá'],
			['nome'=>'Escola Estadual Dr. Gabriel Vandoni de Barros','sigla'=>'EEDGVB','cidade'=>'Corumbá'],
			['nome'=>'Escola Estadual Dr. João Leite de Barros','sigla'=>'EEDJLB','cidade'=>'Corumbá'],
			['nome'=>'Escola Estadual Maria Helena Albaneze','sigla'=>'EEMHA','cidade'=>'Corumbá'],
			['nome'=>'Escola Estadual Maria Leite','sigla'=>'EEML','cidade'=>'Corumbá'],
			['nome'=>'Escola Estadual Nathércia Pompeo dos Santos','sigla'=>'EENPS','cidade'=>'Corumbá'],
			['nome'=>'Escola Estadual Rotary Club','sigla'=>'EERC','cidade'=>'Corumbá'],
			['nome'=>'Escola Municipal Barão do Rio Branco','sigla'=>'EMBRB','cidade'=>'Corumbá'],
			['nome'=>'Escola Municipal Clio Proença','sigla'=>'EMCP','cidade'=>'Corumbá'],
			['nome'=>'Escola Municipal Cyriaco Félix de Toledo','sigla'=>'EMCFT','cidade'=>'Corumbá'],
			['nome'=>'Escola Municipal Dr. Cássio Leite de Barros','sigla'=>'EMDCLB','cidade'=>'Corumbá'],
			['nome'=>'Escola Municipal Izabel Corrêa de Oliveira','sigla'=>'EMICO','cidade'=>'Corumbá'],
			['nome'=>'Escola Municipal de Ed. Infantil e Ensino Fundamental Marquês de Tamandaré','sigla'=>'EMEIEFMT','cidade'=>'Ladário'],
			['nome'=>'Escola Municipal Nelson Mangabeira','sigla'=>'EMNM','cidade'=>'Corumbá'],
			['nome'=>'Escola Municipal Professor João Baptista','sigla'=>'EMPJB','cidade'=>'Corumbá'],
			['nome'=>'Escola Municipal Rural Maria Ana Ruso','sigla'=>'EMRMAR','cidade'=>'Corumbá'],
			['nome'=>'Escola Municipal Rural Polo Luiz de Albuquerque de Melo Pereira e Caceres','sigla'=>'EMRPLAMPC','cidade'=>'Corumbá'],		
			['nome'=>'Instituto Baruki de Educação e Cultura','sigla'=>'IBEC','cidade'=>'Corumbá'],
			['nome'=>'Serviço Social da Indústria','sigla'=>'SESI','cidade'=>'Corumbá'],
		]);

		DB::table('categoria')->insert([
			['descricao'=>'Ensino Fundamental'],
			['descricao'=>'Ensino Médio'],
		]);
		
		DB::table('tipo_trabalho')->insert([
			['nome'=>'Pesquisa Científica'],
			['nome'=>'Pesquisa Tecnológica'],
		]);
		
		DB::table('conteudo')->insert([
			['rota' => '/evento','rotulo' => 'Evento','publica' => '0','menu' => '1', 'menu_pai' => 'Cadastro'],
			['rota' => '/area','rotulo' => 'Área','publica' => '0','menu' => '1', 'menu_pai' => 'Cadastro'],
			['rota' => '/trabalho','rotulo' => 'Trabalhos','publica' => '0','menu' => '0', 'menu_pai' => 'Cadastro'],
			['rota' => '/tipoTrabalho','rotulo' => 'Tipos de Trabalhos','publica' => '0','menu' => '1', 'menu_pai' => 'Cadastro'],
			['rota' => '/quesito','rotulo' => 'Quesitos de Avaliação','publica' => '0','menu' => '0', 'menu_pai' => 'Cadastro'],
			['rota' => '/avaliacao','rotulo' => 'Avaliação','publica' => '0','menu' => '0' , 'menu_pai' => 'Avaliação'],
			['rota' => '/participacao','rotulo' => 'Participação','publica' => '0','menu' => '0','menu_pai' => 'Avaliação'],
			['rota' => '/orientacao','rotulo' => 'Orientação','publica' => '0','menu' => '0','menu_pai' => 'Avaliação'],
			['rota' => '/avaliacao','rotulo' => 'Avaliações','publica' => '0','menu' => '0','menu_pai' => 'Avaliação'],
			['rota' => '/pessoa/avaliador','rotulo' => 'Avaliadores','publica' => '0','menu' => '1','menu_pai' => 'Pessoa'],
			['rota' => '/pessoa/orientador','rotulo' => 'Orientadores','publica' => '0','menu' => '1','menu_pai' => 'Pessoa'],
			['rota' => '/pessoa/estudante','rotulo' => 'Estudantes','publica' => '0','menu' => '1','menu_pai' => 'Pessoa'],
			['rota' => '/categoria','rotulo' => 'Categorias','publica' => '0','menu' => '0','menu_pai' => 'Cadastro'],
			['rota' => '/avaliador/avaliacoes/','rotulo' => 'avaliacoes','publica' => '0','menu' => '0','menu_pai' => 'Avaliação'],
			['rota' => '/avaliador/minhas-avaliacoes/','rotulo' => 'avaliacoes','publica' => '0','menu' => '1','menu_pai' => 'Avaliação'],
			['rota' => '/pessoa/orientador/meus-trabalhos','rotulo' => 'Meus Trabalhos','publica' => '0','menu' => '1','menu_pai' => 'Orientador'],
		]);
		
		DB::table('permissao')->insert([
			['perfil_id' => '2','conteudo_id' => '1','visualizar' => '1','inserir' => '1','alterar' => '1','excluir' => '1'],
			['perfil_id' => '2','conteudo_id' => '2','visualizar' => '1','inserir' => '1','alterar' => '1','excluir' => '1'],
			['perfil_id' => '2','conteudo_id' => '3','visualizar' => '1','inserir' => '1','alterar' => '1','excluir' => '1'],
			['perfil_id' => '2','conteudo_id' => '4','visualizar' => '1','inserir' => '1','alterar' => '1','excluir' => '1'],
			['perfil_id' => '2','conteudo_id' => '5','visualizar' => '1','inserir' => '1','alterar' => '1','excluir' => '1'],
			['perfil_id' => '2','conteudo_id' => '6','visualizar' => '1','inserir' => '1','alterar' => '1','excluir' => '1'],
			['perfil_id' => '2','conteudo_id' => '7','visualizar' => '1','inserir' => '1','alterar' => '1','excluir' => '1'],
			['perfil_id' => '2','conteudo_id' => '8','visualizar' => '1','inserir' => '1','alterar' => '1','excluir' => '1'],
			['perfil_id' => '2','conteudo_id' => '10','visualizar' => '1','inserir' => '1','alterar' => '1','excluir' => '1'],
			['perfil_id' => '2','conteudo_id' => '11','visualizar' => '1','inserir' => '1','alterar' => '0','excluir' => '1'],
			['perfil_id' => '2','conteudo_id' => '12','visualizar' => '1','inserir' => '1','alterar' => '0','excluir' => '1'],
			['perfil_id' => '2','conteudo_id' => '13','visualizar' => '1','inserir' => '1','alterar' => '1','excluir' => '1'],
			//['perfil_id' => '3','conteudo_id' => '2','visualizar' => '1','inserir' => '0','alterar' => '0','excluir' => '0'],
			['perfil_id' => '3','conteudo_id' => '3','visualizar' => '1','inserir' => '0','alterar' => '0','excluir' => '0'],
			['perfil_id' => '3','conteudo_id' => '5','visualizar' => '1','inserir' => '0','alterar' => '0','excluir' => '0'],
			['perfil_id' => '3','conteudo_id' => '6','visualizar' => '1','inserir' => '0	','alterar' => '1','excluir' => '1'],
			['perfil_id' => '3','conteudo_id' => '9','visualizar' => '1','inserir' => '1','alterar' => '1','excluir' => '1'],
			['perfil_id' => '3','conteudo_id' => '14','visualizar' => '1','inserir' => '1','alterar' => '1','excluir' => '1'],
			//['perfil_id' => '4','conteudo_id' => '2','visualizar' => '1','inserir' => '0','alterar' => '0','excluir' => '0'],
			//['perfil_id' => '5','conteudo_id' => '2','visualizar' => '1','inserir' => '0','alterar' => '0','excluir' => '0'],
			//['perfil_id' => '6','conteudo_id' => '2','visualizar' => '1','inserir' => '0','alterar' => '0','excluir' => '0'],
			['perfil_id' => '6','conteudo_id' => '3','visualizar' => '1','inserir' => '0','alterar' => '0','excluir' => '0'],
			['perfil_id' => '6','conteudo_id' => '5','visualizar' => '1','inserir' => '0','alterar' => '0','excluir' => '0'],
			['perfil_id' => '6','conteudo_id' => '6','visualizar' => '1','inserir' => '1','alterar' => '1','excluir' => '1'],
			['perfil_id' => '6','conteudo_id' => '7','visualizar' => '1','inserir' => '0','alterar' => '0','excluir' => '0'],
			['perfil_id' => '6','conteudo_id' => '8','visualizar' => '1','inserir' => '0','alterar' => '0','excluir' => '0'],
		]);
		
	}

}
