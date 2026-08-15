<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Kehadiran Peserta</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: sans-serif;
            font-size: 11px;
            color: #222;
            padding: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 16px;
        }

        .header h1 {
            font-size: 16px;
            color: #7a1010;
            margin-bottom: 4px;
        }

        .header p {
            font-size: 11px;
            color: #555;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead th {
            text-align: left;
            padding: 8px 10px;
            background: #faf5ea;
            color: #7a1010;
            font-weight: 700;
            border: 1px solid #e0d6c0;
        }

        tbody td {
            padding: 6px 10px;
            border: 1px solid #eee;
        }

        tbody tr:nth-child(even) {
            background: #fafafa;
        }

        .footer-note {
            margin-top: 18px;
            font-size: 10px;
            color: #555;
            text-align: right;
        }

        /* === Rekap === */
        .rekap-wrap {
            margin-top: 26px;
            page-break-inside: avoid;
        }

        .rekap-title {
            font-size: 13px;
            font-weight: 700;
            color: #7a1010;
            margin-bottom: 10px;
            padding-bottom: 4px;
            border-bottom: 1.5px solid #7a1010;
        }

        .rekap-section {
            margin-bottom: 16px;
        }

        .rekap-section-label {
            font-size: 11px;
            font-weight: 700;
            color: #444;
            margin-bottom: 6px;
        }

        .rekap-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 4px;
        }

        .rekap-table th {
            text-align: left;
            padding: 6px 10px;
            background: #faf5ea;
            color: #7a1010;
            font-weight: 700;
            border: 1px solid #e0d6c0;
            font-size: 10.5px;
        }

        .rekap-table td {
            padding: 6px 10px;
            border: 1px solid #eee;
            font-size: 10.5px;
        }

        .rekap-table td.angka,
        .rekap-table th.angka {
            text-align: center;
            width: 60px;
        }

        .rekap-table tfoot td {
            font-weight: 700;
            background: #fdf3e0;
            color: #7a1010;
        }

        .ringkasan-grid {
            display: table;
            width: 100%;
            border-collapse: collapse;
            margin-top: 4px;
        }

        .ringkasan-row {
            display: table-row;
        }

        .ringkasan-box {
            display: table-cell;
            width: 50%;
            padding: 10px 14px;
            border: 1px solid #eecf9a;
            background: #fdf3e0;
            vertical-align: middle;
        }

        .ringkasan-box + .ringkasan-box {
            border-left: none;
        }

        .ringkasan-label {
            font-size: 10px;
            color: #8a6414;
            margin-bottom: 2px;
        }

        .ringkasan-value {
            font-size: 16px;
            font-weight: 700;
            color: #7a1010;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Laporan Kehadiran Malam Tirakatan Puri Potorono Asri</h1>
        <p>16 Agustus 2026</p>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width:5%;">No</th>
                <th style="width:35%;">Nama Lengkap</th>
                <th style="width:10%;">Usia</th>
                <th style="width:10%;">Blok</th>
                <th style="width:15%;">No. Rumah</th>
                <th style="width:25%;">Waktu Daftar</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($data as $i => $row)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $row->nama_lengkap }}</td>
                    <td>{{ $row->usia }}</td>
                    <td>{{ $row->blok_rumah }}</td>
                    <td>{{ $row->nomor_rumah }}</td>
                    <td>{{ $row->created_at->copy()->addHours(7)->format('d M Y H:i') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align:center; padding:16px;">Tidak ada data.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{-- ================= REKAP LAPORAN ================= --}}
    <div class="rekap-wrap">
        <div class="rekap-title">Rekapitulasi Kehadiran</div>

        {{-- Ringkasan angka besar: total hadir & tepat waktu --}}
        <div class="rekap-section">
            <div class="ringkasan-grid">
                <div class="ringkasan-row">
                    <div class="ringkasan-box">
                        <div class="ringkasan-label">Total Warga Hadir</div>
                        <div class="ringkasan-value">{{ $totalHadir }} orang</div>
                    </div>
                    <div class="ringkasan-box">
                        <div class="ringkasan-label">Total Presensi Tidak Lebih dari Jam 20.00 WIB</div>
                        <div class="ringkasan-value">{{ $totalTepatWaktu }} orang</div>
                    </div>
                </div>
            </div>
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
                        <td>Anak-anak (5–11 tahun)</td>
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
                            <td>Lainnya (di bawah 5 tahun)</td>
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

    <div class="footer-note">
        Dicetak pada tanggal {{ $dicetakPada }}
    </div>
</body>
</html>