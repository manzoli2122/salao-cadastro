<?php

namespace  Manzoli2122\Salao\Cadastro\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class CadastroController extends BaseController
{
 
	use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
	
    public function __construct(  ){
        $this->middleware('auth');
    }  
       


    public function index()
    {
        return view("cadastro::index");
    }
        
}
