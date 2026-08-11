@extends('adminlte::page')

@section('title', 'Kriteria Penilaian')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h1 class="m-0 font-weight-bold">Kriteria Penilaian</h1>
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
        <li class="breadcrumb-item active">Kriteria Penilaian</li>
    </ol>
</div>
@stop

@section('content')
<div class="card">
    <div class="card-header d-flex align-items-center">
        <h3 class="card-title mb-0"><i class="fas fa-list-ul mr-2"></i>Kriteria Penilaian</h3>
        <div class="card-tools ml-auto">
            <button class="btn btn-light px-4 py-2 rounded-4 fw-bold" data-toggle="modal" data-target="#exampleModal">
                <i class="fas fa-plus"></i>
            </button>
        </div>
    </div>
    
    @php
    $heads = [
        ['label' => 'ID', 'width' => 5],
        'Kriteria',
        'Deskripsi',
        ['label' => 'Aksi', 'no-export' => true, 'width' => 10, 'className' => 'text-center'],
    ];

    $config = [
        'order' => [[0, 'asc']],
        'searching' => true,
        'lengthChange' => true,
        'columns' => [
            null, 
            null, 
            null, 
            ['orderable' => false]
        ],
    ];
    @endphp

    <div class="card-body p-3">
        <x-adminlte-datatable id="tableKriteria" :heads="$heads" :config="$config" stripe hoverable buffered text-sm>
            @forelse($kriterias as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->kriteria }}</td>
                    <td>{{ $item->deskripsi ?? '-' }}</td>
                    <td class="text-center">
                        <nobr>
                            <button type="button" 
                                    class="btn btn-xs btn-default text-primary mx-1 shadow" 
                                    title="Edit"
                                    data-toggle="modal" 
                                    data-target="#editModal{{ $item->id }}">
                                <i class="fa fa-lg fa-fw fa-pen"></i>
                            </button>

                            <form action="{{ route('kriteria.destroy', $item->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="btn btn-xs btn-default text-danger mx-1 shadow" 
                                        title="Delete"
                                        onclick="return confirm('Hapus kriteria ini?')">
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

<!-- Modal Edit Kriteria -->
@foreach($kriterias as $item)
<div class="modal fade" id="editModal{{ $item->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 24px;">
            <div class="modal-header border-0 pt-4 px-4">
                <h5 class="modal-title fw-bold">Edit Kriteria Penilaian</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            
            <form action="{{ route('kriteria.update', $item->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Kriteria</label>
                        <input type="text" name="kriteria" class="form-control rounded-3" value="{{ $item->kriteria }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Deskripsi</label>
                        <input type="text" name="deskripsi" class="form-control rounded-3" value="{{ $item->deskripsi }}" required>
                    </div>
                </div>
                <div class="modal-footer border-0 pb-4 px-4">
                    <button type="button" class="btn btn-light py-2 px-4 fw-bold" data-dismiss="modal" style="border-radius: 12px;">Kembali</button>
                    <button type="submit" class="btn btn-dark flex-grow-1 py-2 fw-bold" style="border-radius: 12px;">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

<!-- Modal Tambah Kriteria -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 24px;">
            <div class="modal-header border-0 pt-4 px-4">
                <h5 class="modal-title fw-bold">Tambah Kriteria</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            
            @if ($errors->any())
                <div class="alert alert-danger mx-4">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('kriteria.store') }}" method="post">
                @csrf
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Kriteria</label>
                        <input type="text" name="kriteria" class="form-control" placeholder="Masukkan kriteria..." style="border-radius: 14px; padding: 12px;" required>

                        <label class="form-label fw-bold mt-3">Deskripsi</label>
                        <textarea name="deskripsi" class="form-control" rows="3" placeholder="Masukkan deskripsi kriteria..." style="border-radius: 14px; padding: 12px;"></textarea>
                    </div>
                </div>
                <div class="modal-footer border-0 pb-4 px-4">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Kembali</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
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