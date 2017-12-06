@extends( Config::get('cadastro.templateMaster' , 'templates.templateMaster')  )

@section( Config::get('cadastro.templateMasterMenuLateral' , 'menuLateral')  )
			@if($apagados)
				@permissao('servicos')
					<li><a href="{{ route('servicos.index')}}"><i class="fa fa-circle-o text-blue"></i> <span>Serviços Ativos</span></a></li>
				@endpermissao
			@else
				@permissao('servicos-cadastrar')
					<li><a href="{{ route('servicos.create')}}"><i class="fa fa-circle-o text-blue"></i> <span>Cadastrar Serviço</span></a></li>
				@endpermissao
				@permissao('servicos-apagados')
					<li><a href="{{  route('servicos.apagados')}}"><i class="fa fa-circle-o text-red"></i> <span>Serviços Apagados</span></a></li>
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
				Listagem dos Serviços Apagados
			@else
				Listagem dos Serviços
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
								{!! Form::open(['route' => 'servicos.pesquisarApagados' , 'method' => 'get' ]) !!}
							@else
								{!! Form::open(['route' => 'servicos.pesquisar' , 'method' => 'get' ]) !!}
							@endif								
									<div class="input-group input-group-sm" style="width: 190px; margin-left:auto;">
										{!! Form::text('key' , null , ['class' => 'form-control' , 'placeholder' => 'Pesquisar Serviços' , 'aria-label' => 'Search']) !!}
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
									<th>Categoria</th>
									<th>Duração</th>
									<th>Comissão</th>
									<th>Valor</th>					
									<th>Ações</th>
								</tr>
								@forelse($models as $model)				
									<tr>
										<td> {{$model->nome}} </td>	
										<td>{{ $model->categoria }}</td>
										<td>{{ $model->duracao_aproximada }}min</td>
										<td>{{ $model->porcentagem_funcionario }}%</td>
										<td>R${{ number_format($model->valor , 2 ,',', '') }}</td>
										<td>
										
											@if($apagados)
												@permissao('servicos-show-apagados')								
														<a class="btn btn-success btn-sm" href='{{route("servicos.showapagado", $model->id)}}'>
															<i class="fa fa-eye" aria-hidden="true"></i>Exibir</a>								
												@endpermissao	

												@permissao('servicos-restore')
													<a class="btn btn-warning btn-sm" href='{{route("servicos.restore", $model->id)}}'>
														<i class="fa fa-arrow-circle-up" aria-hidden="true"></i>Reativar</a>
												@endpermissao 														
														
												@permissao('servicos-delete-mater-ulta-mega')	
													<a class="btn btn-danger btn-sm" href="javascript:void(0);" onclick="$(this).find('form').submit();" >
														{!! Form::open(['route' => ['servicos.destroy', $model->id ],  'method' => 'DELETE' ])!!}                                        
														{!! Form::close()!!}    
														<i class="fa fa-trash" aria-hidden="true"></i>Extinguir</a> 		        
													
												@endpermissao
											@else
												@permissao('servicos')								
														<a class="btn btn-success btn-sm" href='{{route("servicos.show", $model->id)}}'>
															<i class="fa fa-eye" aria-hidden="true"></i>Exibir</a>								
												@endpermissao	

												@permissao('servicos-editar')								
														<a class="btn btn-warning btn-sm" href='{{route("servicos.edit", $model->id)}}'>
															<i class="fa fa-pencil" aria-hidden="true"></i>Editar</a>								
												@endpermissao				
											
												@permissao('servicos-soft-delete')			
													<a class="btn btn-danger btn-sm"  href="javascript:void(0);" onclick="$(this).find('form').submit();" >
															{!! Form::open(['route' => ['servicos.destroySoft', $model->id ],  'method' => 'DELETE' ])!!}                                        
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