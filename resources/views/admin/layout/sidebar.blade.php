<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('admin.dashboard') }}" class="brand-link">
        <img src="{{ asset('admin-asset/dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo"
            class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">Admin Panel</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                @if (!Auth::guard('admin')->user()->image)
                    <img src="{{ asset('admin-asset/dist/img/photos/download.png') }}" class="img-circle elevation-2"
                        alt="User Image">
                @else
                    <img src="{{ asset('admin-asset/dist/img/photos/download.png') }}" class="img-circle elevation-2"
                        alt="User Image">
                @endif
            </div>
            <div class="info">
                <a href="#" class="d-block">{{ Auth::guard('admin')->user()->name }}</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
       with font-awesome or any other icon font library -->
                @if (Session::get('page') == 'dashboard')
                    @php $active = 'active' @endphp
                @else
                    @php $active = '' @endphp
                @endif
                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link {{ $active }}">
                        <i class="nav-icon fas fa-th"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>
                @if (Auth::guard('admin')->user()->type == 'admin')
                    <li class="nav-item menu-open">
                        @if (Session::get('page') == 'update-password' || Session::get('page') == 'update-details')
                            @php $active = 'active' @endphp
                        @else
                            @php $active = '' @endphp
                        @endif
                        <a href="#" class="nav-link {{ $active }}">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>
                                Seetings
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @if (Session::get('page') == 'update-password')
                                @php $active = 'active' @endphp
                            @else
                                @php $active = '' @endphp
                            @endif
                            <li class="nav-item">
                                <a href="{{ route('update.passwrd') }}" class="nav-link {{ $active }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Update Admin Password</p>
                                </a>
                            </li>
                            @if (Session::get('page') == 'update-details')
                                @php $active = 'active' @endphp
                            @else
                                @php $active = '' @endphp
                            @endif
                            <li class="nav-item">
                                <a href="{{ url('admin/update-details') }}" class="nav-link {{ $active }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Updates Admin Details</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif
                @if (Session::get('page') == 'subadmin')
                    @php $active =  'active' @endphp
                @else
                    @php $active =  '' @endphp
                @endif
                @if (Auth::guard('admin')->user()->type == 'admin')
                    <li class="nav-item">
                        <a href="{{ route('subadmin') }}" class="nav-link {{ $active }}">
                            <i class="nav-icon fas fa-users"></i>
                            <p>
                                Subadmins
                            </p>
                        </a>
                    </li>
                @endif
                @if (Session::get('page') == 'cmsPages')
                    @php $active =  'active' @endphp
                @else
                    @php $active =  '' @endphp
                @endif
                <li class="nav-item">
                    <a href="{{ route('cmsPages.index') }}" class="nav-link {{ $active }}">
                        <i class="nav-icon fas fa-copy"></i>
                        <p>
                            CMS Page
                        </p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
