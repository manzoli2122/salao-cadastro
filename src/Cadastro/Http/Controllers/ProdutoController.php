<?php

namespace Manzoli2122\Salao\Cadastro\Http\Controllers;

use Manzoli2122\Salao\Cadastro\Models\Produto;
use Manzoli2122\Salao\Cadastro\Http\Controllers\Padroes\StandardAtivoController ;
use DataTables;

class ProdutoController extends StandardAtivoController
{

    

    protected $model;

    protected $name = "Produto";

    protected $view = "cadastro::produtos";

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


   




}
