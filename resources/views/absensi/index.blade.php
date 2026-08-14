<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Absensi Malam Tirakatan - Potaz</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Arial, sans-serif;
            background: #f5f5f7;
            color: #222;
            padding: 24px 16px;
            min-height: 100vh;
        }

        .wrapper {
            max-width: 640px;
            margin: 0 auto;
        }

        .card {
            background: #ffffff;
            border-radius: 14px;
            box-shadow: 0 2px 14px rgba(0,0,0,0.08);
            overflow: hidden;
        }

        .card-header {
            padding: 28px 28px 20px;
            border-bottom: 1px solid #eee;
        }

        .card-header .eyebrow {
            display: inline-block;
            font-size: 12px;
            font-weight: 700;
            letter-spacing: .08em;
            color: #b5842a;
            background: #fdf3e0;
            padding: 4px 10px;
            border-radius: 999px;
            margin-bottom: 10px;
        }

        .card-header h1 {
            font-size: 22px;
            font-weight: 700;
            color: #7a1010;
            margin-bottom: 6px;
        }

        .card-header p {
            font-size: 14px;
            color: #666;
        }

        .card-body {
            padding: 24px 28px 28px;
        }

        .notice-box {
            background: #fff8e8;
            border: 1px solid #e7cd8f;
            color: #7a5c14;
            padding: 12px 14px;
            border-radius: 10px;
            font-size: 12.5px;
            line-height: 1.5;
            margin-bottom: 20px;
        }

        .alert-error {
            background: #fdecec;
            border: 1px solid #f5b5b5;
            color: #a02020;
            padding: 14px 16px;
            border-radius: 10px;
            font-size: 13px;
            margin-bottom: 20px;
        }

        .alert-error ul {
            margin: 6px 0 0 18px;
        }

        .peserta-block {
            border: 1px solid #eaeaea;
            border-radius: 12px;
            padding: 18px;
            margin-bottom: 16px;
            background: #fafafa;
        }

        .peserta-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 14px;
        }

        .peserta-title {
            font-size: 14px;
            font-weight: 700;
            color: #333;
        }

        .btn-hapus-peserta {
            font-size: 12px;
            color: #a02020;
            background: none;
            border: 1px solid #f0b8b8;
            padding: 4px 10px;
            border-radius: 999px;
            cursor: pointer;
        }

        .btn-hapus-peserta:hover {
            background: #fdecec;
        }

        .form-row {
            margin-bottom: 14px;
        }

        .form-row label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: #444;
            margin-bottom: 6px;
        }

        .form-row input,
        .form-row select {
            width: 100%;
            padding: 10px 12px;
            font-size: 14px;
            border: 1px solid #ddd;
            border-radius: 8px;
            background: #fff;
            color: #222;
        }

        .form-row input:focus,
        .form-row select:focus {
            outline: none;
            border-color: #b5842a;
            box-shadow: 0 0 0 3px rgba(181,132,42,0.12);
        }

        .form-row input:disabled,
        .form-row select:disabled {
            background: #f0f0f0;
            color: #888;
            cursor: not-allowed;
        }

        .field-hint {
            display: block;
            font-size: 11.5px;
            color: #999;
            margin-top: 5px;
        }

        .form-row-split {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 12px;
        }

        @media (max-width: 480px) {
            .form-row-split {
                grid-template-columns: 1fr;
            }
        }

        .form-row-checkbox {
            margin-bottom: 14px;
        }

        .checkbox-label {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 13px;
            font-weight: 600;
            color: #444;
            cursor: pointer;
            background: #fdf3e0;
            border: 1px solid #e7cd8f;
            padding: 10px 12px;
            border-radius: 8px;
        }

        .checkbox-label input[type="checkbox"] {
            width: 16px;
            height: 16px;
            accent-color: #b5842a;
            cursor: pointer;
            flex-shrink: 0;
        }

        .btn-tambah-peserta {
            width: 100%;
            padding: 12px;
            font-size: 14px;
            font-weight: 600;
            color: #b5842a;
            background: #fdf3e0;
            border: 1px dashed #d9a441;
            border-radius: 10px;
            cursor: pointer;
            margin-bottom: 20px;
        }

        .btn-tambah-peserta:hover {
            background: #fbead0;
        }

        .btn-submit {
            width: 100%;
            padding: 14px;
            font-size: 15px;
            font-weight: 700;
            color: #fff;
            background: #7a1010;
            border: none;
            border-radius: 10px;
            cursor: pointer;
        }

        .btn-submit:hover {
            background: #641010;
        }

        .hint {
            font-size: 12px;
            color: #999;
            text-align: center;
            margin-top: 14px;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="card">
            <div class="card-header">
                <span class="eyebrow">PERUM PURI POTORONO ASRI</span>
                <h1>Malam Tirakatan HUT RI-81</h1>
                <p>Isi data diri Anda.</p>
            </div>

            <div class="card-body">
                <div class="notice-box">
                    <strong>Penting:</strong> Pastikan data yang anda masukkan <strong>terisi dengan benar.</strong>
                    Data yang tersimpan <strong>tidak dapat</strong> diubah — sistem akan mendeteksi nama yang
                    mengisi lebih dari 1 kali.
                </div>

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

                <form action="{{ route('absensi.store') }}" method="POST" id="form-absensi">
                    @csrf

                    <div id="peserta-container">
                        <div class="peserta-block" data-index="0">
                            <div class="peserta-header">
                                <span class="peserta-title">Peserta 1 (Anda)</span>
                            </div>
                            <div class="form-row">
                                <label>Nama Lengkap</label>
                                <input type="text" name="peserta[0][nama_lengkap]" data-field="nama_lengkap" required maxlength="255" placeholder="Isi Nama Lengkap" value="{{ old('peserta.0.nama_lengkap') }}">
                                <small class="field-hint">Tulis nama lengkap, jangan disingkat/inisial.</small>
                            </div>
                            <div class="form-row form-row-split">
                                <div>
                                    <label>Usia</label>
                                    <input type="number" name="peserta[0][usia]" data-field="usia" required min="1" max="120" placeholder="Usia" value="{{ old('peserta.0.usia') }}">
                                </div>
                                <div>
                                    <label>Blok Rumah</label>
                                    <select name="peserta[0][blok_rumah]" data-field="blok_rumah" id="first-blok-rumah" required>
                                        <option value="">Pilih</option>
                                        @foreach (['A', 'B', 'C', 'D', 'E'] as $blok)
                                            <option value="{{ $blok }}" @selected(old('peserta.0.blok_rumah') === $blok)>{{ $blok }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label>No. Rumah</label>
                                    <input type="text" name="peserta[0][nomor_rumah]" data-field="nomor_rumah" id="first-nomor-rumah" required maxlength="20" placeholder="No" value="{{ old('peserta.0.nomor_rumah') }}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="button" class="btn-tambah-peserta" id="btn-tambah-peserta">+ Tambah Peserta</button>
                    <button type="submit" class="btn-submit">Kirim</button>
                </form>
                <p class="hint">Formulir hanya berlaku satu kali disetiap perangkat.</p>
            </div>
        </div>
    </div>
    <template id="peserta-template">
        <div class="peserta-block">
            <div class="peserta-header">
                <span class="peserta-title">Peserta</span>
                <button type="button" class="btn-hapus-peserta">Hapus</button>
            </div>
            <div class="form-row">
                <label>Nama Lengkap</label>
                <input type="text" data-field="nama_lengkap" required maxlength="255" placeholder="Nama lengkap anggota keluarga">
                <small class="field-hint">Tulis nama lengkap, jangan disingkat/inisial.</small>
            </div>
            <div class="form-row-checkbox">
                <label class="checkbox-label">
                    <input type="checkbox" class="chk-sama-rumah">
                    Nomor rumah sama dengan<strong>Peserta 1</strong>
                </label>
            </div>
            <div class="form-row form-row-split">
                <div>
                    <label>Usia</label>
                    <input type="number" data-field="usia" required min="1" max="120" placeholder="Usia">
                </div>
                <div>
                    <label>Blok Rumah</label>
                    <select data-field="blok_rumah" required>
                        <option value="">Pilih</option>
                        <option value="A">A</option>
                        <option value="B">B</option>
                        <option value="C">C</option>
                        <option value="D">D</option>
                        <option value="E">E</option>
                    </select>
                </div>
                <div>
                    <label>No. Rumah</label>
                    <input type="text" data-field="nomor_rumah" required maxlength="20" placeholder="No">
                </div>
            </div>
        </div>
    </template>
    <script>
        (function () {
            var MAX_PESERTA = {{ (int) $maxPeserta }};
            var container = document.getElementById('peserta-container');
            var addBtn = document.getElementById('btn-tambah-peserta');
            var template = document.getElementById('peserta-template');
            var form = document.getElementById('form-absensi');
            var firstBlok = document.getElementById('first-blok-rumah');
            var firstNomor = document.getElementById('first-nomor-rumah');
            function renumber() {
                var blocks = container.querySelectorAll('.peserta-block');
                blocks.forEach(function (block, idx) {
                    block.dataset.index = idx;
                    var titleEl = block.querySelector('.peserta-title');
                    titleEl.textContent = idx === 0 ? 'Peserta 1 (Anda)' : 'Peserta ' + (idx + 1);
                    block.querySelectorAll('[data-field]').forEach(function (el) {
                        var field = el.dataset.field;
                        el.name = 'peserta[' + idx + '][' + field + ']';
                    });
                });
                addBtn.style.display = blocks.length >= MAX_PESERTA ? 'none' : 'block';
            }
            function syncSamaRumah(block) {
                var chk = block.querySelector('.chk-sama-rumah');
                var blokSel = block.querySelector('[data-field="blok_rumah"]');
                var nomorInput = block.querySelector('[data-field="nomor_rumah"]');
                if (!chk || !chk.checked) return;
                blokSel.value = firstBlok.value;
                nomorInput.value = firstNomor.value;
                blokSel.disabled = true;
                nomorInput.disabled = true;
            }
            addBtn.addEventListener('click', function () {
                var blocks = container.querySelectorAll('.peserta-block');
                if (blocks.length >= MAX_PESERTA) return;
                var clone = template.content.cloneNode(true);
                var block = clone.querySelector('.peserta-block');
                block.querySelector('.btn-hapus-peserta').addEventListener('click', function () {
                    block.remove();
                    renumber();
                });
                var chk = block.querySelector('.chk-sama-rumah');
                var blokSel = block.querySelector('[data-field="blok_rumah"]');
                var nomorInput = block.querySelector('[data-field="nomor_rumah"]');
                chk.addEventListener('change', function () {
                    if (chk.checked) {
                        syncSamaRumah(block);
                    } else {
                        blokSel.disabled = false;
                        nomorInput.disabled = false;
                    }
                });
                container.appendChild(clone);
                renumber();
            });
            function syncAllChecked() {
                container.querySelectorAll('.peserta-block').forEach(function (block) {
                    if (block.dataset.index === '0') return;
                    var chk = block.querySelector('.chk-sama-rumah');
                    if (chk && chk.checked) {
                        syncSamaRumah(block);
                    }
                });
            }
            firstBlok.addEventListener('change', syncAllChecked);
            firstNomor.addEventListener('input', syncAllChecked);
            form.addEventListener('submit', function () {
                form.querySelectorAll('[data-field][disabled]').forEach(function (el) {
                    el.disabled = false;
                });
            });
            renumber();
        })();
    </script>
</body>
</html>