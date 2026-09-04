@extends('adminlte::page')

@section('title', 'Nilai Karakter')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h1 class="m-0">Nilai Karakter</h1>
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
        <li class="breadcrumb-item active">Nilai Karakter</li>
    </ol>
</div>
@stop

@section('content')
<div class="container-fluid">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <form action="{{ route('nilai-karakter.store') }}" method="POST">
    @csrf
    <input type="hidden" name="guru_id" value="{{ $guruId }}">

        <div class="card shadow-sm border-0 mb-5">
            <div class="card-header bg-white py-3 px-4">
                <h5 class="card-title fw-bold mb-1">
                    <i class="fas fa-star mr-2"></i> Input Nilai Karakter
                </h5>
            </div>

            <div class="card-body p-4">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle mb-0">
                        <thead class="text-white text-center" style="background-color: #17a2b8;">
                            <tr>
                                <th rowspan="2" class="align-middle" style="width: 5%;">No</th>
                                <th rowspan="2" class="align-middle" style="width: 12%;">NIS</th>
                                <th rowspan="2" class="align-middle" style="min-width: 250px;">Nama Siswa</th>
                                <th rowspan="2" class="align-middle" style="width: 10%;">Kelas</th>
                                <th colspan="{{ $karakters->count() }}" class="align-middle">Karakter</th>
                            </tr>
                            <tr>
                                @foreach($karakters as $karakter)
                                    <th class="text-center" data-toggle="tooltip" data-placement="bottom"
                                        title="{{ $karakter->karakter ?? 'Tidak ada deskripsi' }}">
                                        {{ $karakter->id ?? '-' }}
                                    </th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($anggotaKelas as $index => $item)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td class="text-center">{{ $item->siswa->nis ?? '-' }}</td>
                                <td>{{ $item->siswa->nama_siswa ?? '-' }}</td>
                                <td class="text-center">{{ $item->kelas->rombel ?? '-' }}</td>

                                @foreach($karakters as $karakter)
                                    @php
                                        $nilaiSiswa = $item->nilaiKarakter->first(function ($itemNilai) use ($karakter) {
                                            return $itemNilai->karakter_id == $karakter->id;
                                        });
                                        $selectedValue = old('nilai.' . $item->id . '.' . $karakter->id, $nilaiSiswa ? $nilaiSiswa->nilai : '');
                                    @endphp
                                    <td>
                                        <select name="nilai[{{ $item->id }}][{{ $karakter->id }}]" class="form-control text-center">
                                            <option value="" {{ $selectedValue == '' ? 'selected' : '' }}></option>
                                            <option value="T" {{ $selectedValue == 'T' ? 'selected' : '' }}>T</option>
                                            <option value="TT" {{ $selectedValue == 'TT' ? 'selected' : '' }}>TT</option>
                                        </select>
                                    </td>
                                @endforeach
                            </tr>
                            @empty
                            <tr>
                                <td colspan="{{ 4 + $karakters->count() }}" class="text-center py-4 text-muted">
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

@section('footer')
<div class="row align-items-center">
    <div class="col-12 col-md-6 text-center text-md-left mb-2 mb-md-0">
        <strong>Copyright &copy; {{ date('Y') }} | <a href="#">Yayasan Prima Insani</a>.</strong>
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
<script>
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })
</script>
@stop