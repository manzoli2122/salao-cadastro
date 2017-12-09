<?php

namespace Manzoli2122\Salao\Cadastro\Http\Controllers;

use Manzoli2122\Salao\Cadastro\Models\Servico;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Manzoli2122\Salao\Cadastro\Http\Controllers\Padroes\StandardAtivoController ;

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



}
