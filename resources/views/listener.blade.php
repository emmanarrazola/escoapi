<x-guest-layout>
    @push('styles')
        @livewireStyles
    @endpush

    <div class="login-box">
        <!-- /.login-logo -->
        <div class="card">
            <div class="card-body">
                <div class="text-center">
                    <a href="index2.html" class="h1">
                        <img src="{{asset('img/company-logo2.png')}}" class="img-fluid" style="max-width:100%;width:200px;" />
                    </a>
                </div>

                <h5 style="text-align:center">
                    @livewire('system-datetime')
                </h5>

                <div class="form-group has-feedback">
                    <input style="text-align:center" value="XXXX-XXXX-XXXX-XXXX" disabled type="text" class="form-control">
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                </div>

                <div class="row">
                    <div class="col-sm-12">
                        <h4 style="text-align:center">Current Activity</h4>
                        
                        @livewire('listener-queue')
                    </div>
                </div>
            </div>
            <!-- /.card-body -->
            <div style="text-align:center;">
                <strong>Copyright &copy; <?php echo date('Y'); ?> <a href="#" id="ackbtn">ESCO Pte Ltd</a></strong>
            </div>
            <div style="text-align:center" class="pb-4">
                v<strong>1.0.1</strong> All Right Reserved.
            </div>
        </div>
        <!-- /.card -->
    </div>

    @push('styles')
        @livewireScripts
    @endpush

</x-guest-layout>

<script type="text/javascript">
    window.addEventListener('statusupdate', event=>{
		console.log(event.detail.loop);
		// if(event.detail.reload == 0){
		// 	if(event.detail.loop < 10){
		// 		clearTimeout(t);
		// 		t = window.setTimeout(function(){
		// 		Livewire.emit('getpatstatus');
		// 		}, event.detail.timeout);
		// 	}else{
		// 		location.reload(true);
		// 	}
		// }else{
		//   location.reload(true);
		// }
	});
</script>