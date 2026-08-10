@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h1 class="m-0">Kriteria Penilaian</h1>
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item">
            <a href="#">Dashboard</a>
        </li>
        <li class="breadcrumb-item active">
            Kriteria Penilaian
        </li>
    </ol>
</div>
@stop

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title mb-0">Kriteria Penilaian</h3>
        <div class="card-tools">
        <button class="btn btn-light px-4 py-2 rounded-4 fw-bold" data-toggle="modal" data-target="#exampleModal">
            <i class="fas fa-plus"></i>
        </button>
    </div>
    </div>
    
    <div class="card-body p-0">
        <table class="table table-hover text-nowrap">
            <thead>
                <tr>
                    <th style="width: 50px;">ID</th>
                    <th>Kriteria</th>
                    <th>Deskripsi</th>
                    <th style="width: 100px;" class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($kriterias as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->kriteria }}</td>
                        <td>{{ $item->deskripsi ?? '-' }}</td>
                        <td class="text-center">
                                <div class="d-flex justify-content-center gap-2">
                                    <button type="button" class="btn btn-xs btn-default text-primary mx-1 shadow" 
                                            data-toggle="modal" 
                                            data-target="#editModal{{ $item->id }}">
                                        <i class="fa fa-lg fa-fw fa-pen"></i>
                                    </button>

                                    <form action="{{ route('kriteria.destroy', $item->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-table-delete" onclick="return confirm('Hapus kriteria ini?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                        </td>
                    </tr>
                    <div class="modal fade" id="editModal{{ $item->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 24px;">
            <div class="modal-header border-0 pt-4 px-4">
                <h5 class="modal-title fw-bold">Edit Kriteria Penilaian</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <!-- 1. Hapus $item->id di route() -->
            <form action="{{ route('kriteria.update', $item->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <!-- 2. Tambahkan input hidden ID di sini -->
                <input type="hidden" name="id" value="{{ $item->id }}">

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
                    <button type="button" class="btn btn-light py-2 px-4 fw-bold" data-bs-dismiss="modal" style="border-radius: 12px;">Kembali</button>
                    <button type="submit" class="btn btn-dark flex-grow-1 py-2 fw-bold" style="border-radius: 12px;">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
                @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted">Belum ada data kriteria.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

    <div class="modal fade" id="exampleModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 24px;">
            <div class="modal-header border-0 pt-4 px-4">
                <h5 class="modal-title fw-bold">Tambah Kriteria</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
                        @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
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
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kembali</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@stop

@section('footer')
    <div class="row">
        <div class="col-12 col-md-6">
            Copyright © {{ date('Y') }} |
            Yayasan Prima Insani.
        </div>

        <div class="col-12 col-md-6 text-center text-md-right">
            <b>E-Raport</b>
        </div>
    </div>
@stop

@section('css')
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    <script> console.log("Hi, I'm using the Laravel-AdminLTE package!"); </script>
@stop
