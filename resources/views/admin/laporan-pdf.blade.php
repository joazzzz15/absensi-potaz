<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Kehadiran Peserta</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 12px;
            color: #000;
            padding: 24px 28px;
            line-height: 1.4;
        }

        /* ================= KOP LAPORAN ================= */
        .kop {
            text-align: center;
            border-bottom: 3px double #000;
            padding-bottom: 10px;
            margin-bottom: 18px;
        }

        .kop .instansi {
            font-size: 13px;
            font-weight: 700;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }

        .kop .alamat {
            font-size: 10.5px;
            margin-top: 2px;
        }

        .judul-laporan {
            text-align: center;
            margin-bottom: 20px;
        }

        .judul-laporan h1 {
            font-size: 14px;
            font-weight: 700;
            text-transform: uppercase;
            text-decoration: underline;
            letter-spacing: 0.3px;
        }

        .judul-laporan p {
            font-size: 12px;
            margin-top: 3px;
        }

        /* ================= INFO CETAK ================= */
        .info-cetak {
            width: 100%;
            margin-bottom: 14px;
            font-size: 11px;
        }

        .info-cetak td {
            padding: 1px 0;
            vertical-align: top;
        }

        .info-cetak td.label {
            width: 120px;
        }

        .info-cetak td.titik-dua {
            width: 14px;
        }

        /* ================= TABEL DATA ================= */
        table.tabel-data {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 4px;
        }

        table.tabel-data th {
            text-align: center;
            padding: 7px 8px;
            background: #e9e9e9;
            font-weight: 700;
            border: 1px solid #000;
            font-size: 11px;
        }

        table.tabel-data td {
            padding: 5px 8px;
            border: 1px solid #000;
            font-size: 11px;
        }

        table.tabel-data td.center {
            text-align: center;
        }

        .footer-note {
            margin-top: 6px;
            font-size: 9.5px;
            color: #333;
            text-align: right;
            font-style: italic;
        }

        /* ================= REKAP ================= */
        .rekap-wrap {
            margin-top: 28px;
            page-break-inside: avoid;
        }

        .rekap-title {
            font-size: 12.5px;
            font-weight: 700;
            text-transform: uppercase;
            text-align: center;
            margin-bottom: 14px;
            padding-bottom: 6px;
            border-bottom: 1.5px solid #000;
        }

        .rekap-section {
            margin-bottom: 18px;
        }

        .rekap-section-label {
            font-size: 11.5px;
            font-weight: 700;
            margin-bottom: 6px;
        }

        table.rekap-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 4px;
        }

        table.rekap-table th {
            text-align: center;
            padding: 6px 8px;
            background: #e9e9e9;
            font-weight: 700;
            border: 1px solid #000;
            font-size: 10.5px;
        }

        table.rekap-table td {
            padding: 6px 8px;
            border: 1px solid #000;
            font-size: 10.5px;
        }

        table.rekap-table td.angka,
        table.rekap-table th.angka {
            text-align: center;
            width: 60px;
        }

        table.rekap-table tfoot td {
            font-weight: 700;
            background: #f2f2f2;
        }

        /* Ringkasan total hadir & tepat waktu */
        table.ringkasan-table {
            width: 100%;
            border-collapse: collapse;
        }

        table.ringkasan-table td {
            width: 50%;
            border: 1px solid #000;
            padding: 10px 14px;
            vertical-align: middle;
        }

        .ringkasan-label {
            font-size: 10.5px;
            margin-bottom: 3px;
        }

        .ringkasan-value {
            font-size: 15px;
            font-weight: 700;
        }

        /* ================= TANDA TANGAN ================= */
        .ttd-wrap {
            margin-top: 46px;
            page-break-inside: avoid;
        }

        table.ttd-table {
            width: 100%;
            border-collapse: collapse;
        }

        table.ttd-table td {
            width: 50%;
            text-align: center;
            font-size: 11.5px;
            vertical-align: top;
            padding: 0 20px;
        }

        .ttd-tempat-tanggal {
            margin-bottom: 4px;
        }

        .ttd-jabatan {
            margin-bottom: 60px;
        }

        .ttd-nama {
            font-weight: 700;
            text-decoration: underline;
        }
    </style>
