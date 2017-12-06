@extends( Config::get('cadastro.templateMaster' , 'templates.templateMaster')  )

@section( Config::get('cadastro.templateMasterMenuLateral' , 'menuLateral')  )
			@if($apagados)
				@permissao('operadoras')
					<li><a href="{{ route('operadoras.index')}}"><i class="fa fa-circle-o text-blue"></i> <span>Operadoras Ativas</span></a></li>
				@endpermissao
			@else
				@permissao('operadoras-cadastrar')
					<li><a href="{{ route('operadoras.create')}}"><i class="fa fa-circle-o text-blue"></i> <span>Cadastrar Operadora</span></a></li>
				@endpermissao
				@permissao('operadoras-apagados')
					<li><a href="{{  route('operadoras.apagados')}}"><i class="fa fa-circle-o text-red"></i> <span>Operadoras Apagadas</span></a></li>
				@endpermissao
			@endif			
@endsection
		
@section( Config::get('cadastro.templateMasterScript' , 'script')  )
        	<script>$(function(){setTimeout("$('.hide-msg').fadeOut();",5000)});</script>
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
				Listagem dos Operadoras Apagadas
			@else
				Listagem dos Operadoras
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
									<th>Nome</th>
									<th>Porc. Credito</th>
									<th>Porc. Credito Parc.</th>
									<th>Porc. Debito</th>
									<th>Máximo de Parcelas</th>					
									<th>Ações</th>
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
														{!! Form::open(['route' => ['operadoras.destroy', $model->id ],  'method' => 'DELETE' ])!!}                                        
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
															{!! Form::open(['route' => ['operadoras.destroySoft', $model->id ],  'method' => 'DELETE' ])!!}                                        
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