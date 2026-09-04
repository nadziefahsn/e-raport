@extends('adminlte::page')

@section('title', 'Guru')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h1 class="m-0">Data Guru</h1>
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
        <li class="breadcrumb-item active">Data Guru</li>
    </ol>
</div>
@stop

@section('content')
<!-- Alert Notifikasi Sukses / Error Utama -->
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-circle mr-2"></i> {{ session('error') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

<div class="card">
    <div class="card-header d-flex align-items-center">
        <h3 class="card-title mb-0"><i class="fas fa-chalkboard-teacher mr-2"></i>Data Guru</h3>
        <div class="card-tools ml-auto">
            <button class="btn btn-primary px-4 py-2 fw-bold" data-toggle="modal" data-target="#modalTambahGuru">
=======
            <button class="btn btn-primary px-4 py-2 rounded-4 fw-bold" data-toggle="modal" data-target="#modalTambahGuru">

                <i class="fas fa-plus"></i> Tambah Guru
            </button>
        </div>
    </div>
    

    @php
    $heads = [
        ['label' => 'No', 'width' => 5],
        'Email',
        'Nama Guru',
        'Jabatan',
        'NIP',
        ['label' => 'Aksi', 'no-export' => true, 'width' => 12, 'className' => 'text-center'],
    ];

    $config = [
        'order' => [[0, 'asc']],
        'searching' => true,    
        'lengthChange' => true, 
        'columns' => [
            null, null, null, null, null,
            ['orderable' => false] 
        ],
    ];
    @endphp

    <div class="card-body p-3">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-3" role="alert">
                <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <x-adminlte-datatable id="tableGuru" :heads="$heads" :config="$config" stripe hoverable buffered text-sm>
            @forelse($gurus as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->email ?? '-' }}</td>
                    <td>{{ $item->nama_guru }}</td>
                    <td>{{ $item->jabatan }}</td>
                    <td>{{ $item->nip ?? '-' }}</td>
                    <td class="text-center">
                        <nobr>
                            {{-- Tombol Reset Password --}}
                            <button type="button" 
                                    class="btn btn-xs btn-default text-warning mx-1 shadow" 
                                    title="Reset Password"
                                    data-toggle="modal" 
                                    data-target="#resetPasswordModal{{ $item->id }}">
                                <i class="fa fa-lg fa-fw fa-key"></i>
                            </button>

                            {{-- Tombol Edit --}}
                            <button type="button" 
                                    class="btn btn-xs btn-default text-primary mx-1 shadow" 
                                    title="Edit"
                                    data-toggle="modal" 
                                    data-target="#editModal{{ $item->id }}">
                                <i class="fa fa-lg fa-fw fa-pen"></i>
                            </button>

                            {{-- Tombol Hapus --}}
                            <form action="{{ route('guru.destroy', $item->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="btn btn-xs btn-default text-danger mx-1 shadow" 
                                        title="Delete"
                                        onclick="return confirm('Hapus data guru ini?')">
                                    <i class="fa fa-lg fa-fw fa-trash"></i>
                                </button>
                            </form>
                        </nobr>
                    </td>
=======
    <div class="card-body p-3">
        <table class="table table-bordered table-striped hover">
            <thead>
                <tr>
                    <th style="width: 5%">No</th>
                    <th>Email</th>
                    <th>Nama Guru</th>
                    <th>Jabatan</th>
                    <th>NIP</th>
                    <th style="width: 15%" class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($gurus as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->user->email ?? '-' }}</td>
                        <td>{{ $item->nama_guru }}</td>
                        <td>{{ $item->jabatan }}</td>
                        <td>{{ $item->nip ?? '-' }}</td>
                        <td class="text-center">
                            <div class="btn-group">
                                <!-- Tombol Reset Password -->
                                <a href="{{ route('guru.edit-password', $item->id) }}" 
                                   class="btn btn-xs btn-default text-warning mx-1 shadow" 
                                   title="Reset Password">
                                    <i class="fa fa-lg fa-fw fa-user-cog"></i>
                                </a>

                                <!-- Tombol Edit -->
                                <button type="button" 
                                        class="btn btn-xs btn-default text-primary mx-1 shadow" 
                                        title="Edit"
                                        data-toggle="modal" 
                                        data-target="#editModal{{ $item->id }}">
                                    <i class="fa fa-lg fa-fw fa-pen"></i>
                                </button>

                                <!-- Tombol Delete -->
                                <form action="{{ route('guru.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-xs btn-default text-danger mx-1 shadow" title="Hapus">
                                        <i class="fa fa-lg fa-fw fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">Data guru belum tersedia.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Reset Password Guru -->
