<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kupon Undian - {{ $infoAcara['judul'] }}</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Arial, sans-serif;
            background: linear-gradient(180deg, #ffffff 0%, #ffffff 100%);
            color: #222;
            padding: 32px 16px 60px;
            min-height: 100vh;
        }
        .wrapper {
            max-width: 960px;
            margin: 0 auto;
        }
        .page-header {
            text-align: center;
            margin-bottom: 30px;
        }
        .page-header .eyebrow {
            display: inline-block;
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 2px;
            color: #b5842a;
            background: #fff8e8;
            border: 1px solid #e7cd8f;
            border-radius: 999px;
            padding: 5px 16px;
            margin-bottom: 12px;
        }
        .page-header h1 {
            font-size: 24px;
            color: #7a1010;
            margin-bottom: 8px;
            letter-spacing: 0.3px;
        }
        .page-header p {
            font-size: 13.5px;
            color: #7a7367;
        }
        .ticket-card {
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(122, 16, 16, 0.12), 0 2px 8px rgba(0,0,0,0.06);
            padding: 20px;
            margin-bottom: 26px;
            border: 1px solid #f0e4c8;
        }
        .ticket-number-badge {
            display: block;
            text-align: center;
            color: #701313;
            font-size: 18px;
            font-weight: 700;
            letter-spacing: 0.5px;
            margin-bottom: 10px;
        }
        canvas.ticket-canvas {
            width: 100%;
            height: auto;
            display: block;
            border-radius: 12px;
        }
        .ticket-loading {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 180px;
            color: #a5741f;
            font-size: 13px;
        }
        .ticket-actions {
            display: flex;
            justify-content: center;
            margin-top: 16px;
        }
        .btn-download {
            display: inline-block;
            padding: 10px 22px;
            font-size: 13.5px;
            font-weight: 600;
            color: #7a1010;
            background: #fff8e8;
            border: 1px solid #e7cd8f;
            border-radius: 8px;
            cursor: pointer;
            transition: background 0.15s ease;
        }
        .btn-download:hover {
            background: #fbeecb;
        }

        .back-link {
            display: block;
            text-align: center;
            margin-top: 30px;
            font-size: 13px;
            color: #8a8378;
            text-decoration: none;
        }
        .back-link:hover {
            color: #555;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="page-header">
            <span class="eyebrow">PERUM PURI POTORONO ASRI</span>
            <h1>Terima kasih, registrasi berhasil!</h1>
            <p>Simpan kupon undian di bawah ini.</p>
        </div>
        @foreach ($peserta as $i => $p)
            <div class="ticket-card">
                <span class="ticket-number-badge">#{{ $i + 1 }}</span>
                <canvas id="ticket-{{ $i }}" class="ticket-canvas" style="display:none;"></canvas>
                <div id="loading-{{ $i }}" class="ticket-loading">Memuat kupon…</div>
                <div class="ticket-actions">
                    <button type="button"
                            class="btn-download"
                            data-target="ticket-{{ $i }}"
                            data-filename="kupon-undian-{{ \Illuminate\Support\Str::slug($p->nama_lengkap) }}.png">
                        Unduh Kupon
                    </button>
                </div>
            </div>
        @endforeach
        <!-- <a href="{{ route('absensi.index') }}" class="back-link">&larr; Kembali ke halaman absensi</a> -->
    </div>
    <script>
        var ticketsData = @json($ticketsData);
        var TEMPLATE_BG_URL = "{{ asset('images/kupon-bg-hut-ri-81.webp') }}";
        var FOOTER_HEIGHT = 130;
        var LEFT_NUM_CENTER  = { x: 282,  y: 555 };
        var RIGHT_NUM_CENTER = { x: 1830, y: 555 };
        var DOWNLOAD_SCALE = 0.4;
        var DOWNLOAD_PADDING_RATIO = 0.06;
        function drawTicket(canvas, img, data) {
            var W = img.naturalWidth;
            var H = img.naturalHeight;
            canvas.width = W;
            canvas.height = H + FOOTER_HEIGHT;
            var ctx = canvas.getContext('2d');
            ctx.drawImage(img, 0, 0, W, H);
            ctx.save();
            ctx.textAlign = 'center';
            ctx.textBaseline = 'middle';
            ctx.fillStyle = '#f5d98a';
            ctx.shadowColor = 'rgba(0,0,0,0.55)';
            ctx.shadowBlur = 6;
            ctx.shadowOffsetY = 2;
            ctx.font = 'bold ' + Math.round(W * 0.033) + 'px Arial, sans-serif';
            ctx.fillText(data.nomor_undian, LEFT_NUM_CENTER.x, LEFT_NUM_CENTER.y);
            ctx.font = 'bold ' + Math.round(W * 0.028) + 'px Arial, sans-serif';
            ctx.fillText(data.nomor_undian, RIGHT_NUM_CENTER.x, RIGHT_NUM_CENTER.y);
            ctx.restore();
            var footerY = H;
            var footerGrad = ctx.createLinearGradient(0, footerY, 0, footerY + FOOTER_HEIGHT);
            footerGrad.addColorStop(0, '#3a0a0a');
            footerGrad.addColorStop(1, '#2a0707');
            ctx.fillStyle = footerGrad;
            ctx.fillRect(0, footerY, W, FOOTER_HEIGHT);
            ctx.strokeStyle = 'rgba(227,183,86,0.55)';
            ctx.lineWidth = 2;
            ctx.beginPath();
            ctx.moveTo(40, footerY + 6);
            ctx.lineTo(W - 40, footerY + 6);
            ctx.stroke();
            ctx.textAlign = 'center';
            ctx.textBaseline = 'middle';
            ctx.fillStyle = '#f5d98a';
            ctx.font = 'bold ' + Math.round(W * 0.019) + 'px Arial, sans-serif';
            ctx.fillText('Nama: ' + data.nama_lengkap, W / 2, footerY + FOOTER_HEIGHT * 0.4);
            ctx.fillStyle = '#f4e4c1';
            ctx.font = Math.round(W * 0.0155) + 'px Arial, sans-serif';
            ctx.fillText(
                'Blok / No. Rumah: ' + data.blok_rumah + ' / ' + data.nomor_rumah,
                W / 2,
                footerY + FOOTER_HEIGHT * 0.75
            );
        }
        function getFormattedTimestamp() {
            var now = new Date();
            var datePart = now.toLocaleDateString('id-ID', {
                day: 'numeric',
                month: 'long',
                year: 'numeric',
                timeZone: 'Asia/Jakarta'
            });
            var timePart = now.toLocaleTimeString('id-ID', {
                hour: '2-digit',
                minute: '2-digit',
                timeZone: 'Asia/Jakarta'
            });
            return datePart + ', ' + timePart + ' WIB';
        }
        function drawVerificationStamp(ctx, W, timestamp) {
            var stampX = LEFT_NUM_CENTER.x;
            var stampY = LEFT_NUM_CENTER.y + Math.round(W * 0.045);
            ctx.save();
            ctx.translate(stampX, stampY);
            ctx.rotate(-3 * Math.PI / 180);
            ctx.textAlign = 'center';
            ctx.textBaseline = 'middle';
            ctx.globalAlpha = 0.75;
            ctx.fillStyle = '#f5d98a';
            ctx.font = '300 ' + Math.round(W * 0.0105) + 'px Arial, sans-serif';
            ctx.fillText('terverifikasi dan dicetak pada:', 0, 0);
            ctx.font = '300 ' + Math.round(W * 0.0105) + 'px Arial, sans-serif';
            ctx.fillText(timestamp, 0, Math.round(W * 0.014));
            ctx.restore();
        }
        function buildRotatedDownloadCanvas(sourceCanvas, originalWidth) {
            var W = sourceCanvas.width;
            var H = sourceCanvas.height;
            var rotW = Math.round(H * DOWNLOAD_SCALE);
            var rotH = Math.round(W * DOWNLOAD_SCALE);
            var padding = Math.round(Math.min(rotW, rotH) * DOWNLOAD_PADDING_RATIO);
            var finalW = rotW + padding * 2;
            var finalH = rotH + padding * 2;
            var outCanvas = document.createElement('canvas');
            outCanvas.width = finalW;
            outCanvas.height = finalH;
            var ctx = outCanvas.getContext('2d');
            ctx.save();
            ctx.translate(finalW / 2, finalH / 2);
            ctx.rotate(90 * Math.PI / 180);
            ctx.scale(DOWNLOAD_SCALE, DOWNLOAD_SCALE);
            ctx.drawImage(sourceCanvas, -W / 2, -H / 2);
            ctx.translate(-W / 2, -H / 2);
            drawVerificationStamp(ctx, originalWidth, getFormattedTimestamp());
            ctx.restore();
            return outCanvas;
        }
        window.addEventListener('DOMContentLoaded', function () {
            var bgImg = new Image();
            bgImg.crossOrigin = 'anonymous';
            bgImg.onload = function () {
                ticketsData.forEach(function (data, i) {
                    var canvas = document.getElementById('ticket-' + i);
                    var loading = document.getElementById('loading-' + i);
                    if (!canvas) return;
                    drawTicket(canvas, bgImg, data);
                    canvas.style.display = 'block';
                    if (loading) loading.style.display = 'none';
                });
            };
            bgImg.onerror = function () {
                document.querySelectorAll('.ticket-loading').forEach(function (el) {
                    el.textContent = 'Gagal memuat gambar template. Pastikan file ' +
                        'kupon-bg-hut-ri-81.webp ada di public/images/.';
                    el.style.color = '#b31212';
                });
            };
            bgImg.src = TEMPLATE_BG_URL;
            document.querySelectorAll('.btn-download').forEach(function (btn) {
                btn.addEventListener('click', function () {
                    var canvas = document.getElementById(this.dataset.target);
                    if (!canvas || canvas.style.display === 'none') return;
                    var rotatedCanvas = buildRotatedDownloadCanvas(canvas, canvas.width);
                    var link = document.createElement('a');
                    link.download = this.dataset.filename || 'kupon-undian.png';
                    link.href = rotatedCanvas.toDataURL('image/png');
                    link.click();
                });
            });
        });
    </script>
</body>
</html>