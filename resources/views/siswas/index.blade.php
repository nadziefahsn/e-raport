@extends('adminlte::page')

@section('title', 'Peserta Didik')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h1 class="m-0">Peserta Didik</h1>
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item">
            <a href="#">Dashboard</a>
        </li>
        <li class="breadcrumb-item active">
            Peserta Didik
        </li>
    </ol>
</div>
@stop

@section('content')
<div class="card">
    <div class="card-header d-flex align-items-center">
        <h3 class="card-title mb-0"><i class="fas fa-user-graduate mr-2"></i>Data Peserta Didik</h3>

        <div class="card-tools ml-auto">
            <button type="button" class="btn btn-light px-4 py-2 rounded-4 fw-bold" data-toggle="modal" data-target="#modalTambahSiswa">
                <i class="fas fa-plus"></i>
            </button>
        </div>
    </div>

    @php
        $heads = [
            ['label' => 'No', 'width' => 5],
            'NIS/NISN',
            'Nama Siswa',
            'Tanggal Lahir',
            'L/P',
            'Kelas Saat Ini',
            ['label' => 'Aksi', 'no-export' => true, 'width' => 10, 'className' => 'text-center'],
        ];

        $config = [
            'order' => [[0, 'asc']],
            'searching' => true,
            'lengthChange' => true,
            'columns' => [null, null, null, null, null, null, ['orderable' => false]],
        ];
    @endphp

    <div class="card-body p-3">
        <x-adminlte-datatable id="tableSiswa" :heads="$heads" :config="$config" stripe hoverable buffered text-sm>
            @forelse($siswas as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->nis }} / {{ $item->nisn ?? '-' }}</td>
                    <td>{{ $item->nama_siswa }}</td>
                    <td>{{ $item->tanggal_lahir }}</td>
                    <td>{{ $item->jenis_kelamin }}</td>
                    <td>{{ $item->kelas?->rombel ?? '-' }}</td>
                    <td class="text-center">
                        <nobr>
                            <button type="button" class="btn btn-xs btn-default text-primary mx-1 shadow" title="Edit" data-toggle="modal" data-target="#editModal{{ $item->nis }}">
                                <i class="fa fa-lg fa-fw fa-pen"></i>
                            </button>
                            <form action="{{ route('siswa.destroy', $item->nis) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-xs btn-default text-danger mx-1 shadow" title="Delete" onclick="return confirm('Hapus data siswa ini?')">
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

@include('siswas.create')
@include('siswas.edit')

@stop


@include('layouts.footer')


@section('css')
<style>
    .table tbody td { font-weight: normal !important; }
    .table thead th { font-weight: 600 !important; }
</style>
@stop


@section('js')
<script>
    console.log("Halaman Peserta Didik berhasil dimuat.");
</script>
@stop