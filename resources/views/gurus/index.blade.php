@extends('adminlte::page')

@section('title', 'Data Guru')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h1 class="m-0">Data Guru</h1>
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
        <li class="breadcrumb-item active">Guru</li>
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
        <h3 class="card-title mb-0"><i class="fas fa-chalkboard-teacher mr-2"></i>Data Guru</h3>
            <div class="card-tools ml-auto">
            <button type="button" class="btn btn-sm mr-1" data-toggle="modal" data-target="#modalImportGuru">
                <i class="fas fa-upload mr-1"></i>
            </button>
            <button type="button" class="btn rounded-4 fw-bold" data-toggle="modal" data-target="#modalTambahGuru">
                <i class="fas fa-plus"></i>
            </button>
            </div>
        </div>
        
        <div class="card-body p-3">
        @php
        $heads = [
            ['label' => 'No', 'width' => 5],
            'Nama Guru',
            'NIPY',
            // 'Email',
            'Jabatan',
            

            ['label' => 'Aksi', 'no-export' => true, 'width' => 15, 'className' => 'text-center'],
        ];

        $config = [
            'order' => [[0, 'asc']],
            'searching' => true,    
            'lengthChange' => true, 
            'columns' => [ 
                null, null, null, null,
                ['orderable' => false] 
            ],
        ];
        @endphp

        <x-adminlte-datatable id="tableGuru" :heads="$heads" :config="$config" stripe hoverable buffered text-sm>
            @forelse($gurus as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->nama_guru }}</td>
                    <td>{{ $item->nip ?? '-' }}</td>
                    {{-- <td>{{ $item->user->email ?? '-' }}</td> --}}
                    <td>{{ $item->jabatan }}</td>
                    <td class="text-center">
                        <nobr>
                            <a href="{{ route('guru.edit-password', $item->id) }}" 
                            class="btn btn-xs btn-default text-warning mx-1 shadow" 
                            title="Reset Password">
                                <i class="fa fa-lg fa-fw fa-user-cog"></i>
                            </a>

                            <button type="button" 
                                    class="btn btn-xs btn-default text-primary mx-1 shadow" 
                                    title="Edit"
                                    data-toggle="modal" 
                                    data-target="#editModal{{ $item->id }}">
                                <i class="fa fa-lg fa-fw fa-pen"></i>
                            </button>

                            <form action="{{ route('guru.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-xs btn-default text-danger mx-1 shadow" title="Hapus">
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

@include('gurus.create')
@include('gurus.edit')
@include('gurus.import')

@stop

@include('layouts.footer')

@section('js')
<script src="https://cdn.jsdelivr.net/npm/bs-custom-file-input/dist/bs-custom-file-input.min.js"></script>

<script>
    $(document).ready(function () {
        bsCustomFileInput.init();

        @if ($errors->any())
            @if(session('edit_id'))
                $('#editModal{{ session('edit_id') }}').modal('show');
            @elseif($errors->has('file'))
                $('#modalImportGuru').modal('show');
            @else
                $('#modalTambahGuru').modal('show');
            @endif
        @endif
    });
</script>
<script>
    $(document).ready(function() {
        
        @if ($errors->any())
            @if(session('edit_id'))
                $('#editModal{{ session('edit_id') }}').modal('show');
            @else
                $('#modalTambahGuru').modal('show');
            @endif
        @endif
    });
</script>
@stop