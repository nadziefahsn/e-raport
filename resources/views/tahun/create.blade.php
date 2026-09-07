<div class="modal fade" id="exampleModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius:24px;">
            <div class="modal-header border-0 pt-4 px-4">
                <h5 class="modal-title fw-bold">Tambah Tahun Pelajaran</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <form action="{{ route('tahun_ajaran.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Tahun Pelajaran</label>
                        <input type="text" name="tahun_ajaran" class="form-control" placeholder="Masukkan tahun pelajaran..." value="{{ old('tahun_ajaran') }}" style="border-radius:14px;padding:12px;" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Semester</label>
                        <div class="mt-2">
                            <label class="mr-4">
                                <input type="radio" name="semester" value="1" {{ old('semester') == '1' ? 'checked' : '' }} required>
                                <span class="ml-1">Semester Ganjil</span>
                            </label>
                            <label>
                                <input type="radio" name="semester" value="2" {{ old('semester') == '2' ? 'checked' : '' }}>
                                <span class="ml-1">Semester Genap</span>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 pb-4 px-4">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Kembali</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>