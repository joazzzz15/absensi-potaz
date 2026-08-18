<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Peserta - Absensi Potaz</title>
    <style>
       *{box-sizing:border-box;margin:0;padding:0}body{font-family:-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,Arial,sans-serif;background:#f5f5f7;color:#222;padding:24px 16px 60px}.wrapper{max-width:560px;margin:0 auto}.top-bar{display:flex;align-items:center;justify-content:space-between;margin-bottom:20px;flex-wrap:wrap;gap:10px}.top-bar h1{font-size:19px;color:#7a1010}.btn-back{font-size:13px;font-weight:600;color:#7a1010;background:#fff;border:1px solid #ddd;padding:8px 14px;border-radius:8px;text-decoration:none}.btn-back:hover{background:#faf5ea}.card{background:#fff;border-radius:14px;box-shadow:0 2px 14px rgb(0 0 0 / .08);padding:24px 20px}.alert-error{background:#fdecec;border:1px solid #f5b5b5;color:#a02020;padding:12px 14px;border-radius:10px;font-size:13px;margin-bottom:18px}.alert-error ul{margin:6px 0 0 18px}.notice-box{background:#fff8e8;border:1px solid #e7cd8f;color:#7a5c14;padding:12px 14px;border-radius:10px;font-size:12.5px;line-height:1.5;margin-bottom:20px}.form-row{margin-bottom:16px}.form-row label{display:block;font-size:13px;font-weight:600;color:#444;margin-bottom:6px}.form-row input,.form-row select{width:100%;padding:10px 12px;font-size:14px;border:1px solid #ddd;border-radius:8px;background:#fff;color:#222}.form-row input:focus,.form-row select:focus{outline:none;border-color:#b5842a;box-shadow:0 0 0 3px rgb(181 132 42 / .12)}.form-row-split{display:grid;grid-template-columns:1fr 1fr;gap:12px}@media (max-width:480px){.form-row-split{grid-template-columns:1fr}}.btn-submit{width:100%;padding:13px;font-size:14px;font-weight:700;color:#fff;background:#7a1010;border:none;border-radius:10px;cursor:pointer;margin-top:6px}.btn-submit:hover{background:#641010}
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="top-bar">
            <h1>Edit Peserta</h1>
            <a href="{{ route('admin.dashboard') }}" class="btn-back">&larr; Kembali</a>
        </div>

        <div class="card">

            @if ($errors->any())
                <div class="alert-error">
                    <strong>Ada data yang belum sesuai:</strong>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('admin.peserta.update', $peserta->id) }}">
                @csrf
                @method('PUT')

                <div class="form-row">
                    <label>Nama Lengkap</label>
                    <input type="text" name="nama_lengkap" required maxlength="255" value="{{ old('nama_lengkap', $peserta->nama_lengkap) }}">
                </div>

                <div class="form-row form-row-split">
                    <div>
                        <label>Usia</label>
                        <input type="number" name="usia" required min="1" max="120" value="{{ old('usia', $peserta->usia) }}">
                    </div>
                    <div>
                        <label>Blok Rumah</label>
                        <select name="blok_rumah" required>
                            <option value="">Pilih</option>
                            @foreach ($blokList as $blok)
                                <option value="{{ $blok }}" @selected(old('blok_rumah', $peserta->blok_rumah) === $blok)>{{ $blok }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-row">
                    <label>No. Rumah</label>
                    <input type="text" name="nomor_rumah" required maxlength="20" value="{{ old('nomor_rumah', $peserta->nomor_rumah) }}">
                </div>

                <div class="form-row">
                    <label>Nomor Undian</label>
                    <input type="text" name="nomor_undian" required maxlength="4" pattern="[0-9]{4}" inputmode="numeric" value="{{ old('nomor_undian', $peserta->nomor_undian) }}">
                </div>

                <button type="submit" class="btn-submit">Simpan Perubahan</button>
            </form>
        </div>
    </div>
</body>
</html>