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
		<form class="form-horizontal" method="post" action="{{route('zohoapi.update', ['zohoapi'=>$zohoapi->id])}}" enctype="multipart/form-data">
			@csrf
			@method('PUT')
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
							<input type="text" required name="description" value="{{old('description', $zohoapi->description)}}" class="form-control form-control-sm" id="description" placeholder="Description">
						</div>
					</div>
					<div class="form-group row">
						<label for="url" class="col-sm-2 col-form-label">URL</label>
						<div class="col-sm-10">
							<input type="text" name="url" value="{{old('url', $zohoapi->url)}}" class="form-control form-control-sm"" id="url" placeholder="URL">
						</div>
					</div>
					<div class="form-group row">
						<label for="method" class="col-sm-2 col-form-label">Method</label>
						<div class="col-sm-10">
							<select name="method" class="form-control form-control-sm select2 select2-sm" style="width:100%" id="method" data-placeholder="Method">
								<option><option>
								@if($methods->count() > 0)
									@foreach($methods as $method)
										@if($method->id == old('method', $zohoapi->api_method_id))
											<option selected value="{{$method->id}}">{{$method->description}}</option>
										@else
											<option value="{{$method->id}}">{{$method->description}}</option>
										@endif
									@endforeach
								@endif
							</select>
						</div>
					</div>
					<div class="form-group row">
						<label for="zohoauth" class="col-sm-2 col-form-label">Zoho Auth</label>
						<div class="col-sm-10">
							<select name="zohoauth" class="form-control form-control-sm select2 select2-sm" style="width:100%" id="zohoauth" data-placeholder="Zoho Auth">
								<option><option>
								@if($auths->count() > 0)
									@foreach($auths as $auth)
										@if($auth->id == old('zohoauth', $zohoapi->zoho_auth_id))
											<option selected value="{{$auth->id}}">{{$auth->description}}</option>
										@else
											<option value="{{$auth->id}}">{{$auth->description}}</option>
										@endif
									@endforeach
								@endif
							</select>
						</div>
					</div>
					<div class="form-group row">
						<label for="isrequest" class="col-sm-2 col-form-label">Is Request?</label>
						<div class="custom-control custom-switch col-sm-10">
							@if(old('isrequest', $zohoapi->isrequest) == 1)
								<input type="checkbox" name="isrequest" value="1" checked class="custom-control-input" id="isrequest">
								<label class="custom-control-label ml-2 mt-1" for="isrequest"></label>
							@else
								<input type="checkbox" name="isrequest" value="1" class="custom-control-input" id="isrequest">
								<label class="custom-control-label ml-2 mt-1" for="isrequest"></label>
							@endif
						</div>
					</div>
					<div class="form-group row">
						<label for="isauth" class="col-sm-2 col-form-label">Is Auth?</label>
						<div class="custom-control custom-switch col-sm-10">
							@if(old('isauth', $zohoapi->isauth) == 1)
								<input type="checkbox" name="isauth" value="1" checked class="custom-control-input" id="isauth">
								<label class="custom-control-label ml-2 mt-1" for="isauth"></label>
							@else
								<input type="checkbox" name="isauth" value="1" class="custom-control-input" id="isauth">
								<label class="custom-control-label ml-2 mt-1" for="isauth"></label>
							@endif
						</div>
					</div>
					<div class="form-group row">
						<label for="iscode" class="col-sm-2 col-form-label">Is Get Code?</label>
						<div class="custom-control custom-switch col-sm-10">
							@if(old('iscode', $zohoapi->iscode) == 1)
								<input type="checkbox" name="iscode" value="1" checked class="custom-control-input" id="iscode">
								<label class="custom-control-label ml-2 mt-1" for="iscode"></label>
							@else
								<input type="checkbox" name="iscode" value="1" class="custom-control-input" id="iscode">
								<label class="custom-control-label ml-2 mt-1" for="iscode"></label>
							@endif
						</div>
					</div>
					<div class="form-group row">
						<label for="isrefresh" class="col-sm-2 col-form-label">Is Refresh Token?</label>
						<div class="custom-control custom-switch col-sm-10">
							@if(old('isrefresh', $zohoapi->isrefresh) == 1)
								<input type="checkbox" name="isrefresh" value="1" checked class="custom-control-input" id="isrefresh">
								<label class="custom-control-label ml-2 mt-1" for="isrefresh"></label>
							@else
								<input type="checkbox" name="isrefresh" value="1" class="custom-control-input" id="isrefresh">
								<label class="custom-control-label ml-2 mt-1" for="isrefresh"></label>
							@endif
						</div>
					</div>
					<div class="form-group row">
						<label for="isactive" class="col-sm-2 col-form-label">Active?</label>
						<div class="custom-control custom-switch col-sm-10">
							@if(old('isactive', $zohoapi->isactive) == 1)
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
					<button type="submit" class="btn btn-outline-success float-right ml-2">Update</button>
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
		<!-- Select2 -->
		<script src="{{asset('plugins/select2/js/select2.full.min.js')}}"></script>
	@endpush

</x-app-layout>

<script type="text/javascript">
	$(function(){
		$('.select2').select2({
			theme: 'bootstrap4',
			containerCssClass: ':all',
		})
	});
</script>