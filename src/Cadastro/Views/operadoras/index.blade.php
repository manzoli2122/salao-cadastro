@extends( Config::get('app.templateMaster' , 'templates.templateMaster')  )

@section( Config::get('cadastro.templateMasterContentTitulo' , 'titulo-page')  )
	Listagem dos Operadoras			
@endsection

@section( Config::get('cadastro.templateMasterContent' , 'content')  )

<div class="col-xs-12">
    <div class="box box-primary">
        <div class="box-header align-right">
			@permissao('operadoras-cadastrar')
				<a href="{{ route('operadoras.create')}}" class="btn btn-primary" title="Adicionar uma nova Operadora">
					<i class="fa fa-plus"></i> Cadastrar Operadora
				</a>
			@endpermissao            
        </div>

        <div class="box-body">
            <table class="table table-bordered table-striped table-hover" id="datatable">
                <thead>
                    <tr>
						<th pesquisavel>ID</th>
						<th pesquisavel>Nome</th>
						<th>Porc. Credito</th>
						<th>Porc. Credito Parc.</th>
						<th>Porc. Debito</th>
						<th>Máximo de Parcelas</th>					
						
                        <th class="align-center">Ações</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

@endsection


@push(Config::get('cadastro.templateMasterScript' , 'script') )
	<script src="{{ mix('js/datatables-padrao.js') }}" type="text/javascript"></script>

	<script>
		$(document).ready(function() {
			var dataTable = datatablePadrao('#datatable', {
				order: [[ 0, "asc" ]],
				ajax: { 
					url:'{{ route('operadoras.getDatatable') }}'
				},
				columns: [
					{ data: 'id', name: 'id' },
					{ data: 'descricao', name: 'descricao' },
					{ data: 'descricao', name: 'descricao' },
					{ data: 'descricao', name: 'descricao' },
					{ data: 'descricao', name: 'descricao' },
					{ data: 'descricao', name: 'descricao' },
					{ data: 'descricao', name: 'descricao' },

					{ data: 'action', name: 'action', orderable: false, searchable: false, class: 'align-center'}
				],
			});

			dataTable.on('draw', function () {
				$('[btn-excluir]').click(function (){
					excluirRecursoPeloId($(this).data('id'), "@lang('msg.conf_excluir_o', ['1' => 'tipo de seção'])", "{{ route('operadoras.index') }}", 
						function(){
							dataTable.row( $(this).parents('tr') ).remove().draw('page');
						}
					);
				});
			});
		});
	</script>
@endpush





















@section( Config::get('cadastro.templateMasterMenuLateral' , 'menuLateral')  )
			@if($apagados)
				@permissao('operadoras')
					<li><a href="{{ route('operadoras.index')}}"><i class="fa fa-circle-o text-blue"></i> <span>Operadoras Ativas</span></a></li>
				@endpermissao
			@else				
				@permissao('operadoras-apagados')
					<li><a href="{{  route('operadoras.apagados')}}"><i class="fa fa-circle-o text-red"></i> <span>Operadoras Apagadas</span></a></li>
				@endpermissao
			@endif			
@endsection


		

	

			<div class="row">
				<div class="col-xs-12">
					<div class="box">
						<div class="box-header">

							


							@if($apagados)
								{!! Form::open(['route' => 'operadoras.pesquisarApagados' , 'method' => 'get' ]) !!}
							@else
								{!! Form::open(['route' => 'operadoras.pesquisar' , 'method' => 'get' ]) !!}
							@endif								
									<div class="input-group input-group-sm" style="width: 190px; margin-left:auto;">
										{!! Form::text('key' , null , ['class' => 'form-control' , 'placeholder' => 'Pesquisar Operadoras' , 'aria-label' => 'Search']) !!}
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
									
								</tr>
								@forelse($models as $model)				
									<tr>
										<td> {{$model->nome}} </td>						
										<td> {{number_format($model->porcentagem_credito, 2)}}% </td>	
										<td> {{number_format($model->porcentagem_credito_parcelado, 2)}}% </td>						
										<td> {{number_format($model->porcentagem_debito, 2) }}% </td>	
										<td> {{$model->max_parcelas}}X </td>
										<td>
										
											@if($apagados)
												@permissao('operadoras-apagados')								
														<a class="btn btn-success btn-sm" href='{{route("operadoras.showapagado", $model->id)}}'>
															<i class="fa fa-eye" aria-hidden="true"></i>Exibir</a>								
												@endpermissao	

												@permissao('operadoras-restore')
													<a class="btn btn-warning btn-sm" href='{{route("operadoras.restore", $model->id)}}'>
														<i class="fa fa-arrow-circle-up" aria-hidden="true"></i>Reativar</a>
												@endpermissao 														
														
												@permissao('operadoras-delete-mater-ulta-mega')	
													<a class="btn btn-danger btn-sm" href="javascript:void(0);" onclick="$(this).find('form').submit();" >
														{!! Form::open(['route' => ['operadoras.destroy', $model->id ],  'method' => 'DELETE' , 'onsubmit' => " return  ApagarModel(this)"])!!}                                        
														{!! Form::close()!!}    
														<i class="fa fa-trash" aria-hidden="true"></i>Extinguir</a> 		        
													
												@endpermissao
											@else
												@permissao('operadoras')								
														<a class="btn btn-success btn-sm" href='{{route("operadoras.show", $model->id)}}'>
															<i class="fa fa-eye" aria-hidden="true"></i>Exibir</a>								
												@endpermissao	

												@permissao('operadoras-editar')								
														<a class="btn btn-warning btn-sm" href='{{route("operadoras.edit", $model->id)}}'>
															<i class="fa fa-pencil" aria-hidden="true"></i>Editar</a>								
												@endpermissao				
											
												@permissao('operadoras-soft-delete')			
													<a class="btn btn-danger btn-sm"  href="javascript:void(0);" onclick="$(this).find('form').submit();" >
															{!! Form::open(['route' => ['operadoras.destroySoft', $model->id ],  'method' => 'DELETE' , 'onsubmit' => " return  ApagarModel(this)" ])!!}                                        
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