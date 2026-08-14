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

    <div class="footer-note">
        Dicetak pada tanggal {{ $dicetakPada }}
    </div>
</body>
</html>