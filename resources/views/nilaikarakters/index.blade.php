@extends('adminlte::page')

@section('title', 'Nilai Karakter')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h1 class="m-0 font-weight-bold">Nilai Karakter</h1>
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
        <li class="breadcrumb-item active">Nilai Karakter</li>
    </ol>
</div>
@stop

@section('content')
<form action="{{ route('nilai-karakter.store') }}" method="POST">
    @csrf
    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered text-center m-0">
                    <thead>
                        <tr style="background-color: #009DAE; color: white;">
                            <th rowspan="2" class="align-middle">No</th>
                            <th rowspan="2" class="align-middle">Nomor Induk</th>
                            <th rowspan="2" class="align-middle">Nama Siswa</th>
                            <th rowspan="2" class="align-middle">Kelas</th>
                            <th colspan="4" class="align-middle">Karakter</th>
                        </tr>
                        <tr style="background-color: #009DAE; color: white;">
                            <th style="width: 120px;"></th>
                            <th style="width: 120px;"></th>
                            <th style="width: 120px;"></th>
                            <th style="width: 120px;"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($siswaList as $index => $item)
                        <tr style="{{ $index % 2 == 1 ? 'background-color: #F9F9F9;' : '' }}">
                            <td class="align-middle">{{ $index + 1 }}</td>
                            <td class="align-middle">{{ $item->nomor_induk }}</td>
                            <td class="align-middle">{{ $item->nama_siswa }}</td>
                            <td class="align-middle">{{ $item->nama_kelas }}</td>
                            
                            <input type="hidden" name="nilai[{{ $index }}][id_siswa]" value="{{ $item->id_siswa }}">

                            <td>
                                <input type="text" 
                                       name="nilai[{{ $index }}][karakter_1]" 
                                       value="{{ $item->karakter_1 ?? '' }}" 
                                       class="form-control form-control-sm text-center">
                            </td>
                            <td>
                                <input type="text" 
                                       name="nilai[{{ $index }}][karakter_2]" 
                                       value="{{ $item->karakter_2 ?? '' }}" 
                                       class="form-control form-control-sm text-center">
                            </td>
                            <td>
                                <input type="text" 
                                       name="nilai[{{ $index }}][karakter_3]" 
                                       value="{{ $item->karakter_3 ?? '' }}" 
                                       class="form-control form-control-sm text-center">
                            </td>
                            <td>
                                <input type="text" 
                                       name="nilai[{{ $index }}][karakter_4]" 
                                       value="{{ $item->karakter_4 ?? '' }}" 
                                       class="form-control form-control-sm text-center">
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer text-right">
            <button type="submit" class="btn" style="background-color: #009DAE; color: white;">Simpan Nilai</button>
        </div>
    </div>
</form>
@stop