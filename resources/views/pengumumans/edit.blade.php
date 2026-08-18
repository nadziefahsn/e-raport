@foreach($pengumumans as $item)
<div class="modal fade" id="editModal{{ $item->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 24px;">
            <div class="modal-header border-0 pt-4 px-4">
                <h5 class="modal-title font-weight-bold">Edit Data Pengumuman</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('pengumuman.update', $item->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body px-4">
                    <div class="form-group">
                        <label class="form-label font-weight-bold text-dark">Judul Pengumuman</label>
                        <input type="text" name="judul" class="form-control" value="{{ $item->judul }}" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label font-weight-bold text-dark">Isi Pengumuman</label>
                        <textarea name="isi" class="form-control summernote-edit" rows="5" required>{{ $item->isi }}</textarea>
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
@endforeach