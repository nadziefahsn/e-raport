@extends('adminlte::page')

@section('title', 'Kondisi Tubuh')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h1 class="m-0 font-weight-bold">Kondisi Tubuh Siswa</h1>
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
        <li class="breadcrumb-item active">Kondisi Tubuh</li>
    </ol>
</div>
@stop

@section('content')
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

<form action="{{ route('kondisi-tubuh.store') }}" method="POST">
    @csrf
    
    <div class="card">
        <div class="card-header d-flex align-items-center">
            <h3 class="card-title mb-0">
                <i class="fas fa-person mr-2"></i>Data Kondisi Tubuh Kelas
            </h3>
        </div>

        @php
        $heads = [
            ['label' => 'No', 'width' => 5],
            ['label' => 'Nomor Induk', 'width' => 15],
            'Nama Siswa',
            ['label' => 'L/P', 'width' => 5, 'className' => 'text-center'],
            ['label' => 'Kelas', 'width' => 10, 'className' => 'text-center'],
            ['label' => 'Semester', 'width' => 10, 'className' => 'text-center'],
            ['label' => 'Berat Badan', 'width' => 20, 'className' => 'text-center'],
            ['label' => 'Tinggi Badan', 'width' => 20, 'className' => 'text-center'],
        ];

        $config = [
            'order' => [[0, 'asc']],
            'searching' => true,    
            'lengthChange' => true, 
            'paging' => false, // Dibuat false agar semua siswa tampil saat disimpan sekaligus
            'columns' => [
                null, 
                null, 
                null,
                ['className' => 'text-center'],
                ['className' => 'text-center'],
                ['className' => 'text-center'],
                ['orderable' => false],
                ['orderable' => false]
            ],
        ];
        @endphp

        <div class="card-body p-3">
            <x-adminlte-datatable id="tableKondisiTubuh" :heads="$heads" :config="$config" stripe hoverable buffered text-sm>
                @forelse($anggotaKelas as $index => $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td><span class="badge badge-secondary">{{ $item->siswa->nisn ?? $item->siswa->nis ?? '-' }}</span></td>
                        <td>{{ $item->siswa->nama ?? '-' }}</td>
                        <td class="text-center">{{ $item->siswa->jenis_kelamin ?? '-' }}</td>
                        <td class="text-center">{{ $kelas->nama_kelas ?? $item->kelas->nama_kelas ?? '-' }}</td>
                        <td class="text-center">{{ $tahunAjaranAktif->semester ?? '-' }}</td>
                        
                        <!-- Input Berat Badan -->
                        <td>
                            <div class="input-group input-group-sm">
                                <input type="number" 
                                       step="0.1" 
                                       name="kondisi[{{ $index }}][berat_badan]" 
                                       value="{{ old('kondisi.'.$index.'.berat_badan', $item->kondisiTubuh->berat_badan ?? '') }}" 
                                       class="form-control text-center" 
                                       placeholder="...">
                                <div class="input-group-append">
                                    <span class="input-group-text">kg</span>
                                </div>
                            </div>
                        </td>

                        <!-- Input Tinggi Badan -->
                        <td>
                            <div class="input-group input-group-sm">
                                <input type="number" 
                                       step="0.1" 
                                       name="kondisi[{{ $index }}][tinggi_badan]" 
                                       value="{{ old('kondisi.'.$index.'.tinggi_badan', $item->kondisiTubuh->tinggi_badan ?? '') }}" 
                                       class="form-control text-center" 
                                       placeholder="...">
                                <div class="input-group-append">
                                    <span class="input-group-text">cm</span>
                                </div>
                            </div>
                        </td>

                        <!-- Hidden Input ID Anggota Kelas -->
                        <input type="hidden" name="kondisi[{{ $index }}][anggota_kelas_id]" value="{{ $item->id }}">
                    </tr>
                @empty
                @endforelse
            </x-adminlte-datatable>
        </div>

        <div class="card-footer d-flex justify-content-end">
            <button type="submit" class="btn btn-primary px-4 fw-bold">
                <i class="fas fa-save mr-1"></i> Simpan Data
            </button>
        </div>
    </div>
</form>
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
        vertical-align: middle !important;
    }
    
    .table thead th {
        font-weight: 600 !important;
        text-align: center;
        background-color: #17a2b8 !important; /* Biru Toska khas AdminLTE (bg-info) */
        color: white !important;
    }
</style>
@stop

@section('js')
@stop