<x-app-layout>
	
	@include('layouts.header')

	@push('styles')
		<!-- DataTables -->
		<link rel="stylesheet" href="{{asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
		<link rel="stylesheet" href="{{asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
		<link rel="stylesheet" href="{{asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">
        <!-- SweetAlert2 -->
        <link rel="stylesheet" href="{{asset('plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css')}}">
        <!-- Toastr -->
        <link rel="stylesheet" href="{{asset('plugins/toastr/toastr.min.css')}}">
	@endpush

	<!-- Main content -->
	<section class="content">
		<!-- Default box -->
		<div class="card">
			<div class="card-header">
				<h3 class="card-title">Masterlist</h3>
				<div class="card-tools">
					<button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
						<i class="fas fa-minus"></i>
					</button>
					<button type="button" class="btn btn-tool d-none" data-card-widget="remove" title="Remove">
						<i class="fas fa-times"></i>
					</button>
				</div>
			</div>
			<div class="card-body">
				<table id="paramstbl" class="table table-sm table-bordered table-striped" style="width:100%">
					<thead>
						<tr>
							<th>ID</th>
							<th>API Name</th>
							<th>Params Type</th>
							<th>Key</th>
							<th>Value</th>
							<th>Active</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						@if($params->count() > 0)
							@foreach($params as $param)
								<tr>
									<td class="align-middle">{{$param->id}}</td>
									<td class="align-middle">{{$param->api_name}}</td>
									<td class="align-middle">{{$param->params_type}}</td>
									<td class="align-middle">{{$param->params_key}}</td>
									<td class="align-middle"><div style="width:200px;text-overflow:ellipsis">{{$param->params_value}}</div></td>
									@if($param->isactive == 1)
									<td class="align-middle text-center"><span class="badge badge-success" style="width:50px">YES</span></td>
									@else
									<td class="align-middle text-center"><span class="badge badge-danger" style="width:50px">NO</span></td>
									@endif
									<td class="align-middle">
										<div class="text-center"> 
											<a href="{{route('parameters.edit', ['parameter'=>$param->id])}}"><button type="button" class="btn btn-outline-primary btn-sm" style="width:60px">Edit</button></a>
											<button type="button" class="btn btn-outline-danger btn-sm text-sm" style="width:60px">Delete</button>
										</div>
									</td>
								</tr>
							@endforeach
						@endif
					</tbody>
				</table>
			</div>
			<!-- /.card-body -->
			<div class="card-footer">
				<a href="{{route('parameters.create')}}" class="btn btn-outline-success float-right">Create New</a>
			</div>
			<!-- /.card-footer-->
		</div>
		<!-- /.card -->
	</section>
	<!-- /.content -->

	@push('scripts')
		<!-- DataTables  & Plugins -->
		<script src="{{asset('plugins/datatables/jquery.dataTables.min.js')}}"></script>
		<script src="{{asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
		<script src="{{asset('plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
		<script src="{{asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
		<script src="{{asset('plugins/datatables-buttons/js/dataTables.buttons.min.js')}}"></script>
		<script src="{{asset('plugins/datatables-buttons/js/buttons.bootstrap4.min.js')}}"></script>
		<script src="{{asset('plugins/jszip/jszip.min.js')}}"></script>
		<script src="{{asset('plugins/pdfmake/pdfmake.min.js')}}"></script>
		<script src="{{asset('plugins/pdfmake/vfs_fonts.js')}}"></script>
		<script src="{{asset('plugins/datatables-buttons/js/buttons.html5.min.js')}}"></script>
		<script src="{{asset('plugins/datatables-buttons/js/buttons.print.min.js')}}"></script>
		<script src="{{asset('plugins/datatables-buttons/js/buttons.colVis.min.js')}}"></script>
        <!-- SweetAlert2 -->
        <script src="{{asset('plugins/sweetalert2/sweetalert2.min.js')}}"></script>
        <!-- Toastr -->
        <script src="{{asset('plugins/toastr/toastr.min.js')}}"></script>
	@endpush

</x-app-layout>

<script type="text/javascript">
	$(function(){
		var Toast = Swal.mixin({
			toast: true,
			position: 'top-end',
			showConfirmButton: false,
			timer: 3000
		});

		@if(Session::get('success'))
			Toast.fire({
				icon: 'success',
				title: '{{Session::get('success')}}'
			})
		@endif

		$("#paramstbl").DataTable({
			'responsive':true,
			'order':[[0, 'desc']],
			'columnDefs': [
				{ width: '200px', targets: 4 }
			],
		});
	})
</script>