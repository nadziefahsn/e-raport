@extends('adminlte::page')

@section('title', 'Nilai Hafalan')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h1 class="m-0">Nilai {{ $namaKategori ?? '' }} </h1>
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
        <li class="breadcrumb-item active">Nilai {{ $namaKategori ?? '' }}</li>
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

<div>
    <form action="{{ route('nilai-hafalan.store') }}" method="POST">
    @csrf
        <input type="hidden" name="kategori" value="{{ $kategori }}">
        <input type="hidden" name="guru_id" value="{{ $guruId }}">

        <div class="card shadow-sm border-0 mb-5">
            <div class="card-header bg-white py-3 px-4">
                <h5 class="card-title fw-bold mb-1">
                    <i class="fas fa-book-open mr-2"></i> Input Nilai {{ $namaKategori ?? '' }}
                </h5>
            </div>

            <div class="card-body p-4">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle mb-0">
                        <thead class="text-white text-center" style="background-color: #17a2b8;">
                            <tr>
                                <th rowspan="2" class="align-middle" style="width: 5%;">No</th>
                                <th rowspan="2" class="align-middle" style="min-width: 250px;">Nama Siswa</th>
                                <th colspan="{{ max(1, $masterHafalan->count()) }}" class="align-middle">Materi</th>
                            </tr>
                            <tr>
                                @foreach($masterHafalan as $materi)
                                    <th class="text-center" data-toggle="tooltip" data-placement="bottom"
                                        title="{{ $materi->deskripsi ?? $materi->nama_hafalan ?? 'Tidak ada deskripsi' }}">
                                        {{ $materi->kode ?? $materi->nama_hafalan ?? '-' }}
                                    </th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($anggotaKelas as $index => $item)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td>{{ $item->siswa->nama_siswa ?? '-' }}</td>

                                @foreach($masterHafalan as $materi)
                                    @php
                                        $nilaiExist = $item->nilaiHafalan->first(function ($nh) use ($materi) {
                                            return $nh->materi_id == $materi->id;
                                        });
                                        $selectedValue = old('nilai.' . $item->id . '.' . $materi->id, $nilaiExist ? $nilaiExist->nilai : '');
                                    @endphp
                                    <td class="text-center">
                                        <select name="nilai[{{ $item->id }}][{{ $materi->id }}]" class="form-control text-center form-control-sm">
                                            <option value="" {{ $selectedValue == '' ? 'selected' : '' }}></option>
                                            <option value="T" {{ $selectedValue == 'T' ? 'selected' : '' }}>Tampak</option>
                                            <option value="TT" {{ $selectedValue == 'TT' ? 'selected' : '' }}>Tidak Tampak</option>
                                        </select>
                                    </td>
                                @endforeach
                            </tr>
                            @empty
                            <tr>
                                <td colspan="{{ 2 + max(1, $masterHafalan->count()) }}" class="text-center py-4 text-muted">
                                    Data anggota kelas belum tersedia atau guru belum dipilih.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            
            <div class="card-footer bg-white text-right py-3 px-4">
                <button type="submit" class="btn btn-info text-white px-4">
                    <i class="fas fa-save mr-1"></i> Simpan
                </button>
            </div>
        </div>
    </form>
</div>
@stop

@include('layouts.footer')

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
<script>
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })
</script>
@stop