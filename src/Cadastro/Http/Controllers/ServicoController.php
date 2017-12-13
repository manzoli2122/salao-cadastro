<?php

namespace Manzoli2122\Salao\Cadastro\Http\Controllers;

use Manzoli2122\Salao\Cadastro\Models\Servico;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Manzoli2122\Salao\Cadastro\Http\Controllers\Padroes\StandardAtivoController ;
use DataTables;

class ServicoController extends StandardAtivoController
{

    

    protected $model;

    protected $name = "Servico";

    protected $view = "cadastro::servicos";

    protected $route = "servicos";

    protected $totalPage = 10;

    public function __construct(Servico $servico){
        $this->model = $servico;
        $this->middleware('auth');

        $this->middleware('permissao:servicos')->only([ 'index' , 'show' , 'pesquisar' ]) ;
        
        $this->middleware('permissao:servicos-cadastrar')->only([ 'create' , 'store']);

        $this->middleware('permissao:servicos-editar')->only([ 'edit' , 'update']);

        $this->middleware('permissao:servicos-soft-delete')->only([ 'destroySoft' ]);

        $this->middleware('permissao:servicos-restore')->only([ 'restore' ]);
        
        $this->middleware('permissao:servicos-admin-permanete-delete')->only([ 'destroy' ]);

        $this->middleware('permissao:servicos-apagados')->only([ 'indexApagados' , 'showApagado' , 'pesquisarApagados']) ;
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
        $models = Servico::select(['id', 'nome', 'valor' , 'duracao_aproximada' , 'observacoes',
                        'porcentagem_funcionario' , 'categoria'  ,'desconto_maximo' ,  ]);
        return Datatables::of($models)
            ->addColumn('action', function($linha) {
                return '<button data-id="'.$linha->id.'" btn-excluir type="button" class="btn btn-danger btn-xs" title="Excluir"> <i class="fa fa-times"></i> </button> '
                    . '<a href="'.route('servicos.edit', $linha->id).'" class="btn btn-primary btn-xs" title="Editar"> <i class="fa fa-pencil"></i> </a> '
                    . '<a href="'.route('servicos.show', $linha->id).'" class="btn btn-primary btn-xs" title="Visualizar"> <i class="fa fa-search"></i> </a>';
            })->make(true);
    }




}
