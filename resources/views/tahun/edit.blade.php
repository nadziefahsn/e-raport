@foreach($tahun_ajarans as $item)
<div class="modal fade" id="editModal{{ $item->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius:24px;">
            <div class="modal-header border-0 pt-4 px-4">
                <h5 class="modal-title fw-bold">Edit Tahun Pelajaran</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>

            <form action="{{ route('tahun_ajaran.update', $item->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Tahun Pelajaran</label> 
                        <input type="text" name="tahun_ajaran" class="form-control rounded-3" value="{{ $item->tahun_ajaran }}" placeholder="Masukkan tahun pelajaran..." required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Semester</label>
                        <div class="mt-2">
                            <label class="mr-4">
                                <input type="radio" name="semester" value="Ganjil" {{ $item->semester == 'Ganjil' ? 'checked' : '' }} required>
                                <span class="ml-1">Semester Ganjil</span>
                            </label>
                            <label>
                                <input type="radio" name="semester" value="Genap" {{ $item->semester == 'Genap' ? 'checked' : '' }}>
                                <span class="ml-1">Semester Genap</span>
                            </label>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Kepala Sekolah</label>
                        <input type="text" name="kepala_sekolah" class="form-control" value="{{ $item->kepala_sekolah }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">NUPTK</label>
                        <input type="text" name="nuptk" class="form-control" value="{{ $item->nuptk }}" required
                         inputmode="numeric" oninput="this.value = this.value.replace(/[^0-9]/g, '')" maxlength="20">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Titimangsa</label>
                        <input type="date" name="titimangsa" class="form-control" value="{{ $item->titimangsa }}" required>
                    </div>
                </div>
                <div class="modal-footer border-0 pb-4 px-4">
                    <button type="button" class="btn btn-light py-2 px-4 fw-bold" data-dismiss="modal" style="border-radius:12px;">Kembali</button>
                    <button type="submit" class="btn btn-dark flex-grow-1 py-2 fw-bold" style="border-radius:12px;">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach