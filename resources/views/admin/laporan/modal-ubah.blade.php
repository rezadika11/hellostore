<!-- Default Modals -->

<div id="modal-ubah" class="modal fade" tabindex="-1" aria-labelledby="modalHapus" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <form action="{{ route('laporan.refresh') }}" method="post">
            @csrf
            @method('post')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalHapus">Ubah Periode</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> </button>
                </div>
                <div class="modal-body">
                    <div class="form-group row mb-3">
                        <label for="tanggal_awal" class="col-lg-2 col-lg-offset-1 control-label">Tanggal Awal</label>
                        <div class="col-lg-10">
                            <input type="text" name="tanggal_awal" id="tanggal_awal" class="form-control flatpickr"
                                data-date-format="Y-m-d" required autofocus value="{{ request('tanggal_awal') }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="tanggal_akhir" class="col-lg-2 col-lg-offset-1 control-label">Tanggal Akhir</label>
                        <div class="col-lg-10">
                            <input type="text" name="tanggal_akhir" id="tanggal_akhir" class="form-control flatpickr"
                                data-date-format="Y-m-d" required
                                value="{{ request('tanggal_akhir') ?? date('Y-m-d') }}">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-primary">Update</button>
                    <button type="button" class="btn btn-sm btn-light" data-bs-dismiss="modal">Batal</button>
                </div>
            </div><!-- /.modal-content -->
        </form>
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
