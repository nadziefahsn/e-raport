@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="m-0">Dashboard</h1>
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item">
                <a href="#">Dashboard</a>
            </li>
        </ol>
    </div>
@stop

@section('content')
    <div class="card shadow-sm sekolah-card">
        <div class="card-body py-3">
            <h4>
                PG-TK GIS PRIMA INSANI
            </h4>
            <p class="tahun-pelajaran mb-0">
                Tahun Pelajaran 2025/2026 Semester Genap
            </p>
        </div>
    </div>

    <div class="row">
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3>150</h3>

                <p>New Orders</p>
              </div>
              <div class="icon">
                <i class="fas fa-layer-group"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3>53<sup style="font-size: 20px">%</sup></h3>

                <p>Bounce Rate</p>
              </div>
              <div class="icon">
                <i class="fas fa-users"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3>44</h3>

                <p>User Registrations</p>
              </div>
              <div class="icon">
                <i class="fas fa-user-tie"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3>65</h3>

                <p>Unique Visitors</p>
              </div>
              <div class="icon">
                <i class="fas fa-building"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
        </div>

        <div class="row">

    <div class="col-md-6">
        <div class="card shadow-sm">
            <div class="card-header bg-success text-white">
                <h3 class="card-title">
                    <i class="fas fa-bullhorn mr-2"></i>
                    Pengumuman
                </h3>
            </div>

            <div class="card-body">
                
            </div>
        </div>
    </div>


    <div class="col-md-6">
        <div class="card shadow-sm">
            <div class="card-header bg-info text-white">
                <h3 class="card-title">
                    <i class="fas fa-school mr-2"></i>
                    Informasi Sekolah
                </h3>
            </div>

            <div class="card-body">
                <div class="row mb-2">
                    <div class="col-3">
                        Nama Sekolah 
                    </div>
                    <div class="col-auto">
                        :
                    </div>
                    <div class="col">
                        {{ $sekolah->nama_sekolah }}
                    </div>
                </div>    <div class="row mb-2">
                    <div class="col-3">
                        NPSN 
                    </div>
                    <div class="col-auto">
                        :
                    </div>
                    <div class="col">
                        {{ $sekolah->npsn }}
                    </div>
                </div> <div class="row mb-2">
                    <div class="col-3">
                        Alamat 
                    </div>
                    <div class="col-auto">
                        :
                    </div>
                    <div class="col">
                        {{ $sekolah->alamat }}
                    </div>
                </div> <div class="row mb-2">
                    <div class="col-3">
                        Kode Pos 
                    </div>
                    <div class="col-auto">
                        :
                    </div>
                    <div class="col">
                        {{ $sekolah->kode }}
                    </div>
                </div> <div class="row mb-2">
                    <div class="col-3">
                        Telepon 
                    </div>
                    <div class="col-auto">
                        :
                    </div>
                    <div class="col">
                        {{ $sekolah->telepon }}
                    </div>
                </div> <div class="row mb-2">
                    <div class="col-3">
                        Kecamatan 
                    </div>
                    <div class="col-auto">
                        :
                    </div>
                    <div class="col">
                        {{ $sekolah->kecamatan }}
                    </div>
                </div> <div class="row mb-2">
                    <div class="col-3">
                        Kabupaten 
                    </div>
                    <div class="col-auto">
                        :
                    </div>
                    <div class="col">
                        {{ $sekolah->kabupaten }}
                    </div>
                </div> <div class="row mb-2">
                    <div class="col-3">
                        Provinsi 
                    </div>
                    <div class="col-auto">
                        :
                    </div>
                    <div class="col">
                        {{ $sekolah->provinsi }}
                    </div>
                </div> 
            </div>
        </div>
    </div>
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
.sekolah-card{
    border-left:4px solid #28a745;
    border-radius:4px;
}

.nama-sekolah{
    font-size: 28px;
    font-weight: 700;
    color: #343a40;
    line-height: 1.2;
}

.tahun-pelajaran{
    font-size: 16px;
    font-weight: 400;
    color: #6c757d;
    line-height: 1.4;
}

.card-header{
    border-bottom: 0;
    padding: .75rem 1rem;
}

.card-title{
    font-size: 18px;
    font-weight: 600;
}

.card{
    border-radius: 6px;
    overflow: hidden;
}

.card-body{
    background: #fff;
}
</style>
@stop

@section('js')
    <script> console.log("Hi, I'm using the Laravel-AdminLTE package!"); </script>
@stop
