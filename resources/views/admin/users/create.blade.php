<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah User - Absensi Potaz</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Arial, sans-serif;
            background: #f5f5f7;
            color: #222;
            padding: 24px 16px 60px;
        }

        .wrapper {
            max-width: 560px;
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

        .info-box {
            background: #fdf3e0;
            border: 1px solid #eecf9a;
            color: #8a6414;
            padding: 12px 14px;
            border-radius: 10px;
            font-size: 13px;
            margin-bottom: 16px;
        }

        .card {
            background: #fff;
            border-radius: 14px;
            box-shadow: 0 2px 14px rgba(0,0,0,0.08);
            padding: 20px;
        }

        .field {
            display: flex;
            flex-direction: column;
            gap: 6px;
            margin-bottom: 16px;
            font-size: 13px;
            color: #444;
        }

        .field label {
            font-weight: 600;
        }

        .field input {
            padding: 10px 12px;
            font-size: 14px;
            border: 1px solid #ddd;
            border-radius: 8px;
        }

        .field input:focus {
            outline: none;
            border-color: #7a1010;
        }

        .field-error {
            color: #a02020;
            font-size: 12px;
        }

        .form-actions {
            display: flex;
            gap: 10px;
            margin-top: 20px;
        }

        .btn-submit {
            color: #fff;
            background: #7a1010;
            border: none;
            padding: 10px 20px;
            font-size: 14px;
            font-weight: 600;
            border-radius: 8px;
            cursor: pointer;
        }

        .btn-submit:hover {
            background: #601010;
        }

        .btn-batal {
            color: #7a1010;
            background: #fff;
            border: 1px solid #7a1010;
            padding: 10px 20px;
            font-size: 14px;
            font-weight: 600;
            border-radius: 8px;
            text-decoration: none;
            display: inline-block;
        }

        .btn-batal:hover {
            background: #fdecec;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="top-bar">
            <h1>Tambah User Admin/Panitia</h1>
            <a href="{{ route('admin.dashboard') }}" class="btn btn-nav">&larr; Kembali</a>
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

        <div class="info-box">
            Password akan otomatis di-set ke <strong>password1234</strong> untuk user baru. Silakan sampaikan ke user yang bersangkutan untuk login lalu ganti password lewat halaman "Profil Saya".
        </div>

        <div class="card">
            <form method="POST" action="{{ route('admin.users.store') }}">
                @csrf

                <div class="field">
                    <label for="name">Nama</label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" placeholder="Contoh: Panitia / Tito / nama lain" required>
                    @error('name')
                        <span class="field-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="field">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="user@contoh.com" required>
                    @error('email')
                        <span class="field-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn-submit">Simpan User</button>
                    <a href="{{ route('admin.dashboard') }}" class="btn-batal">Batal</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>