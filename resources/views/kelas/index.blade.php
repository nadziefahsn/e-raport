@extends('adminlte::page')

@section('title', 'Kelas')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h1 class="m-0">Data Kelas Dan Pembimbing</h1>
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
        <li class="breadcrumb-item active">Data Kelas Dan Pembimbing</li>
    </ol>
</div>
@stop

@section('content')
<div class="card">
    <div class="card-header d-flex align-items-center">
        <h3 class="card-title mb-0"><i class="fas fa-layer-group mr-2"></i>Data Kelas Dan Pembimbing</h3>
        <div class="card-tools ml-auto">
            <button class="btn btn-light px-4 py-2 rounded-4 fw-bold" data-toggle="modal" data-target="#modalTambahKelas">
                <i class="fas fa-plus"></i>
            </button>
        </div>
    </div>
    
    @php
    $heads = [
        ['label' => 'No', 'width' => 5],
        'Rombel / Kelas',
        'Wali Kelas',
        'Pendamping',
        'Tahun Ajaran',
        ['label' => 'Aksi', 'no-export' => true, 'width' => 10, 'className' => 'text-center'],
    ];

    $config = [
        'order' => [[0, 'asc']],
        'searching' => true,    
        'lengthChange' => true, 
        'columns' => [
            null, null, null, null, null,
            ['orderable' => false] 
        ],
    ];
    @endphp

    <div class="card-body p-3">
        <x-adminlte-datatable id="tableKelas" :heads="$heads" :config="$config" stripe hoverable buffered text-sm>
            @forelse($kelas as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->rombel }}</td>
                    <td>{{ $item->waliKelas->nama_guru ?? '-' }}</td>
                    <td>{{ $item->pendamping->nama_guru ?? '-' }}</td>
                    <td>{{ $item->tahunAjaran->tahun_ajaran ?? '-' }} {{ $item->tahunAjaran?->semester == '1' || $item->tahunAjaran?->semester == 'Ganjil' ? 'Ganjil' : 'Genap' }}</td>
                    <td class="text-center">
                        <nobr>
                            <button type="button" 
                                    class="btn btn-xs btn-default text-primary mx-1 shadow" 
                                    title="Edit"
                                    data-toggle="modal" 
                                    data-target="#editModal{{ $item->id }}">
                                <i class="fa fa-lg fa-fw fa-pen"></i>
                            </button>
                            <form action="{{ route('kelas.destroy', $item->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="btn btn-xs btn-default text-danger mx-1 shadow" 
                                        title="Delete"
                                        onclick="return confirm('Hapus data kelas ini?')">
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

<!-- Modal Edit Kelas -->
@foreach($kelas as $item)
<div class="modal fade" id="editModal{{ $item->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 24px;">
            <div class="modal-header border-0 pt-4 px-4">
                <h5 class="modal-title fw-bold">Edit Data Kelas</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            
            <form action="{{ route('kelas.update', $item->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="modal-body p-4">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Rombel</label>
                            <input type="text" name="rombel" class="form-control rounded-3" value="{{ $item->rombel }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Tahun Ajaran</label>
                            <select name="tahun_ajaran_id" class="form-control rounded-3" required>
                                <option value="" disabled>-- Pilih Tahun Ajaran --</option>
                                @foreach($tahunAjarans as $ta)
                                <option value="{{ $ta->id }}" {{ $item->tahun_ajaran_id == $ta->id ? 'selected' : '' }}>
                                    {{ $ta->tahun_ajaran }} - {{ $ta->semester == '1' || $ta->semester == 'Ganjil' ? 'Ganjil' : 'Genap' }}
                                </option>
                            @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Wali Kelas</label>
                            <select name="wali_kelas_id" class="form-control rounded-3" required>
                                <option value="" disabled>-- Pilih Wali Kelas --</option>
                                @foreach($gurus as $guru)
                                    <option value="{{ $guru->id }}" {{ $item->wali_kelas_id == $guru->id ? 'selected' : '' }}>
                                        {{ $guru->nama_guru }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Pendamping</label>
                            <select name="pendamping_id" class="form-control rounded-3" required>
                                <option value="" disabled>-- Pilih Pendamping --</option>
                                @foreach($gurus as $guru)
                                    <option value="{{ $guru->id }}" {{ $item->pendamping_id == $guru->id ? 'selected' : '' }}>
                                        {{ $guru->nama_guru }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
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

<!-- Modal Tambah Kelas -->
<div class="modal fade" id="modalTambahKelas" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 24px;">
            <div class="modal-header border-0 pt-4 px-4">
                <h5 class="modal-title fw-bold">Tambah Data Kelas</h5>
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

            <form action="{{ route('kelas.store') }}" method="post">
                @csrf
                <div class="modal-body p-4">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Rombel</label>
                            <input type="text" name="rombel" class="form-control rounded-3" placeholder="Contoh: Kelas 1A" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Tahun Ajaran</label>
                            <select name="tahun_ajaran_id" class="form-control rounded-3" required>
                                <option value="" selected disabled>-- Pilih Tahun Ajaran --</option>
                                @foreach($tahunAjarans as $ta)
                                <option value="{{ $ta->id }}">
                                    {{ $ta->tahun_ajaran }} - {{ $ta->semester == '1' || $ta->semester == 'Ganjil' ? 'Ganjil' : 'Genap' }}
                                </option>
                            @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Wali Kelas</label>
                            <select name="wali_kelas_id" class="form-control rounded-3" required>
                                <option value="" selected disabled>-- Pilih Wali Kelas --</option>
                                @foreach($gurus as $guru)
                                    <option value="{{ $guru->id }}">{{ $guru->nama_guru }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Pendamping</label>
                            <select name="pendamping_id" class="form-control rounded-3" required>
                                <option value="" selected disabled>-- Pilih Pendamping --</option>
                                @foreach($gurus as $guru)
                                    <option value="{{ $guru->id }}">{{ $guru->nama_guru }}</option>
                                @endforeach
                            </select>
                        </div>
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