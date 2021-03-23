<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ url('/') }}" class="brand-link">
        <img src="{{ asset('dist/img/NL.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
            style="opacity: .8">
        <span class="brand-text font-weight-light">Blog</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ asset('dist/img/user_logo_160x160.png') }}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">
                    {{ auth()->user()->name }}
                </a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
               <li class="nav-item has-treeview menu-close">
                <a href="#" class="nav-link active">
                    <i class="nav-icon fas fa-tasks"></i>
                    <p>
                        Jira
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    @can('view jira')
                    <li class="nav-item">
                        <a href="{{ url('admin/jira') }}" class="nav-link">
                            <i class="fas fa-fire nav-icon"></i>
                            <p>Jira</p>
                        </a>
                    </li>
                    @endcan 
                    @can('view version')
                    <li class="nav-item">
                        <a href="{{ url('admin/version') }}" class="nav-link">
                            <i class="fas fa-compress nav-icon"></i>
                            <p>Versión</p>
                        </a>
                    </li>
                    @endcan 
                </ul>
            </li>
            <li class="nav-item has-treeview menu-close">
                    <a href="#" class="nav-link active">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Manage
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        @can('view role')
                        <li class="nav-item">
                            <a href="{{ route('admin.role.index') }}" class="nav-link">
                                <i class="fas fa-file-alt nav-icon"></i>
                                <p>Roles & Permisos</p>
                            </a>
                        </li>
                        @endcan 
                        @can('view tipoaccionjira')
                        <li class="nav-item">
                            <a href="{{ url('admin/tipoaccionjira') }}" class="nav-link">
                                <i class="fas fa-th nav-icon"></i>
                                <p>Tipo de accion jira</p>
                            </a>
                        </li>
                        @endcan                         
                        @can('view user')
                        <li class="nav-item">
                            <a href="{{ url('admin/user') }}" class="nav-link">
                                <i class="fas fa-users nav-icon"></i>
                                <p>Users</p>
                            </a>
                        </li>
                        @endcan
                        <li class="nav-item">
                            <a href="{{ url('admin/profile') }}" class="nav-link">
                                <i class="fas fa-user nav-icon"></i>
                                <p>Administrar tu cuenta</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a 
                    onclick="event.preventDefault(); document.getElementById('logout').submit();"
                    href="admin/post/" class="nav-link">
                        <i class="nav-icon fas fa-power-off text-danger"></i>
                        <p>
                            Salir
                        </p>
                    </a>
                    <form action="/logout" method="post" id="logout">
                        @csrf
                    </form>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>