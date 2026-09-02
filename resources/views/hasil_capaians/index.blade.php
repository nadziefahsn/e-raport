@extends('adminlte::page')

@section('title', 'Nilai Capaian Perkembangan')

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
<div>
    <form action="{{ route('hasil-capaian.store', ['kategori' => $kategori]) }}" method="POST">        
        @csrf

        <input type="hidden" name="guru_id" value="{{ $guruId }}">
        <input type="hidden" name="kategori" value="{{ $kategori }}">

        <div class="card shadow-sm border-0 mb-5">
            <div class="card-header bg-white py-3 px-4">
                <h5 class="card-title fw-bold mb-1">
                    <i class="fas fa-chart-line mr-2"></i> Input Nilai {{ $namaKategori ?? '' }}
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
                                <th colspan="{{ $rencanaIndikator->count() }}" class="align-middle">Indikator</th>
                            </tr>
                            <tr>
                                @foreach($rencanaIndikator as $rencana)
                                    <th class="text-center" data-toggle="tooltip" data-placement="bottom"
                                        title="{{ $rencana->indikator->deskripsi ?? $rencana->indikator->nama_indikator ?? 'Tidak ada deskripsi' }}">
                                        {{ $rencana->indikator->kode ?? '-' }}
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

                                @foreach($rencanaIndikator as $rencana)
                                    @php
                                        $nilaiCapaian = $item->hasilCapaian->first(function ($hasil) use ($rencana) {
                                            return $hasil->indikator_id == $rencana->indikator_id;
                                        });
                                        $selectedValue = old('nilai.' . $item->id . '.' . $rencana->indikator_id, $nilaiCapaian ? $nilaiCapaian->nilai : '');
                                    @endphp
                                    <td class="text-center">
                                        <select name="nilai[{{ $item->id }}][{{ $rencana->indikator_id }}]" class="form-control text-center form-control-sm">
                                            <option value="" {{ $selectedValue == '' ? 'selected' : '' }}>-</option>
                                            <option value="BB" {{ $selectedValue == 'BB' ? 'selected' : '' }}>BB</option>
                                            <option value="MB" {{ $selectedValue == 'MB' ? 'selected' : '' }}>MB</option>
                                            <option value="BSH" {{ $selectedValue == 'BSH' ? 'selected' : '' }}>BSH</option>
                                            <option value="BSB" {{ $selectedValue == 'BSB' ? 'selected' : '' }}>BSB</option>
                                        </select>
                                    </td>
                                @endforeach
                            </tr>
                            @empty
                            <tr>
                                <td colspan="{{ 4 + max(1, $rencanaIndikator->count()) }}" class="text-center py-4 text-muted">
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
@push('js')
<script>
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })
</script>
@endpush
@stop