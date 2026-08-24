@extends('adminlte::page')

@section('title', 'Kesehatan Mata')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h1 class="m-0 font-weight-bold">Kesehatan Mata</h1>
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
        <li class="breadcrumb-item active">Kesehatan Mata</li>
    </ol>
</div>
@stop

@section('content')
<div class="container-fluid">
    <form action="{{ route('mata.update', 1) }}" method="POST">
        @csrf
        @method('PUT')
        <input type="hidden" name="guru_id" value="{{ request('guru_id') }}">

        <div class="card shadow-sm border-0 mb-5">
            <div class="card-header bg-white py-3 px-4">
                <h5 class="card-title fw-bold mb-1">
                    <i class="fas fa-eye mr-2"></i> Input Kesehatan Mata
                </h5>
            </div>

            <div class="card-body p-4">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle mb-0">
                        <thead class="text-white text-center" style="background-color:#17a2b8;">
                            <tr>
                                <th rowspan="2" class="align-middle" style="width: 50px;">No</th>
                                <th rowspan="2" class="align-middle" style="width: 120px;">NIS</th>
                                <th rowspan="2" class="align-middle" style="min-width: 200px;">Nama Siswa</th>
                                <th rowspan="2" class="align-middle" style="width: 100px;">kelas</th>
                                <th colspan="2" class="align-middle">Ketajaman Penglihatan</th>
                                <th rowspan="2" class="align-middle" style="width: 130px;">Buta Warna</th>
                                <th colspan="2" class="align-middle">Radang</th>
                                <th colspan="2" class="align-middle">Juling</th>
                            </tr>
                            <tr>
                                <th style="width: 110px;">Kanan</th>
                                <th style="width: 110px;">Kiri</th>
                                <th style="width: 110px;">Kanan</th>
                                <th style="width: 110px;">Kiri</th>
                                <th style="width: 110px;">Kanan</th>
                                <th style="width: 110px;">Kiri</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($kesehatanMata as $item)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td class="text-center">{{ $item->siswa->nis ?? '-' }}</td>
                                <td>{{ $item->siswa->nama_siswa ?? '-' }}</td>
                                <td class="text-center">{{ $item->kelas->rombel ?? '-' }}</td>

                                <input type="hidden" name="anggota_kelas_id[]" value="{{ $item->id }}">

                                <td>
                                    <select name="ketajaman_kanan[]" class="form-control">
                                        <option value="" {{ !$item->kesehatanMata ? 'selected' : '' }}></option>
                                        <option value="Baik" {{ ($item->kesehatanMata->ketajaman_kanan ?? '') == 'Baik' ? 'selected' : '' }}>Baik</option>
                                        <option value="Kurang baik" {{ ($item->kesehatanMata->ketajaman_kanan ?? '') == 'Kurang baik' ? 'selected' : '' }}>Kurang baik</option>
                                    </select>
                                </td> 
                                
                                <td>
                                    <select name="ketajaman_kiri[]" class="form-control">
                                        <option value="" {{ !$item->kesehatanMata ? 'selected' : '' }}></option>
                                        <option value="Baik" {{ ($item->kesehatanMata->ketajaman_kiri ?? '') == 'Baik' ? 'selected' : '' }}>Baik</option>
                                        <option value="Kurang baik" {{ ($item->kesehatanMata->ketajaman_kiri ?? '') == 'Kurang baik' ? 'selected' : '' }}>Kurang baik</option>
                                    </select>
                                </td>    

                                <td>
                                    <select name="buta_warna[]" class="form-control">
                                        <option value="" {{ !$item->kesehatanMata ? 'selected' : '' }}></option>
                                        <option value="Baik" {{ ($item->kesehatanMata->buta_warna ?? '') == 'Baik' ? 'selected' : '' }}>Baik</option>
                                        <option value="Kurang baik" {{ ($item->kesehatanMata->buta_warna ?? '') == 'Kurang baik' ? 'selected' : '' }}>Kurang baik</option>
                                    </select>
                                </td>    

                                <td>
                                    <select name="radang_kanan[]" class="form-control">
                                        <option value="" {{ !$item->kesehatanMata ? 'selected' : '' }}></option>
                                        <option value="Baik" {{ ($item->kesehatanMata->radang_kanan ?? '') == 'Baik' ? 'selected' : '' }}>Baik</option>
                                        <option value="Kurang baik" {{ ($item->kesehatanMata->radang_kanan ?? '') == 'Kurang baik' ? 'selected' : '' }}>Kurang baik</option>
                                    </select>
                                </td>    

                                <td>
                                    <select name="radang_kiri[]" class="form-control">
                                        <option value="" {{ !$item->kesehatanMata ? 'selected' : '' }}></option>
                                        <option value="Baik" {{ ($item->kesehatanMata->radang_kiri ?? '') == 'Baik' ? 'selected' : '' }}>Baik</option>
                                        <option value="Kurang baik" {{ ($item->kesehatanMata->radang_kiri ?? '') == 'Kurang baik' ? 'selected' : '' }}>Kurang baik</option>
                                    </select>
                                </td>    

                                <td>
                                    <select name="juling_kanan[]" class="form-control">
                                        <option value="" {{ !$item->kesehatanMata ? 'selected' : '' }}></option>
                                        <option value="Baik" {{ ($item->kesehatanMata->juling_kanan ?? '') == 'Baik' ? 'selected' : '' }}>Baik</option>
                                        <option value="Kurang baik" {{ ($item->kesehatanMata->juling_kanan ?? '') == 'Kurang baik' ? 'selected' : '' }}>Kurang baik</option>
                                    </select>
                                </td>    

                                <td>
                                    <select name="juling_kiri[]" class="form-control">
                                        <option value="" {{ !$item->kesehatanMata ? 'selected' : '' }}></option>
                                        <option value="Baik" {{ ($item->kesehatanMata->juling_kiri ?? '') == 'Baik' ? 'selected' : '' }}>Baik</option>
                                        <option value="Kurang baik" {{ ($item->kesehatanMata->juling_kiri ?? '') == 'Kurang baik' ? 'selected' : '' }}>Kurang baik</option>
                                    </select>
                                </td>       
                            </tr>    
                            @empty
                            <tr>
                                <td colspan="11" class="text-center py-4 text-muted">Data kesehatan mata belum tersedia.</td>
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
        <strong>Copyright &copy; {{ date('Y') }} | <a href="#">Yayasan Prima Insani</a>.</strong>
    </div>
    <div class="col-12 col-md-6 text-center text-md-right">
        <b>E-Raport</b>
    </div>
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