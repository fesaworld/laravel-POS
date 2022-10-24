<form id="showForm">
    <div class="modal" tabindex="-1" role="dialog" id="showModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Detail Transaksi</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="form-group">
                <label for="showName">Nama Barang</label>
                <input type="text" class="form-control" id="showName" name="name">
            </div>
            <div class="form-group">
                <label for="showKategori">Kategori</label>
                <input type="text" class="form-control" id="showKategori" name="kategori">
            </div>
            <div class="form-group">
                <label for="showFoto">Foto</label>
                <textarea class="form-control" id="showFoto" name="foto"></textarea>
            </div>
            <div class="form-group">
                <label for="showHarga">Harga</label>
                <textarea class="form-control" id="showHarga" name="harga"></textarea>
            </div>
            <div class="form-group">
                <label for="showJumlah">Jumlah</label>
                <textarea class="form-control" id="showJumlah" name="jumlah"></textarea>
            </div>
            <div class="form-group">
                <label for="showSubtotal">Subtotal</label>
                <textarea class="form-control" id="showSubtotal" name="subtotal"></textarea>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" id="showSubmit">Save changes</button>
        </div>
        </div>
    </div>
    </div>
</form>
