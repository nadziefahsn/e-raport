<div class="modal fade" id="modalTambahIndikator" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 24px;">
            <div class="modal-header border-0 pt-4 px-4">
                <h5 class="modal-title fw-bold">Tambah Indikator</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            
            @if ($errors->any() && !old('_method'))
                <div class="alert alert-danger mx-4">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('indikator.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Capaian Perkembangan</label>
                        <select name="capaian_perkembangan_id" class="form-control rounded-3" required>
                            <option value="">-- Pilih Capaian Perkembangan --</option>
                            @foreach($capaians as $capaian)
                                <option value="{{ $capaian->id }}" {{ old('capaian_perkembangan_id') == $capaian->id ? 'selected' : '' }}>
                                    {{ $capaian->capaian_perkembangan }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Kode Indikator</label>
                        <input type="text" name="kode" class="form-control rounded-3" value="{{ old('kode') }}" placeholder="Contoh: 3.1" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Nama Indikator</label>
                        <textarea name="nama_indikator" class="form-control rounded-3" placeholder="Masukkan detail indikator..." rows="3" required>{{ old('nama_indikator') }}</textarea>
                    </div>

                    <div class="form-group mb-3">
                        <label class="form-label fw-bold">Jenjang</label>
                        <select name="jenjang" class="form-control rounded-3" required>
                            <option value="" disabled {{ old('jenjang') ? '' : 'selected' }}>-- Pilih Jenjang --</option>
                            <option value="TK A" {{ old('jenjang') == 'TK A' ? 'selected' : '' }}>TK A</option>
                            <option value="TK B" {{ old('jenjang') == 'TK B' ? 'selected' : '' }}>TK B</option>
                            <option value="PG" {{ old('jenjang') == 'PG' ? 'selected' : '' }}>PG</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Tahun Ajaran</label>
                        <select name="tahun_ajaran_id" class="form-control rounded-3" required>
                            <option value="" disabled {{ old('tahun_ajaran_id') ? '' : 'selected' }}>-- Pilih Tahun Ajaran --</option>
                            @foreach($tahunAjarans as $ta)
                                <option value="{{ $ta->id }}" {{ old('tahun_ajaran_id') == $ta->id ? 'selected' : '' }}>
                                    {{ $ta->tahun_ajaran }} - {{ $ta->semester == '1' || $ta->semester == 'Ganjil' ? 'Ganjil' : 'Genap' }}
                                </option>
                            @endforeach
                        </select>
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