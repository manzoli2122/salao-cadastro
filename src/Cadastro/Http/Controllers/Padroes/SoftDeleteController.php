<?php
namespace Manzoli2122\Salao\Cadastro\Http\Controllers\Padroes;

use Illuminate\Http\Request;

class SoftDeleteController extends Controller
{
    protected $totalPage = 10;
    protected $upload = false;


    public function index()
    {
        return view("{$this->view}.index");
        // $models = $this->model::paginate($this->totalPage);
        //return view("{$this->view}.index", compact('models'));
    }


    
    public function indexApagados()
    {
        //$models = $this->model->onlyTrashed()->paginate($this->totalPage);
        return view("{$this->view_apagados}.index");
    }



    public function create()
    {
        return view("{$this->view}.create");
    }



  
    public function store(Request $request)
    {
        $this->validate($request , $this->model->rules());
        $dataForm = $request->all();              
        $insert = $this->model->create($dataForm);           
        if($insert){
            return redirect()->route("{$this->route}.index")->with('success', __('msg.sucesso_adicionado', ['1' => $this->name ]));
        }
        else {
            return redirect()->route("{$this->route}.create")->withErrors(['errors' =>'Erro no Cadastro'])->withInput();
        }
    }




    public function show($id)
    {
        $model = $this->model->find($id);
        if($model){
            return view("{$this->view}.show", compact('model'));
        }
        return redirect()->route("{$this->route}.index")->withErrors(['message' => __('msg.erro_nao_encontrado', ['1' => $this->name ])]);;
    }




    public function showApagado($id)
    {
        $model = $this->model->onlyTrashed()->find($id);
        if($model){
            return view("{$this->view_apagados}.show", compact('model'));
        }
        return redirect()->route("{$this->route}.apagados")->withErrors(['message' => __('msg.erro_nao_encontrado', ['1' => $this->name ])]);;
    }




    public function edit($id)
    {
        $model = $this->model->find($id);
        return view("{$this->view}.edit", compact('model'));
    }




    public function update( Request $request, $id)
    {
        $this->validate($request , $this->model->rules($id));        
        $dataForm = $request->all();                      
        $model = $this->model->find($id);        
        $update = $model->update($dataForm);         
        
        if($update){
            return redirect()->route("{$this->route}.index")->with('success', __('msg.sucesso_alterado', ['1' => $this->name ]));
        }        
        else {
            return redirect()->route("{$this->route}.edit" , ['id'=> $id])->withErrors(['errors' =>'Erro no Editar'])->withInput();
        }
    }




    
    public function destroy($id)
    {
        try {
            $model = $this->model->withTrashed()->find($id);  
            $delete = $model->forceDelete();        
            $msg = __('msg.sucesso_excluido', ['1' => 'Tipo de Seção']);
        } catch(\Illuminate\Database\QueryException $e) {
            $erro = true;
            $msg = $e->errorInfo[1] == ErrosSQL::DELETE_OR_UPDATE_A_PARENT_ROW ? 
                __('msg.erro_exclusao_fk', ['1' => 'Tipo de Seção', '2' => 'Seção']):
                __('msg.erro_bd');
        }
        return response()->json(['erro' => isset($erro), 'msg' => $msg], 200);
    }







    public function destroySoft($id)
    {
        try {            
            $model = $this->model->find($id);
            $delete = $model->delete();                   
            $msg = __('msg.sucesso_excluido', ['1' => $this->name ]);
        } 
        catch(\Illuminate\Database\QueryException $e) 
        {
            $erro = true;
            $msg = $e->errorInfo[1] == ErrosSQL::DELETE_OR_UPDATE_A_PARENT_ROW ? 
                __('msg.erro_exclusao_fk', ['1' => $this->name , '2' => 'Seção']):
                __('msg.erro_bd');
        }
        return response()->json(['erro' => isset($erro), 'msg' => $msg], 200);

    }




    public function restore($id)
    {
        $model = $this->model->withTrashed()->find($id);
        $restore = $model->restore();
        if($restore){
            return redirect()->route("{$this->route}.index")->with(['success' => 'Item restaurado com sucesso']);
        }
        else{
            return  redirect()->route("{$this->route}.showApagados",['id' => $id])->withErrors(['errors' => 'Falha ao Deletar']);
        }
    }





    /**
    * Processa a requisição AJAX do DataTable na página de listagem.
    * Mais informações em: http://datatables.yajrabox.com
    *
    * @return \Illuminate\Http\JsonResponse
    */
    public function getDatatable()
    {
        $models = $this->model->getDatatable();
        return Datatables::of($models)
            ->addColumn('action', function($linha) {
                return '<button data-id="'.$linha->id.'" btn-excluir type="button" class="btn btn-danger btn-xs" title="Excluir"> <i class="fa fa-times"></i> </button> '
                    . '<a href="'.route("{$this->route}.edit", $linha->id).'" class="btn btn-primary btn-xs" title="Editar"> <i class="fa fa-pencil"></i> </a> '
                    . '<a href="'.route("{$this->route}.show", $linha->id).'" class="btn btn-primary btn-xs" title="Visualizar"> <i class="fa fa-search"></i> </a>';
            })->make(true);
    }




    
    /**
    * Processa a requisição AJAX do DataTable na página de listagem.
    * Mais informações em: http://datatables.yajrabox.com
    *
    * @return \Illuminate\Http\JsonResponse
    */
    public function getDatatableApagados()
    {
        $models = $this->model->getDatatableApagados();
        return Datatables::of($models)
            ->addColumn('action', function($linha) {
                return '<button data-id="'.$linha->id.'" btn-excluir type="button" class="btn btn-danger btn-xs" title="Excluir"> <i class="fa fa-times"></i> </button> '
                    . '<a href="'.route("{$this->route}.showApagados", $linha->id).'" class="btn btn-primary btn-xs" title="Visualizar"> <i class="fa fa-search"></i> </a>';
            })->make(true);
    }

   



















    

/*

    public function destroySoft($id)
    {
        $model = $this->model->find($id);
        $delete = $model->delete();
        if($delete){
            return redirect()->route("{$this->route}.index")->with(['success' => 'item apagado com sucesso']);
        }
        else{
            return  redirect()->route("{$this->route}.showApagados",['id' => $id])->withErrors(['errors' => 'Falha ao Deletar']);
        }
    }
*/

    /*
    public function pesquisar(Request $request)
    {      
        $apagados = false; 
        $dataForm = $request->except('_token');
        if(! isset($dataForm['key'])){
            return redirect()->route("{$this->route}.index");             
        }
        $models = $this->model->where('nome','LIKE', "%{$dataForm['key']}%")->paginate($this->totalPage);       
        return view("{$this->view}.index", compact('models', 'dataForm' , 'apagados'));
    }



    public function pesquisarApagados(Request $request)
    {        
        $apagados = true; 
        $dataForm = $request->except('_token');
        if(!isset($dataForm['key'])){  
            return redirect()->route("{$this->route}.apagados");            
        }   
        $models = $this->model->onlyTrashed()->where('nome','LIKE', "%{$dataForm['key']}%")->paginate($this->totalPage);       
        return view("{$this->view}.index", compact('models', 'dataForm' , 'apagados'));
    }

    */


}

