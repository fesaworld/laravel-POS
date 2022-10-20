<form id="createForm">
    <div class="modal" tabindex="-1" role="dialog" id="createModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Tambah User</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="form-group">
                <label for="createName">Nama User</label>
                <input type="text" class="form-control" id="createName" name="name">
            </div>
            <div class="form-group">
                <label for="createEmail">Email</label>
                <input type="email" class="form-control" id="createEmail" name="email">
            </div>
            <div class="form-group">
                <label for="createStatus">Status User</label>
                <select name="user_role" id="createStatus" class="form-control">
                    <option value="" selected disabled>Pilih Kategori</option>
                    @foreach($status as $user_status)
                        <option value="{{ $user_status->id }}">{{ $user_status->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="createPass">Password</label>
                <input type="password" class="form-control" id="createPass" name="pass">
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" id="createSubmit">Save changes</button>
        </div>
        </div>
    </div>
    </div>
</form>
