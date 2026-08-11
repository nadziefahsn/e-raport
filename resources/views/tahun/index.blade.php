@extends('adminlte::page')

@section('title', 'Tahun Pelajaran')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h1 class="m-0"><b>Tahun Pelajaran</b></h1>
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
        <li class="breadcrumb-item active">Tahun Pelajaran</li>
    </ol>
</div>
@stop

@section('content')
<div class="card">
    <div class="card-header d-flex align-items-center">
        <h3 class="card-title mb-0"><i class="fas fa-calendar-alt mr-2"></i>Data Tahun Ajaran</h3>
        <div class="card-tools ml-auto">
            <button class="btn btn-light px-4 py-2 rounded-4 fw-bold" data-toggle="modal" data-target="#exampleModal">
                <i class="fas fa-plus"></i>
            </button>
        </div>
    </div>

    @php
        $heads = [
            ['label' => 'No', 'width' => 5],
            'Tahun Pelajaran',
            'Semester',
            ['label' => 'Aksi', 'no-export' => true, 'width' => 10, 'className' => 'text-center'],
        ];

        $config = [
            'order' => [[0, 'asc']],
            'searching' => true,
            'lengthChange' => true,
            'columns' => [null, null, null, ['orderable' => false]],
        ];
    @endphp

    <div class="card-body p-3">
        <x-adminlte-datatable id="tableTahunAjaran" :heads="$heads" :config="$config" stripe hoverable buffered text-sm>
            @forelse($tahun_ajarans as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->tahun_ajaran }}</td>
                    <td>{{ $item->semester == '1' ? 'Semester Ganjil' : 'Semester Genap' }}</td>
                    <td class="text-center">
                        <nobr>
                            <button type="button" class="btn btn-xs btn-default text-primary mx-1 shadow"
                                title="Edit" data-toggle="modal" data-target="#editModal{{ $item->id }}">
                                <i class="fa fa-lg fa-fw fa-pen"></i>
                            </button>
                            <form action="{{ route('tahun_ajaran.destroy', $item->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-xs btn-default text-danger mx-1 shadow"
                                    title="Delete" onclick="return confirm('Hapus tahun pelajaran ini?')">
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

@foreach($tahun_ajarans as $item)
<div class="modal fade" id="editModal{{ $item->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius:24px;">
            <div class="modal-header border-0 pt-4 px-4">
                <h5 class="modal-title fw-bold">Edit Tahun Pelajaran</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>

            <form action="{{ route('tahun_ajaran.update', $item->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Tahun Pelajaran</label> 
                        <input type="text" name="tahun_ajaran" class="form-control rounded-3" value="{{ $item->tahun_ajaran }}" placeholder="Masukkan tahun pelajaran..." required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Semester</label>
                        <div class="mt-2">
                            <label class="mr-4">
                                <input type="radio" name="semester" value="1" {{ $item->semester == '1' ? 'checked' : '' }} required>
                                <span class="ml-1">Semester Ganjil</span>
                            </label>
                            <label>
                                <input type="radio" name="semester" value="2" {{ $item->semester == '2' ? 'checked' : '' }}>
                                <span class="ml-1">Semester Genap</span>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 pb-4 px-4">
                    <button type="button" class="btn btn-light py-2 px-4 fw-bold" data-dismiss="modal" style="border-radius:12px;">Kembali</button>
                    <button type="submit" class="btn btn-dark flex-grow-1 py-2 fw-bold" style="border-radius:12px;">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

<div class="modal fade" id="exampleModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius:24px;">
            <div class="modal-header border-0 pt-4 px-4">
                <h5 class="modal-title fw-bold">Tambah Tahun Pelajaran</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <form action="{{ route('tahun_ajaran.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Tahun Pelajaran</label>
                        <input type="text" name="tahun_ajaran" class="form-control" placeholder="Masukkan tahun pelajaran..." value="{{ old('tahun_ajaran') }}" style="border-radius:14px;padding:12px;" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Semester</label>
                        <div class="mt-2">
                            <label class="mr-4">
                                <input type="radio" name="semester" value="1" {{ old('semester') == '1' ? 'checked' : '' }} required>
                                <span class="ml-1">Semester Ganjil</span>
                            </label>
                            <label>
                                <input type="radio" name="semester" value="2" {{ old('semester') == '2' ? 'checked' : '' }}>
                                <span class="ml-1">Semester Genap</span>
                            </label>
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
        <strong>Copyright &copy; {{ date('Y') }} | <a href="#">Yayasan Prima Insani</a>.</strong>
    </div>
    <div class="col-12 col-md-6 text-center text-md-right"><b>E-Raport</b></div>
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