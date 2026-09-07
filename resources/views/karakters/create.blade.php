<div class="modal fade" id="modalTambahKarakter" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 550px;">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 24px;">
            <div class="modal-header border-0 pt-4 px-4">
                <h5 class="modal-title fw-bold">Tambah Data Karakter</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('karakter.store') }}" method="post">
                @csrf
                <div class="modal-body p-4">
                    @if($errors->any() && !old('_method'))
                        <div class="alert alert-danger py-2 mb-3">
                            <small><i class="fas fa-ban mr-1"></i> {{ $errors->first('id') }}</small>
                        </div>
                    @endif
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label class="form-label fw-bold">Kode Karakter</label>
                            <input type="text" name="id" class="form-control rounded-3 @error('id') is-invalid @enderror" value="{{ old('id') }}" placeholder="Contoh: 1.1" maxlength="10" required>
                            <small class="text-muted">Maksimal 10 karakter.</small>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label fw-bold">Karakter</label>
                            <input type="text" name="karakter" class="form-control rounded-3 @error('karakter') is-invalid @enderror" value="{{ old('karakter') }}" placeholder="Karakter" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 pb-4 px-4">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        Kembali
                    </button>
                    <button type="submit" class="btn btn-dark">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>