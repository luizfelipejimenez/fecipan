<?php 

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Area;

class AreaController extends Controller {
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
        	$this->permissoes = Auth::user()->temPermissao(["/area"]);
        	if ($this->permissoes == null)
        		return redirect('/')->with('erro', 'Você não tem permissão suficiente');
        	return $next($request);
        });
    }    

    public function index(){
    	$areas = Area::get();
    	return view('area.area')->with(['areas' => $areas, 'permissoes'=>$this->permissoes]);
    }

    public function create(){
    	if ($this->permissoes->inserir){
    		return view('area.formCreate');
    	}
    	else{
    		return redirect('area')->with('erro', 'Você não tem permissão suficiente');
    	}
    }

    public function store(Request $request){
    	$params = $request->all();
    	$area = new Area($params);
    	if($area->save())
    		return redirect('/area')->with('sucesso', 'Área cadastrada com sucesso!');
    	return redirect('/area')->with('erro', 'Algo deu errado!');
    }

    public function edit($id){
    	if ($this->permissoes->alterar){
    		$area = Area::find($id);
    		return view('area.formUpdate')->with('area', $area);
    	}
    	else{
    		return redirect('/area')->with('erro', 'Você não tem permissão suficiente');
    	}
    }

    public function update(Request $request, $id){
    	$this->validate($request, [
    		'area' => 'required',
    	]);

    	$data = $request->all();
    	$area = Area::find($id);
    	if($area->update($data))
    		return redirect('/area')->with('sucesso', 'Área editada com sucesso!');
    	return redirect('/area')->with('erro', 'Algo deu errado!');
    }

    public function destroy($area_id){
    	if ($this->permissoes->excluir){
    		$area = Area::find($area_id);
    		if($area->delete())
    			return redirect('/area')->with('sucesso', 'Área excluida com sucesso!');
    		return redirect('/area')->with('erro', 'Algo deu errado!');
    	}
    	return redirect('/area')->with('erro', 'Você não tem permissão para excluir esse registro');

    }
}
