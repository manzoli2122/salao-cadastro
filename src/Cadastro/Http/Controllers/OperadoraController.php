<?php

namespace Manzoli2122\Salao\Cadastro\Http\Controllers;

use Manzoli2122\Salao\Cadastro\Models\Operadora;
use Manzoli2122\Salao\Cadastro\Http\Controllers\Padroes\SoftDeleteController ;
use DataTables;


class OperadoraController extends SoftDeleteController
{

    

    protected $model;

    protected $name = "Operadora";

    protected $view = "cadastro::operadoras";

    protected $route = "operadoras";

    public function __construct(Operadora $operadora){
        $this->model = $operadora;
        $this->middleware('auth');

        $this->middleware('permissao:operadoras')->only([ 'index' , 'show' , 'pesquisar' ]) ;
        
        $this->middleware('permissao:operadoras-cadastrar')->only([ 'create' , 'store']);

        $this->middleware('permissao:operadoras-editar')->only([ 'edit' , 'update']);

        $this->middleware('permissao:operadoras-soft-delete')->only([ 'destroySoft' ]);

        $this->middleware('permissao:operadoras-restore')->only([ 'restore' ]);
        
        $this->middleware('permissao:operadoras-admin-permanete-delete')->only([ 'destroy' ]);

        $this->middleware('permissao:operadoras-apagados')->only([ 'indexApagados' , 'showApagado' , 'pesquisarApagados']) ;
        

    }






    
    public function create()
    {
        return view("{$this->view}.create");
    }


    
    public function edit($id)
    {
        $model = $this->model->find($id);
        return view("{$this->view}.edit", compact('model'));
    }





    public function destroySoft($id)
    {
        try {
            error_log($id);
            $model = $this->model->find($id);
            $delete = $model->delete();

            
            
                    
        $msg = __('msg.sucesso_excluido', ['1' => 'Tipo de Seção']);
        } catch(\Illuminate\Database\QueryException $e) {
            $erro = true;
            $msg = $e->errorInfo[1] == ErrosSQL::DELETE_OR_UPDATE_A_PARENT_ROW ? 
                __('msg.erro_exclusao_fk', ['1' => 'Tipo de Seção', '2' => 'Seção']):
                __('msg.erro_bd');
        }

        return response()->json(['erro' => isset($erro), 'msg' => $msg], 200);

    }



    


     /**
    * Processa a requisição AJAX do DataTable na página de listagem.
    * Mais informações em: http://datatables.yajrabox.com
    *
    * @return \Illuminate\Http\JsonResponse
    */
    public function getDatatable()
    {
        $models = Operadora::select(['id', 'nome', 'porcentagem_credito',  'porcentagem_credito_parcelado' ,
                        'porcentagem_debito' , 'max_parcelas'   ]);
        return Datatables::of($models)
            ->addColumn('action', function($linha) {
                return '<button data-id="'.$linha->id.'" btn-excluir type="button" class="btn btn-danger btn-xs" title="Excluir"> <i class="fa fa-times"></i> </button> '
                    . '<a href="'.route('operadoras.edit', $linha->id).'" class="btn btn-primary btn-xs" title="Editar"> <i class="fa fa-pencil"></i> </a> '
                    . '<a href="'.route('operadoras.show', $linha->id).'" class="btn btn-primary btn-xs" title="Visualizar"> <i class="fa fa-search"></i> </a>';
            })->make(true);
    }


}
