@extends('adminlte::page')

@section('title', 'Capaian Perkembangan')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h1 class="m-0 font-weight-bold">Capaian Perkembangan</h1>
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
        <li class="breadcrumb-item active">Capaian Perkembangan</li>
    </ol>
</div>
@stop

@section('content')
<div class="card">
    <div class="card-header d-flex align-items-center">
        <h3 class="card-title mb-0"><i class="fas fa-chart-line mr-2"></i>Data Capaian Perkembangan</h3>
        <div class="card-tools ml-auto">
            <button class="btn btn-light px-4 py-2 rounded-4 fw-bold" data-toggle="modal" data-target="#modalTambahCapaian">
                <i class="fas fa-plus"></i>
            </button>
        </div>
    </div>
    
    @php
    $heads = [
        ['label' => 'No', 'width' => 5],
        'Nama Capaian Perkembangan',
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
        <x-adminlte-datatable id="tableCapaian" :heads="$heads" :config="$config" stripe hoverable buffered text-sm>
            @forelse($capaianPerkembangan as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->capaian_perkembangan }}</td>
                    <td class="text-center">
                        <nobr>
                            <button type="button" 
                                    class="btn btn-xs btn-default text-primary mx-1 shadow" 
                                    title="Edit"
                                    data-toggle="modal" 
                                    data-target="#editModal{{ $item->id }}">
                                <i class="fa fa-lg fa-fw fa-pen"></i>
                            </button>
                            <form action="{{ route('capaian-perkembangan.destroy', $item->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="btn btn-xs btn-default text-danger mx-1 shadow" 
                                        title="Delete"
                                        onclick="return confirm('Hapus data capaian perkembangan ini?')">
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

<!-- Modal Edit Capaian Perkembangan -->
@foreach($capaianPerkembangan as $item)
<div class="modal fade" id="editModal{{ $item->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 24px;">
            <div class="modal-header border-0 pt-4 px-4">
                <h5 class="modal-title fw-bold">Edit Capaian Perkembangan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            
            <form action="{{ route('capaian-perkembangan.update', $item->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Nama Capaian Perkembangan</label>
                        <input type="text" name="capaian_perkembangan" class="form-control rounded-3" value="{{ $item->capaian_perkembangan }}" required>
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

<!-- Modal Tambah Capaian Perkembangan -->
<div class="modal fade" id="modalTambahCapaian" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 24px;">
            <div class="modal-header border-0 pt-4 px-4">
                <h5 class="modal-title fw-bold">Tambah Capaian Perkembangan</h5>
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

            <form action="{{ route('capaian-perkembangan.store') }}" method="post">
                @csrf
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Nama Capaian Perkembangan</label>
                        <input type="text" name="capaian_perkembangan" class="form-control rounded-3" placeholder="Masukkan nama capaian perkembangan..." required>
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