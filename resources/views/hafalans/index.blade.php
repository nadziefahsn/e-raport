@extends('adminlte::page')

@section('title', 'Capaian Hafalan')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h1 class="m-0">Capaian Hafalan</h1>
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
        <li class="breadcrumb-item active">Capaian Hafalan</li>
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
        <h3 class="card-title mb-0"><i class="fas fa-quran mr-2"></i>Data Capaian Hafalan</h3>
        <div class="card-tools ml-auto">
            <button type="button" class="btn rounded-4 fw-bold" data-toggle="modal" data-target="#modalTambahHafalan">
                <i class="fas fa-plus"></i>
            </button>
        </div>
    </div>
    
    @php
    $heads = [
        ['label' => 'No', 'width' => 5],
        'Nama Capaian Hafalan',
        ['label' => 'Aksi', 'no-export' => true, 'width' => 15, 'className' => 'text-center'],
    ];

    $config = [
        'order' => [[0, 'asc']],
        'searching' => true,    
        'lengthChange' => true, 
        'columns' => [
            null, null,
            ['orderable' => false] 
        ],
    ];
    @endphp

    <div class="card-body p-3">
        <x-adminlte-datatable id="tableHafalan" :heads="$heads" :config="$config" stripe hoverable buffered text-sm>
            @forelse($hafalans as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->capaian_hafalan }}</td>
                    <td class="text-center">
                        <nobr>
                            <button type="button" 
                                    class="btn btn-xs btn-default text-primary mx-1 shadow" 
                                    title="Edit"
                                    data-toggle="modal" 
                                    data-target="#editModal{{ $item->id }}">
                                <i class="fa fa-lg fa-fw fa-pen"></i>
                            </button>
                            <form action="{{ route('capaian-hafalan.destroy', $item->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="btn btn-xs btn-default text-danger mx-1 shadow" 
                                        title="Delete"
                                        onclick="return confirm('Hapus data capaian hafalan ini?')">
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

@include('hafalans.create')
@include('hafalans.edit')

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
@stop