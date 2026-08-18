@extends('adminlte::page')

@section('title', 'Peserta Didik')

@section('content_header')
    <h1>Peserta Didik</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header d-flex align-items-center">
        <h3 class="card-title mb-0"><i class="fas fa-user-graduate mr-2"></i>Data Peserta Didik</h3>

        <div class="card-tools ml-auto">
            <button type="button" class="btn btn-light px-4 py-2 rounded-4 fw-bold" data-toggle="modal" data-target="#modalTambahSiswa">
                <i class="fas fa-plus"></i>
            </button>
        </div>
    </div>

    @php
        $heads = [
            ['label' => 'No', 'width' => 5],
            'NIS/NISN',
            'Nama Siswa',
            'Tanggal Lahir',
            'L/P',
            'Kelas Saat Ini',
            ['label' => 'Aksi', 'no-export' => true, 'width' => 10, 'className' => 'text-center'],
        ];

        $config = [
            'order' => [[0, 'asc']],
            'searching' => true,
            'lengthChange' => true,
            'columns' => [null, null, null, null, null, null, ['orderable' => false]],
        ];
    @endphp

    <div class="card-body p-3">
        <x-adminlte-datatable id="tableSiswa" :heads="$heads" :config="$config" stripe hoverable buffered text-sm>
            @forelse($siswas as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->nis }} / {{ $item->nisn ?? '-' }}</td>
                    <td>{{ $item->nama_siswa }}</td>
                    <td>{{ $item->tanggal_lahir }}</td>
                    <td>{{ $item->jenis_kelamin }}</td>
                    <td>{{ $item->kelas?->rombel ?? '-' }}</td>
                    <td class="text-center">
                        <nobr>
                            <button type="button" class="btn btn-xs btn-default text-primary mx-1 shadow" title="Edit" data-toggle="modal" data-target="#editModal{{ $item->nis }}">
                                <i class="fa fa-lg fa-fw fa-pen"></i>
                            </button>
                            <form action="{{ route('siswa.destroy', $item->nis) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-xs btn-default text-danger mx-1 shadow" title="Delete" onclick="return confirm('Hapus data siswa ini?')">
                                    <i class="fa fa-lg fa-fw fa-trash"></i>
                                </button>
                            </form>

                        </nobr>
                    </td>
                </tr>
            @empty
            @endforelse
        </x-adminlte-datatable>
    </div>
</div>

