<div class="modal fade" id="modalTambahGuru" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 24px;">
            <div class="modal-header border-0 pt-4 px-4">
                <h5 class="modal-title fw-bold">Tambah Data Guru</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form action="{{ route('guru.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    
                    @if ($errors->any() & !session('edit_id'))
                        <div class="alert alert-danger mb-3">
                            <ul class="mb-0 pl-3">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Email <span class="text-danger">*</span></label>
                            <input type="email" name="email" class="form-control rounded-3" value="{{ old('email') }}" placeholder="Contoh: guru@sekolah.id" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Nama Guru <span class="text-danger">*</span></label>
                            <input type="text" name="nama_guru" class="form-control rounded-3" value="{{ old('nama_guru') }}" placeholder="Masukkan nama guru..." required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Jabatan <span class="text-danger">*</span></label>
                            <input type="text" name="jabatan" class="form-control rounded-3" value="{{ old('jabatan') }}" placeholder="Masukkan jabatan..." required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">NIP</label>
                            <input type="text" name="nip" class="form-control rounded-3" value="{{ old('nip') }}" 
                                inputmode="numeric" oninput="this.value = this.value.replace(/[^0-9]/g, '')" 
                                placeholder="Masukkan NIP (angka saja)...">
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 pb-4 px-4">
                    <button type="button" class="btn btn-secondary py-2 px-4 fw-bold" data-dismiss="modal" style="border-radius: 12px;">Kembali</button>
                    <button type="submit" class="btn btn-primary py-2 px-4 fw-bold" style="border-radius: 12px;">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>