<div class="modal fade" id="modalTambahPengumuman" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-dark">Posting Pengumuman Baru</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <form action="{{ route('pengumuman.store') }}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label class="form-label fw-bold text-dark" >Judul Pengumuman</label>
                        <input type="text" name="judul" class="form-control" placeholder="Judul">
                    </div>
                    <div class="form-group">
                        <label class="form-label fw-bold text-dark">Isi Pengumuman</label>
                        <textarea name="isi" id="isi_pengumuman" class="form-control"></textarea>
                    </div>
                </div>
                <div class="modal-footer border-0 pb-4 px-4">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        Batal
                    </button>
                    <button type="submit" class="btn btn-primary">
                        Simpan
                    </button>
                </div>
            </form>
        </div>  
    </div>
</div>  