{{-- edit --}}
@foreach($siswas as $item)
<div class="modal fade" id="editModal{{ $item->nis }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 24px;">
            <div class="modal-header border-0 pt-4 px-4">
                <h5 class="modal-title fw-bold">Edit Data Siswa</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('siswa.update', $item->nis) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body p-4">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">NIS</label>
                            <input type="text" name="nis" class="form-control rounded-3" value="{{ $item->nis }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Nama Siswa</label>
                            <input type="text" name="nama_siswa" class="form-control rounded-3" value="{{ $item->nama_siswa }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">NISN</label>
                            <input type="text" name="nisn" class="form-control rounded-3" value="{{ $item->nisn }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold d-block mb-2">Jenis Kelamin</label>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="jenis_kelamin" id="laki{{ $item->nis }}" value="Laki-laki" {{ $item->jenis_kelamin == 'Laki-laki' ? 'checked' : '' }} required>
                                <label class="form-check-label" for="laki{{ $item->nis }}">Laki-laki</label>
                            </div>

                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="jenis_kelamin" id="perempuan{{ $item->nis }}" value="Perempuan" {{ $item->jenis_kelamin == 'Perempuan' ? 'checked' : '' }}>
                                <label class="form-check-label" for="perempuan{{ $item->nis }}">Perempuan</label>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Tempat Lahir</label>
                            <input type="text" name="tempat_lahir" class="form-control rounded-3" value="{{ $item->tempat_lahir }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Tanggal Lahir</label>
                            <input type="date" name="tanggal_lahir" class="form-control rounded-3" value="{{ $item->tanggal_lahir }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Agama</label>
                            <select name="agama" class="form-control rounded-3" required>
                                <option value="">-- Pilih Agama --</option>
                                <option value="Islam" {{ $item->agama == 'Islam' ? 'selected' : '' }}>Islam</option>
                                <option value="Kristen Protestan" {{ $item->agama == 'Kristen Protestan' ? 'selected' : '' }}>Kristen Protestan</option>
                                <option value="Katolik" {{ $item->agama == 'Katolik' ? 'selected' : '' }}>Katolik</option>
                                <option value="Hindu" {{ $item->agama == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                                <option value="Buddha" {{ $item->agama == 'Buddha' ? 'selected' : '' }}>Buddha</option>
                                <option value="Khonghucu" {{ $item->agama == 'Khonghucu' ? 'selected' : '' }}>Khonghucu</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Telepon</label>
                            <input type="number" name="telepon" class="form-control rounded-3" value="{{ $item->telepon }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Nama Ayah</label>
                            <input type="text" name="nama_ayah" class="form-control rounded-3" value="{{ $item->nama_ayah }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Nama Ibu</label>
                            <input type="text" name="nama_ibu" class="form-control rounded-3" value="{{ $item->nama_ibu }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Pekerjaan Ayah</label>
                            <input type="text" name="pekerjaan_ayah" class="form-control rounded-3" value="{{ $item->pekerjaan_ayah }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Pekerjaan Ibu</label>
                            <input type="text" name="pekerjaan_ibu" class="form-control rounded-3" value="{{ $item->pekerjaan_ibu }}" required>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label fw-bold">Alamat</label>
                            <textarea name="alamat" class="form-control rounded-3" rows="2" required>{{ $item->alamat }}</textarea>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Kelas</label>
                            <select name="kelas_id" class="form-control rounded-3" required>
                                <option value="" disable>-- Pilih Kelas --</option>
                                    @foreach ($kelas as $k )
                                    <option value="{{ $k->id }}" 
                                        {{ $item->kelas_id == $k->id ? 'selected' : '' }}>
                                        {{ $k->rombel }}
                                    </option>
                                    @endforeach>
                            </select>
                        </div>
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

{{-- tambah data --}}
<div class="modal fade" id="modalTambahSiswa" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 24px;">
            <div class="modal-header border-0 pt-4 px-4">
                <h5 class="modal-title fw-bold">Tambah Data Siswa</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('siswa.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">NIS</label>
                            <input type="text" name="nis" class="form-control rounded-3" placeholder=" NIS" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Nama Siswa</label>
                            <input type="text" name="nama_siswa" class="form-control rounded-3" placeholder=" Nama Siswa" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">NISN</label>
                            <input type="text" name="nisn" class="form-control rounded-3" placeholder=" NISN">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold d-block mb-2">Jenis Kelamin</label>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="jenis_kelamin" id="lakiTambah" value="Laki-laki" required>
                                <label class="form-check-label" for="lakiTambah">Laki-laki</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="jenis_kelamin" id="perempuanTambah" value="Perempuan">
                                <label class="form-check-label" for="perempuanTambah">Perempuan</label>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Tempat Lahir</label>
                            <input type="text" name="tempat_lahir" class="form-control rounded-3" placeholder=" Tempat Lahir" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Tanggal Lahir</label>
                            <input type="date" name="tanggal_lahir" class="form-control rounded-3" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Agama</label>
                            <select name="agama" class="form-control rounded-3" required>
                                <option value="">-- Pilih Agama --</option>
                                <option value="Islam">Islam</option>
                                <option value="Kristen Protestan">Kristen Protestan</option>
                                <option value="Katolik">Katolik</option>
                                <option value="Hindu">Hindu</option>
                                <option value="Buddha">Buddha</option>
                                <option value="Khonghucu">Khonghucu</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Telepon</label>
                            <input type="number" name="telepon" class="form-control rounded-3" placeholder=" Nomor HP" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Nama Ayah</label>
                            <input type="text" name="nama_ayah" class="form-control rounded-3" placeholder=" Nama Ayah" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Nama Ibu</label>
                            <input type="text" name="nama_ibu" class="form-control rounded-3" placeholder=" Nama Ibu" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Pekerjaan Ayah</label>
                            <input type="text" name="pekerjaan_ayah" class="form-control rounded-3" placeholder=" Pekerjaan Ayah" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Pekerjaan Ibu</label>
                            <input type="text" name="pekerjaan_ibu" class="form-control rounded-3" placeholder=" Pekerjaan Ibu" required>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label fw-bold">Alamat</label>
                            <textarea name="alamat" class="form-control rounded-3" rows="2" placeholder=" Alamat Lengkap" required></textarea>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Kelas</label>
                            <select name="kelas_id" class="form-control rounded-3" required>
                                <option value="" selected disabled>-- Pilih Kelas --</option>
                                @foreach($kelas as $k)
                                    <option value="{{ $k->id }}">
                                        {{ $k->rombel }}
                                    </option>
                                @endforeach
                            </select>
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
@stop


@section('footer')
<div class="row align-items-center">
    <div class="col-12 col-md-6 text-center text-md-left mb-2 mb-md-0">
        <strong>Copyright &copy; {{ date('Y') }} | <a href="#">Yayasan Prima Insani</a>.</strong>
    </div>
    <div class="col-12 col-md-6 text-center text-md-right">
        <b>E-Raport</b>
    </div>
</div>                           
@stop


@section('css')
<style>
    .table tbody td { font-weight: normal !important; }
    .table thead th { font-weight: 600 !important; }
</style>
@stop


@section('js')
<script>
    console.log("Halaman Peserta Didik berhasil dimuat.");
</script>
@stop