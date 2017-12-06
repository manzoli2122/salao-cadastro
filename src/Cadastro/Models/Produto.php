<?php

namespace Manzoli2122\Salao\Cadastro\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;

class Produto extends Model
{
    protected $table = Config::get('cadastro.produtos_table' , 'produtos') ;
    
    
    protected $fillable = [
            'nome', 'valor', 'descricao', 'ativo' , 'observacoes' , 'desconto_maximo' , 'desconto_promocional' , 
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
                                
        ];
    }

}
