@extends( Config::get('app.templateMaster' , 'templates.templateMaster')  )

@section( Config::get('app.templateMasterContentTitulo' , 'titulo-page')  )
	Listagem dos Produtos			
@endsection

@section( Config::get('app.templateMasterContent' , 'content')  )

<div class="col-xs-12">
    <div class="box box-success">
        <div class="box-header align-right">
			@permissao('produtos-cadastrar')
				<a href="{{ route('produtos.create')}}" class="btn btn-success" title="Adicionar uma nova Operadora">
					<i class="fa fa-plus"></i> Cadastrar Produto
				</a>
			@endpermissao            
        </div>

        <div class="box-body">
            <table class="table table-bordered table-striped table-hover" id="datatable">
                <thead>
                    <tr>
						<th>ID</th>
						<th pesquisavel>Nome</th>
						<th>Valor</th>
						<th pesquisavel>Descrição</th>
						<th>Observações</th>
						<th>Desconto Máximo</th>
												
                        <th class="align-center">Ações</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

@endsection


@push(Config::get('app.templateMasterScript' , 'script') )
	<script src="{{ mix('js/datatables-padrao.js') }}" type="text/javascript"></script>

	<script>
		$(document).ready(function() {
			var dataTable = datatablePadrao('#datatable', {
				order: [[ 1, "asc" ]],
				ajax: { 
					url:'{{ route('produtos.getDatatable') }}'
				},
				columns: [
					{ data: 'id', name: 'id' },
					{ data: 'nome', name: 'nome' },
					{ data: 'valor', name: 'valor' },
					{ data: 'descricao', name: 'descricao' },
					{ data: 'observacoes', name: 'observacoes' },
					{ data: 'desconto_maximo', name: 'desconto_maximo' },
					
					{ data: 'action', name: 'action', orderable: false, searchable: false, class: 'align-center'}
				],
			});

			dataTable.on('draw', function () {
				$('[btn-excluir]').click(function (){
					excluirRecursoPeloId($(this).data('id'), "@lang('msg.conf_excluir_o', ['1' => 'tipo de seção'])", "{{ route('produtos.index') }}", 
						function(){
							dataTable.row( $(this).parents('tr') ).remove().draw('page');
						}
					);
				});
			});
		});
	</script>
@endpush




















@extends( Config::get('cadastro.templateMaster' , 'templates.templateMaster')  )

@section( Config::get('cadastro.templateMasterMenuLateral' , 'menuLateral')  )
			@if($apagados)
				@permissao('produtos')
					<li><a href="{{ route('produtos.index')}}"><i class="fa fa-circle-o text-blue"></i> <span>Produtos Ativos</span></a></li>
				@endpermissao
			@else
				@permissao('produtos-cadastrar')
					<li><a href="{{ route('produtos.create')}}"><i class="fa fa-circle-o text-blue"></i> <span>Cadastrar Produto</span></a></li>
				@endpermissao
				@permissao('produtos-apagados')
					<li><a href="{{  route('produtos.apagados')}}"><i class="fa fa-circle-o text-red"></i> <span>Produtos Apagados</span></a></li>
				@endpermissao
			@endif			
@endsection
		
@section( Config::get('cadastro.templateMasterScript' , 'script')  )
        	<script>$(function(){setTimeout("$('.hide-msg').fadeOut();",5000)});</script>
			<script>
            function ApagarModel(val) {
                return  confirm('Deseja mesmo apagar?'  );                       
            }
		</script>
@endsection

@section( Config::get('cadastro.templateMasterCss' , 'css')  )				
			<style type="text/css">
					.btn-sm{
						padding: 1px 10px;
					}
					.pagination{
						margin:0px;
						display: unset;
						font-size:12px;
					}
			</style>
@endsection


@section( Config::get('cadastro.templateMasterContentTitulo' , 'titulo-page')  )
			@if($apagados)
				Listagem dos Produtos Apagados
			@else
				Listagem dos Produtos
			@endif						
@endsection

		


