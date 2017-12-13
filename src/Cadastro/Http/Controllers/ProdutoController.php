<?php

namespace Manzoli2122\Salao\Cadastro\Http\Controllers;

use Manzoli2122\Salao\Cadastro\Models\Produto;
use Manzoli2122\Salao\Cadastro\Http\Controllers\Padroes\StandardAtivoController ;
use DataTables;
use App\Constants\ErrosSQL;

class ProdutoController extends StandardAtivoController
{

    

    protected $model;

    protected $name = "Produto";

    protected $view = "cadastro::produtos";
    protected $view_apagados = "cadastro::produtos.apagados";

    protected $route = "produtos";

    protected $totalPage = 10;

    public function __construct(Produto $produto){
        $this->model = $produto;
        $this->middleware('auth');

        $this->middleware('permissao:produtos')->only([ 'index' , 'show' , 'pesquisar' ]) ;
        
        $this->middleware('permissao:produtos-cadastrar')->only([ 'create' , 'store']);

        $this->middleware('permissao:produtos-editar')->only([ 'edit' , 'update']);

        $this->middleware('permissao:produtos-soft-delete')->only([ 'destroySoft' ]);

        $this->middleware('permissao:produtos-restore')->only([ 'restore' ]);
        
        $this->middleware('permissao:produtos-admin-permanete-delete')->only([ 'destroy' ]);

        $this->middleware('permissao:produtos-apagados')->only([ 'indexApagados' , 'showApagado' , 'pesquisarApagados']) ;
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
            $model = $this->model->ativo()->find($id);
            $model->ativo = false ; 
            $delete = $model->save();           
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
        $models = Produto::select(['id', 'nome', 'valor' ,
                        'observacoes' , 'desconto_maximo'   ]);
        return Datatables::of($models)
            ->addColumn('action', function($linha) {
                return '<button data-id="'.$linha->id.'" btn-excluir type="button" class="btn btn-danger btn-xs" title="Excluir"> <i class="fa fa-times"></i> </button> '
                    . '<a href="'.route('produtos.edit', $linha->id).'" class="btn btn-primary btn-xs" title="Editar"> <i class="fa fa-pencil"></i> </a> '
                    . '<a href="'.route('produtos.show', $linha->id).'" class="btn btn-primary btn-xs" title="Visualizar"> <i class="fa fa-search"></i> </a>';
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
        $models = Produto::onlyTrashed()->select(['id', 'nome', 'valor' ,
                        'observacoes' , 'desconto_maximo'   ]);
        return Datatables::of($models)
            ->addColumn('action', function($linha) {
                return '<button data-id="'.$linha->id.'" btn-excluir type="button" class="btn btn-danger btn-xs" title="Excluir"> <i class="fa fa-times"></i> </button> '
                    . '<a href="'.route('produtos.edit', $linha->id).'" class="btn btn-primary btn-xs" title="Editar"> <i class="fa fa-pencil"></i> </a> '
                    . '<a href="'.route('produtos.show', $linha->id).'" class="btn btn-primary btn-xs" title="Visualizar"> <i class="fa fa-search"></i> </a>';
            })->make(true);
    }

   




}
