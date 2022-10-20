@php
    $segment1 = request()->segment(1);
    $segment2 = request()->segment(2);
    $segment3 = request()->segment(3);
    $segment4 = request()->segment(4);
@endphp

<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ url('/product') }}" class="brand-link">
      <img src="{{ asset('assets/dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">{{ env('APP_NAME') }}</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{ asset('assets/dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">{{ Auth::user()->name }} | {{ Auth::user()->getRoleNames()[0] }}</a>
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
            <!-- Add icons to the links using the .nav-icon class
                with font-awesome or any other icon font library -->
            <li class="nav-item">
                <a href={{ url('/dashboard') }} class="nav-link {{ $segment1 == 'dashboard' ? 'active' : null }}">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>
                    Dashboard
                </p>
                </a>
            </li>
            <li class="nav-item">
                <a href={{ url('/product') }} class="nav-link {{ $segment1 == 'product' ? 'active' : null }}">
                <i class="nav-icon fas fa-th"></i>
                <p>
                    Daftar Produk
                </p>
                </a>
            </li>
            <li class="nav-item">
                <a href={{ url('/category') }} class="nav-link {{ $segment1 == 'category' ? 'active' : null }}">
                <i class="nav-icon fas fa-th"></i>
                <p>
                    Kategori Produk
                </p>
                </a>
            </li>
            <li class="nav-item">
                <a href={{ url('/user') }} class="nav-link {{ $segment1 == 'user' ? 'active' : null }}">
                <i class="nav-icon fas fa-th"></i>
                <p>
                    Kelola User
                </p>
                </a>
            </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
