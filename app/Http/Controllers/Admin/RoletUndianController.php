<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\UndianBatch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RoletUndianController extends Controller
{
    /**
     * Halaman PANITIA — bisa lihat nama pemilik nomor undian.
     */
    public function index()
    {
        $totalPeserta = Absensi::count();
        $sudahDiundi  = Absensi::where('sudah_diundi', true)->count();
        $belumDiundi  = $totalPeserta - $sudahDiundi;

        $riwayat = UndianBatch::orderByDesc('batch_ke')->get();

        $batchTerbaru = $riwayat->first();

        return view('admin.rolet-undian.index', [
            'totalPeserta' => $totalPeserta,
            'sudahDiundi'  => $sudahDiundi,
            'belumDiundi'  => $belumDiundi,
            'riwayat'      => $riwayat,
            'batchTerbaru' => $batchTerbaru,
        ]);
    }

    /**
     * Proses pengundian: ambil maksimal 5 nomor undian yang BELUM pernah dipanggil.
     */
    public function undi(Request $request)
    {
        $jumlahDiambil = 5;

        $kandidat = Absensi::where('sudah_diundi', false)
            ->inRandomOrder()
            ->limit($jumlahDiambil)
            ->get();

        if ($kandidat->isEmpty()) {
            return redirect()
                ->route('admin.rolet.index')
                ->with('error', 'Semua nomor undian sudah pernah dipanggil. Tidak ada peserta tersisa.');
        }

        $pesanTambahan = null;
        if ($kandidat->count() < $jumlahDiambil) {
            $pesanTambahan = 'Peserta yang tersisa hanya ' . $kandidat->count() . ' orang, jadi hanya itu yang diundi.';
        }

        $batchKe = (UndianBatch::max('batch_ke') ?? 0) + 1;

        $dataPemenang = [];

        DB::transaction(function () use ($kandidat, $batchKe, &$dataPemenang) {
            foreach ($kandidat as $row) {
                $row->sudah_diundi  = true;
                $row->diundi_pada   = now();
                $row->batch_undian  = $batchKe;
                $row->save();

                $dataPemenang[] = [
                    'nomor_undian'  => $row->nomor_undian,
                    'nama_lengkap'  => $row->nama_lengkap,
                    'usia'          => $row->usia,
                    'blok_rumah'    => $row->blok_rumah,
                    'nomor_rumah'   => $row->nomor_rumah,
                ];
            }

            UndianBatch::create([
                'batch_ke'      => $batchKe,
                'data_pemenang' => $dataPemenang,
            ]);
        });

        return redirect()
            ->route('admin.rolet.index')
            ->with('success', 'Pengundian batch ke-' . $batchKe . ' berhasil!')
            ->with('warning', $pesanTambahan);
    }

    /**
     * Reset total: semua status undian dikembalikan seperti semula.
     * Dipakai kalau mau mengulang sesi undian dari awal (misal gladi bersih).
     */
    public function reset(Request $request)
    {
        DB::transaction(function () {
            Absensi::query()->update([
                'sudah_diundi' => false,
                'diundi_pada'  => null,
                'batch_undian' => null,
            ]);

            UndianBatch::query()->delete();
        });

        return redirect()
            ->route('admin.rolet.index')
            ->with('success', 'Semua data undian berhasil direset.');
    }

    /**
     * Halaman TAMPILAN LCD — publik, HANYA menampilkan nomor undian (tanpa nama).
     */
    public function display()
    {
        $batchTerbaru = UndianBatch::orderByDesc('batch_ke')->first();

        return view('admin.rolet-undian.display', [
            'batchTerbaru' => $batchTerbaru,
        ]);
    }

    /**
     * Endpoint JSON untuk di-polling oleh halaman LCD.
     * Sengaja HANYA mengembalikan nomor undian, tanpa nama peserta,
     * karena endpoint ini publik (tidak pakai login).
     */
    public function latestJson()
    {
        $batchTerbaru = UndianBatch::orderByDesc('batch_ke')->first();

        if (!$batchTerbaru) {
            return response()->json([
                'batch_id' => null,
                'batch_ke' => null,
                'nomor'    => [],
            ]);
        }

        $nomorSaja = collect($batchTerbaru->data_pemenang)
            ->pluck('nomor_undian')
            ->values();

        return response()->json([
            'batch_id' => $batchTerbaru->id,
            'batch_ke' => $batchTerbaru->batch_ke,
            'nomor'    => $nomorSaja,
        ]);
    }
}