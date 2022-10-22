@php
    $segment1 = request()->segment(1);
    $segment2 = request()->segment(2);
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

      @if(Auth::user()->getRoleNames()[0] == 'Admin')
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
                        <a href={{ url('/member') }} class="nav-link {{ $segment1 == 'member' ? 'active' : null }}">
                        <i class="nav-icon fas fa-address-card"></i>
                        <p>
                            Member
                        </p>
                        </a>
                    </li>

            </ul>
        </nav>>
      @else
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
                <li class="nav-item {{ $segment1 == 'product' || $segment1 == 'category' || $segment1 == 'stockLog' ? 'menu-open' : null }}">
                <a href="#" class="nav-link {{ $segment1 == 'product' || $segment1 == 'category' || $segment1 == 'stockLog' ? 'active' : null }}" >
                  <i class="nav-icon fas fa-clipboard"></i>
                  <p>
                    Kelola Produk
                    <i class="fas fa-angle-left right"></i>
                    <span class="badge badge-info right">3</span>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href={{ url('/product') }} class="nav-link {{ $segment1 == 'product' ? 'active' : null }}">
                        <i class="nav-icon fas fa-dolly-flatbed"></i>
                        <p>Daftar Produk</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href={{ url('/category') }} class="nav-link {{ $segment1 == 'category' ? 'active' : null }}">
                        <i class="nav-icon fas fa-clipboard-list"></i>
                        <p>
                            Kategori Produk
                        </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href={{ url('/stockLog') }} class="nav-link {{ $segment1 == 'stockLog' ? 'active' : null }}">
                        <i class="nav-icon fas fa-poll"></i>
                        <p>
                            Riwayat Stok
                        </p>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="nav-item {{ $segment1 == 'user' || $segment1 == 'supplier' || $segment1 == 'member' ? 'menu-open' : null }}">
                <a href="#" class="nav-link {{ $segment1 == 'user' || $segment1 == 'supplier' || $segment1 == 'member' ? 'active' : null }}">
                  <i class="nav-icon fas fa-copy"></i>
                  <p>
                    Stakeholder
                    <i class="fas fa-angle-left right"></i>
                    <span class="badge badge-info right">3</span>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href={{ url('/user') }} class="nav-link {{ $segment1 == 'user' ? 'active' : null }}">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                            Kelola User
                        </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href={{ url('/supplier') }} class="nav-link {{ $segment1 == 'supplier' ? 'active' : null }}">
                        <i class="nav-icon fas fa-truck"></i>
                        <p>
                            Kelola Supplier
                        </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href={{ url('/member') }} class="nav-link {{ $segment1 == 'member' ? 'active' : null }}">
                        <i class="nav-icon fas fa-address-card"></i>
                        <p>
                            Member
                        </p>
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
      @endif
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
