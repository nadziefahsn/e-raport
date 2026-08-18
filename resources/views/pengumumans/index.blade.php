@extends('adminlte::page')

@section('title', 'Informasi Sekolah')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h1 class="m-0">Pengumuman</h1>
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item">
            <a href="#">Dashboard</a>
        </li>
        <li class="breadcrumb-item active">
            Pengumuman
        </li>
    </ol>
</div>
@stop

@section('content')
<div class="card">
    <div class="card-header d-flex align-items-center">
        <h3 class="card-title mb-0"><i class="fas fa-bullhorn mr-2"></i>Pengumuman</h3>
        <div class="card-tools ml-auto">
            <button class="btn btn-light px-4 py-2 rounded-4 fw-bold" data-toggle="modal" data-target="#modalTambahPengumuman">
                <i class="fas fa-plus"></i>
            </button>
        </div>
    </div>
        <div class="card-body">
            <div class="timeline">
                <div class="time-label">
                    <span class="bg-success">
                        Pengumuman Terakhir
                    </span>
                </div>
            @forelse ($pengumumans as $item)
            <div>
                <i class="fas fa-envelope bg-primary"></i>
                    <div class="timeline-item">
                        <span class="time text-muted">
                            <i class="fas fa-clock mr-1"></i>
                            {{ $item->created_at->format('Y-m-d H:i:s') }}
                        </span>
                        <h3 class="timeline-header">
                            <a href="#" class="font-weight-bold text-primary">
                                {{ $item->user->name ?? '-' }}
                            </a> 
                            <span class="text-secondary">{{ $item->judul }}</span>
                        </h3>
                        <div class="timeline-body">
                            {!! $item->isi !!}
                        </div>
                            <div class="timeline-footer">
                                <button type="button" class="btn btn-primary btn-sm px-3" data-toggle="modal" data-target="#editModal{{ $item->id }}">
                                    <i class="fas fa-pen mr-1"></i> Edit
                                </button>  
                                <form action="{{ route('pengumuman.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengumuman ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm px-3">
                                        <i class="fas fa-trash mr-1"></i> Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div> 
                @empty
                    <div>
                        <i class="fas fa-info bg-secondary"></i>
                        <div class="timeline-item">
                            <div class="timeline-body text-muted text-center">
                                Belum ada pengumuman.
                            </div>
                        </div>
                    </div>
                @endforelse
                    <div>
                        <i class="fas fa-clock bg-gray"></i>
                    </div>
                </div>
            </div>
        </div>
@include('pengumumans.create')
@include('pengumumans.edit')

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
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    <script> console.log("Hi, I'm using the Laravel-AdminLTE package!"); </script>
    <script>
    $(document).ready(function () {
        $('#isi_pengumuman').summernote({
            height: 250,
            placeholder: 'Tulis isi pengumuman...'
        });
    });
    $(document).ready(function () {
    $('.summernote-edit').summernote({
        height: 200,
        placeholder: 'Edit isi pengumuman...'
    });
    });
    </script>
@stop
