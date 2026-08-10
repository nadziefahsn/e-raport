@extends('adminlte::page')

@section('title', 'Informasi Sekolah')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h1 class="m-0">Profil Sekolah</h1>
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item">
            <a href="#">Dashboard</a>
        </li>
        <li class="breadcrumb-item active">
            Profil Sekolah
        </li>
    </ol>
</div>
@stop

@section('content')
    @if ($sekolah)
        <form action="{{ route('sekolah.update', $sekolah->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
    @else
        <form action="{{ route('sekolah.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
    @endif
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                Profil Sekolah
            </h3>
        </div>
        <div class="card-body">
            <div class="form-group row ">
                <label class="col-md-2 col-form-label"  >
                    Nama Sekolah
                </label>
                <div class="col-md-10">
                    <x-adminlte-input type="text" name="nama_sekolah" class="form-control"
                    value="{{ old('nama_sekolah', $sekolah->nama_sekolah ?? '') }}"/>
                    @error('nama_sekolah') <div class="form-text"> {{ $message }} </div>@enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label">
                    NPSN
                </label>
                <div class="col-md-10">
                    <x-adminlte-input type="number" name="npsn" class="form-control"
                    value="{{ old('npsn', $sekolah->npsn ?? '') }}"/>
                    @error('npsn') <div class="form-text text-danger"> {{ $message }} </div>@enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label">
                    Alamat
                </label>
                <div class="col-md-10">
                    <x-adminlte-input type="text" name="alamat" class="form-control"
                    value="{{ old('alamat', $sekolah->alamat ?? '') }}"/>
                    @error('alamat') <div class="form-text text-danger"> {{ $message }} </div>@enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label">
                    Kode
                </label>
                <div class="col-md-10">
                    <x-adminlte-input type="number" name="kode" class="form-control"
                    value="{{ old('kode', $sekolah->kode ?? '') }}"/>
                    @error('kode') <div class="form-text text-danger"> {{ $message }} </div>@enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label">
                    Telepon
                </label>
                <div class="col-md-10">
                    <x-adminlte-input type="number" name="telepon" class="form-control"
                    value="{{ old('telepon', $sekolah->telepon ?? '') }}"/>
                    @error('telepon') <div class="form-text text-danger"> {{ $message }} </div>@enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label">
                    Desa
                </label>
                <div class="col-md-10">
                    <x-adminlte-input type="text" name="desa" class="form-control"
                    value="{{ old('desa', $sekolah->desa ?? '') }}"/>
                    @error('desa') <div class="form-text text-danger"> {{ $message }} </div>@enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label">
                    Kecamatan
                </label>
                <div class="col-md-10">
                    <x-adminlte-input type="text" name="kecamatan" class="form-control"
                    value="{{ old('kecamatan', $sekolah->kecamatan ?? '') }}"/>
                    @error('kecamatan') <div class="form-text text-danger"> {{ $message }} </div>@enderror
                </div>
            </div>    
            <div class="form-group row">
                <label class="col-md-2 col-form-label">
                     Kabupaten
                </label>
                <div class="col-md-10">
                    <x-adminlte-input type="text" name="kabupaten" class="form-control"
                    value="{{ old('kabupaten', $sekolah->kabupaten ?? '') }}"/>
                    @error('kabupaten') <div class="form-text text-danger"> {{ $message }} </div>@enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label">
                    Provinsi
                </label>
                <div class="col-md-10">
                    <x-adminlte-input type="text" name="provinsi" class="form-control"
                    value="{{ old('provinsi', $sekolah->provinsi ?? '') }}"/>
                    @error('provinsi') <div class="form-text text-danger"> {{ $message }} </div>@enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label">
                    Logo Sekolah
                </label>
                    <div class="col-md-10">
                        <x-adminlte-input-file name="logo" placeholder="Choose a file" disable-feedback/>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="perbarui" name="perbarui">
                        <label class="form-check-label" for="perbarui">
                            Perbarui data profil sekolah
                        </label> 
                    </div>
                    <button type="submit" class="btn btn-primary mt-2">
                        Simpan
                    </button>
                </div>       
            </div>
        </div>
    </div>
</form>
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
@stop
