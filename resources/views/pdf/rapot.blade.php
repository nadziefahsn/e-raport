<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href="./asset/invoice_raport.css" rel="stylesheet">
    <style>
        body {
        margin-top: 8mm; 
    }
    table { page-break-inside:auto }
    tr    { page-break-inside:avoid}
    thead { display:table-header-group }
    </style>
</head>
<body>
    <div style="width: 60%; margin: 0 auto;">
        <h3> 
            LAPORAN PERKEMBANGAN ANAK DIDIK<br>
            SEMESTER 1 USIA 3-4 TAHUN
        </h3>
    </div>
    <div class="tb">
        <table>     
            <tr>       
                <td style="width: 160px;">Nama PAUD</td>
                <td>:</td>
                <td>{{ $sekolah->nama_sekolah }}</td>
            </tr>
            <tr>       
                <td style="width: 160px;">NPSN</td>
                <td>:</td>
                <td>{{ $sekolah->npsn }}</td>
            </tr>
            <tr>       
                <td style="width: 160px;">Alamat</td>
                <td>:</td>
                <td>{{ $sekolah->alamat }}</td>
            </tr>
            <tr>       
                <td style="width: 160px;"></td>
                <td></td>
                <td>{{ $sekolah->kode }}</td>
            </tr>
            <tr>       
                <td style="width: 160px;"></td>
                <td></td>
                <td>{{ $sekolah->telepon }}</td>
            </tr>
            <tr>       
                <td style="width: 160px;">Desa / Kelurahan</td>
                <td>:</td>
                <td>{{ $sekolah->desa }}</td>
            </tr>
            <tr>       
                <td style="width: 160px;">Kecamatan</td>
                <td>:</td>
                <td>{{ $sekolah->kecamatan }}</td>
            </tr>
            <tr>       
                <td style="width: 160px;">Kabupaten</td>
                <td>:</td>
                <td>{{ $sekolah->kabupaten }}</td>
            </tr>
            <tr>       
                <td style="width: 160px;">Provinsi</td>
                <td>:</td>
                <td>{{ $sekolah->provinsi }}</td>
            </tr>
        </table>
    </div>>

    <div class="content">
        <h3 style="line-height: 1.6;">
            <strong>PENILAIAN KARAKTER</strong>
        </h3>
    </div>
    <div class="invoice-box">
        <table style="width: 80%; border-collapse: collapse;" align="center">
            @foreach ( $kriterias as $kriteria)
                <tr>
                    <td style="width: 20px; vertical-align: top; padding-bottom: 8px;">{{ $loop->iteration }}</td>
                    <td style="width: 50px; vertical-align: top; padding-bottom: 8px;"><strong>{{ $kriteria->kriteria }}</strong></td>
                    <td style="width: 10px; vertical-align: top; padding-bottom: 8px; text-align: left;">:</td>
                    <td style="vertical-align: top; padding-bottom: 8px;">{{ $kriteria->deskripsi }}</td>
                </tr> 
            @endforeach
        </table>
    </div>

    <div class="page-break"></div>

    <div class="content">
        <h3 style="line-height: 1.6;">
            <strong>LAPORAN KESEHATAN</strong>
        </h3>
    </div>

    <div class="invoice-box">
    <table cellspacing="0">
        <tr>
          <td colspan="4" style="height: 30px;"><strong>1. KEBERSIHAN PRIBADI</strong></td>
        </tr>
        <thead>
            <tr class="heading">
                <td style="width: 6%;" rowspan="2">NO</td>
                <td style="width: 40%;" rowspan="2">KEADAAN</td>
                <td style="width: 28%;" rowspan="2">BERSIH</td>
                <td style="width: 28%;" rowspan="2">KOTOR</td>
                <td style="width: 28%;" rowspan="2">KETERANGAN</td>
            </tr>
             {{-- @foreach ( $kebersihanSiswa as $kebersihan)
                <tr>
                    <td style="width: 6%;">{{ $loop->iteration }}</td>
                    <td style="width: 40%;">Pakaian</td>
                    <td style="width: 28%;">{{ $kebersihan->hasil_pakaian }}</td>
                    <td style="width: 28%;">{{ $kebersihan->keterangan }}</td>
                </tr>
            @endforeach --}}
        </thead>
    </table>
    </div>
</body>
</html>