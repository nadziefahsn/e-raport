@extends('adminlte::page')

@section('title', 'Data Karakter')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h1 class="m-0">Data Karakter</h1>
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
        <li class="breadcrumb-item active">Data Karakter</li>
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
                        <i class="fas fa-star mr-2 text-info"></i> Karakter
                    </h3>
                </div>
                <div class="card-body p-4">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover align-middle mb-0">
                            <thead class="text-white text-center" style="background-color:#17a2b8;">
                                <tr>
                                    <th style="width: 5%;">No</th>
                                    <th class="align-center">Nama Karakter</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($karakters as $index => $item)
                                    <tr>
                                        <td class="text-center align-middle">{{ $index + 1 }}</td>
                                        <td class="align-middle">{{ $item->karakter ?? '-' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-4 text-muted">
                                            Data indikator belum tersedia. 
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