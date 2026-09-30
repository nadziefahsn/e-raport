@extends('adminlte::page')

@section('title', 'Materi Hafalan')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h1 class="m-0">Rencana {{ $namaKategori ?? 'Materi Hafalan' }}</h1>
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
        <li class="breadcrumb-item active">Rencana {{ $namaKategori ?? 'Materi Hafalan' }}</li>
    </ol>
</div>
@stop

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow-sm border-0 mb-5">
                <div class="card-header bg-white py-3 px-4">
                    <h3 class="card-title fw-bold mb-1">
                        <i class="fas fa-list-alt mr-2 text-info"></i> Data Materi Hafalan - {{ $namaKategori ?? '' }}
                    </h3>
                </div>
                <div class="card-body p-4">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover align-middle mb-0">
                            <thead class="text-white text-center" style="background-color:#17a2b8;">
                                <tr>
                                    <th style="width: 5%;">No</th>
                                    <th style="width: 15%;">Kode</th>
                                    <th class="align-center">Nama Materi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($materiHafalan as $index => $item)
                                    <tr>
                                        <td class="text-center align-middle">{{ $index + 1 }}</td>
                                        <td class="text-center align-middle">{{ $item->materi->kode ?? '-' }}</td>
                                        <td class="align-middle">{{ $item->materi->nama_materi ?? '-' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center py-4 text-muted">
                                            Data materi hafalan belum tersedia. 
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop

@include('layouts.footer')

@section('css')
<style>
    .table-bordered th, .table-bordered td {
        border: 1px solid #dee2e6 !important;
    }
    .card-header {
        border-bottom: 1px solid #ebedf2;
    }
    .table tbody td {
        font-weight: normal !important;
    }
</style>
@stop

@section('js')

@stop