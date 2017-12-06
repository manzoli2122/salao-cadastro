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
                    {!! Form::model($model , ['route' => ['produtos.update' , $model->id], 'method' => 'PUT' ,  'role' => 'form'])!!}
                @else
                    {!! Form::open(['route' => 'produtos.store', 'role' => 'form' ])!!}
                @endif

                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-6">

                                <div class="form-group">
                                    <label for="nome">Nome:</label>
                                    {!! Form::text('nome' , null , ['placeholder' => 'Nome', 'class' => 'form-control'])!!}
                                </div>

                                <div class="form-group">
                                    <label for="valor">Valor:</label>
                                    {!! Form::number('valor' , null , ['placeholder' => 'Valor', 'step' => '0.01', 'class' => 'form-control'])!!}
                                </div>
                            
                            </div>


                            <div class="col-md-6">

                                
                                <div class="form-group">
                                    <label for="desconto_maximo">Desconto máximo (%):</label>
                                    {!! Form::number('desconto_maximo' , null , ['placeholder' => 'desconto máximo', 'step' => '0.01', 'class' => 'form-control', 'min'=> 0 , 'max' => 100])!!}
                                </div>


                            </div>
                        
                        <div class="col-md-12">                            
                            <div class="form-group">
                                <label for="observacoes">observacoes:</label>
                                {!! Form::text('observacoes' , null , ['placeholder' => 'observacoes', 'class' => 'form-control'])!!}
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