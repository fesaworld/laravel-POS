@extends('layouts.app')

@section('content')
    @push('style')
        @include('components.styles.datatables')
        @include('components.styles.dropify')

    @endpush
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>Riwayat Stok</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
                <li class="breadcrumb-item">Riwayat Stok</li>
              </ol>
            </div>
          </div>
        </div><!-- /.container-fluid -->
      </section>

      <!-- Main content -->
      <section class="content">

        <!-- Default box -->
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Daftar Riwayat Stok</h3>

          </div>
          <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-striped table-border" id="table">
                    <thead>
                        <th>#</th>
                        <th>Nama Produk</th>
                        <th>Nama Supplier</th>
                        <th>Nama Admin</th>
                        <th>Stok Masuk</th>
                        <th>Stok Keluar</th>
                        <th>Tanggal Transaksi</th>
                        <th>Detail</th>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
          </div>
        </div>
        <!-- /.card -->

      </section>
      <!-- /.content -->
      @push('script')
        @include('components.scripts.sweetalert')
        @include('components.scripts.datatables')
        @include($script)
      @endpush
@endsection
