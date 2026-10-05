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
                            <label class="form-label fw-bold">NIPY</label>
                            <input type="text" name="nip" class="form-control rounded-3" value="{{ old('nip') }}" 
                                inputmode="numeric" oninput="this.value = this.value.replace(/[^0-9]/g, '')" 
                                placeholder=" NIPY" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Nama Guru <span class="text-danger">*</span></label>
                            <input type="text" name="nama_guru" class="form-control rounded-3" value="{{ old('nama_guru') }}" placeholder="Nama lengkap" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Akun <span class="text-danger">*</span></label>
                            <input type="text" name="email" class="form-control rounded-3" value="{{ old('email') }}" placeholder="Gunakan NIPY" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Jabatan <span class="text-danger">*</span></label>
                            <input type="text" name="jabatan" class="form-control rounded-3" value="{{ old('jabatan') }}" placeholder="Jabatan">
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