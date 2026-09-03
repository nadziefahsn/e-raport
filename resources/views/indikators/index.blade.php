@extends('adminlte::page')

@section('title', 'Indikator')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h1 class="m-0">Indikator</h1>
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
        <li class="breadcrumb-item active">Indikator</li>
    </ol>
</div>
@stop

@section('content')
<div class="card">
    <div class="card-header d-flex align-items-center">
        <h3 class="card-title mb-0"><i class="fas fa-clipboard-list mr-2"></i>Data Indikator</h3>
        <div class="card-tools ml-auto">
            <button class="btn btn-light px-4 py-2 rounded-4 fw-bold" data-toggle="modal" data-target="#modalTambahIndikator">
                <i class="fas fa-plus mr-1"></i>
            </button>
        </div>
    </div>
    
    @php
    $heads = [
        ['label' => 'No', 'width' => 5],
        ['label' => 'Kode', 'width' => 10],
        'Capaian Perkembangan',
        'Nama Indikator',
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

        <x-adminlte-datatable id="tableIndikator" :heads="$heads" :config="$config" stripe hoverable buffered text-sm>
            @forelse($indikators as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td><span class="badge badge-info">{{ $item->kode }}</span></td>
                    <td>{{ $item->capaianPerkembangan->capaian_perkembangan ?? '-' }}</td>
                    <td>{{ $item->nama_indikator }}</td>
                    <td>{{ $item->jenjang ?? '-' }}</td>
                    <td>{{ $item->tahunAjaran->tahun_ajaran ?? '-' }}</td>
                    <td class="text-center">
                        <nobr>
                            <button type="button" 
                                    class="btn btn-xs btn-default text-primary mx-1 shadow" 
                                    title="Edit"
                                    data-toggle="modal" 
                                    data-target="#editModal{{ $item->id }}">
                                <i class="fa fa-lg fa-fw fa-pen"></i>
                            </button>
                            <form action="{{ route('indikator.destroy', $item->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="btn btn-xs btn-default text-danger mx-1 shadow" 
                                        title="Delete"
                                        onclick="return confirm('Hapus data indikator ini?')">
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

@include('indikators.create')
@include('indikators.edit')

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
        font-weight: 600 !important;
    }
</style>
@stop

@section('js')
@stop