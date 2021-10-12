<x-guest-layout>
    <x-auth-card>
        <!-- /.login-logo -->
        <div class="card card-outline">
            <x-slot name="logo">
                <div class="card-header text-center">
                    <a href="index2.html" class="h1">
                        <img src="{{asset('img/company-logo2.png')}}" class="img-fluid" style="max-width:100%;width:200px;" />
                    </a>
                </div>
            </x-slot>

            <div class="card-body">
                <h4 style="text-align:center"><small>Datetime: </small><span id="datetime"><?php echo date('Y-m-d H:i:s'); ?></span></h4>

                <div class="form-group has-feedback">
                    <input style="text-align:center" value="XXXX-XXXX-XXXX-XXXX" disabled type="text" class="form-control">
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                </div>

                <div class="row">
                    <div class="col-12">
                        <h4 style="text-align:center">Current Activity</h4>
                        <ul class="list-group">
                            <li class="list-group-item text-center">
                                <span id="curractivity">Waiting for Scheduled Message </span><i class="fa fa-spinner fa-spin"></i>
                            </li>
                            <li class="list-group-item">
                                <i class="fa fa-spinner fa-spin"></i> Queue <span id="queue" class="float-right badge bg-blue">0</span>
                            </li>
                            <li class="list-group-item">
                                <i class="fa fa-spinner fa-spin"></i> Warnings <span id="warning" class="float-right badge bg-red">0</span>
                            </li> 
                            <li class="list-group-item">Gateways <span class="badge float-right bg-green" id="gateway">0</span></li> 
                        </ul>
                    </div>
                </div>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </x-auth-card>
</x-guest-layout>
