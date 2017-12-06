@extends( Config::get('cadastro.templateMaster' , 'templates.templateMaster')  )


@section( Config::get('cadastro.templateMasterContentTitulo' , 'titulo-page')  )			
		Cadastrar / Editar Serviços
@endsection
    
@section( Config::get('cadastro.templateMasterCss' , 'css')  )  			
		<link rel="stylesheet" href="{{url('/bower_components/select2/dist/css/select2.min.css')}}">
@endsection

@section( Config::get('cadastro.templateMasterScript' , 'script')  )
        <script src="{{url('/bower_components/select2/dist/js/select2.full.min.js')}}"></script>			
@endsection



@section( Config::get('cadastro.templateMasterContent' , 'content')  )

        <section class="row text-center placeholders">
            <div class="col-12 col-sm-12 placeholder">
                @if(isset($errors) && count($errors)>0)
                    <div class="alert alert-warning">
                        @foreach($errors->all() as $erro)
                            <p>{{$erro}}</p>
                        @endforeach
                    </div>
                @endif
            </div>        
        </section>

        



         <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title">FORMULÁRIO</h3>
            </div>

                    @if( isset($model))
                        {!! Form::model($model , ['route' => ['operadoras.update' , $model->id], 'method' => 'PUT' ,  'role' => 'form'])!!}
                    @else
                        {!! Form::open(['route' => 'operadoras.store', 'role' => 'form'])!!}
                    @endif

                         <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">

                                    <div class="form-group">
                                        <label for="nome">Nome:</label>
                                        {!! Form::text('nome' , null , ['placeholder' => 'Nome', 'class' => 'form-control'])!!}
                                    </div>

                                    <div class="form-group">
                                        <label for="porcentagem_credito">Taxa credito:</label>
                                        {!! Form::number('porcentagem_credito' , null , ['placeholder' => 'Taxa credito', 'step' => '0.01', 'class' => 'form-control'])!!}
                                    </div>

                                     <div class="form-group">
                                        <label for="max_parcelas">Nº max. de parcelas:</label>
                                        {!! Form::number('max_parcelas' , null , ['placeholder' => 'Nº max. de parcelas', 'min'=> 1 , 'max' => 12, 'class' => 'form-control'])!!}
                                    </div>                              
                               
                                </div>


                                <div class="col-md-6">


                                    <div class="form-group">
                                        <label for="porcentagem_credito_parcelado">Taxa credito:</label>
                                        {!! Form::number('porcentagem_credito_parcelado' , null , ['placeholder' => 'Taxa credito parcelado', 'step' => '0.01', 'class' => 'form-control'])!!}
                                    </div>

                                     <div class="form-group">
                                        <label for="porcentagem_debito">Taxa debito:</label>
                                        {!! Form::number('porcentagem_debito' , null , ['placeholder' => 'Taxa debito', 'step' => '0.01', 'class' => 'form-control'])!!}
                                    </div>

                                    <div class="form-group">
                                        <label for="repasse_debito_dias">Repasse debito:</label>
                                        {!! Form::number('repasse_debito_dias' , null , ['placeholder' => 'quantidade de dias para o repasse', 'min'=> 0 , 'max' => 30, 'class' => 'form-control'])!!}
                                    </div>

                                </div>
                        
                            </div>
                        </div>
                        <div class="box-footer">                    
                                {!! Form::submit('Enviar' , ['class' => 'btn btn-success btn-sm']) !!}                           
                                <a class="btn btn-warning btn-sm" style="margin-left:50px;" href="{{ URL::previous()}}">Voltar</a>                                   
                        </div>    
                       

                    {!! Form::close()!!}
                
                </div>
    @endsection