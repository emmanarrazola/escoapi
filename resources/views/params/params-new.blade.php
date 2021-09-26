<x-app-layout>
	
	@include('layouts.header')

	@push('styles')
		<!-- SweetAlert2 -->
        <link rel="stylesheet" href="{{asset('plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css')}}">
        <!-- Toastr -->
        <link rel="stylesheet" href="{{asset('plugins/toastr/toastr.min.css')}}">
		<!-- Select2 -->
		<link rel="stylesheet" href="{{asset('plugins/select2/css/select2.min.css')}}">
  		<link rel="stylesheet" href="{{asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
	@endpush

	<!-- Main content -->
	<section class="content">
		<!-- Default box -->
		<form class="form-horizontal" method="post" action="{{route('parameters.store')}}" enctype="multipart/form-data">
			@csrf
			<div class="card">
				<div class="card-header">
					<h3 class="card-title">Edit Record</h3>
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
						<label for="apiname" class="col-sm-2 col-form-label">API Name</label>
						<div class="col-sm-10">
							<select required id="apiname" class="select2 form-control form-control-sm" style="width:100%" name="apiname" data-placeholder="Select API">
								<option></option>
								@if($apis->count() > 0)
									@foreach($apis as $api)
										@if($api->id == old('apiname'))
											<option selected value="{{$api->id}}">{{$api->description}}</option>
										@else
											<option value="{{$api->id}}">{{$api->description}}</option>
										@endif
									@endforeach
								@endif
							</select>
						</div>
					</div>
					<div class="form-group row">
						<label for="paramstype" class="col-sm-2 col-form-label">Param Type</label>
						<div class="col-sm-10">
							<select required id="paramstype" class="select2 form-control form-control-sm" style="width:100%" name="paramstype" data-placeholder="Params Type">
								<option></option>
								@if($paramstype->count() > 0)
									@foreach($paramstype as $type)
										@if($type->id == old('paramstype'))
											<option selected value="{{$api->id}}">{{$type->description}}</option>
										@else
											<option value="{{$api->id}}">{{$type->description}}</option>
										@endif
									@endforeach
								@endif
							</select>
						</div>
					</div>
					<div class="form-group row">
						<label for="key" class="col-sm-2 col-form-label">Key</label>
						<div class="col-sm-10">
							<input type="text" required name="key" value="{{old('key')}}" class="form-control form-control-sm" id="key" placeholder="Key">
						</div>
					</div>
					<div class="form-group row">
						<label for="value" class="col-sm-2 col-form-label">Value</label>
						<div class="col-sm-10">
							<input type="text" name="value" value="{{old('value')}}" class="form-control form-control-sm"" id="value" placeholder="Value">
						</div>
					</div>
					<div class="form-group row">
						<label for="isactive" class="col-sm-2 col-form-label">Active?</label>
						<div class="custom-control custom-switch col-sm-10">
							@if(old('isactive', 1) == 1)
								<input type="checkbox" name="isactive" value="1" checked class="custom-control-input" id="active">
								<label class="custom-control-label ml-2 mt-1" for="active"></label>
							@else
								<input type="checkbox" name="isactive" value="0" class="custom-control-input" id="active">
								<label class="custom-control-label ml-2 mt-1" for="active"></label>
							@endif
						</div>
					</div>
				</div>
				<!-- /.card-body -->
				<div class="card-footer">
					<button type="submit" class="btn btn-outline-success float-right ml-2">Create</button>
					<a href="{{route('parameters.index')}}"><button type="button" class="btn btn-outline-secondary float-right">Cancel</button></a>
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
		<!-- Select2 -->
		<script src="{{asset('plugins/select2/js/select2.full.min.js')}}"></script>
	@endpush

</x-app-layout>

<script type="text/javascript">
	$(function(){
		$('.select2').select2({
			theme: 'bootstrap4'
		});
	})
</script>