<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Undian - Live</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }

        html, body {
            height: 100%;
            overflow: hidden;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Arial, sans-serif;
            background: radial-gradient(circle at center, #8a1414 0%, #4a0a0a 100%);
            color: #fff;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 30px;
            padding-bottom: 90px;
            position: relative;
        }

        .judul {
            font-size: 3vw;
            font-weight: 800;
            letter-spacing: 2px;
            margin-bottom: 10px;
            text-shadow: 0 3px 10px rgba(0,0,0,0.4);
        }

        .sub-judul {
            font-size: 1.3vw;
            color: #fcd88a;
            margin-bottom: 40px;
            letter-spacing: 3px;
            text-transform: uppercase;
        }

        .status-menunggu {
            font-size: 2vw;
            color: #fcd88a;
            animation: pulse 1.6s infinite ease-in-out;
        }

        @keyframes pulse {
            0%, 100% { opacity: 0.4; }
            50% { opacity: 1; }
        }

        .slot-wrap {
            display: flex;
            gap: 3vw;
            flex-wrap: wrap;
            justify-content: center;
        }

        .slot {
            background: rgba(255,255,255,0.08);
            border: 3px solid #fcd88a;
            border-radius: 20px;
            width: 15vw;
            min-width: 160px;
            height: 15vw;
            min-height: 160px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 0 30px rgba(252, 216, 138, 0.35);
        }

        .slot .angka {
            font-size: 5vw;
            font-weight: 900;
            color: #fff;
        }

        .slot.rolling .angka {
            color: #fcd88a;
        }

        .slot.landed {
            background: #fcd88a;
            border-color: #fff;
            box-shadow: 0 0 45px rgba(252, 216, 138, 0.9);
            transform: scale(1.05);
            transition: all 0.4s ease;
        }

        .slot.landed .angka {
            color: #7a1010;
        }

        .footer-info {
            margin-top: 40px;
            font-size: 1.1vw;
            color: rgba(255,255,255,0.6);
            letter-spacing: 1px;
        }

        /* ==== SPONSOR TICKER ==== */
        .sponsor-ticker-wrap {
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            padding: 14px 0;
            background: rgba(0,0,0,0.35);
            border-top: 2px solid rgba(252, 216, 138, 0.5);
            overflow: hidden;
            white-space: nowrap;
        }

        .sponsor-ticker-label {
            position: absolute;
            top: -22px;
            left: 20px;
            font-size: 0.9vw;
            color: rgba(255,255,255,0.5);
            letter-spacing: 2px;
            text-transform: uppercase;
        }

        .sponsor-ticker-track {
            display: inline-block;
            white-space: nowrap;
            animation: geserSponsor 32s linear infinite;
            font-size: 1.4vw;
            font-weight: 700;
            color: #fcd88a;
            letter-spacing: 1px;
        }

        .sponsor-ticker-track span {
            margin: 0 2.5vw;
            display: inline-block;
        }

        @keyframes geserSponsor {
            0%   { transform: translateX(0); }
            100% { transform: translateX(-50%); }
        }
    </style>
</head>
<body>
    <div class="judul">🎉UNDIAN 🎉</div>
    <div class="sub-judul">Malam Tirakatan Potaz</div>

    @if (!$batchTerbaru)
        <div class="status-menunggu" id="statusMenunggu">Menunggu pengundian dimulai...</div>
    @endif

    <div class="slot-wrap" id="slotWrap" style="{{ $batchTerbaru ? '' : 'display:none;' }}">
        @for ($i = 0; $i < 5; $i++)
            <div class="slot landed" id="slot-{{ $i }}">
                <div class="angka" id="angka-{{ $i }}">
                    {{ $batchTerbaru->data_pemenang[$i]['nomor_undian'] ?? '--' }}
                </div>
            </div>
        @endfor
    </div>

    <div class="footer-info" id="infoBatch">
        @if ($batchTerbaru)
            Batch Undian #{{ $batchTerbaru->batch_ke }}
        @endif
    </div>

    <div class="sponsor-ticker-wrap" id="sponsorTickerWrap">
        <div class="sponsor-ticker-label">Sponsor by</div>
        <div class="sponsor-ticker-track" id="sponsorTickerTrack">
            <span>Abekani</span>
            <span>The Bagbone</span>
            <span>Bakul Gundam</span>
            <span>Jawon Villa</span>
            <span>Tera Indonesia</span>
            <span>Gendhis Plug &amp; Play</span>
            <span>Sajadah Jogja</span>
            <span>Khananea Seprei Homade</span>
            <span>Sajian Kembang Turi</span>
            <span>Kopi Thiam</span>
            <span>Angkringan Om Wit</span>
            <span>Fabio Yoghurt</span>
            <span>Bandeng Presto SKT</span>
            <span>Bapak Wagiyo</span>
            <span>Bapak Reza</span>
            <span>Bapak Anton</span>
            <span>Bapak Waluyo</span>
            <span>Ibu Nuri</span>
            <span>Ibu Yuni</span>
            <span>Ibu Aris AKI</span>
            <span>Mama Ave</span>
            <span>Kak Sekar</span>
            <span>Blok C</span>
            <!-- duplikat supaya loop mulus -->
            <span>Abekani</span>
            <span>The Bagbone</span>
            <span>Bakul Gundam</span>
            <span>Jawon Villa</span>
            <span>Tera Indonesia</span>
            <span>Gendhis Plug &amp; Play</span>
            <span>Sajadah Jogja</span>
            <span>Khananea Seprei Homade</span>
            <span>Sajian Kembang Turi</span>
            <span>Kopi Thiam</span>
            <span>Angkringan Om Wit</span>
            <span>Fabio Yoghurt</span>
            <span>Bandeng Presto SKT</span>
            <span>Bapak Wagiyo</span>
            <span>Bapak Reza</span>
            <span>Bapak Anton</span>
            <span>Bapak Waluyo</span>
            <span>Ibu Nuri</span>
            <span>Ibu Yuni</span>
            <span>Ibu Aris AKI</span>
            <span>Mama Ave</span>
            <span>Kak Sekar</span>
            <span>Blok C</span>
        </div>
    </div>

    <script>
        // ==== KONFIGURASI ====
        const URL_LATEST = "{{ route('rolet.latest') }}";
        const INTERVAL_POLLING_MS = 2500;
        const DURASI_ROLLING_MS = 1800;
        const JEDA_ANTAR_SLOT_MS = 350;

        let lastBatchId = {{ $batchTerbaru ? $batchTerbaru->id : 'null' }};
        let sedangAnimasi = false;

        const slotWrap = document.getElementById('slotWrap');
        const statusMenunggu = document.getElementById('statusMenunggu');
        const infoBatch = document.getElementById('infoBatch');
        const sponsorTickerWrap = document.getElementById('sponsorTickerWrap');

        function angkaAcakTampilan() {
            return Math.floor(Math.random() * 900) + 100; // angka acak 3 digit untuk efek visual
        }

        function jalankanSlot(index, nomorAsli) {
            return new Promise((resolve) => {
                const slotEl = document.getElementById('slot-' + index);
                const angkaEl = document.getElementById('angka-' + index);

                slotEl.classList.remove('landed');
                slotEl.classList.add('rolling');

                const mulai = Date.now();
                const timer = setInterval(() => {
                    angkaEl.textContent = angkaAcakTampilan();

                    if (Date.now() - mulai >= DURASI_ROLLING_MS) {
                        clearInterval(timer);
                        angkaEl.textContent = nomorAsli;
                        slotEl.classList.remove('rolling');
                        slotEl.classList.add('landed');
                        resolve();
                    }
                }, 60);
            });
        }

        async function tampilkanHasilBaru(nomorArray, batchKe) {
            sedangAnimasi = true;

            if (statusMenunggu) {
                statusMenunggu.style.display = 'none';
            }
            // sponsor ticker tetap tampil baik saat menunggu maupun saat hasil undian muncul
            slotWrap.style.display = 'flex';

            for (let i = 0; i < 5; i++) {
                const nomor = nomorArray[i] !== undefined ? nomorArray[i] : '-';
                await jalankanSlot(i, nomor);
                await new Promise(r => setTimeout(r, JEDA_ANTAR_SLOT_MS));
            }

            infoBatch.textContent = 'Batch Undian #' + batchKe;
            sedangAnimasi = false;
        }

        async function cekPembaruan() {
            if (sedangAnimasi) return;

            try {
                const res = await fetch(URL_LATEST, { cache: 'no-store' });
                const data = await res.json();

                if (data.batch_id && data.batch_id !== lastBatchId) {
                    lastBatchId = data.batch_id;
                    tampilkanHasilBaru(data.nomor, data.batch_ke);
                }
            } catch (e) {
                console.error('Gagal mengambil data undian:', e);
            }
        }

        setInterval(cekPembaruan, INTERVAL_POLLING_MS);
    </script>
</body>
</html>