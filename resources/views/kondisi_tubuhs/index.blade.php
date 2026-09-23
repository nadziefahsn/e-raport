@extends('adminlte::page')

@section('title', 'Kondisi Tubuh')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h1 class="m-0">Kondisi Tubuh</h1>
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
        <li class="breadcrumb-item active">Kondisi Tubuh</li>
    </ol>
</div>
@stop

@section('content')
<div class="container-fluid">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="icon fas fa-check mr-1"></i> {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="icon fas fa-ban mr-1"></i> {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <form action="{{ route('kondisi-tubuh.update', 0) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="card shadow-sm border-0 mb-5">
            <div class="card-header bg-white py-3 px-4">
                <h5 class="card-title fw-bold mb-0">
                    <i class="fas fa-heartbeat mr-2"></i> Input Kondisi Tubuh Kelas
                </h5>
            </div>

            <div class="card-body p-4">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle mb-0">
                        <thead class="text-white text-center" style="background-color: #17a2b8;">
                            <tr>
                                <th style="width: 5%;">No</th>
                                <th>Nama Siswa</th>
                                <th style="width: 20%;">Berat Badan</th>
                                <th style="width: 20%;">Tinggi Badan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($kondisiTubuhs as $index => $item)
                            <tr>
                                <td class="text-center">
                                    {{ $loop->iteration }}
                                    <input type="hidden" name="anggota_kelas_id[]" value="{{ $item->id }}">
                                </td>
                                <td>{{ $item->siswa->nama_siswa ?? '-' }}</td>
                                <td>
                                    <div class="input-group input-group-sm">
                                        <input type="number" 
                                            step="0.1" 
                                            name="berat_badan[]" 
                                            value="{{ old('berat_badan.'.$index, $item->kondisiTubuh->berat_badan ?? '') }}" 
                                            class="form-control text-center" 
                                            placeholder="...">
                                        <div class="input-group-append">
                                            <span class="input-group-text">kg</span>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="input-group input-group-sm">
                                        <input type="number" 
                                            step="0.1" 
                                            name="tinggi_badan[]" 
                                            value="{{ old('tinggi_badan.'.$index, $item->kondisiTubuh->tinggi_badan ?? '') }}" 
                                            class="form-control text-center" 
                                            placeholder="...">
                                        <div class="input-group-append">
                                            <span class="input-group-text">cm</span>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center py-4 text-muted">Data kondisi tubuh belum tersedia.</td>
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

@include('layouts.footer')

@section('css')
<style>
    .table tbody td {
        font-weight: normal !important;
        vertical-align: middle !important;
    }
    
    .table thead th {
        font-weight: 600 !important;
        text-align: center;
        vertical-align: middle !important;
    }
</style>
@stop

@section('js')
@stop