<x-app-layout>
	
	@include('layouts.header')

	@push('styles')
		<!-- SweetAlert2 -->
        <link rel="stylesheet" href="{{asset('plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css')}}">
        <!-- Toastr -->
        <link rel="stylesheet" href="{{asset('plugins/toastr/toastr.min.css')}}">
	@endpush

	<!-- Main content -->
	<section class="content">
		<!-- Default box -->
		<form class="form-horizontal" method="post" action="{{route('zohoapi.store')}}" enctype="multipart/form-data">
			@csrf
			
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
					<div class="form-group row">
						<label for="description" class="col-sm-2 col-form-label">Description</label>
						<div class="col-sm-10">
							<input type="text" required name="description" value="{{old('description')}}" class="form-control form-control-sm" id="description" placeholder="Description">
						</div>
					</div>
					<div class="form-group row">
						<label for="url" class="col-sm-2 col-form-label">URL</label>
						<div class="col-sm-10">
							<input type="text" name="url" value="{{old('url')}}" class="form-control form-control-sm"" id="url" placeholder="URL">
						</div>
					</div>
					<div class="form-group row">
						<label for="isactive" class="col-sm-2 col-form-label">Active?</label>
						
						<div class="custom-control custom-switch col-sm-10">
							@if(old('isactive', 1) == 1)
								<input type="checkbox" name="isactive" value="1" checked class="custom-control-input" id="active">
								<label class="custom-control-label ml-2 mt-1" for="active"></label>
							@else
								<input type="checkbox" name="isactive" value="1" class="custom-control-input" id="active">
								<label class="custom-control-label ml-2 mt-1" for="active"></label>
							@endif
						</div>
					</div>
				</div>
				<!-- /.card-body -->
				<div class="card-footer">
					<button type="submit" class="btn btn-outline-success float-right ml-2">Create</button>
					<a href="{{route('zohoapi.index')}}"><button type="button" class="btn btn-outline-secondary float-right">Cancel</button></a>
				</div>
				<!-- /.card-footer-->
			</div>
			<!-- /.card -->
		</form>
	</section>
	<!-- /.content -->

	@push('scripts')
        <!-- SweetAlert2 -->
        <script src="{{asset('plugins/sweetalert2/sweetalert2.min.js')}}"></script>
        <!-- Toastr -->
        <script src="{{asset('plugins/toastr/toastr.min.js')}}"></script>
	@endpush

</x-app-layout>

<script type="text/javascript">

</script>