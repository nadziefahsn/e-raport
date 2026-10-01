@extends('adminlte::page')

@section('title', 'Materi')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h1 class="m-0">Materi</h1>
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
        <li class="breadcrumb-item active">Materi</li>
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

<div class="card">
    <div class="card-header d-flex align-items-center">
        <h3 class="card-title mb-0"><i class="fas fa-book mr-2"></i>Data Materi</h3>
        <div class="card-tools ml-auto d-flex align-items-center gap-2">
            <form action="{{ route('indikator.duplicate') }}" method="POST" class="m-2" onsubmit="return confirm('Apakah Anda yakin ingin menyalin kelas dari semester sebelumnya?')">
                @csrf
                <button type="submit" class="btn btn-outline-secondary rounded-pill">
                    <i class="fas fa-copy"></i> Salin Materi Semester Lalu
                </button>
            </form>
            <button type="button" class="btn rounded-4 fw-bold" data-toggle="modal" data-target="#modalTambahMateri">
                <i class="fas fa-plus mr-1"></i>
            </button>
            <button type="button" class="btn btn-sm mr-1" data-toggle="modal" data-target="#modalImportMateri">
                <i class="fas fa-upload mr-1"></i>
            </button>
        </div>
    </div>
    
    @php
    $heads = [
        ['label' => 'No', 'width' => 5],
        ['label' => 'Kode', 'width' => 10],
        'Capaian Hafalan',
        'Nama Materi',
        'Jenjang',
        'Tahun Ajaran',
        ['label' => 'Aksi', 'no-export' => true, 'width' => 15, 'className' => 'text-center'],
    ];

    $config = [
        'order' => [[0, 'asc']],
        'searching' => true,    
        'lengthChange' => true, 
        'columns' => [
            null, 
            null, 
            null,
            null,
            null,
            null,
            ['orderable' => false]
        ],
    ];
    @endphp

    <div class="card-body p-3">
        <x-adminlte-datatable id="tableMateri" :heads="$heads" :config="$config" stripe hoverable buffered text-sm>
            @forelse($materi as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td><span class="badge badge-info">{{ $item->kode }}</span></td>
                    <td>{{ $item->capaianHafalan->capaian_hafalan ?? '-' }}</td>
                    <td>{{ $item->nama_materi }}</td>
                    <td>{{ $item->jenjang ?? '-' }}</td>
                    <td>{{ $item->tahunAjaran->tahun_ajaran ?? '-' }} {{ $item->tahunAjaran?->semester ? '('.$item->tahunAjaran->semester.')' : '' }}</td>
                    <td class="text-center">
                        <nobr>
                            <button type="button" 
                                    class="btn btn-xs btn-default text-primary mx-1 shadow" 
                                    title="Edit"
                                    data-toggle="modal" 
                                    data-target="#editModal{{ $item->id }}">
                                <i class="fa fa-lg fa-fw fa-pen"></i>
                            </button>
                            <form action="{{ route('materi.destroy', $item->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="btn btn-xs btn-default text-danger mx-1 shadow" 
                                        title="Delete"
                                        onclick="return confirm('Hapus data materi ini?')">
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

@include('materis.create')
@include('materis.edit')
@include('materis.import')

@stop

@include('layouts.footer')

@section('css')
<style>
    .table tbody td {
        font-weight: normal !important;
    }
    
    .table thead th {
        font-weight: 600 !important;
    }
</style>
@stop

@section('js')
<script src="https://cdn.jsdelivr.net/npm/bs-custom-file-input/dist/bs-custom-file-input.min.js"></script>

<script>
    $(document).ready(function () {
        bsCustomFileInput.init();

        @if ($errors->any())
            @if(session('edit_id'))
                $('#editModal{{ session('edit_id') }}').modal('show');
            @elseif($errors->has('file'))
                $('#modalImportMateri').modal('show');
            @else
                $('#modalTambahMateri').modal('show');
            @endif
        @endif
    });
</script>
<script>
    @if ($errors->any())
        @if(old('_method') == 'PUT' && old('old_id'))
            $('#editModal{{ old('old_id') }}').modal('show');
        @else
            $('#modalTambahMateri').modal('show');
        @endif
    @endif
</script>
@stop