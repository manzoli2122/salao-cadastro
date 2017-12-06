<?php

namespace Manzoli2122\Salao\Cadastro\Models;

use Illuminate\Database\Eloquent\Model;

class Servico extends Model
{
    
    
    public function __construct(){
        $this->table = Config::get('cadastro.servicos_table' , 'servicos') ;    
    }

    protected $fillable = [
            'nome', 'valor', 'porcentagem_funcionario', 'ativo' , 'categoria' , 'custo_com_produto' ,
            'desconto_maximo' ,  'desconto_promocional' , 'duracao_aproximada' , 'observacoes' , 
    ];
    

    
    public function scopeAtivo($query)
    {
        return $query->where('ativo', 1);
    }

    
    public function scopeInativo($query)
    {
        return $query->where('ativo', 0);
    }


    


    public function index($totalPage)
    {
        return $this->ativo()->orderBy('nome', 'asc')->paginate($totalPage);        
    }




    public function rules($id = '')
    {
        return [
            'nome' => 'required|min:2|max:100',
            'porcentagem_funcionario' => "required|min:0|max:100|integer",                       
        ];
    }



}
