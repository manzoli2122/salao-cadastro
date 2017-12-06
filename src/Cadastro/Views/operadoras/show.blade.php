@extends( Config::get('cadastro.templateMaster' , 'templates.templateMaster')  )

@section( Config::get('cadastro.templateMasterContentTitulo' , 'titulo-page')  )        
        {{$model->nome}}
@endsection


@section( Config::get('cadastro.templateMasterContent' , 'content')  )

    <section class="row text-center dados">
            
            <div class="col-12 col-sm-4 dado">
                <h4 style="text-align:left;"> {{ number_format($model->porcentagem_credito, 2)}}% para Credito </h4>
                
            </div> 

            <div class="col-12 col-sm-4 dado">
                <h4 style="text-align:left;"> {{ number_format($model->porcentagem_credito_parcelado, 2)}}% para Credito Parcelado</h4>
            </div>

            <div class="col-12 col-sm-4 dado">
                <h4 style="text-align:left;">  {{ number_format($model->porcentagem_debito, 2) }}% para Debito</h4>
            </div>

            <div class="col-12 col-sm-4 dado">
               <h4 style="text-align:left;"> Repasse debito: {{$model->repasse_debito_dias}} dias </h4>
            </div>

             <div class="col-12 col-sm-4 dado">
               <h4 style="text-align:left;"> Máximo de parcelas: {{$model->max_parcelas}}</h4>
            </div>

    </section>


     <br>
        <a class="btn btn-warning btn-sm" href="{{route('operadoras.index')}}">Voltar</a>

@endsection