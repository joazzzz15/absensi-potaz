<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Saya - Absensi Potaz</title>
    <style>
        *{box-sizing:border-box;margin:0;padding:0}body{font-family:-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,Arial,sans-serif;background:#f5f5f7;color:#222;padding:24px 16px 60px}.wrapper{max-width:560px;margin:0 auto}.top-bar{display:flex;align-items:center;justify-content:space-between;margin-bottom:20px;flex-wrap:wrap;gap:10px}.top-bar h1{font-size:20px;color:#7a1010}.btn-nav{color:#7a1010;background:#fff;border:1px solid #ddd;padding:9px 16px;font-size:13px;font-weight:600;border-radius:8px;text-decoration:none;display:inline-block}.btn-nav:hover{background:#faf5ea}.alert-status{background:#e8f7ec;border:1px solid #a9dfb8;color:#1c7a37;padding:12px 14px;border-radius:10px;font-size:13px;margin-bottom:16px}.alert-error{background:#fdecec;border:1px solid #f5b5b5;color:#a02020;padding:12px 14px;border-radius:10px;font-size:13px;margin-bottom:16px}.alert-error ul{margin:6px 0 0 18px}.card{background:#fff;border-radius:14px;box-shadow:0 2px 14px rgb(0 0 0 / .08);padding:20px}.field{display:flex;flex-direction:column;gap:6px;margin-bottom:16px;font-size:13px;color:#444}.field label{font-weight:600}.field input{padding:10px 12px;font-size:14px;border:1px solid #ddd;border-radius:8px}.field input:focus{outline:none;border-color:#7a1010}.field input[disabled]{background:#f2f2f2;color:#888}.field-hint{color:#888;font-size:12px}.field-error{color:#a02020;font-size:12px}.section-title{font-size:13px;font-weight:700;color:#7a1010;margin:20px 0 12px;padding-top:12px;border-top:1px solid #f0f0f0}.section-title:first-child{margin-top:0;padding-top:0;border-top:none}.form-actions{display:flex;gap:10px;margin-top:20px}.btn-submit{color:#fff;background:#7a1010;border:none;padding:10px 20px;font-size:14px;font-weight:600;border-radius:8px;cursor:pointer}.btn-submit:hover{background:#601010}.btn-batal{color:#7a1010;background:#fff;border:1px solid #7a1010;padding:10px 20px;font-size:14px;font-weight:600;border-radius:8px;text-decoration:none;display:inline-block}.btn-batal:hover{background:#fdecec}
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="top-bar">
            <h1>Profil Saya</h1>
            <a href="{{ route('admin.dashboard') }}" class="btn-nav">&larr; Kembali</a>
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

        <div class="card">
            <form method="POST" action="{{ route('admin.profile.update') }}">
                @csrf
                @method('PUT')

                <div class="section-title">Data Akun</div>

                <div class="field">
                    <label for="name">Nama</label>
                    <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                    @error('name')
                        <span class="field-error">{{ $message }}</span>
                    @enderror
                </div>

                <!-- <div class="field">
                    <label for="email">Email</label>
                    <input type="email" id="email" value="{{ $user->email }}" disabled>
                    <span class="field-hint">Email tidak dapat diubah.</span>
                </div> -->

                <div class="section-title">Ganti Password (opsional)</div>

                <div class="field">
                    <label for="password">Password Baru</label>
                    <input type="password" id="password" name="password" placeholder="Kosongkan jika tidak ingin mengganti password">
                    @error('password')
                        <span class="field-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="field">
                    <label for="password_confirmation">Konfirmasi Password Baru</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Ulangi password baru">
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn-submit">Simpan Perubahan</button>
                    <a href="{{ route('admin.dashboard') }}" class="btn-batal">Batal</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>