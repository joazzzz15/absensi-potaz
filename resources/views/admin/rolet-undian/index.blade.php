<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panitia - Undian</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Arial, sans-serif;
            background: #f5f5f7;
            color: #222;
            padding: 24px 16px 60px;
        }

        .wrapper {
            max-width: 1000px;
            margin: 0 auto;
        }

        .top-bar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
            flex-wrap: wrap;
            gap: 10px;
        }

        .top-bar h1 {
            font-size: 20px;
            color: #7a1010;
        }

        .top-bar-actions {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .btn {
            padding: 9px 16px;
            font-size: 13px;
            font-weight: 600;
            border-radius: 8px;
            border: 1px solid transparent;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
        }

        .btn-logout {
            color: #7a1010;
            background: #fdecec;
            border: 1px solid #f0b8b8;
        }

        .btn-logout:hover { background: #fbdada; }

        .btn-nav {
            color: #7a1010;
            background: #fff;
            border: 1px solid #ddd;
        }

        .btn-nav:hover { background: #faf5ea; }

        .alert {
            padding: 12px 16px;
            border-radius: 10px;
            margin-bottom: 16px;
            font-size: 13px;
        }

        .alert-success {
            background: #eaf7ee;
            color: #1e7a3a;
            border: 1px solid #b9e5c6;
        }

        .alert-error {
            background: #fdecec;
            color: #7a1010;
            border: 1px solid #f0b8b8;
        }

        .alert-warning {
            background: #fdf3e0;
            color: #8a5a00;
            border: 1px solid #eecf9a;
        }

        .stats-row {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 12px;
            margin-bottom: 20px;
        }

        .stat-card {
            background: #fff;
            border-radius: 14px;
            box-shadow: 0 2px 14px rgba(0,0,0,0.08);
            padding: 18px;
            text-align: center;
        }

        .stat-card .num {
            font-size: 26px;
            font-weight: 800;
            color: #7a1010;
        }

        .stat-card .label {
            font-size: 12px;
            color: #777;
            margin-top: 4px;
        }

        .action-card {
            background: #fff;
            border-radius: 14px;
            box-shadow: 0 2px 14px rgba(0,0,0,0.08);
            padding: 20px;
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 12px;
        }

        .action-card p {
            font-size: 13px;
            color: #666;
        }

        .btn-undi {
            background: #7a1010;
            color: #fff;
            padding: 14px 26px;
            font-size: 15px;
            font-weight: 700;
            border-radius: 10px;
            border: none;
            cursor: pointer;
        }

        .btn-undi:hover { background: #601010; }

        .btn-undi:disabled {
            background: #ccc;
            cursor: not-allowed;
        }

        .btn-reset-danger {
            background: #fff;
            color: #7a1010;
            border: 1px solid #7a1010;
            padding: 10px 18px;
            font-size: 13px;
            font-weight: 600;
            border-radius: 8px;
            cursor: pointer;
        }

        .btn-reset-danger:hover { background: #fdecec; }

        .card {
            background: #fff;
            border-radius: 14px;
            box-shadow: 0 2px 14px rgba(0,0,0,0.08);
            overflow: hidden;
            margin-bottom: 20px;
        }

        .card-header {
            padding: 16px 20px;
            border-bottom: 1px solid #eee;
            font-weight: 700;
            color: #7a1010;
            font-size: 14px;
        }

        .hasil-terbaru {
            padding: 20px;
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
        }

        .kartu-nomor {
            background: #faf5ea;
            border: 1px solid #eecf9a;
            border-radius: 12px;
            padding: 14px 18px;
            min-width: 160px;
        }

        .kartu-nomor .no-undian {
            font-size: 22px;
            font-weight: 800;
            color: #b5842a;
        }

        .kartu-nomor .nama {
            font-size: 13px;
            font-weight: 600;
            margin-top: 4px;
        }

        .kartu-nomor .alamat {
            font-size: 12px;
            color: #777;
            margin-top: 2px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
        }

        thead th {
            text-align: left;
            padding: 12px 16px;
            background: #faf5ea;
            color: #7a1010;
            font-weight: 700;
            border-bottom: 1px solid #eee;
        }

        tbody td {
            padding: 10px 16px;
            border-bottom: 1px solid #f2f2f2;
            vertical-align: top;
        }

        tbody tr:last-child td { border-bottom: none; }

        .badge-batch {
            display: inline-block;
            font-weight: 700;
            color: #fff;
            background: #7a1010;
            padding: 3px 10px;
            border-radius: 999px;
            font-size: 11px;
        }

        .empty {
            padding: 40px;
            text-align: center;
            color: #999;
            font-size: 14px;
        }

        @media (max-width: 600px) {
            .stats-row { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="top-bar">
            <h1>Undian - Panitia</h1>
            <div class="top-bar-actions">
                <a href="{{ route('admin.dashboard') }}" class="btn btn-nav">Data Peserta</a>
                <a href="{{ route('rolet.display') }}" target="_blank" class="btn btn-nav">Buka Tampilan LCD</a>
                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-logout">Keluar</button>
                </form>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if (session('warning'))
            <div class="alert alert-warning">{{ session('warning') }}</div>
        @endif

        @if (session('error'))
            <div class="alert alert-error">{{ session('error') }}</div>
        @endif

        <div class="stats-row">
            <div class="stat-card">
                <div class="num">{{ $totalPeserta }}</div>
                <div class="label">Total Hadir</div>
            </div>
            <div class="stat-card">
                <div class="num">{{ $sudahDiundi }}</div>
                <div class="label">Sudah Diundi</div>
            </div>
            <div class="stat-card">
                <div class="num">{{ $belumDiundi }}</div>
                <div class="label">Belum Diundi</div>
            </div>
        </div>

        <div class="action-card">
            <div>
                <p><strong>Tekan tombol</strong> untuk mengambil 5 nomor undian secara acak.<br>
                Nomor hanya akan muncul 1x</p>
            </div>
            <form method="POST" action="{{ route('admin.rolet.undi') }}">
                @csrf
                <button type="submit" class="btn-undi" {{ $belumDiundi == 0 ? 'disabled' : '' }}>
                    Mulai Undian (5 Nomor)
                </button>
            </form>
        </div>

        @if ($batchTerbaru)
            <div class="card">
                <div class="card-header">
                    Hasil Undian Terbaru — Batch #{{ $batchTerbaru->batch_ke }}
                </div>
                <div class="hasil-terbaru">
                    @foreach ($batchTerbaru->data_pemenang as $p)
                        <div class="kartu-nomor">
                            <div class="no-undian">{{ $p['nomor_undian'] }}</div>
                            <div class="nama">{{ $p['nama_lengkap'] }}</div>
                            <div class="alamat">Blok {{ $p['blok_rumah'] }} No. {{ $p['nomor_rumah'] }} • Usia {{ $p['usia'] }}</div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <div class="card">
            <div class="card-header">Riwayat Semua Pengundian</div>
            @if ($riwayat->isEmpty())
                <div class="empty">Belum ada pengundian yang dilakukan.</div>
            @else
                <table>
                    <thead>
                        <tr>
                            <th>Batch</th>
                            <th>Nomor &amp; Nama Pemenang</th>
                            <th>Waktu</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($riwayat as $batch)
                            <tr>
                                <td><span class="badge-batch">#{{ $batch->batch_ke }}</span></td>
                                <td>
                                    @foreach ($batch->data_pemenang as $p)
                                        <div style="margin-bottom:6px;">
                                            <strong>{{ $p['nomor_undian'] }}</strong> — {{ $p['nama_lengkap'] }}
                                            <span style="color:#999;">(Blok {{ $p['blok_rumah'] }} No. {{ $p['nomor_rumah'] }})</span>
                                        </div>
                                    @endforeach
                                </td>
                                <td>{{ $batch->created_at->copy()->addHours(7)->format('d M Y H:i') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>

        <form method="POST" action="{{ route('admin.rolet.reset') }}"
              onsubmit="return confirm('Yakin ingin reset SEMUA data undian? Semua nomor akan bisa diundi ulang dari awal dan riwayat akan terhapus. Tindakan ini tidak bisa dibatalkan.');">
            @csrf
            <button type="submit" class="btn-reset-danger">Reset Semua Data Undian</button>
        </form>
    </div>
</body>
</html>