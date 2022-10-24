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
              <h1>Transaksi</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
                <li class="breadcrumb-item">Transaksi</li>
              </ol>
            </div>
          </div>
        </div><!-- /.container-fluid -->
    </section>

      <!-- Main content -->
    <section class="content">
        <div class="row justify-content-center">

{{--  Bagian Pilih Barang  --}}
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-header">
                        Pilih Barang
                    </div>
                    <div class="card-body">
                        <form id="selectProductForm">
                            <input type="hidden" name="productId" id="productId">

                            <div class="form-group">
                                <div class="input-group">
                                    <input type="text" class="form-control" id="productName" placeholder="Pilih barang..." readonly>
                                    <div class="input-group-append">
                                        <button type="button" class="btn btn-outline-secondary" onclick="selectProduct()">Pilih</button>
                                    </div>
                                </div>

                                @include('components.modals.transaksi.selectProduct')
                            </div>

                            <div class="form-group">
                                <div class="input-group">
                                    <input type="number" min="1" value="1" class="form-control" name="productQty" id="productQty" placeholder="Masukkan jumlah..." required>
                                    <div class="input-group-append">
                                        <span class="input-group-text">Unit</span>
                                    </div>
                                </div>
                            </div>

                            <button type="button" class="btn btn-primary float-right" id="createCart">Tambah</button>
                        </form>
                    </div>
                </div>
            </div>

{{--  Bagian Transaksi  --}}
            <div class="col-md-8 mb-4">
                <div class="card">
                    <div class="card-header">
                        Pembayaran
                    </div>
                    <div class="card-body">
                        <form id="createTransaksiForm">
                            <input type="hidden" name="memberId" id="memberId">

                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Total Harga</label>

                                <div class="input-group col-sm-10">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Rp</span>
                                    </div>
                                    <input type="text" class="form-control" id="totalPrice" name="totalPrice" placeholder="0" readonly required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Total Bayar</label>

                                <div class="input-group col-sm-10">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Rp</span>
                                    </div>
                                    <input type="number" class="form-control" name="totalPay" id="totalPay" placeholder="0" min="1" required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Pembayaran</label>

                                <div class="input-group col-sm-10">
                                    <select class="form-control" name="paymentStatus" id="paymentStatus">
                                        <option selected disabled>Pilih status pembayaran</option>
                                        <option name="paymentStatus" value="Paid">Tunai</option>
                                        <option name="paymentStatus" value="Unpaid">Kasbon</option>
                                      </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="input-group">
                                    <input type="text" class="form-control" id="memberName" placeholder="Pilih member..." readonly>
                                    <div class="input-group-append">
                                        <button type="button" class="btn btn-outline-secondary" onclick="selectMember()">Pilih</button>
                                    </div>
                                </div>

                                @include('components.modals.transaksi.selectMember')
                            </div>

                            <button type="button" class="btn btn-primary float-right" id="createTransaksi">Bayar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

{{--  Bagian Cart (View Table)  --}}
        <div class="table-responsive">
            <table class="table table-hover table-striped table-border" id="viewCartTable">
                <thead class="thead-dark">
                    <tr>
                        <th>#</th>
                        <th>Nama Barang</th>
                        <th>Kategori</th>
                        <th>Foto</th>
                        <th>Harga</th>
                        <th>Jumlah</th>
                        <th>Subtotal</th>
                        <th>Opsi</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
        @include('components.modals.transaksi.editCart')

    </section>
    <!-- /.content -->
@endsection
@push('script')
    @include('components.scripts.datatables')
    @include('components.scripts.sweetalert')
    @include($script)
@endpush
