<form id="createForm">
    <div class="modal" tabindex="-1" role="dialog" id="createModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Produk</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="createName">Nama Produk</label>
                        <input type="text" class="form-control" id="createName" name="name">
                    </div>
                    <div class="form-group">
                        <label for="createProductCategory">Kategori Produk</label>
                        <select name="product_category_id" id="createProductCategory" class="form-control">
                            <option value="" selected disabled>Pilih Kategori</option>
                            @foreach ($productCategories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="createProductSupplier">Supplier Produk</label>
                        <select name="product_supplier_id" id="createProductSupplier" class="form-control">
                            <option value="" selected disabled>Pilih Supplier</option>
                            @foreach ($productSuppliers as $supplier)
                                <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="createDetail">Detail</label>
                        <input type="text" class="form-control" id="createDetail" name="detail">
                    </div>
                    <div class="form-group">
                        <label for="createPriceBuy">Harga Beli</label>
                        <input type="text" class="form-control price" id="createPriceBuy" name="priceBuy">
                    </div>
                    <div class="form-group">
                        <label for="createPriceSell">Harga Jual</label>
                        <input type="text" class="form-control price" id="createPriceSell" name="priceSell">
                    </div>
                    <div class="form-group">
                        <label for="createStok">Stok</label>
                        <input type="number" class="form-control" id="createStok" name="stok">
                    </div>
                    <div class="form-group">
                        <label for="createImage">Gambar Post</label>
                        <input type="file" id="createImage" name="image" class="form-control"
                            required data-allowed-file-extensions="jpg png"
                            data-max-file-size-preview="3M"
                            data-max-file-size="3M">
                    </div>
                    <?php
                    // $j = 0;

                    for ($x = 0; $x <= 10; $x++) { ?>

                    <?php if ($x % 2 == 1) { ?>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                            <label class="form-check-label" for="defaultCheck1">
                                Susu <?= $x ?>
                            </label>
                        </div>
                    <?php } else { ?>
                            <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                            <label class="form-check-label" for="defaultCheck1">
                                Susu
                            </label>
                        </div>
                    <?php } ?>
                    <?php }?>
                    <div class="row">
                        <div class="form-check col-sm-6">
                            <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                            <label class="form-check-label" for="defaultCheck1">
                                Susu
                            </label>
                        </div>
                        <div class="form-check col-sm-6">
                            <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                            <label class="form-check-label" for="defaultCheck1">
                                Teh
                            </label>
                        </div>
                    </div>

                    {{-- <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <div class="input-group-text">
                    <input type="checkbox" aria-label="Checkbox for following text input">
                  </div>
                </div>
                <input type="text" class="form-control" aria-label="Text input with checkbox">
            </div> --}}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="createSubmit">Save changes</button>
                </div>
            </div>
        </div>
    </div>
</form>
