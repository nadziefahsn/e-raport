<!-- Modal Tambah Anggota Kelas -->
<div class="modal fade" id="modalTambahAnggotaKelas" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 24px;">
            <div class="modal-header border-0 pt-4 px-4">
                <h5 class="modal-title fw-bold">Tambah Anggota Kelas</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            
            @if ($errors->any())
                <div class="alert alert-danger mx-4">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('anggota-kelas.store') }}" method="post">
                @csrf
                <div class="modal-body p-4">
                    <!-- Dropdown Pilih NIS -->
                    <div class="mb-3">
                        <label class="form-label fw-bold">NIS Siswa</label>
                        <select name="nis_id" id="nis_id_create" class="form-control rounded-3" required>
                            <option value="">-- Pilih NIS --</option>
                            @foreach($siswas as $siswa)
                                <option value="{{ $siswa->nis }}" data-nama="{{ $siswa->nama_siswa }}" {{ old('nis_id') == $siswa->nis ? 'selected' : '' }}>
                                    {{ $siswa->nis }} - {{ $siswa->nama_siswa }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Input Nama Siswa (Autofill & Readonly) -->
                    <div class="mb-3">
                        <label class="form-label fw-bold">Nama Siswa</label>
                        <input type="text" id="nama_siswa_create" class="form-control rounded-3 bg-light" placeholder="Nama akan terisi otomatis" readonly>
                    </div>

                    <!-- Dropdown Pilih Kelas -->
                    <div class="mb-3">
                        <label class="form-label fw-bold">Kelas / Rombel</label>
                        <select name="kelas_id" class="form-control rounded-3" required>
                            <option value="">-- Pilih Kelas --</option>
                            @foreach($kelas as $k)
                                <option value="{{ $k->id }}" {{ old('kelas_id') == $k->id ? 'selected' : '' }}>
                                    {{ $k->rombel }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="modal-footer border-0 pb-4 px-4">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- JavaScript Autofill Nama Siswa -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const nisSelect = document.getElementById('nis_id_create');
        const namaInput = document.getElementById('nama_siswa_create');

        function updateNamaSiswa() {
            const selectedOption = nisSelect.options[nisSelect.selectedIndex];
            const namaSiswa = selectedOption.getAttribute('data-nama') || '';
            namaInput.value = namaSiswa;
        }

        // Jalankan saat dropdown NIS berubah
        nisSelect.addEventListener('change', updateNamaSiswa);

        // Jalankan otomatis saat pertama kali dibuka (jika ada nilai old)
        if (nisSelect.value) {
            updateNamaSiswa();
        }
    });
</script>