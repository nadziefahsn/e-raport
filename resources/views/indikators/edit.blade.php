@foreach($indikators as $item)
<div class="modal fade" id="editModal{{ $item->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 24px;">
            <div class="modal-header border-0 pt-4 px-4">
                <h5 class="modal-title fw-bold">Edit Indikator</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            
            @if ($errors->any() && old('old_id') == $item->id)
                <div class="alert alert-danger mx-4">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('indikator.update', $item->id) }}" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="old_id" value="{{ $item->id }}">

                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Capaian Perkembangan</label>
                        <select name="capaian_perkembangan_id" class="form-control rounded-3" required>
                            <option value="" disabled>-- Pilih Capaian Perkembangan --</option>
                            @foreach($capaians as $capaian)
                                <option value="{{ $capaian->id }}" {{ old('capaian_perkembangan_id', $item->capaian_perkembangan_id) == $capaian->id ? 'selected' : '' }}>
                                    {{ $capaian->capaian_perkembangan }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Kode Indikator</label>
                        <input type="text" name="kode" class="form-control rounded-3" value="{{ old('kode', $item->kode) }}" placeholder="Contoh: 3.1" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Nama Indikator</label>
                        <textarea name="nama_indikator" class="form-control rounded-3" rows="3" required>{{ old('nama_indikator', $item->nama_indikator) }}</textarea>
                    </div>

                    <div class="form-group mb-3">
                        <label class="form-label fw-bold">Jenjang</label>
                        <select name="jenjang" class="form-control rounded-3" required>
                            <option value="" disabled>-- Pilih Jenjang --</option>
                            <option value="TK A" {{ old('jenjang', $item->jenjang) == 'TK A' ? 'selected' : '' }}>TK A</option>
                            <option value="TK B" {{ old('jenjang', $item->jenjang) == 'TK B' ? 'selected' : '' }}>TK B</option>
                            <option value="PG" {{ old('jenjang', $item->jenjang) == 'PG' ? 'selected' : '' }}>PG</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Tahun Ajaran</label>
                        <select name="tahun_ajaran_id" class="form-control rounded-3" required>
                            @if($item->tahunAjaran)
                                <option value="{{ $item->tahun_ajaran_id }}" selected>
                                    {{ $item->tahunAjaran->tahun_ajaran }} - {{ $item->tahunAjaran->semester == '1' || $item->tahunAjaran->semester == 'Ganjil' ? 'Ganjil' : 'Genap' }}
                                </option>
                            @elseif($tahunAjaranAktif)
                                <option value="{{ $tahunAjaranAktif->id }}" selected>
                                    {{ $tahunAjaranAktif->tahun_ajaran }} - {{ $tahunAjaranAktif->semester == '1' || $tahunAjaranAktif->semester == 'Ganjil' ? 'Ganjil' : 'Genap' }}
                                </option>
                            @else
                                <option value="" disabled selected>-- Belum Ada Data Tahun Ajaran --</option>
                            @endif
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