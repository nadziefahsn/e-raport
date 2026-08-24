@extends('adminlte::page')

@section('title', 'Kesehatan Telinga')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h1 class="m-0 font-weight-bold">Kesehatan Telinga</h1>
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
        <li class="breadcrumb-item active">Kesehatan Telinga</li>
    </ol>
</div>
@stop

@section('content')
<div class="container-fluid">
    <form action="{{ route('kesehatan-telinga.update', 1) }}" method="POST">
        @csrf
        @method('PUT')
        <input type="hidden" name="guru_id" value="{{ request('guru_id') }}">

        <div class="card shadow-sm border-0 mb-5">
            <div class="card-header bg-white py-3 px-4">
                <h5 class="card-title fw-bold mb-1">
                    <i class="fas fa-deaf mr-2"></i> Input Kesehatan Telinga Siswa
                </h5>
            </div>

            <div class="card-body p-4">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle mb-0">
                        <thead class="text-white text-center" style="background-color:#17a2b8;">
                            <tr>
                                <th rowspan="2" class="align-middle" style="width:5%;">No</th>
                                <th rowspan="2" class="align-middle" style="width:12%;">Nomor Induk</th>
                                <th rowspan="2" class="align-middle">Nama Siswa</th>
                                <th colspan="2" class="align-middle">Pendengaran</th>
                                <th colspan="2" class="align-middle">Radang</th>
                            </tr>
                            <tr>
                                <th class="align-middle" style="width:12%;">Kanan</th>
                                <th class="align-middle" style="width:12%;">Kiri</th>
                                <th class="align-middle" style="width:12%;">Kanan</th>
                                <th class="align-middle" style="width:12%;">Kiri</th>
                            </tr>
                        </thead>
                        <tbody>
                        @forelse($kesehatanTelingas as $item)
                            <tr>
                                <td class="text-center align-middle">{{ $loop->iteration }}</td>
                                <td class="text-center align-middle">{{ $item->siswa->nis ?? '-' }}</td>
                                <td class="align-middle">{{ $item->siswa->nama_siswa ?? '-' }}</td>

                                <input type="hidden" name="anggota_kelas_id[]" value="{{ $item->id }}">

                                <td>
                                    <select name="pendengaran_kanan[]" class="form-control">
                                        <option value="" {{ !$item->kesehatanTelinga ? 'selected' : '' }}></option>
                                        <option value="Baik" {{ ($item->kesehatanTelinga->pendengaran_kanan ?? '') == 'Baik' ? 'selected' : '' }}>Baik</option>
                                        <option value="Kurang baik" {{ ($item->kesehatanTelinga->pendengaran_kanan ?? '') == 'Kurang baik' ? 'selected' : '' }}>Kurang baik</option>
                                    </select>
                                </td>

                                <td>
                                    <select name="pendengaran_kiri[]" class="form-control">
                                        <option value="" {{ !($item->kesehatanTelinga->pendengaran_kiri ?? null) ? 'selected' : '' }}></option>
                                        <option value="Baik" {{ ($item->kesehatanTelinga->pendengaran_kiri ?? '') == 'Baik' ? 'selected' : '' }}>Baik</option>
                                        <option value="Kurang baik" {{ ($item->kesehatanTelinga->pendengaran_kiri ?? '') == 'Kurang baik' ? 'selected' : '' }}>Kurang baik</option>
                                    </select>
                                </td>

                                <td>
                                    <select name="radang_kanan[]" class="form-control">
                                        <option value="" {{ !($item->kesehatanTelinga->radang_kanan ?? null) ? 'selected' : '' }}></option>
                                        <option value="Baik" {{ ($item->kesehatanTelinga->radang_kanan ?? '') == 'Baik' ? 'selected' : '' }}>Baik</option>
                                        <option value="Kurang Baik" {{ ($item->kesehatanTelinga->radang_kanan ?? '') == 'Kurang Baik' || ($item->telinga->radang_kanan ?? '') == 'Kuang Baik' ? 'selected' : '' }}>Kurang Baik</option>
                                    </select>
                                </td>

                                <td>
                                    <select name="radang_kiri[]" class="form-control">
                                        <option value="" {{ !($item->kesehatanTelinga->radang_kiri ?? null) ? 'selected' : '' }}></option>
                                        <option value="Baik" {{ ($item->kesehatanTelinga->radang_kiri ?? '') == 'Baik' ? 'selected' : '' }}>Baik</option>
                                        <option value="Kurang Baik" {{ ($item->kesehatanTelinga->radang_kiri ?? '') == 'Kurang Baik' ? 'selected' : '' }}>Kurang Baik</option>
                                    </select>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-4 text-muted">
                                    Data anggota kelas belum tersedia.
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card-footer bg-white text-right py-3 px-4">
                <button type="submit" class="btn btn-info text-white px-4">
                    <i class="fas fa-save mr-1"></i> Simpan
                </button>
            </div>
        </div>
    </form>
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
@stop