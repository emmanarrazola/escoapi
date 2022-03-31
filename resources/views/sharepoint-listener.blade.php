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
                        <ul class="list-group">
                            <li class="list-group-item text-center">
                                <span id="curr_activity">Connecting to Database </span><i class="fa fa-circle-notch fa-spin"></i>
                            </li>
                            <li class="list-group-item">
                                <i class="fa fa-circle-notch fa-spin"></i> New Tickets <span id="add" class="float-right badge bg-blue">0</span>
                            </li>
                            <li class="list-group-item">
                                <i class="fa fa-circle-notch fa-spin"></i> New Attachments <span id="edit" class="float-right badge bg-green">0</span>
                            </li> 
                            <li class="list-group-item">
                                <i class="fa fa-circle-notch fa-spin"></i> Deleted Record <span id="delete" class="float-right badge bg-warning">0</span>
                            </li>
                            <li class="list-group-item">Warnings <span class="badge float-right bg-red" id="warning">0</span></li> 
                        </ul>
                        @livewire('sharepoint-listener')
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


<script src="{{asset('plugins/jquery/jquery.min.js')}}"></script>
<script type="text/javascript">
    document.addEventListener('livewire:load', function () {
        $(function(){
            var t;
            Livewire.emit('sharepoint_listener');

            window.addEventListener('update_task_count', event=>{
                $("#add").text(event.detail.add_tickets);
                $("#edit").text(event.detail.add_attach);
                $("#delete").text(event.detail.delete);
                $("#curr_activity").text(event.detail.msg);

                console.log(event.detail);

                if(event.detail.reload == 0){
                    console.log(event.detail.loop);
                    if(event.detail.loop < 50){
                        clearTimeout(t);
                        t = window.setTimeout(function(){
                            Livewire.emit('sharepoint_listener');
                        }, event.detail.timeout);
                    }else{
                        location.reload(true);
                    }
                }else{
                    location.reload(true);
                }
            });
        });

        window.livewire.onError(statusCode => {
            if (statusCode === 500) {
                location.reload(true);
            }
            return false;
        });
    });
</script>