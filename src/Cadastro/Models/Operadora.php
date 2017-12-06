<?php

namespace Manzoli2122\Salao\Cadastro\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Config;

class Operadora extends Model
{
    use SoftDeletes;

    protected $table = Config::get('cadastro.operadoras_table' , 'operadoras') ;
    
    
    protected $fillable = [
        'nome', 'porcentagem_credito', 'porcentagem_credito_parcelado' , 'porcentagem_debito', 'ativo' ,
        'max_parcelas' , 'repasse_debito_dias' ,
    ];
    
    

    public function rules($id = '')
    {
        return [
            'nome' => 'required|min:3|max:100',
            'porcentagem_credito' => "required|min:0|max:100",
            'porcentagem_debito' => "required|min:0|max:100",             
        ];
    }

    

    protected $dates = ['deleted_at'];
    
}
