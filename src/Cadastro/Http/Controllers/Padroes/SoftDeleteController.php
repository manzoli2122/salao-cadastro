<?php
namespace Manzoli2122\Salao\Cadastro\Http\Controllers\Padroes;

use Illuminate\Http\Request;

class SoftDeleteController extends Controller
{
    protected $totalPage = 10;
    protected $upload = false;


    public function index()
    {
        $apagados = false;
        $models = $this->model::paginate($this->totalPage);
        return view("{$this->view}.index", compact('models', 'apagados'));
    }


    
    public function indexApagados()
    {
        $apagados = true;
        $models = $this->model->onlyTrashed()->paginate($this->totalPage);
        return view("{$this->view_apagados}.index", compact('models', 'apagados'));
    }



    public function create()
    {
        return view("{$this->view}.create-edit");
    }



  
    public function store(Request $request)
    {
        $this->validate($request , $this->model->rules());
        $dataForm = $request->all();              
        $insert = $this->model->create($dataForm);           
        if($insert){
            return redirect()->route("{$this->route}.index")->with(['success' => 'Cadastro realizado com sucesso']);
        }
        else {
            return redirect()->route("{$this->route}.create")->withErrors(['errors' =>'Erro no Cadastro'])->withInput();
        }
    }




    public function show($id)
    {
        $model = $this->model->find($id);
        return view("{$this->view}.show", compact('model'));
    }




    public function showApagado($id)
    {
        $model = $this->model->withTrashed()->find($id);
        return view("{$this->view}.show", compact('model'));
    }




    public function edit($id)
    {
        $model = $this->model->find($id);
        return view("{$this->view}.create-edit", compact('model'));
    }




    public function update( Request $request, $id)
    {
        $this->validate($request , $this->model->rules($id));        
        $dataForm = $request->all();                      
        $model = $this->model->find($id);        
        $update = $model->update($dataForm);                
        if($update){
            return redirect()->route("{$this->route}.index")->with(['success' => 'Alteração realizada com sucesso']);
        }        
        else {
            return redirect()->route("{$this->route}.edit" , ['id'=> $id])->withErrors(['errors' =>'Erro no Editar'])->withInput();
        }
    }




    
    public function destroy($id)
    {
        $model = $this->model->withTrashed()->find($id);
        $delete = $model->forceDelete();
        if($delete){
            return redirect()->route("{$this->route}.apagados")->with(['success' => 'Item extinguido com sucesso']);
        }
        else{
            return  redirect()->route("{$this->route}.show",['id' => $id])->withErrors(['errors' => 'Falha ao Deletar']);
        }
    }




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


}
