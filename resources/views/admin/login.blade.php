<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - Absensi Potaz</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Arial, sans-serif;
            background: #f5f5f7;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .card {
            width: 100%;
            max-width: 380px;
            background: #fff;
            border-radius: 14px;
            box-shadow: 0 2px 14px rgba(0,0,0,0.08);
            padding: 32px 28px;
        }

        .card h1 {
            font-size: 18px;
            color: #7a1010;
            margin-bottom: 4px;
        }

        .card p.sub {
            font-size: 13px;
            color: #888;
            margin-bottom: 22px;
        }

        .alert-error {
            background: #fdecec;
            border: 1px solid #f5b5b5;
            color: #a02020;
            padding: 10px 14px;
            border-radius: 8px;
            font-size: 13px;
            margin-bottom: 18px;
        }

        .form-row {
            margin-bottom: 16px;
        }

        .form-row label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: #444;
            margin-bottom: 6px;
        }

        .form-row input {
            width: 100%;
            padding: 10px 12px;
            font-size: 14px;
            border: 1px solid #ddd;
            border-radius: 8px;
        }

        .form-row input:focus {
            outline: none;
            border-color: #b5842a;
            box-shadow: 0 0 0 3px rgba(181,132,42,0.12);
        }

        .field-hint {
            display: block;
            font-size: 11.5px;
            color: #999;
            margin-top: 5px;
        }

        .btn-submit {
            width: 100%;
            padding: 12px;
            font-size: 14px;
            font-weight: 700;
            color: #fff;
            background: #7a1010;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            margin-top: 6px;
        }

        .btn-submit:hover {
            background: #641010;
        }
    </style>
</head>
<body>
    <div class="card">
        <h1>Login Admin</h1>
        <p class="sub">Absensi Malam Tirakatan - Potaz</p>

        @if ($errors->any())
            <div class="alert-error">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('admin.login.submit') }}">
            @csrf
            <div class="form-row">
                <label>Nama</label>
                <input type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="off" placeholder="Contoh: admin potaz">
            </div>
            <div class="form-row">
                <label>Password</label>
                <input type="password" name="password" required>
            </div>
            <button type="submit" class="btn-submit">Masuk</button>
        </form>
    </div>
</body>
</html>