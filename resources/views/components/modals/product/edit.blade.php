<form id="editForm">
    <div class="modal" tabindex="-1" role="dialog" id="editModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Edit Produk</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="form-group">
                <label for="name">Nama Produk</label>
                <input type="text" class="form-control" id="name" name="name">
            </div>
            <div class="form-group">
                <label for="product_category_id">Kategori Produk</label>
                <select name="product_category_id" id="product_category_id" class="form-control">
                    @foreach($productCategories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="detail">Detail</label>
                <input type="text" class="form-control" id="detail" name="detail">
            </div>
            <div class="form-group">
                <label for="price">Harga</label>
                <input type="text" class="form-control price" id="price" name="price">
            </div>
            <div class="form-group">
                <label for="stok">Stok</label>
                <input type="text" class="form-control" id="stok" name="stok">
            </div>
            <div class="form-group">
                <label for="image">Gambar Post</label>
                <input type="file" id="image" name="image" class="form-control"
                    required data-allowed-file-extensions="jpg png"
                    data-max-file-size-preview="3M"
                    data-max-file-size="3M">
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" id="editSubmit">Save changes</button>
        </div>
        </div>
    </div>
    </div>
</form>
