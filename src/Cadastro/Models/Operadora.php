<?php

namespace Manzoli2122\Salao\Cadastro\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Config;

class Operadora extends Model
{
    use SoftDeletes;

    public function newInstance($attributes = [], $exists = false)
    {
        $model = parent::newInstance($attributes, $exists);    
        $model->setTable($this->getTable());    
        return $model;
    }

    public function getTable()
    {
        return  Config::get('cadastro.operadoras_table' , 'operadoras');
    }


    
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




    public function getDatatable()
    {
        return $this->select(['id', 'nome', 'porcentagem_credito',  'porcentagem_credito_parcelado' ,
        'porcentagem_debito' , 'max_parcelas'   ]);        
    }
    
    public function getDatatableApagados()
    {
        return $this->onlyTrashed()->select(['id', 'nome', 'porcentagem_credito',  'porcentagem_credito_parcelado' ,
        'porcentagem_debito' , 'max_parcelas'   ]);        
    }
   

    protected $dates = ['deleted_at'];
    
}
