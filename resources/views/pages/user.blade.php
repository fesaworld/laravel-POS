@extends('layouts.app')

@section('content')
    @push('style')
        @include('components.styles.datatables')
    @endpush
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>User</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
                <li class="breadcrumb-item">User</li>
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
            <h3 class="card-title">Daftar User</h3>

          </div>
          <div class="card-body">
            <div class="table-responsive">
                    <button type="button" class="my-3 btn btn-primary" onclick="create()">Tambah User</button>
                <table class="table table-hover table-striped table-border" id="table">
                    <thead>
                        <th>#</th>
                        <th>Nama User</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>Tindakan</th>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
          </div>
        </div>
        @include('components.modals.user.create')
        @include('components.modals.user.edit')
        <!-- /.card -->

      </section>
      <!-- /.content -->
      @push('script')
        @include('components.scripts.datatables')
        @include('components.scripts.sweetalert')
        @include($script)
      @endpush
@endsection
