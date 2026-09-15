<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style>
        @page {
            size: A4;
            margin: 20mm 18mm 18mm 18mm;
        }
        body { 
            font-family: 'Times New Roman', Times, serif; 
            font-size: 11pt; 
            color: #000000;
            line-height: 1.4; 
            margin: 0;
            padding: 0;
        }

        .title { text-align: center; margin-bottom: 25px; }
        .title h3 { 
            margin: 0; 
            font-size: 13pt; 
            text-transform: uppercase; 
            letter-spacing: 1px; 
            font-weight: bold;
            color: #000000;
        }

        .table-biodata { width: 100%; border-collapse: collapse; margin-bottom: 10px; }
        .table-biodata td { padding: 3px 0; vertical-align: top; font-size: 11pt; }
        .label-bold { font-weight: bold; }
        .sub-label { padding-left: 20px; }

        /* Style Pas Foto & Tanda Tangan Halaman 1 */
        .footer-biodata {
            width: 100%;
            margin-top: 30px;
        }
        .foto-box {
            width: 3cm;
            height: 4cm;
            border: 1px solid #000;
            text-align: center;
            vertical-align: middle;
            font-size: 10pt;
            font-weight: bold;
        }
        .ttd-box-bio {
            text-align: center;
            vertical-align: top;
            font-size: 11pt;
        }

        /* Style Tambahan untuk Halaman 2 & Seterusnya */
        .page-break {
            page-break-before: always;
        }
        .table-rapor {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
            page-break-inside: avoid;
            font-family: sans-serif;
        }
        .table-rapor th, .table-rapor td {
            border: 1px solid #000000;
            padding: 5px;
            font-size: 9.5pt;
        }
        .table-rapor th {
            background-color: transparent;
            text-align: center;
            color: #000000;
        }
        .kategori-title {
            font-family: sans-serif;
            font-weight: bold; 
            font-size: 10.5pt; 
            margin-top: 14px; 
            margin-bottom: 6px; 
            color: #000000;
            text-transform: uppercase;
        }
    </style>
