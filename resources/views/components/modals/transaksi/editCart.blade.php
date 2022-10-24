<form id="editCartForm">
    <div class="modal" tabindex="-1" role="dialog" id="editCartModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Edit Jumlah Produk</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="input-group">
                <input type="number" min="1" class="form-control" id="cartQuantity" name="cartQuantity" placeholder="Masukkan jumlah...">
                <div class="input-group-append">
                    <span class="input-group-text">Unit</span>
                    <button type="button" class="btn btn-primary float-right" id="editCartSubmit">Ubah</button>
                </div>
            </div>
        </div>
    </div>
    </div>
</form>