</head>
<body>
    {{-- ================= KOP ================= --}}
    <div class="kop">
        <div class="instansi">Panitia Malam Tirakatan HUT RI Ke-81</div>
        <div class="instansi">Perumahan Puri Potorono Asri</div>
        <div class="alamat">Potorono, Banguntapan, Bantul, Daerah Istimewa Yogyakarta</div>
    </div>

    <div class="judul-laporan">
        <h1>Laporan Kehadiran Peserta</h1>
        <p>Malam Tirakatan Peringatan HUT Kemerdekaan Republik Indonesia Ke-81</p>
    </div>

    {{-- ================= INFO CETAK ================= --}}
    <table class="info-cetak">
        <tr>
            <td class="label">Hari / Tanggal Kegiatan</td>
            <td class="titik-dua">:</td>
            <td>Minggu, 16 Agustus 2026</td>
        </tr>
        <tr>
            <td class="label">Jumlah Data Peserta</td>
            <td class="titik-dua">:</td>
            <td>{{ $data->count() }} orang</td>
        </tr>
    </table>

    {{-- ================= TABEL DATA ================= --}}
    <table class="tabel-data">
        <thead>
            <tr>
                <th style="width:5%;">No</th>
                <th style="width:32%;">Nama Lengkap</th>
                <th style="width:9%;">Usia</th>
                <th style="width:9%;">Blok</th>
                <th style="width:15%;">No. Rumah</th>
                <th style="width:30%;">Waktu Daftar</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($data as $i => $row)
                <tr>
                    <td class="center">{{ $i + 1 }}</td>
                    <td>{{ $row->nama_lengkap }}</td>
                    <td class="center">{{ $row->usia }}</td>
                    <td class="center">{{ $row->blok_rumah }}</td>
                    <td class="center">{{ $row->nomor_rumah }}</td>
                    <td class="center">{{ $row->created_at->copy()->addHours(7)->format('d M Y H:i') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align:center; padding:16px;">Tidak ada data.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer-note">
        Dicetak pada tanggal {{ $dicetakPada }}
    </div>

    {{-- ================= REKAP LAPORAN ================= --}}
    <div class="rekap-wrap">
        <div class="rekap-title">Rekapitulasi Kehadiran</div>

        {{-- Ringkasan angka besar: total hadir & tepat waktu --}}
        <div class="rekap-section">
            <table class="ringkasan-table">
                <tr>
                    <td>
                        <div class="ringkasan-label">Total Warga Hadir</div>
                        <div class="ringkasan-value">{{ $totalHadir }} orang</div>
                    </td>
                    <td>
                        <div class="ringkasan-label">Presensi dibawah jam 20.00 WIB</div>
                        <div class="ringkasan-value">{{ $totalTepatWaktu }} orang</div>
                    </td>
                </tr>
            </table>
        </div>

        {{-- Total per blok --}}
        <div class="rekap-section">
            <div class="rekap-section-label">Total Warga Hadir per Blok</div>
            <table class="rekap-table">
                <thead>
                    <tr>
                        <th>Blok</th>
                        @foreach ($rekapBlok as $blok => $jumlah)
                            <th class="angka">{{ $blok }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Jumlah Warga</td>
                        @foreach ($rekapBlok as $blok => $jumlah)
                            <td class="angka">{{ $jumlah }}</td>
                        @endforeach
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <td>Total</td>
                        <td class="angka" colspan="{{ count($rekapBlok) }}">{{ array_sum($rekapBlok) }} orang</td>
                    </tr>
                </tfoot>
            </table>
        </div>

        {{-- Total per kelompok usia --}}
        <div class="rekap-section">
            <div class="rekap-section-label">Total Berdasarkan Kelompok Usia</div>
            <table class="rekap-table">
                <thead>
                    <tr>
                        <th>Kelompok Usia</th>
                        <th class="angka">Jumlah</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Anak-anak (1–11 tahun)</td>
                        <td class="angka">{{ $rekapUsia['anak'] }}</td>
                    </tr>
                    <tr>
                        <td>Remaja (12–25 tahun)</td>
                        <td class="angka">{{ $rekapUsia['remaja'] }}</td>
                    </tr>
                    <tr>
                        <td>Dewasa (26–45 tahun)</td>
                        <td class="angka">{{ $rekapUsia['dewasa'] }}</td>
                    </tr>
                    <tr>
                        <td>Orang Tua / Lansia (di atas 45 tahun)</td>
                        <td class="angka">{{ $rekapUsia['lansia'] }}</td>
                    </tr>
                    @if ($rekapUsia['lainnya'] > 0)
                        <tr>
                            <td>Lainnya (di bawah 1 tahun)</td>
                            <td class="angka">{{ $rekapUsia['lainnya'] }}</td>
                        </tr>
                    @endif
                </tbody>
                <tfoot>
                    <tr>
                        <td>Total</td>
                        <td class="angka">{{ array_sum($rekapUsia) }} orang</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    {{-- ================= TANDA TANGAN ================= --}}
    <div class="ttd-wrap">
        <table class="ttd-table">
            <tr>
                <td>
                    <div class="ttd-tempat-tanggal">Potorono, {{ \Carbon\Carbon::now()->addHours(7)->translatedFormat('d F Y') }}</div>
                    <div class="ttd-jabatan">Ketua Panitia</div>
                    <div class="ttd-nama">(...........................................)</div>
                </td>
                <td>
                    <div class="ttd-tempat-tanggal">&nbsp;</div>
                    <div class="ttd-jabatan">Mengetahui,<br>Ketua RT</div>
                    <div class="ttd-nama">(...........................................)</div>
                </td>
            </tr>
        </table>
    </div>
</body>
</html>