@extends('adminlte::page')

@section('title', 'Catatan Wali Kelas')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h1 class="m-0">Input Catatan Umum Siswa</h1>
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
        <li class="breadcrumb-item active">Catatan Wali Kelas</li>
    </ol>
</div>
@stop

@section('content')
<div class="container-fluid">
    <form action="{{ route('catatan.update', 1) }}" method="POST">
    @csrf
    @method('PUT')
    <input type="hidden" name="guru_id" value="{{ request('guru_id') }}">

    <div class="card shadow-sm border-0 mb-5">
        <div class="card-header bg-white py-3 px-4">
            <h5 class="card-title fw-bold mb-1">
                <i class="fas fa-edit mr-2"></i> Input Catatan Umum Siswa
            </h5>
        </div>

        <div class="card-body p-4">
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle mb-0">
                    <thead class="text-white text-center" style="background-color:#17a2b8;">
                        <tr>
                            <th style="width:5%;">No</th>
                            <th>Nama Siswa</th>
                            <th style="width:65%;">Catatan</th>
                        </tr>
                    </thead>        
                    <tbody>
                        @forelse ($catatans as $index => $item)
                            <tr>
                                <td class="text-center align-middle">{{ $loop->iteration }}</td>
                                <td class="align-middle fw-bold">{{ $item->siswa->nama_siswa ?? '-' }}</td>
                                <td>
                                    <textarea name="catatan[{{ $item->id }}]" class="form-control" rows="3" placeholder=""
                                    >{{ old('catatan.' . $item->id, $item->catatan->catatan ?? '') }}</textarea>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center py-4 text-muted">
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

@include('layouts.footer')

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