</head>
<body>

    <!-- ======================================================== -->
    <!-- HALAMAN 1: KETERANGAN DIRI SISWA                        -->
    <!-- ======================================================== -->

    <div class="title">
        <h3>KETERANGAN DIRI SISWA</h3>
    </div>

    <table class="table-biodata">
        <tr>
            <td width="4%" class="label-bold">1.</td>
            <td width="35%" class="label-bold">Nama Anak Didik</td>
            <td width="3%">:</td>
            <td>{{ $siswa->nama_siswa ?? $siswa->nama ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label-bold">2.</td>
            <td class="label-bold">Nomor Induk</td>
            <td>:</td>
            <td>{{ $siswa->nis ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label-bold">3.</td>
            <td class="label-bold">NISN</td>
            <td>:</td>
            <td>{{ $siswa->nisn ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label-bold">4.</td>
            <td class="label-bold">Jenis Kelamin</td>
            <td>:</td>
            <td>{{ $siswa->jk ?? $siswa->jenis_kelamin ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label-bold">5.</td>
            <td class="label-bold">Tempat / Tgl. Lahir</td>
            <td>:</td>
            <td>{{ $siswa->ttl ?? ($siswa->tempat_lahir . ' / ' . $siswa->tanggal_lahir) ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label-bold">6.</td>
            <td class="label-bold">Agama</td>
            <td>:</td>
            <td>{{ $siswa->agama ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label-bold">7.</td>
            <td class="label-bold">Anak Ke</td>
            <td>:</td>
            <td>{{ $siswa->anak_ke ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label-bold">8.</td>
            <td class="label-bold" colspan="3">Nama Orang Tua/ Wali*</td>
        </tr>
        <tr>
            <td></td>
            <td class="sub-label">a. Ayah</td>
            <td>:</td>
            <td>{{ $siswa->nama_ayah ?? '-' }}</td>
        </tr>
        <tr>
            <td></td>
            <td class="sub-label">b. Ibu</td>
            <td>:</td>
            <td>{{ $siswa->nama_ibu ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label-bold">9.</td>
            <td class="label-bold" colspan="3">Pekerjaan Orang Tua/ Wali*</td>
        </tr>
        <tr>
            <td></td>
            <td class="sub-label">a. Ayah</td>
            <td>:</td>
            <td>{{ $siswa->pekerjaan_ayah ?? '-' }}</td>
        </tr>
        <tr>
            <td></td>
            <td class="sub-label">b. Ibu</td>
            <td>:</td>
            <td>{{ $siswa->pekerjaan_ibu ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label-bold">10.</td>
            <td class="label-bold">Alamat Orang Tua/ Wali*</td>
            <td>:</td>
            <td>{{ $siswa->alamat_ortu ?? $siswa->alamat ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label-bold">11.</td>
            <td class="label-bold">Telepon</td>
            <td>:</td>
            <td>{{ $siswa->no_hp ?? $siswa->telepon ?? '-' }}</td>
        </tr>
    </table>

    <table class="footer-biodata">
        <tr>
            <td width="40%" align="center">
                <div class="foto-box">
                    <br><br>Pas Foto<br>3X4
                </div>
            </td>
            <td width="60%" class="ttd-box-bio">
                Garut, 14 Juli 2025<br>
                Mengetahui,<br>
                Kepala Taman Kanak-kanak Islam Plus<br>
                <strong>PRIMA INSANI</strong>
                <br><br><br><br><br>
                <u><strong>Santi Rismayanti, M.Pd.</strong></u><br>
                <strong>NUPTK. 9453758659300022</strong>
            </td>
        </tr>
    </table>


    <!-- ======================================================== -->
    <!-- PEMISAH HALAMAN (PAGE BREAK)                             -->
    <!-- ======================================================== -->
    <div class="page-break"></div>


    <!-- ======================================================== -->
    <!-- HALAMAN 2: LAPORAN PENCAPAIAN PERKEMBANGAN               -->
    <!-- ======================================================== -->

    <div class="title" style="margin-bottom: 15px;">
        <h3>LAPORAN PENCAPAIAN PERKEMBANGAN ANAK DIDIK</h3>
    </div>

    <!-- Header Informasi Siswa -->
    <table class="table-biodata" style="margin-bottom: 15px;">
        <tr>
            <td width="15%">Nama Siswa</td>
            <td width="2%">:</td>
            <td width="38%"><strong>{{ $siswa->nama_siswa ?? $siswa->nama ?? '-' }}</strong></td>
            <td width="15%">Kelompok Usia</td>
            <td width="2%">:</td>
            <td width="28%">3-4 Tahun</td>
        </tr>
        <tr>
            <td>NIS / NISN</td>
            <td>:</td>
            <td>{{ $siswa->nis ?? '-' }} / {{ $siswa->nisn ?? '-' }}</td>
            <td>Tahun Ajaran</td>
            <td>:</td>
            <td>2023/2024</td>
        </tr>
        <tr>
            <td>Semester</td>
            <td>:</td>
            <td>Ganjil</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
    </table>

    @php
        // Daftar Kategori sesuai menu aplikasi kamu (Indikator dikosongkan dulu)
        $daftarCapaian = [
            'A. AQIDAH' => [],
            'B. IBADAH' => [],
            'C. AKHLAQ' => [],
            'D. DISIPLIN DAN KENDALI DIRI' => [],
            'E. AL-QURAN' => [],
            'F. WAWASAN KEAGAMAAN' => [],
            'G. KESEHATAN KEBUGARAN' => [],
            'H. LIFE SKILL DAN WIRAUSAHA' => [],
        ];
    @endphp

    @foreach($daftarCapaian as $judulKategori => $indikators)
        <div class="kategori-title">{{ $judulKategori }}</div>

        <table class="table-rapor">
            <thead>
                <tr>
                    <th rowspan="2" width="5%">NO</th>
                    <th rowspan="2" width="55%">INDIKATOR</th>
                    <th colspan="4" width="40%">CAPAIAN PERKEMBANGAN</th>
                </tr>
                <tr>
                    <th width="10%">BM</th>
                    <th width="10%">MM</th>
                    <th width="10%">BSH</th>
                    <th width="10%">BSB</th>
                </tr>
            </thead>
            <tbody>
                @forelse($indikators as $no => $text)
                    <tr>
                        <td style="text-align: center;">{{ $no + 1 }}</td>
                        <td>{{ $text }}</td>
                        <td style="text-align: center;"></td>
                        <td style="text-align: center;"></td>
                        <td style="text-align: center;">v</td>
                        <td style="text-align: center;"></td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="text-align: center; color: #777; font-style: italic;">
                            Belum ada indikator
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    @endforeach

</body>
</html>