@foreach($gurus as $item)
<div class="modal fade" id="resetPasswordModal{{ $item->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
            <div class="modal-header border-0 pt-4 px-4">
                <h5 class="modal-title fw-bold"><i class="fas fa-key text-warning mr-2"></i>Reset Password - {{ $item->nama_guru }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            
            <form action="{{ route('guru.update-password', $item->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="modal-body p-4">
                    <div class="form-group mb-3">
                        <label class="form-label fw-bold">Password Baru</label>
                        <input type="password" name="password" class="form-control rounded-3" placeholder="Masukkan 6-8 karakter" required minlength="6" maxlength="8">
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label fw-bold">Konfirmasi Password Baru</label>
                        <input type="password" name="password_confirmation" class="form-control rounded-3" placeholder="Ulangi password baru" required minlength="6" maxlength="8">
                    </div>
                </div>

                <div class="modal-footer border-0 pb-4 px-4">
                    <button type="button" class="btn btn-light py-2 px-4 fw-bold" data-dismiss="modal" style="border-radius: 12px;">Batal</button>
                    <button type="submit" class="btn btn-warning py-2 px-4 fw-bold text-white" style="border-radius: 12px;">Simpan Password Baru</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

<!-- Modal Edit Guru -->
@foreach($gurus as $item)
<div class="modal fade" id="editModal{{ $item->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 24px;">
            <div class="modal-header border-0 pt-4 px-4">
                <h5 class="modal-title fw-bold">Edit Data Guru</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            
            <form action="{{ route('guru.update', $item->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="modal-body p-4">
                    @if ($errors->any() && session('edit_id') == $item->id)
                        <div class="alert alert-danger mb-3">
                            <ul class="mb-0 pl-3">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Email</label>

                            <input type="email" name="email" class="form-control rounded-3" value="{{ old('email', $item->email) }}" required>
=======
                            <input type="email" name="email" class="form-control rounded-3" value="{{ old('email', $item->user->email ?? '') }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Nama Guru</label>
                            <input type="text" name="nama_guru" class="form-control rounded-3" value="{{ old('nama_guru', $item->nama_guru) }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Jabatan</label>
                            <input type="text" name="jabatan" class="form-control rounded-3" value="{{ old('jabatan', $item->jabatan) }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">NIP</label>
                            <input type="text" name="nip" class="form-control rounded-3" value="{{ old('nip', $item->nip) }}" 
                                inputmode="numeric" oninput="this.value = this.value.replace(/[^0-9]/g, '')" 
                                placeholder="Masukkan NIP (angka saja)...">
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 pb-4 px-4">
                    <button type="button" class="btn btn-light py-2 px-4 fw-bold" data-dismiss="modal" style="border-radius: 12px;">Kembali</button>
                    <button type="submit" class="btn btn-dark flex-grow-1 py-2 fw-bold" style="border-radius: 12px;">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

<!-- Modal Tambah Guru -->
<div class="modal fade" id="modalTambahGuru" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 24px;">
            <div class="modal-header border-0 pt-4 px-4">
                <h5 class="modal-title fw-bold">Tambah Data Guru</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            
=======

            <form action="{{ route('guru.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <!-- Tampilan Pesan Error di Dalam Modal -->
                    @if ($errors->any() && !session('edit_id'))
                        <div class="alert alert-danger mb-3">
                            <ul class="mb-0 pl-3">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-md-6 mb-3">

                            <label class="form-label fw-bold">Email</label>
                            <input type="email" name="email" class="form-control rounded-3" value="{{ old('email') }}" placeholder="Masukkan email guru..." required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Nama Guru</label>
                            <input type="text" name="nama_guru" class="form-control rounded-3" value="{{ old('nama_guru') }}" placeholder="Masukkan nama guru..." required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Jabatan</label>
=======
                            <label class="form-label fw-bold">Email <span class="text-danger">*</span></label>
                            <input type="email" name="email" class="form-control rounded-3" value="{{ old('email') }}" placeholder="Contoh: guru@sekolah.id" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Nama Guru <span class="text-danger">*</span></label>
                            <input type="text" name="nama_guru" class="form-control rounded-3" value="{{ old('nama_guru') }}" placeholder="Masukkan nama guru..." required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Jabatan <span class="text-danger">*</span></label>
                            <input type="text" name="jabatan" class="form-control rounded-3" value="{{ old('jabatan') }}" placeholder="Masukkan jabatan..." required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">NIP</label>
                            <input type="text" name="nip" class="form-control rounded-3" value="{{ old('nip') }}" 
                                inputmode="numeric" oninput="this.value = this.value.replace(/[^0-9]/g, '')" 
                                placeholder="Masukkan NIP (angka saja)...">
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 pb-4 px-4">
                    <button type="button" class="btn btn-secondary py-2 px-4 fw-bold" data-dismiss="modal" style="border-radius: 12px;">Kembali</button>
                    <button type="submit" class="btn btn-primary py-2 px-4 fw-bold" style="border-radius: 12px;">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@stop

@section('js')
<script>
    @if ($errors->any())
        $(document).ready(function() {
            $('#modalTambahGuru').modal('show');
        });
    @endif
=======
    $(document).ready(function() {
        // Otomatis buka kembali modal jika ada error validasi saat submit
        @if ($errors->any())
            @if(session('edit_id'))
                $('#editModal{{ session('edit_id') }}').modal('show');
            @else
                $('#modalTambahGuru').modal('show');
            @endif
        @endif
    });
</script>
@stop