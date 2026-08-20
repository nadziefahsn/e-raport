@extends('adminlte::page')

@section('title', 'Data Kehadiran')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h1 class="m-0 font-weight-bold">Data Kehadiran Siswa</h1>
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
        <li class="breadcrumb-item active">Kehadiran</li>
    </ol>
</div>
@stop

@section('content')
<div class="container-fluid">
        <form action="{{ route('kehadiran.update', 1) }}" method="POST">
        @csrf
        @method('PUT')

        <input type="hidden" name="guru_id" value="{{ request('guru_id') }}">

        <div class="card shadow-sm border-0 mb-5">
            <div class="card-header bg-white py-3 px-4">
                <h5 class="card-title fw-bold mb-1">
                    <i class="fas fa-user-check mr-2"></i> Input Kehadiran Siswa
                </h5>
            </div>

            <div class="card-body p-4">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle mb-0">
                        <thead class="text-white text-center" style="background-color: #17a2b8;">
                            <tr>
                                <th style="width: 5%;">No</th>
                                <th style="width: 12%;">NIS</th>
                                <th>Nama Siswa</th>
                                <th style="width: 10%;">Kelas</th>
                                <th style="width: 12%;">Sakit</th>
                                <th style="width: 12%;">Izin</th>
                                <th style="width: 15%;">Tanpa Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($kehadirans as $item)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td class="text-center">{{ $item->siswa->nis ?? '-' }}</td>
                                <td>{{ $item->siswa->nama_siswa ?? '-' }}</td>
                                <td class="text-center">{{ $item->kelas->rombel ?? '-' }}</td>
                                <input type="hidden" name="anggota_kelas_id[]" value="{{ $item->id }}">

                                <td>
                                    <input type="number" name="sakit[]" value="{{ $item->kehadiran->sakit ?? 0 }}" min="0" class="form-control text-center">
                                </td>
                                <td>
                                    <input type="number" name="izin[]" value="{{ $item->kehadiran->izin ?? 0 }}" min="0" class="form-control text-center">
                                </td>
                                <td>
                                    <input type="number" name="tanpa_keterangan[]" value="{{ $item->kehadiran->tanpa_keterangan ?? 0 }}" min="0" class="form-control text-center">
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4 text-muted">Data anggota kelas belum tersedia.</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            
            <div class="card-footer bg-white text-right py-3 px-4">
                <button type="submit" class="btn btn-info text-white px-4">
                    <i class="fas fa-save me-1"></i> Simpan
                </button>
            </div>
        </div>
    </form>
</div>
@stop

@section('footer')
    <div class="row align-items-center">
        <div class="col-12 col-md-6 text-center text-md-left mb-2 mb-md-0">
            <strong>
                Copyright &copy; {{ date('Y') }} |
                <a href="#">Yayasan Prima Insani</a>.
            </strong>
        </div>

        <div class="col-12 col-md-6 text-center text-md-right">
            <b>E-Raport</b> 
        </div>
    </div>
@stop

@section('css')
<style>
    .table tbody td {
        font-weight: normal !important;
    }
    
    .table thead th {
        font-weight: normal !important;
    }
</style>
@stop

@section('js')
@stop