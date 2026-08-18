@extends('adminlte::page')

@section('title', 'Karakter')

@section('content_header')
    <h1>Karakter</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header d-flex align-items-center">
        <h3 class="card-title mb-0"><i class="fas fa-layer-group mr-2"></i>Data Kelas</h3>
        <div class="card-tools ml-auto">
            <button class="btn btn-light px-4 py-2 rounded-4 fw-bold" data-toggle="modal" data-target="#modalTambahKarakter">
                <i class="fas fa-plus"></i>
            </button>
        </div>
    </div>
    
    @php
    $heads = [
        ['label' => 'No', 'width' => 5],
        'Karakter',
        ['label' => 'Aksi', 'no-export' => true, 'width' => 10, 'className' => 'text-center'],
    ];

    $config = [
        'order' => [[0, 'asc']],
        'searching' => true,    
        'lengthChange' => true, 
        'columns' => [
            null, null,
            ['orderable' => false] 
        ],
    ];
    @endphp

    <div class="card-body p-3">
        <x-adminlte-datatable id="tableKarakter" :heads="$heads" :config="$config" stripe hoverable buffered text-sm>
            @forelse( $karakters as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->karakter }}</td>
                    <td class="text-center">
                        <nobr>
                            <button type="button" class="btn btn-xs btn-default text-primary mx-1 shadow" title="Edit" data-toggle="modal" data-target="#editModal{{ $item->id }}">
                                <i class="fa fa-lg fa-fw fa-pen"></i>
                            </button>
                            <form action="{{ route('karakter.destroy', $item->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-xs btn-default text-danger mx-1 shadow" title="Delete" onclick="return confirm('Hapus data karakter ini?')">
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

<!-- Modal Edit Karakter -->
@foreach($karakters as $item)
<div class="modal fade" id="editModal{{ $item->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 550px;">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 24px;">
            <div class="modal-header border-0 pt-4 px-4">
                <h5 class="modal-title fw-bold">Edit Data Karakter</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <form action="{{ route('karakter.update', $item->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Karakter</label>
                        <input type="text" name="karakter" class="form-control rounded-3" value="{{ $item->karakter }}" required>
                    </div>
                </div>
                <div class="modal-footer border-0 pb-4 px-4">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        Kembali
                    </button>
                    <button type="submit" class="btn btn-dark">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

<!-- Modal Tambah Kelas -->
<div class="modal fade" id="modalTambahKarakter" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 550px;">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 24px;">
            <div class="modal-header border-0 pt-4 px-4">
                <h5 class="modal-title fw-bold">Tambah Data Karakter</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('karakter.store') }}" method="post">
                @csrf
                <div class="modal-body p-4">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label class="form-label fw-bold">Karakter</label>
                            <input type="text" name="karakter" class="form-control rounded-3" placeholder="Karakter" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 pb-4 px-4">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        Kembali
                    </button>
                    <button type="submit" class="btn btn-dark">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
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
<script>
    console.log("Halaman Peserta Didik berhasil dimuat.");
</script>
@stop