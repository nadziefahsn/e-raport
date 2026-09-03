@extends('adminlte::page')

@section('title', 'Kesehatan Gigi')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h1 class="m-0">Kesehatan Gigi</h1>
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
        <li class="breadcrumb-item active">Kesehatan Gigi</li>
    </ol>
</div>
@stop

@section('content')
<div class="container-fluid">
    <form action="{{ route('gigi.update', 1) }}" method="POST">
        @csrf
        @method('PUT')
        <input type="hidden" name="guru_id" value="{{ request('guru_id') }}">

        <div class="card shadow-sm border-0 mb-5">
            <div class="card-header bg-white py-3 px-4">
                <h5 class="card-title fw-bold mb-1">
                    <i class="fas fa-tooth mr-2"></i> Input Kesehatan Gigi
                </h5>
            </div>

            <div class="card-body p-4">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle mb-0">
                        <thead class="text-white text-center" style="background-color:#17a2b8;">
                            <tr>
                                <th style="width:5%;">No</th>
                                <th style="width:12%;">NIS</th>
                                <th>Nama Siswa</th>
                                <th style="width:10%;">Kelas</th>
                                <th style="width:15%;">Kondisi Gigi</th>
                                <th style="width:20%;">Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                        @forelse($kesehatanGigis as $item)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td class="text-center">{{ $item->siswa->nis ?? '-' }}</td>
                                <td>{{ $item->siswa->nama_siswa ?? '-' }}</td>
                                <td class="text-center">{{ $item->kelas->rombel ?? '-' }}</td>

                                <input type="hidden" name="anggota_kelas_id[]" value="{{ $item->id }}">

                                <td>
                                    <select name="kesehatan_gigi[]" class="form-control">
                                        <option value="" {{ !$item->kesehatanGigi ? 'selected' : '' }}>-- Pilih Kondisi --</option>
                                        <option value="Baik" {{ ($item->kesehatanGigi->kesehatan_gigi ?? '') == 'Baik' ? 'selected' : '' }}>Baik</option>
                                        <option value="Kurang baik" {{ ($item->kesehatanGigi->kesehatan_gigi ?? '') == 'Kurang baik' ? 'selected' : '' }}>Kurang baik</option>
                                    </select>
                                </td>

                                <td>
                                    <input type="text" name="keterangan[]" value="{{ $item->kesehatanGigi->keterangan ?? '' }}" class="form-control">
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4 text-muted">
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