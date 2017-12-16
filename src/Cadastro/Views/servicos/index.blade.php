@extends( Config::get('app.templateMaster' , 'templates.templateMaster')  )

@section( Config::get('app.templateMasterContentTitulo' , 'titulo-page')  )
	Listagem dos Serviços			
@endsection


@section( Config::get('app.templateMasterMenuLateral' , 'menuLateral')  )				
	@permissao('servicos-apagados')
		<li><a href="{{  route('servicos.apagados')}}"><i class="fa fa-circle-o text-red"></i> <span>Serviços Apagados</span></a></li>
	@endpermissao
@endsection


@section( Config::get('app.templateMasterContent' , 'content')  )

<div class="col-xs-12">
    <div class="box box-success">
		@permissao('servicos-cadastrar')
        	<div class="box-header align-right">			
				<a href="{{ route('servicos.create')}}" class="btn btn-success" title="Adicionar um novo Serviço">
					<i class="fa fa-plus"></i> Cadastrar Serviço
				</a>          
        	</div>
		@endpermissao  

        <div class="box-body">
            <table class="table table-bordered table-striped table-hover" id="datatable">
                <thead>
                    <tr>
						<th>ID</th>
						<th pesquisavel>Nome</th>
						<th>Valor</th>						
						<th>Duração Aproximada</th>										
						<th>Porcentagem Funcionário</th>
						<th>Categoria</th>
						<th>Desconto Máximo</th>												
                        <th class="align-center" style="width:100px">Ações</th>
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
					url:'{{ route('servicos.getDatatable') }}'
				},
				columns: [
					{ data: 'id', name: 'id' },
					{ data: 'nome', name: 'nome' },
					{ data: 'valor', name: 'valor' },
					{ data: 'duracao_aproximada', name: 'duracao_aproximada' },					
					{ data: 'porcentagem_funcionario', name: 'porcentagem_funcionario' },
					{ data: 'categoria', name: 'categoria' },
					{ data: 'desconto_maximo', name: 'desconto_maximo' },
					{ data: 'action', name: 'action', orderable: false, searchable: false, class: 'align-center'}
				],
			});

			dataTable.on('draw', function () {
				$('[btn-excluir]').click(function (){
					excluirRecursoPeloId($(this).data('id'), "@lang('msg.conf_excluir_o', ['1' => serviços'])", "{{ route('servicos.apagados') }}", 
						function(){
							dataTable.row( $(this).parents('tr') ).remove().draw('page');
						}
					);
				});
			});
		});
	</script>
@endpush

