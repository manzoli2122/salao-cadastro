<?php

namespace Manzoli2122\Salao\Cadastro\Http\Controllers;

use Manzoli2122\Salao\Cadastro\Models\Operadora;
use Manzoli2122\Salao\Cadastro\Http\Controllers\Padroes\SoftDeleteController ;


class OperadoraController extends SoftDeleteController
{
  
    protected $model;
    protected $name = "Operadora";
    protected $view = "cadastro::operadoras";
    protected $view_apagados = "cadastro::operadoras.apagados";
    protected $route = "operadoras";

    public function __construct(Operadora $operadora){
        $this->model = $operadora;
        $this->middleware('auth');

        $this->middleware('permissao:operadoras')->only([ 'index' , 'show' ]) ;        
        $this->middleware('permissao:operadoras-cadastrar')->only([ 'create' , 'store']);
        $this->middleware('permissao:operadoras-editar')->only([ 'edit' , 'update']);
        $this->middleware('permissao:operadoras-soft-delete')->only([ 'destroySoft' ]);
        $this->middleware('permissao:operadoras-restore')->only([ 'restore' ]);        
        $this->middleware('permissao:operadoras-admin-permanete-delete')->only([ 'destroy' ]);
        $this->middleware('permissao:operadoras-apagados')->only([ 'indexApagados' , 'showApagado']) ;
        

    }   

}
