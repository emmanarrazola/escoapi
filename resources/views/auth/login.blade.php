<x-guest-layout>
    <x-auth-card>
        
        <!-- /.login-logo -->
        <div class="card card-outline card-success">
            <x-slot name="logo">
                <div class="card-header text-center">
                    <a href="index2.html" class="h1">
                        <img src="{{asset('img/company-logo2.png')}}" class="img-fluid" style="max-width:100%;width:200px;" />
                    </a>
                </div>
            </x-slot>

            <div class="card-body">
                <!-- Session Status -->
                <x-auth-session-status class="mb-4 d-none" :status="session('status')" />

                <!-- Validation Errors -->
                <x-auth-validation-errors class="mb-4 d-none" :errors="$errors" />

                

                <p class="login-box-msg">Sign in to start your session</p>

                <form action="{{ route('login') }}" method="post">
                    @csrf

                    <div class="input-group mb-3">
                        <input type="email" required class="form-control" placeholder="Email" name="email">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" required class="form-control" placeholder="Password" name="password">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-8">
                            <div class="icheck-primary">
                                <input type="checkbox" id="remember" name="remember">
                                <label for="remember">
                                    Remember Me
                                </label>
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-4">
                            <button type="submit" class="btn btn-success btn-block">Sign In</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>

                <div class="social-auth-links text-center mt-2 mb-3 d-none">
                    <a href="#" class="btn btn-block btn-primary">
                        <i class="fab fa-facebook mr-2"></i> Sign in using Facebook
                    </a>
                    <a href="#" class="btn btn-block btn-danger">
                        <i class="fab fa-google-plus mr-2"></i> Sign in using Google+
                    </a>
                </div>
                <!-- /.social-auth-links -->

                <p class="mb-1">
                    <a href="forgot-password.html">I forgot my password</a>
                </p>
                <p class="mb-0 d-none">
                    <a href="{{route('register')}}" class="text-center">Register a new membership</a>
                </p>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
        
    </x-auth-card>
</x-guest-layout>
