@extends('adminlte::page')

@section('title', 'Data Kebersihan Siswa')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h1 class="m-0 font-weight-bold">Input Kebersihan Siswa</h1>
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
        <li class="breadcrumb-item active">Kebersihan Siswa</li>
    </ol>
</div>
@stop

@section('content')
<div class="container-fluid">
    <form action="{{ route('kebersihan-siswa.update', 1) }}" method="POST">
        @csrf
        @method('PUT')

        <input type="hidden" name="guru_id" value="{{ request('guru_id') }}">

        <div class="card shadow-sm border-0 mb-5">
            <div class="card-header bg-white py-3 px-4">
                <h5 class="card-title fw-bold mb-1">
                    <i class="fas fa-solid fa-user-shield mr-2"></i> Input Kebersihan Siswa
                </h5>
            </div>

            <div class="card-body p-4">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle mb-0">
                        <thead class="text-white text-center" style="background-color: #17a2b8;">
                            <tr>
                                <th rowspan="2" class="align-middle" >No</th>
                                <th rowspan="2" class="align-middle" >NIS</th>
                                <th rowspan="2" class="align-middle" style="min-width: 250px;">Nama Siswa</th>
                                <th rowspan="2" class="align-middle" style="width: 10%;">Kelas</th>
                                <th colspan="4" class="align-middle">Keadaan</th>
                                <th rowspan="2" class="align-middle" style="width: 20%;">Keterangan</th>
                            </tr>
                            <tr>
                                <th>Pakaian</th>
                                <th>Kuku</th>
                                <th>Rambut</th>
                                <th>Kulit</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($kebersihanSiswa as $item)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td class="text-center">{{ $item->siswa->nis ?? '-' }}</td>
                                <td>{{ $item->siswa->nama_siswa ?? '-' }}</td>
                                <td class="text-center">{{ $item->kelas->rombel ?? '-' }}</td>
                                <input type="hidden" name="anggota_kelas_id[]" value="{{ $item->id }}">

                                <td>
                                    <select name="hasil_pakaian[]" class="form-control">
                                        <option value="" {{ !$item->kebersihanSiswa ? 'selected' : '' }}>-- Pilih Kondisi --</option>
                                        <option value="Bersih" {{ ($item->kebersihanSiswa->hasil_pakaian ?? '') == 'Bersih' ? 'selected' : '' }}>Bersih</option>
                                        <option value="Kotor" {{ ($item->kebersihanSiswa->hasil_pakaian ?? '') == 'Kotor' ? 'selected' : '' }}>Kotor</option>
                                    </select>
                                </td>

                                <td>
                                    <select name="hasil_kuku[]" class="form-control">
                                        <option value="" {{ !$item->kebersihanSiswa ? 'selected' : '' }}>-- Pilih Kondisi --</option>
                                        <option value="Bersih" {{ ($item->kebersihanSiswa->hasil_kuku ?? '') == 'Bersih' ? 'selected' : '' }}>Bersih</option>
                                        <option value="Kotor" {{ ($item->kebersihanSiswa->hasil_kuku ?? '') == 'Kotor' ? 'selected' : '' }}>Kotor</option>
                                    </select>
                                </td>

                                <td>
                                    <select name="hasil_rambut[]" class="form-control">
                                        <option value="" {{ !$item->kebersihanSiswa ? 'selected' : '' }}>-- Pilih Kondisi --</option>
                                        <option value="Bersih" {{ ($item->kebersihanSiswa->hasil_rambut ?? '') == 'Bersih' ? 'selected' : '' }}>Bersih</option>
                                        <option value="Kotor" {{ ($item->kebersihanSiswa->hasil_rambut ?? '') == 'Kotor' ? 'selected' : '' }}>Kotor</option>
                                    </select>
                                </td>

                                <td>
                                    <select name="hasil_kulit[]" class="form-control">
                                        <option value="" {{ !$item->kebersihanSiswa ? 'selected' : '' }}>-- Pilih Kondisi --</option>
                                        <option value="Bersih" {{ ($item->kebersihanSiswa->hasil_kulit ?? '') == 'Bersih' ? 'selected' : '' }}>Bersih</option>
                                        <option value="Kotor" {{ ($item->kebersihanSiswa->hasil_kulit ?? '') == 'Kotor' ? 'selected' : '' }}>Kotor</option>
                                    </select>
                                </td>

                                <td>
                                    <input type="text" name="keterangan[]" value="{{ $item->kebersihanSiswa->keterangan ?? '' }}" class="form-control">
                                </td>
                            </tr>
                         @empty
                            <tr>
                                <td colspan="9" class="text-center py-4 text-muted">Data anggota kelas belum tersedia.</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            
            <div class="card-footer bg-white text-right py-3 px-4">
                <button type="submit" class="btn btn-info text-white px-4">
                    <i class="fas fa-save me-1"></i> Simpan
                </button>
            </div>
        </div>
    </form>
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
        font-weight: normal !important;
    }
</style>
@stop

@section('js')
@stop