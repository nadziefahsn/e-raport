<!-- Modal Edit Anggota Kelas -->
@foreach($anggotaKelas as $item)
<div class="modal fade" id="editModal{{ $item->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 24px;">
            <div class="modal-header border-0 pt-4 px-4">
                <h5 class="modal-title fw-bold">Edit Anggota Kelas</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            
            <form action="{{ route('anggota-kelas.update', $item->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-bold">NIS Siswa</label>
                        <select name="nis_id" id="nis_id_edit_{{ $item->id }}" class="form-control rounded-3 select-nis-edit" data-id="{{ $item->id }}" required>
                            <option value="">-- Pilih NIS --</option>
                            @foreach($siswas as $siswa)
                                <option value="{{ $siswa->nis }}" data-nama="{{ $siswa->nama_siswa }}" {{ $item->nis_id == $siswa->nis ? 'selected' : '' }}>
                                    {{ $siswa->nis }} - {{ $siswa->nama_siswa }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Nama Siswa</label>
                        <input type="text" id="nama_siswa_edit_{{ $item->id }}" class="form-control rounded-3 bg-light" value="{{ optional($item->siswa)->nama_siswa }}" placeholder="Nama akan terisi otomatis" readonly>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Kelas / Rombel</label>
                        <select name="kelas_id" class="form-control rounded-3" required>
                            <option value="">-- Pilih Kelas --</option>
                            @foreach($kelas as $k)
                                <option value="{{ $k->id }}" {{ $item->kelas_id == $k->id ? 'selected' : '' }}>
                                    {{ $k->rombel }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                
                <div class="modal-footer border-0 pb-4 px-4">
                    <button type="button" class="btn btn-light py-2 px-4 fw-bold" data-dismiss="modal" style="border-radius: 12px;">Kembali</button>
                    <button type="submit" class="btn btn-dark flex-grow-1 py-2 fw-bold" style="border-radius: 12px;">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

<!-- JavaScript Autofill Dynamic Update untuk Modal Edit Loop -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const editSelects = document.querySelectorAll('.select-nis-edit');

        editSelects.forEach(select => {
            select.addEventListener('change', function () {
                const itemId = this.getAttribute('data-id');
                const namaInput = document.getElementById('nama_siswa_edit_' + itemId);
                const selectedOption = this.options[this.selectedIndex];
                const namaSiswa = selectedOption.getAttribute('data-nama') || '';
                
                if (namaInput) {
                    namaInput.value = namaSiswa;
                }
            });
        });
    });
</script>