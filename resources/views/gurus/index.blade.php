@extends('adminlte::page')

@section('title', 'Data Guru')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h1 class="m-0 font-weight-bold">Data Guru</h1>
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
        <li class="breadcrumb-item active">Guru</li>
    </ol>
</div>
@stop

@section('content')
<div class="card">
    <div class="card-header d-flex align-items-center">
        <h3 class="card-title mb-0"><i class="fas fa-chalkboard-teacher mr-2"></i>Data Guru</h3>
        <div class="card-tools ml-auto">
            <button class="btn btn-light px-4 py-2 rounded-4 fw-bold" data-toggle="modal" data-target="#modalTambahGuru">
                <i class="fas fa-plus"></i>
            </button>
        </div>
    </div>
    
    @php
    $heads = [
        ['label' => 'No', 'width' => 5],
        'User ID',
        'Nama Guru',
        'Jabatan',
        'NIP',
        'Tempat Lahir',
        'Tanggal Lahir',
        'Jenis Kelamin',
        ['label' => 'Aksi', 'no-export' => true, 'width' => 10, 'className' => 'text-center'],
    ];

    $config = [
        'order' => [[0, 'asc']],
        'searching' => true,    
        'lengthChange' => true, 
        'columns' => [
            null, null, null, null, null, null, null, null,
            ['orderable' => false] 
        ],
    ];
    @endphp

    <div class="card-body p-3">
        <x-adminlte-datatable id="tableGuru" :heads="$heads" :config="$config" stripe hoverable buffered text-sm>
            @forelse($gurus as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->user_id ?? '-' }}</td>
                    <td>{{ $item->nama_guru }}</td>
                    <td>{{ $item->jabatan }}</td>
                    <td>{{ $item->nip ?? '-' }}</td>
                    <td>{{ $item->tempat_lahir }}</td>
                    <td>{{ $item->tanggal_lahir }}</td>
                    <td>{{ $item->jenis_kelamin }}</td>
                    <td class="text-center">
                        <nobr>
                            <button type="button" 
                                    class="btn btn-xs btn-default text-primary mx-1 shadow" 
                                    title="Edit"
                                    data-toggle="modal" 
                                    data-target="#editModal{{ $item->id }}">
                                <i class="fa fa-lg fa-fw fa-pen"></i>
                            </button>
                            <form action="{{ route('guru.destroy', $item->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="btn btn-xs btn-default text-danger mx-1 shadow" 
                                        title="Delete"
                                        onclick="return confirm('Hapus data guru ini?')">
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

<!-- Modal Edit Guru -->
@foreach($gurus as $item)
<div class="modal fade" id="editModal{{ $item->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 24px;">
            <div class="modal-header border-0 pt-4 px-4">
                <h5 class="modal-title fw-bold">Edit Data Guru</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            
            <form action="{{ route('guru.update', $item->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="modal-body p-4">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Nama Guru</label>
                            <input type="text" name="nama_guru" class="form-control rounded-3" value="{{ $item->nama_guru }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Jabatan</label>
                            <input type="text" name="jabatan" class="form-control rounded-3" value="{{ $item->jabatan }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">NIP</label>
                        <input type="text" name="nip" class="form-control rounded-3" value="" 
                            inputmode="numeric" oninput="this.value = this.value.replace(/[^0-9]/g, '')" 
                            placeholder="Masukkan NIP (angka saja)...">
                    </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Tempat Lahir</label>
                            <input type="text" name="tempat_lahir" class="form-control rounded-3" value="{{ $item->tempat_lahir }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Tanggal Lahir</label>
                            <input type="date" name="tanggal_lahir" class="form-control rounded-3" value="{{ $item->tanggal_lahir }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold d-block mb-2">Jenis Kelamin</label>
                            
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="jenis_kelamin" id="laki{{ $item->id }}" value="Laki-Laki" {{ $item->jenis_kelamin == 'Laki-Laki' ? 'checked' : '' }}>
                                <label class="form-check-label" for="laki{{ $item->id }}">Laki-Laki</label>
                            </div>

                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="jenis_kelamin" id="perempuan{{ $item->id }}" value="Perempuan" {{ $item->jenis_kelamin == 'Perempuan' ? 'checked' : '' }}>
                                <label class="form-check-label" for="perempuan{{ $item->id }}">Perempuan</label>
                            </div>
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

<!-- Modal Tambah Guru -->
<div class="modal fade" id="modalTambahGuru" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 24px;">
            <div class="modal-header border-0 pt-4 px-4">
                <h5 class="modal-title fw-bold">Tambah Data Guru</h5>
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

            <form action="{{ route('guru.store') }}" method="post">
                @csrf
                <div class="modal-body p-4">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Nama Guru</label>
                            <input type="text" name="nama_guru" class="form-control rounded-3" placeholder="Masukkan nama guru..." required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Jabatan</label>
                            <input type="text" name="jabatan" class="form-control rounded-3" placeholder="Masukkan jabatan..." required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">NIP</label>
                        <input type="text" name="nip" class="form-control rounded-3" value="{{ $item->nip }}" 
                            inputmode="numeric" oninput="this.value = this.value.replace(/[^0-9]/g, '')" 
                            placeholder="Masukkan NIP (angka saja)...">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Tempat Lahir</label>
                            <input type="text" name="tempat_lahir" class="form-control rounded-3" placeholder="Masukkan tempat lahir..." required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Tanggal Lahir</label>
                            <input type="date" name="tanggal_lahir" class="form-control rounded-3" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold d-block mb-2">Jenis Kelamin</label>
                            
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="jenis_kelamin" id="lakiTambah" value="Laki-Laki" required>
                                <label class="form-check-label" for="lakiTambah">Laki-Laki</label>
                            </div>

                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="jenis_kelamin" id="perempuanTambah" value="Perempuan" required>
                                <label class="form-check-label" for="perempuanTambah">Perempuan</label>
                            </div>
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