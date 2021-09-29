<aside class="main-sidebar sidebar-light-success elevation-4">
    <!-- Brand Logo -->
    <a href="{{url('/')}}" class="brand-link">
        <img src="{{asset('img/icon.png')}}" alt="ESCO Pte Ltd Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">ESCO Pte Ltd</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{asset('img/user-images/emman.png')}}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">Emman Arrazola</a>
            </div>
        </div>

        <!-- SidebarSearch Form -->
        <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                <div class="input-group-append">
                <button class="btn btn-sidebar">
                    <i class="fas fa-search fa-fw"></i>
                </button>
                </div>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class with font-awesome or any other icon font library -->
                @if($usermodules->count() > 0)
                    @foreach($usermodules as $module)
                        @php 
                            $active = ($activemodule == $module->module_id) ? "active" : "";
                            $open = ($activemodule == $module->module_id) ? "menu-open" : "";
                        @endphp

                        @if($module->sub_module_count == 0)
                            <li class="nav-item">
                                <a href="{{route($module->route)}}" class="nav-link {{$active}}">
                                    <i class="nav-icon {{$module->icon}}"></i>
                                    <p>
                                        {{$module->description}}
                                    </p>
                                </a>
                            </li>
                        @else
                            <li class="nav-item {{$open}}">
                                <a href="#" class="nav-link {{$active}}">
                                    <i class="nav-icon {{$module->icon}}"></i>
                                    <p>
                                    {{$module->description}}
                                    <i class="fas fa-angle-left right"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    @if($usersubmodules->count() > 0)
                                        @foreach($usersubmodules as $submodule)
                                            @if($submodule->module_id == $module->module_id)
                                                @if(request()->routeIs($submodule->controllers.'.*'))
                                                <li class="nav-item">
                                                    <a href="{{route($submodule->route)}}" class="nav-link active">
                                                        <i class="far fa-circle nav-icon"></i>
                                                        <p>{{$submodule->description}}</p>
                                                    </a>
                                                </li>
                                                @else
                                                <li>
                                                    <a href="{{route($submodule->route)}}" class="nav-link">
                                                        <i class="far fa-circle nav-icon"></i>
                                                        <p>{{$submodule->description}}</p>
                                                    </a>
                                                </li>
                                                @endif
                                            @endif
                                        @endforeach
                                    @endif
                                </ul>
                            </li>
                        @endif
                    @endforeach
                @endif
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>