@section( Config::get('cadastro.templateMasterContent' , 'content')  )
	
		
			<section class="row Listagens">
				<div class="col-12 col-sm-12 lista">		
					@if(Session::has('success'))
						<div class="alert alert-success hide-msg" style="float: left; width:100%; margin: 10px 0px;">
						{{Session::get('success')}}
						</div>
					@endif
				</div>
			</section>

			<div class="row">
				<div class="col-xs-12">
					<div class="box">
						<div class="box-header">

							@if(isset($dataForm))
								{!! $models->appends($dataForm)->links() !!}
							@else
								{!! $models->links() !!}
							@endif


							@if($apagados)
								{!! Form::open(['route' => 'produtos.pesquisarApagados' , 'method' => 'get' ]) !!}
							@else
								{!! Form::open(['route' => 'produtos.pesquisar' , 'method' => 'get' ]) !!}
							@endif								
									<div class="input-group input-group-sm" style="width: 190px; margin-left:auto;">
										{!! Form::text('key' , null , ['class' => 'form-control' , 'placeholder' => 'Pesquisar Produtos' , 'aria-label' => 'Search']) !!}
										<div class="input-group-btn">
											<button style="margin-right:10px;" class="btn btn-outline-success my-2 my-sm-0 " type="submit">
												<i class="fa fa-search" aria-hidden="true"></i>
											</button>	
										</div>
									</div>			
							{!!  Form::close()  !!}
								
							

						</div>
						<!-- /.box-header -->
						<div class="box-body table-responsive no-padding">
							<table class="table table-hover table-striped">
								<tr>
									<th>Nome</th>
									<th>Observações</th>
									<th>Desconto Máximo</th>
									<th>Valor</th>					
									<th>Ações</th>
								</tr>
								@forelse($models as $model)				
									<tr>
										<td> {{$model->nome}} </td>	
										<td>{{$model->observacoes }}</td>
										<td>{{$model->desconto_maximo }}%</td>
										<td>R${{ number_format($model->valor , 2 ,',', '') }}</td>
										<td>
										
											@if($apagados)
												@permissao('produtos-apagados')								
														<a class="btn btn-success btn-sm" href='{{route("produtos.showapagado", $model->id)}}'>
															<i class="fa fa-eye" aria-hidden="true"></i>Exibir</a>								
												@endpermissao	

												@permissao('produtos-restore')
													<a class="btn btn-warning btn-sm" href='{{route("produtos.restore", $model->id)}}'>
														<i class="fa fa-arrow-circle-up" aria-hidden="true"></i>Reativar</a>
												@endpermissao 														
														
												@permissao('produtos-delete-mater-ulta-mega')	
													<a class="btn btn-danger btn-sm" href="javascript:void(0);" onclick="$(this).find('form').submit();" >
														{!! Form::open(['route' => ['produtos.destroy', $model->id ],  'method' => 'DELETE' , 'onsubmit' => " return  ApagarModel(this)"])!!}                                        
														{!! Form::close()!!}    
														<i class="fa fa-trash" aria-hidden="true"></i>Extinguir</a> 		        
													
												@endpermissao
											@else
												@permissao('produtos')								
														<a class="btn btn-success btn-sm" href='{{route("produtos.show", $model->id)}}'>
															<i class="fa fa-eye" aria-hidden="true"></i>Exibir</a>								
												@endpermissao	

												@permissao('produtos-editar')								
														<a class="btn btn-warning btn-sm" href='{{route("produtos.edit", $model->id)}}'>
															<i class="fa fa-pencil" aria-hidden="true"></i>Editar</a>								
												@endpermissao				
											
												@permissao('produtos-soft-delete')			
													<a class="btn btn-danger btn-sm"  href="javascript:void(0);" onclick="$(this).find('form').submit();" >
															{!! Form::open(['route' => ['produtos.destroySoft', $model->id ],  'method' => 'DELETE', 'onsubmit' => " return  ApagarModel(this)" ])!!}                                        
															{!! Form::close()!!}    
															<i class="fa fa-trash" aria-hidden="true"></i>Apagar</a>													
												@endpermissao
											@endif
											
										</td>
									</tr>
								@empty
									
								@endforelse
							</table>
					</div>


					
					<!-- /.box-body -->
				</div>
				<!-- /.box -->
				</div>
			</div>

@endsection