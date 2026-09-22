<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href="./asset/invoice_raport.css" rel="stylesheet">
    <style>
        body {
            margin-top: 8mm; 
            font-family: 'Times New Roman', Times, serif;
            color: #000;
        }
        table { page-break-inside: auto; }
        tr    { page-break-inside: avoid; }
        thead { display: table-header-group; }
        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body>
    {{-- cover --}}
    <div style="font-family: 'Times New Roman', Times, serif; text-align: center; padding: 10px 0;">
        <div style="width: 100%; margin: 0 auto;">
            <h3 style="line-height: 1.5; font-size: 20px; font-weight: bold; margin: 0; letter-spacing: 0.5px; text-transform: uppercase;">
                LAPORAN PERKEMBANGAN SISWA<br>
                USIA {{ $usia }}<br>
                TAHUN AJARAN {{ str_replace('/', '-', $tahunAjaranAktif->tahun_ajaran ?? '1025-1026') }}
            </h3>
        </div>

        <div style="margin: 60px 0 80px 0;">
            <img src="{{ public_path('asset/bw_logo_tk.png') }}" alt="Logo Sekolah" style="width: 280px; height: auto;">
        </div>

        <table style="margin: 0 auto; border-collapse: collapse; font-size: 13px; line-height: 1.6; text-align: left;">
            <tr>
                <td style="width: 180px; padding-bottom: 3px; vertical-align: top;">Nama PAUD</td>
                <td style="width: 10px; padding-bottom: 3px; vertical-align: top;">:</td>
                <td style="padding-bottom: 3px; vertical-align: top;">{{ $sekolah->nama_sekolah ?? '-' }}</td>
            </tr>
            <tr>
                <td style="padding-bottom: 3px; vertical-align: top;">NPSN</td>
                <td style="padding-bottom: 3px; vertical-align: top;">:</td>
                <td style="padding-bottom: 3px; vertical-align: top;">{{ $sekolah->npsn ?? '-' }}</td>
            </tr>
            <tr>
                <td style="vertical-align: top; padding-bottom: 3px;">Alamat</td>
                <td style="vertical-align: top; padding-bottom: 3px;">:</td>
                <td style="padding-bottom: 3px; vertical-align: top;">
                    {{ $sekolah->alamat ?? '-' }}<br>
                    Kode Pos {{ $sekolah->kode_pos ?? '44112' }}<br>
                    Telp. {{ $sekolah->telepon ?? '-' }}
                </td>
            </tr>
            <tr>
                <td style="padding-bottom: 3px; vertical-align: top;">Desa / Kelurahan</td>
                <td style="padding-bottom: 3px; vertical-align: top;">:</td>
                <td style="padding-bottom: 3px; vertical-align: top;">{{ $sekolah->desa ?? '-' }}</td>
            </tr>
            <tr>
                <td style="padding-bottom: 3px; vertical-align: top;">Kecamatan</td>
                <td style="padding-bottom: 3px; vertical-align: top;">:</td>
                <td style="padding-bottom: 3px; vertical-align: top;">{{ $sekolah->kecamatan ?? '-' }}</td>
            </tr>
            <tr>
                <td style="padding-bottom: 3px; vertical-align: top;">Kabupaten</td>
                <td style="padding-bottom: 3px; vertical-align: top;">:</td>
                <td style="padding-bottom: 3px; vertical-align: top;">{{ $sekolah->kabupaten ?? '-' }}</td>
            </tr>
            <tr>
                <td style="padding-bottom: 3px; vertical-align: top;">Provinsi</td>
                <td style="padding-bottom: 3px; vertical-align: top;">:</td>
                <td style="padding-bottom: 3px; vertical-align: top;">{{ $sekolah->provinsi ?? '-' }}</td>
            </tr>
        </table>
    </div>

    <div class="page-break"></div>

    {{-- data siswa --}}
    <div class="title">
        <h3>KETERANGAN DIRI SISWA</h3>
    </div>

    <table class="table-biodata">
        <tr>
            <td width="4%" class="label-bold">1.</td>
            <td width="36%" class="label-bold">Nama Anak Didik</td>
            <td width="60%">: {{ $anggotaKelas->siswa->nama_siswa ?? $anggotaKelas->siswa->nama_siswa ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label-bold">2.</td>
            <td class="label-bold">Nomor Induk</td>
            <td>: {{ $anggotaKelas->siswa->nis ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label-bold">3.</td>
            <td class="label-bold">NISN</td>
            <td>: {{ $anggotaKelas->siswa->nisn ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label-bold">4.</td>
            <td class="label-bold">Jenis Kelamin</td>
            <td>: {{ $anggotaKelas->siswa->jk ?? $anggotaKelas->siswa->jenis_kelamin ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label-bold">5.</td>
            <td class="label-bold">Tempat / Tgl. Lahir</td>
            <td>: {{ $anggotaKelas->siswa->ttl ?? ($anggotaKelas->siswa->tempat_lahir . ' / ' . $anggotaKelas->siswa->tanggal_lahir) ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label-bold">6.</td>
            <td class="label-bold">Agama</td>
            <td>: {{ $anggotaKelas->siswa->agama ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label-bold">7.</td>
            <td class="label-bold">Anak Ke</td>
            <td>: {{ $anggotaKelas->siswa->anak_ke ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label-bold">8.</td>
            <td class="label-bold" colspan="2">Nama Orang Tua/ Wali*</td>
        </tr>
        <tr>
            <td></td>
            <td class="label-bold" style="padding-left: 18px;">a.&nbsp;&nbsp;Ayah</td>
            <td>: {{ $anggotaKelas->siswa->nama_ayah ?? '-' }}</td>
        </tr>
        <tr>
            <td></td>
            <td class="label-bold" style="padding-left: 18px;">b.&nbsp;&nbsp;Ibu</td>
            <td>: {{ $anggotaKelas->siswa->nama_ibu ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label-bold">9.</td>
            <td class="label-bold" colspan="2">Pekerjaan Orang Tua/ Wali*</td>
        </tr>
        <tr>
            <td></td>
            <td class="label-bold" style="padding-left: 18px;">a.&nbsp;&nbsp;Ayah</td>
            <td>: {{ $anggotaKelas->siswa->pekerjaan_ayah ?? '-' }}</td>
        </tr>
        <tr>
            <td></td>
            <td class="label-bold" style="padding-left: 18px;">b.&nbsp;&nbsp;Ibu</td>
            <td>: {{ $anggotaKelas->siswa->pekerjaan_ibu ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label-bold">10.</td>
            <td class="label-bold">Alamat Orang Tua/ Wali*</td>
            <td>: {{ $anggotaKelas->siswa->alamat_ortu ?? $anggotaKelas->siswa->alamat ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label-bold">11.</td>
            <td class="label-bold">Telepon</td>
            <td>: {{ $anggotaKelas->siswa->no_hp ?? $anggotaKelas->siswa->telepon ?? '-' }}</td>
        </tr>
    </table>

    <table class="footer-biodata">
        <tr>
            <td width="45%" align="left" style="vertical-align: bottom;">
                <div class="foto-box">
                    <table>
                        <tr>
                            <td>
                                Pas Foto<br>
                                3X4
                            </td>
                        </tr>
                    </table>
                </div>
            </td>
            <td width="55%" class="ttd-box-bio">
                Garut, {{ isset($tahunAjaranAktif->titimangsa) ? 
                    \Carbon\Carbon::parse($tahunAjaranAktif->titimangsa)->locale('id')->translatedFormat('d F Y') : '-' }}<br>
                <div>Mengetahui,</div>
                Kepala Taman Kanak–kanak Islam Plus<br>
                <strong>PRIMA INSANI</strong>
                <br><br><br><br><br>
                <span class="ttd-nama">{{ $tahunAjaranAktif->kepala_sekolah ?? '-' }}</span><br>
                <span class="ttd-nuptk">NUPTK.{{ $tahunAjaranAktif->nuptk ?? '-' }}</span>
            </td>
        </tr>
    </table>

    <div class="page-break"></div>

    {{-- kriteria penilain --}}
    <div style="text-align: center; margin-bottom: 40px;">
        <h3 style="font-size: 14px; font-weight: bold; margin: 0; letter-spacing: 0.3px; color: #000;">
            KRITERIA PENILAIAN PENCAPAIAN PERKEMBANGAN SISWA
        </h3>
    </div>

    <div style="width: 88%; margin: 0 auto;">
        <table style="width: 100%; border-collapse: collapse; font-size: 13px; line-height: 1.5; color: #000;">
            @forelse ( $kriterias as $kriteria)
                <tr>
                    <td style="width: 10px; vertical-align: top; padding: 0 0 10px 0; font-weight: bold; color: #000;">
                        {{ $loop->iteration }}.
                    </td>
                    <td style="width: 55px; vertical-align: top; padding: 0 0 10px 0; text-align: center; font-weight: bold; color: #000;">
                        {{ $kriteria->kriteria }}
                    </td>
                    <td style="width: 15px; vertical-align: top; padding: 0 0 10px 0; color: #000;">
                        :
                    </td>
                    <td style="vertical-align: top; padding: 0 0 10px 10px; text-align: justify; color: #000;">
                        {{ $kriteria->deskripsi }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" style="text-align: center; padding-top: 10px;">
                        Data kriteria penilaian belum ada.
                    </td>
                </tr>
            @endforelse
        </table>
    </div>

    <div class="page-break"></div>

    <div class="title" style="margin-bottom: 15px;">
        <h3>LAPORAN PENCAPAIAN PERKEMBANGAN ANAK DIDIK</h3>
    </div>

    <table class="table-biodata" style="margin-bottom: 15px;" align="center ">
        <tr>
            <td width="15%"><strong>Nama Siswa</td>
            <td width="2%">:</td>
            <td width="38%"><strong>{{ $anggotaKelas->siswa->nama_siswa ?? $anggotaKelas->siswa->nama_siswa ?? '-' }}</strong></td>
            <td width="20%"><strong> Kelompok Usia</td>
            <td width="2%">:</td>
            <td width="28%">{{ $usia }}</td>
        </tr>
        <tr>
            <td><strong>NIS</td>
            <td>:</td>
            <td>{{ $anggotaKelas->siswa->nis ?? '-' }} / {{ $anggotaKelas->siswa->nisn ?? '-' }}</td>
            <td><strong> Tahun Ajaran</td>
            <td>:</td>
            <td>{{ $tahunAjaranAktif->tahun_ajaran ?? '2023/2024' }}</td>
        </tr>
        <tr>
            <td><strong>NISN</td>
            <td>:</td>
            <td>{{ $anggotaKelas->siswa->nisn ?? '-' }}</td>
            <td><strong>Semester</td>
            <td>:</td>
            <td>{{ $tahunAjaranAktif->semester ?? 'ganjil' }}</td>
        </tr>
    </table>

    @foreach($daftarCapaian as $judulKategori => $indikators)
    <div class="kategori-title" style="font-weight: bold; margin-top: 10px; margin-bottom: 5px;">
        {{ $judulKategori }}
    </div>

    <table border="1" cellspacing="0" cellpadding="5" style="width: 100%; border-collapse: collapse; text-align: center;">
        <thead>
            <tr style="font-weight: bold;">
                <th style="width: 8%;">NO</th>
                <th style="width: 64%;">INDIKATOR</th>
                <th style="width: 14%;">TAMPAK</th>
                <th style="width: 14%;">TIDAK TAMPAK</th>
            </tr>
        </thead>
        <tbody>
        @forelse($indikators as $indikator)
            @php
                $item = $anggotaKelas?->hasilCapaian?->firstWhere('indikator_id', $indikator->id);
                $nilai = $item ? strtoupper(trim($item->nilai)) : null;
            @endphp
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td style="text-align: left; padding-left: 8px;">{{ $indikator->nama_indikator }}</td>
                <td>
                    @if($nilai == 'T')
                        <span style="font-family: 'DejaVu Sans', sans-serif;">&#10003;</span>
                    @endif
                </td>
                <td>
                    @if($nilai == 'TT')
                        <span style="font-family: 'DejaVu Sans', sans-serif;">&#10003;</span>
                    @endif
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="4" style="text-align: center; color: #777; font-style: italic;">
                    Belum ada indikator
                </td>
            </tr>
        @endforelse
        </tbody>
    </table>
    @endforeach

    <div class="page-break"></div>

    <div class="content">
        <h3 style="line-height: 1.6">
          <strong>PENILAIAN KARAKTER</strong>
        </h3>
      <div class="invoice-box">
        <table cellspacing="0">
            <thead>
                <tr class="heading">
                    <td style="width: 6%;" rowspan="2">NO</td>
                    <td style="width: 66%;" rowspan="2">KARAKTER</td>
                    <td style="width: 28%;" colspan="2">HASIL PENILAIAN</td>
                </tr>
                <tr class="heading">
                    <td style="width: 14%;">TAMPAK</td>
                    <td style="width: 14%;">TIDAK TAMPAK</td>
                </tr>
            </thead>
            <tbody>
            @foreach($karakters as $karakter)
                <tr class="sikap">
                    <td style="text-align:center;">{{ $loop->iteration }}</td>
                    
                    <td class="description" style="line-height: 1.4;">
                        {{ $karakter->karakter }}
                    </td>

                    @php
                        $nilaiItem = $anggotaKelas->nilaiKarakter
                            ->where('karakter_id', $karakter->id)
                            ->first();

                        $nilai = $nilaiItem ? $nilaiItem->nilai : null;
                    @endphp

                    <td style="text-align: center; border: 1px solid black;">
                        @if(strtoupper($nilai) == 'T')
                            <span style="font-family: DejaVu Sans, sans-serif; font-size: 16px; font-weight: bold;">&#10004;</span>
                        @endif
                    </td>

                    <td style="text-align: center; border: 1px solid black;">
                        @if(strtoupper($nilai) == 'TT')
                            <span style="font-family: DejaVu Sans, sans-serif; font-size: 16px; font-weight: bold;">&#10004;</span>
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <div class="page-break"></div>

    {{-- kesehatan --}}
    <div class="content">
        <h3 style="text-align: center; line-height: 1.6; font-weight: bold; font-size: 18px;">
            LAPORAN KESEHATAN
        </h3>
    </div>

    <p style="font-weight: bold; margin-top: 10px; margin-bottom: 3px; text-align: left;">I. KEBERSIHAN PRIBADI</p>
    <table border="1" cellspacing="0" cellpadding="2" style="width: 100%; border-collapse: collapse; text-align: center;">
        <thead>
            <tr style="font-weight: bold;">
                <th style="width: 8%;">NO.</th>
                <th style="width: 35%;">KEADAAN</th>
                <th style="width: 18%;">BERSIH</th>
                <th style="width: 18%;">KOTOR</th>
                <th style="width: 21%;">KETERANGAN</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1</td>
                <td style="text-align: left; padding-left: 8px;">Pakaian</td>
                <td>
                    @if(strtolower($anggotaKelas?->kebersihanSiswa?->hasil_pakaian) == 'bersih')
                        <span style="font-family: 'DejaVu Sans', sans-serif;">&#10003;</span>
                    @endif
                </td>
                <td>
                    @if(strtolower($anggotaKelas?->kebersihanSiswa?->hasil_pakaian) == 'kotor')
                        <span style="font-family: 'DejaVu Sans', sans-serif;">&#10003;</span>
                    @endif
                </td>
                <td>{{ $anggotaKelas?->kebersihanSiswa?->keterangan }}</td>
            </tr>
            <tr>
                <td>2</td>
                <td style="text-align: left; padding-left: 8px;">Kuku</td>
                <td>
                    @if(strtolower($anggotaKelas?->kebersihanSiswa?->hasil_kuku) == 'bersih')
                        <span style="font-family: 'DejaVu Sans', sans-serif;">&#10003;</span>
                    @endif
                </td>
                <td>
                    @if(strtolower($anggotaKelas?->kebersihanSiswa?->hasil_kuku) == 'kotor')
                        <span style="font-family: 'DejaVu Sans', sans-serif;">&#10003;</span>
                    @endif
                </td>
                <td></td>
            </tr>
            <tr>
                <td>3</td>
                <td style="text-align: left; padding-left: 8px;">Rambut</td>
                <td>
                    @if(strtolower($anggotaKelas?->kebersihanSiswa?->hasil_rambut) == 'bersih')
                        <span style="font-family: 'DejaVu Sans', sans-serif;">&#10003;</span>
                    @endif
                </td>
                <td>
                    @if(strtolower($anggotaKelas?->kebersihanSiswa?->hasil_rambut) == 'kotor')
                        <span style="font-family: 'DejaVu Sans', sans-serif;">&#10003;</span>
                    @endif
                </td>
                <td></td>
            </tr>
            <tr>
                <td>4</td>
                <td style="text-align: left; padding-left: 8px;">Kulit</td>
                <td>
                    @if(strtolower($anggotaKelas?->kebersihanSiswa?->hasil_kulit) == 'bersih')
                        <span style="font-family: 'DejaVu Sans', sans-serif;">&#10003;</span>
                    @endif
                </td>
                <td>
                    @if(strtolower($anggotaKelas?->kebersihanSiswa?->hasil_kulit) == 'kotor')
                        <span style="font-family: 'DejaVu Sans', sans-serif;">&#10003;</span>
                    @endif
                </td>
                <td></td>
            </tr>
        </tbody>
    </table>

    <p style="font-weight: bold; margin-top: 10px; margin-bottom: 3px; text-align: left;">II. MATA</p>
    <table border="1" cellspacing="0" cellpadding="2" style="width: 100%; border-collapse: collapse; text-align: center;">
        <thead>
            <tr style="font-weight: bold;">
                <th style="width: 8%;">NO.</th>
                <th style="width: 52%;">KEADAAN</th>
                <th style="width: 40%;">KETERANGAN</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td rowspan="2" style="vertical-align: middle;">1</td>
                <td style="text-align: left; padding-left: 8px;">
                    <div style="display: flex; align-items: center;">
                        <span>Ketajaman penglihatan :</span>
                        <span style="margin-left: 10px;">a. Kanan</span>
                    </div>
                </td>
                <td>{{ $anggotaKelas?->kesehatanMata?->ketajaman_kanan ?? '-' }}</td>
            </tr>
            <tr>
                <td style="text-align: left; padding-left: 8px;">
                    <div style="display: flex; align-items: center;">
                        <span style="visibility: hidden;">Ketajaman penglihatan :</span>
                        <span style="margin-left: 10px;">b. Kiri</span>
                    </div>
                </td>
                <td>{{ $anggotaKelas?->kesehatanMata?->ketajaman_kiri ?? '-' }}</td>
            </tr>
            <tr>
                <td>2</td>
                <td style="text-align: left; padding-left: 8px;">Buta warna</td>
                <td>{{ $anggotaKelas?->kesehatanMata?->buta_warna ?? '-' }}</td>
            </tr>
            <tr>
                <td rowspan="2" style="vertical-align: middle;">3</td>
                <td style="text-align: left; padding-left: 8px;">
                    <div style="display: flex; align-items: center;">
                        <span>Radang :</span>
                        <span style="margin-left: 10px;">a. Kanan</span>
                    </div>
                </td>
                <td>{{ $anggotaKelas?->kesehatanMata?->radang_kanan ?? '-' }}</td>
            </tr>
            <tr>
                <td style="text-align: left; padding-left: 8px;">
                    <div style="display: flex; align-items: center;">
                        <span style="visibility: hidden;">Radang :</span>
                        <span style="margin-left: 10px;">b. Kiri</span>
                    </div>
                </td>
                <td>{{ $anggotaKelas?->kesehatanMata?->radang_kiri ?? '-' }}</td>
            </tr>
            <tr>
                <td rowspan="2" style="vertical-align: middle;">4</td>
                <td style="text-align: left; padding-left: 8px;">
                    <div style="display: flex; align-items: center;">
                        <span>Juling :</span>
                        <span style="margin-left: 10px;">a. Kanan</span>
                    </div>
                </td>
                <td>{{ $anggotaKelas?->kesehatanMata?->juling_kanan ?? '-' }}</td>
            </tr>
            <tr>
                <td style="text-align: left; padding-left: 8px;">
                    <div style="display: flex; align-items: center;">
                        <span style="visibility: hidden;">Juling :</span>
                        <span style="margin-left: 10px;">b. Kiri</span>
                    </div>
                </td>
                <td>{{ $anggotaKelas?->kesehatanMata?->juling_kiri ?? '-' }}</td>
            </tr>
        </tbody>
    </table>

    <p style="font-weight: bold; margin-top: 10px; margin-bottom: 3px; text-align: left;">III. TELINGA</p>
    <table border="1" cellspacing="0" cellpadding="2" style="width: 100%; border-collapse: collapse; text-align: center;">
        <thead>
            <tr style="font-weight: bold;">
                <th style="width: 8%;">NO.</th>
                <th style="width: 52%;">KEADAAN</th>
                <th style="width: 40%;">KETERANGAN</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td rowspan="2" style="vertical-align: middle;">1</td>
                <td style="text-align: left; padding-left: 8px;">
                    <div style="display: flex; align-items: center;">
                        <span>Ketajaman pendengaran :</span>
                        <span style="margin-left: 10px;">a. Kanan</span>
                    </div>
                </td>
                <td>{{ $anggotaKelas?->kesehatanTelinga?->pendengaran_kanan ?? '-' }}</td>
            </tr>
            <tr>
                <td style="text-align: left; padding-left: 8px;">
                    <div style="display: flex; align-items: center;">
                        <span style="visibility: hidden;">Ketajaman pendengaran :</span>
                        <span style="margin-left: 10px;">b. Kiri</span>
                    </div>
                </td>
                <td>{{ $anggotaKelas?->kesehatanTelinga?->pendengaran_kiri ?? '-' }}</td>
            </tr>
            <tr>
                <td rowspan="2" style="vertical-align: middle;">2</td>
                <td style="text-align: left; padding-left: 8px;">
                    <div style="display: flex; align-items: center;">
                        <span>Radang :</span>
                        <span style="margin-left: 10px;">a. Kanan</span>
                    </div>
                </td>
                <td>{{ $anggotaKelas?->kesehatanTelinga?->radang_kanan ?? '-' }}</td>
            </tr>
            <tr>
                <td style="text-align: left; padding-left: 8px;">
                    <div style="display: flex; align-items: center;">
                        <span style="visibility: hidden;">Radang :</span>
                        <span style="margin-left: 10px;">b. Kiri</span>
                    </div>
                </td>
                <td>{{ $anggotaKelas?->kesehatanTelinga?->radang_kiri ?? '-' }}</td>
            </tr>
        </tbody>
    </table>

    <p style="font-weight: bold; margin-top: 10px; margin-bottom: 3px; text-align: left;">IV. GIGI DAN MULUT</p>
    <table border="1" cellspacing="0" cellpadding="2" style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr style="font-weight: bold; text-align: center;">
                <th style="width: 8%;">NO.</th>
                <th style="width: 32%;">KEADAAN</th>
                <th style="width: 15%;">BAIK</th>
                <th style="width: 18%;">KURANG BAIK</th>
                <th style="width: 27%;">KETERANGAN</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td style="text-align: center;">1</td>
                <td style="padding-left: 8px;">Gigi</td>
                <td style="text-align: center;">
                    @if(strtolower($anggotaKelas?->kesehatanGigi?->kesehatan_gigi) == 'baik')
                        <span style="font-family: 'DejaVu Sans', sans-serif;">&#10003;</span>                    
                    @endif
                </td>
                <td style="text-align: center;">
                    @if(strtolower($anggotaKelas?->kesehatanGigi?->kesehatan_gigi) == 'kurang baik')
                        <span style="font-family: 'DejaVu Sans', sans-serif;">&#10003;</span>                    
                    @endif
                </td>
                <td style="text-align: center;">
                    {{ $anggotaKelas?->kesehatanGigi?->keterangan }}
                </td>
            </tr>
            <tr>
                <td style="text-align: center;">2</td>
                <td style="padding-left: 8px;">Mulut</td>
                <td style="text-align: center;">
                    @if(strtolower($anggotaKelas?->kesehatanMulut?->kesehatan_mulut) == 'baik')
                        <span style="font-family: 'DejaVu Sans', sans-serif;">&#10003;</span>                    
                    @endif
                </td>
                <td style="text-align: center;">
                    @if(strtolower($anggotaKelas?->kesehatanMulut?->kesehatan_mulut) == 'kurang baik')
                        <span style="font-family: 'DejaVu Sans', sans-serif;">&#10003;</span>                    
                    @endif
                </td>
                <td style="text-align: center;">
                    {{ $anggotaKelas?->kesehatanMulut?->keterangan }}
                </td>
            </tr>
        </tbody>
    </table>

    <br>
    <table border="1" cellspacing="0" cellpadding="2" style="width: 100%; border-collapse: collapse;">
        <tr>
            <td style="width: 40%; padding-left: 8px; font-weight: bold;">BERAT BADAN</td>
            <td style="width: 60%; padding-left: 8px;">{{ $anggotaKelas?->kondisiTubuh?->berat_badan ?? '-' }} Kg</td>
        </tr>
        <tr>
            <td style="padding-left: 8px; font-weight: bold;">TINGGI BADAN</td>
            <td style="padding-left: 8px;">{{ $anggotaKelas?->kondisiTubuh?->tinggi_badan ?? '-' }} Cm</td>
        </tr>
    </table>

    <div class="page-break"></div>

    <div class="content">
        <h3 style="line-height: 1.6">
          <strong>LAPORAN KEHADIRAN</strong>
        </h3>
        <div class="invoice-box">
            <table style="width: 100%; border-collapse: collapse; border: 1px solid black;">
                <thead>
                    <tr>
                        <th style="width: 10%; text-align: center; border: 1px solid black; padding: 6px;">NO.</th>
                        <th style="width: 90%; text-align: center; border: 1px solid black; padding: 6px;" colspan="2">KETIDAKHADIRAN</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="text-align: center; border: 1px solid black; padding: 6px;">1</td>
                        <td style="width: 50%; border: 1px solid black; padding: 6px;">Sakit</td>
                        <td style="text-align: center; border: 1px solid black; padding: 6px;">
                            {{ $anggotaKelas->kehadiran->sakit ? $anggotaKelas->kehadiran->sakit . ' hari' : '—' }}
                        </td>
                    </tr>
                    <tr>
                        <td style="text-align: center; border: 1px solid black; padding: 6px;">2</td>
                        <td style="border: 1px solid black; padding: 6px;">Izin</td>
                        <td style="text-align: center; border: 1px solid black; padding: 6px;">
                            {{ $anggotaKelas->kehadiran->izin ? $anggotaKelas->kehadiran->izin . ' hari' : '—' }}
                        </td>
                    </tr>
                    <tr>
                        <td style="text-align: center; border: 1px solid black; padding: 6px;">3</td>
                        <td style="border: 1px solid black; padding: 6px;">Tanpa Keterangan</td>
                        <td style="text-align: center; border: 1px solid black; padding: 6px;">
                            {{ $anggotaKelas->kehadiran->tanpa_keterangan ? $anggotaKelas->kehadiran->tanpa_keterangan . ' hari' : '—' }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div><br>

        <div class="invoice-box">
            <table style="width: 100%; border-collapse: collapse; border: 1px solid black;">
                <tr>
                    <td style="width: 60%; border: 1px solid black; padding: 8px; vertical-align: top;">
                        <div style="text-align: center; font-weight: bold; margin-bottom: 8px;">
                            Komentar Guru
                        </div>
                        <div style="text-align: justify; line-height: 1.4; font-size: 11pt;">
                            {{ $anggotaKelas->catatan->catatan ?? '-' }}
                        </div>
                    </td>
                    <td style="width: 40%; border: 1px solid black; padding: 8px; text-align: center; vertical-align: top;">
                        <div style="font-weight: bold; margin-bottom: 90px;">
                            Tanda tangan Guru
                        </div>
                        <div style="font-weight: bold; text-decoration: underline;">
                            {{ $anggotaKelas->kelas->waliKelas->nama_guru ?? '-' }}
                        </div>
                        <div>
                            NUPTK. {{ $anggotaKelas->kelas->waliKelas->nip ?? '-' }}
                        </div>
                    </td>
                </tr>

                <tr>
                    <td style="border: 1px solid black; padding: 8px; vertical-align: top;">
                        <div style="text-align: center; font-weight: bold; margin-bottom: 8px;">
                            Komentar Orang Tua
                        </div>
                        <div style="border-bottom: 1px solid #aaa; margin-bottom: 12px; height: 12px;"></div>
                        <div style="border-bottom: 1px solid #aaa; margin-bottom: 12px; height: 12px;"></div>
                        <div style="border-bottom: 1px solid #aaa; margin-bottom: 12px; height: 12px;"></div>
                        <div style="border-bottom: 1px solid #aaa; margin-bottom: 12px; height: 12px;"></div>
                        <div style="border-bottom: 1px solid #aaa; margin-bottom: 5px; height: 12px;"></div>
                    </td>
                    <td style="border: 1px solid black; padding: 8px; text-align: center; vertical-align: top;">
                        <div style="font-weight: bold; margin-bottom: 90px;">
                            Tanda tangan Orang Tua
                        </div>
                        <div>
                            ...................................................
                        </div>
                    </td>
                </tr>
            </table>
        </div>

        <table style="width: 100%; margin-top: 25px; border-collapse: collapse;">
            <tr>
                <td style="width: 55%;"></td>
                <td style="width: 45%; text-align: center; vertical-align: top;">
                    Garut, {{ isset($tahunAjaranAktif->titimangsa) ? 
                    \Carbon\Carbon::parse($tahunAjaranAktif->titimangsa)->locale('id')->translatedFormat('d F Y') : '-' }}
                <div>Mengetahui,</div>
                <div>Kepala Taman Kanak-Kanak Islam Plus</div>
                <div style="font-weight: bold; margin-bottom: 60px;">PRIMA INSANI</div>

                <div style="font-weight: bold; text-decoration: underline;">
                    {{ $tahunAjaranAktif->kepala_sekolah ?? '-' }}
                </div>
                <div>
                        NUPTK. {{ $tahunAjaranAktif->nuptk ?? '-' }}
                </div>
                </td>
            </tr>
        </table>
    </body>
</html>

