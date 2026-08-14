<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Absensi Potaz</title>
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

        .btn-nav {
            color: #7a1010;
            background: #fff;
            border: 1px solid #ddd;
        }

        .btn-nav:hover {
            background: #faf5ea;
        }

        .btn-tambah {
            color: #fff;
            background: #7a1010;
        }

        .btn-tambah:hover {
            background: #601010;
        }

        .btn-logout {
            padding: 8px 16px;
            font-size: 13px;
            font-weight: 600;
            color: #7a1010;
            background: #fdecec;
            border: 1px solid #f0b8b8;
            border-radius: 8px;
            cursor: pointer;
        }

        .btn-logout:hover {
            background: #fbdada;
        }

        .alert-status {
            background: #e8f7ec;
            border: 1px solid #a9dfb8;
            color: #1c7a37;
            padding: 12px 14px;
            border-radius: 10px;
            font-size: 13px;
            margin-bottom: 16px;
        }

        .alert-error {
            background: #fdecec;
            border: 1px solid #f5b5b5;
            color: #a02020;
            padding: 12px 14px;
            border-radius: 10px;
            font-size: 13px;
            margin-bottom: 16px;
        }

        .alert-error ul {
            margin: 6px 0 0 18px;
        }

        .toolbar {
            background: #fff;
            border-radius: 14px;
            box-shadow: 0 2px 14px rgba(0,0,0,0.08);
            padding: 16px;
            margin-bottom: 16px;
        }

        .toolbar-row {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            align-items: flex-end;
        }

        .field {
            display: flex;
            flex-direction: column;
            gap: 4px;
            font-size: 12px;
            color: #555;
        }

        .field input,
        .field select {
            padding: 8px 10px;
            font-size: 13px;
            border: 1px solid #ddd;
            border-radius: 8px;
            min-width: 150px;
        }

        .field input[type="text"] {
            min-width: 200px;
        }

        .btn-primary {
            color: #fff;
            background: #7a1010;
        }

        .btn-primary:hover {
            background: #601010;
        }

        .btn-reset {
            color: #7a1010;
            background: #fff;
            border: 1px solid #7a1010;
        }

        .btn-reset:hover {
            background: #fdecec;
        }

        .btn-print {
            color: #b5842a;
            background: #fdf3e0;
            border: 1px solid #eecf9a;
        }

        .btn-print:hover {
            background: #fbe8c8;
        }

        .card {
            background: #fff;
            border-radius: 14px;
            box-shadow: 0 2px 14px rgba(0,0,0,0.08);
            overflow: hidden;
        }

        /* Bungkus tabel supaya bisa discroll horizontal di layar kecil,
           tanpa merusak layout tabel itu sendiri */
        .table-scroll {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        table {
            width: 100%;
            min-width: 760px; /* jaga supaya kolom tidak gepeng di layar sempit */
            border-collapse: collapse;
            font-size: 13px;
        }

        thead th {
            text-align: left;
            padding: 14px 16px;
            background: #faf5ea;
            color: #7a1010;
            font-weight: 700;
            border-bottom: 1px solid #eee;
            white-space: nowrap;
        }

        thead th a {
            color: inherit;
            text-decoration: none;
        }

        thead th a:hover {
            text-decoration: underline;
        }

        tbody td {
            padding: 12px 16px;
            border-bottom: 1px solid #f2f2f2;
            vertical-align: middle;
        }

        tbody tr:last-child td {
            border-bottom: none;
        }

        .badge-undian {
            display: inline-block;
            font-weight: 700;
            color: #b5842a;
            background: #fdf3e0;
            padding: 3px 10px;
            border-radius: 999px;
            white-space: nowrap;
        }

        .aksi-cell {
            display: flex;
            gap: 6px;
            white-space: nowrap;
        }

        .btn-aksi {
            padding: 6px 12px;
            font-size: 12px;
            font-weight: 600;
            border-radius: 6px;
            border: 1px solid transparent;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
        }

        .btn-edit {
            color: #1c5a9c;
            background: #eaf2fb;
            border: 1px solid #bcd7f2;
        }

        .btn-edit:hover {
            background: #d9e9fb;
        }

        .btn-hapus {
            color: #a02020;
            background: #fdecec;
            border: 1px solid #f0b8b8;
        }

        .btn-hapus:hover {
            background: #fbdada;
        }

        .empty {
            padding: 40px;
            text-align: center;
            color: #999;
            font-size: 14px;
        }

        .pagination-wrap {
            padding: 16px;
        }

        .sort-arrow {
            font-size: 10px;
            margin-left: 2px;
        }

        /* === Mobile friendly === */
        @media (max-width: 640px) {
            body {
                padding: 16px 10px 50px;
            }

            .top-bar h1 {
                font-size: 17px;
            }

            .top-bar-actions {
                width: 100%;
            }

            .top-bar-actions .btn,
            .top-bar-actions form {
                flex: 1 1 auto;
            }

            .top-bar-actions .btn-logout {
                width: 100%;
            }

            .toolbar-row {
                flex-direction: column;
                align-items: stretch;
            }

            .field {
                width: 100%;
            }

            .field input,
            .field select {
                width: 100%;
                min-width: 0;
            }

            .toolbar-row .btn {
                width: 100%;
                text-align: center;
            }
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="top-bar">
            <h1>Data Peserta &amp; Nomor Undian</h1>
            <div class="top-bar-actions">
                <a href="{{ route('admin.peserta.create') }}" class="btn btn-tambah">+ Tambah Peserta</a>
                <a href="{{ route('admin.rolet.index') }}" class="btn btn-nav">Undian</a>
                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button type="submit" class="btn-logout">Keluar</button>
                </form>
            </div>
        </div>

        @if (session('status'))
            <div class="alert-status">{{ session('status') }}</div>
        @endif

        @if ($errors->any())
            <div class="alert-error">
                <strong>Ada masalah:</strong>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- FILTER & SEARCH --}}
        <div class="toolbar">
            <form method="GET" action="{{ route('admin.dashboard') }}">
                <div class="toolbar-row">
                    <div class="field">
                        <label>Cari Nama</label>
                        <input type="text" name="search" placeholder="Nama peserta..." value="{{ $filters['search'] ?? '' }}">
                    </div>

                    <div class="field">
                        <label>Blok</label>
                        <select name="blok">
                            <option value="">Semua Blok</option>
                            @foreach (['A', 'B', 'C', 'D', 'E'] as $blokOpt)
                                <option value="{{ $blokOpt }}" {{ ($filters['blok'] ?? '') == $blokOpt ? 'selected' : '' }}>
                                    Blok {{ $blokOpt }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="field">
                        <label>Daftar Dari Tanggal</label>
                        <input type="date" name="tanggal_awal" value="{{ $filters['tanggal_awal'] ?? '' }}">
                    </div>

                    <div class="field">
                        <label>Daftar Sampai Tanggal</label>
                        <input type="date" name="tanggal_akhir" value="{{ $filters['tanggal_akhir'] ?? '' }}">
                    </div>

                    <div class="field">
                        <label>Urutkan Berdasarkan</label>
                        <select name="sort_by">
                            <option value="created_at" {{ $sortBy == 'created_at' ? 'selected' : '' }}>Waktu Daftar</option>
                            <option value="nomor_undian" {{ $sortBy == 'nomor_undian' ? 'selected' : '' }}>Nomor Undian</option>
                            <option value="usia" {{ $sortBy == 'usia' ? 'selected' : '' }}>Usia</option>
                            <option value="blok_rumah" {{ $sortBy == 'blok_rumah' ? 'selected' : '' }}>Blok &amp; No. Rumah</option>
                        </select>
                    </div>

                    <div class="field">
                        <label>Arah</label>
                        <select name="sort_dir">
                            <option value="asc" {{ $sortDir == 'asc' ? 'selected' : '' }}>Naik (A-Z / Kecil-Besar)</option>
                            <option value="desc" {{ $sortDir == 'desc' ? 'selected' : '' }}>Turun (Z-A / Besar-Kecil)</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary">Terapkan</button>
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-reset" style="text-decoration:none; display:inline-block;">Reset</a>
                    <button type="submit" formaction="{{ route('admin.dashboard.cetak') }}" formtarget="_blank" class="btn btn-print">
                        Cetak PDF Laporan
                    </button>
                </div>
            </form>
        </div>

        <div class="card">
            @if ($data->isEmpty())
                <div class="empty">Belum ada peserta yang absensi.</div>
            @else
                <div class="table-scroll">
                    <table>
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama Lengkap</th>
                                <th>
                                    <a href="{{ request()->fullUrlWithQuery(['sort_by' => 'usia', 'sort_dir' => ($sortBy == 'usia' && $sortDir == 'asc') ? 'desc' : 'asc']) }}">
                                        Usia
                                        @if ($sortBy == 'usia')
                                            <span class="sort-arrow">{{ $sortDir == 'asc' ? '▲' : '▼' }}</span>
                                        @endif
                                    </a>
                                </th>
                                <th>
                                    <a href="{{ request()->fullUrlWithQuery(['sort_by' => 'blok_rumah', 'sort_dir' => ($sortBy == 'blok_rumah' && $sortDir == 'asc') ? 'desc' : 'asc']) }}">
                                        Blok
                                        @if ($sortBy == 'blok_rumah')
                                            <span class="sort-arrow">{{ $sortDir == 'asc' ? '▲' : '▼' }}</span>
                                        @endif
                                    </a>
                                </th>
                                <th>No. Rumah</th>
                                <th>
                                    <a href="{{ request()->fullUrlWithQuery(['sort_by' => 'nomor_undian', 'sort_dir' => ($sortBy == 'nomor_undian' && $sortDir == 'asc') ? 'desc' : 'asc']) }}">
                                        No. Undian
                                        @if ($sortBy == 'nomor_undian')
                                            <span class="sort-arrow">{{ $sortDir == 'asc' ? '▲' : '▼' }}</span>
                                        @endif
                                    </a>
                                </th>
                                <th>
                                    <a href="{{ request()->fullUrlWithQuery(['sort_by' => 'created_at', 'sort_dir' => ($sortBy == 'created_at' && $sortDir == 'asc') ? 'desc' : 'asc']) }}">
                                        Waktu Daftar
                                        @if ($sortBy == 'created_at')
                                            <span class="sort-arrow">{{ $sortDir == 'asc' ? '▲' : '▼' }}</span>
                                        @endif
                                    </a>
                                </th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $i => $row)
                                <tr>
                                    <td>{{ $data->firstItem() + $i }}</td>
                                    <td>{{ $row->nama_lengkap }}</td>
                                    <td>{{ $row->usia }}</td>
                                    <td>{{ $row->blok_rumah }}</td>
                                    <td>{{ $row->nomor_rumah }}</td>
                                    <td><span class="badge-undian">{{ $row->nomor_undian }}</span></td>
                                    <td>{{ $row->created_at->copy()->addHours(7)->format('d M Y H:i') }}</td>
                                    <td>
                                        <div class="aksi-cell">
                                            <a href="{{ route('admin.peserta.edit', $row->id) }}" class="btn-aksi btn-edit">Edit</a>
                                            <form method="POST" action="{{ route('admin.peserta.destroy', $row->id) }}"
                                                  onsubmit="return confirm('Yakin hapus data \'{{ addslashes($row->nama_lengkap) }}\' (No. Undian {{ $row->nomor_undian }})? Data yang dihapus tidak dapat dikembalikan.');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn-aksi btn-hapus">Hapus</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="pagination-wrap">
                    {{ $data->links() }}
                </div>
            @endif
        </div>
    </div>
</body>
</html>