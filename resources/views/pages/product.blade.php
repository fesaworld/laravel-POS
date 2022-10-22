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
              <h1>Produk</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
                <li class="breadcrumb-item">Produk</li>
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
            <h3 class="card-title">Daftar Produk</h3>

          </div>
          <div class="card-body">
            <div class="table-responsive">
                @can('create_product')
                    <button type="button" class="my-3 btn btn-primary" onclick="create()">Tambah Produk</button>
                @endcan
                <table class="table table-hover table-striped table-border" id="table">
                    <thead>
                        <th>#</th>
                        <th>Nama Produk</th>
                        <th>Kategori</th>
                        <th>Supplier</th>
                        <th>Detail</th>
                        <th>Harga Beli</th>
                        <th>Harga Jual</th>
                        <th>Stok</th>
                        <th>Status</th>
                        <th>Image</th>
                        <th>Tindakan</th>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
          </div>
        </div>
        @include('components.modals.product.create')
        @include('components.modals.product.edit')
        <!-- /.card -->

      </section>
      <!-- /.content -->
      @push('script')
        @include('components.scripts.sweetalert')
        @include('components.scripts.datatables')
        @include('components.scripts.dropify')
        @include($script)
      @endpush
@endsection
