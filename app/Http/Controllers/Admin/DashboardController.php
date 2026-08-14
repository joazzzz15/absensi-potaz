<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Database\QueryException;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class DashboardController extends Controller
{
    private const MAX_RETRY_NOMOR_UNDIAN = 10;
    private const DAFTAR_BLOK = ['A', 'B', 'C', 'D', 'E'];

    public function index(Request $request)
    {
        $query = Absensi::query();

        // Search nama lengkap
        if ($request->filled('search')) {
            $query->where('nama_lengkap', 'like', '%' . $request->search . '%');
        }

        // Filter blok (A, B, C, D, E)
        if ($request->filled('blok')) {
            $query->where('blok_rumah', $request->blok);
        }

        // Filter rentang waktu daftar (paling awal - paling akhir)
        if ($request->filled('tanggal_awal')) {
            $query->whereDate('created_at', '>=', $request->tanggal_awal);
        }
        if ($request->filled('tanggal_akhir')) {
            $query->whereDate('created_at', '<=', $request->tanggal_akhir);
        }

        // Sorting
        $sortBy  = $request->get('sort_by', 'created_at');
        $sortDir = $request->get('sort_dir', 'desc');

        if (!in_array($sortDir, ['asc', 'desc'])) {
            $sortDir = 'desc';
        }

        switch ($sortBy) {
            case 'nomor_undian':
                $query->orderBy('nomor_undian', $sortDir);
                break;

            case 'usia':
                $query->orderBy('usia', $sortDir);
                break;

            case 'blok_rumah':
                // sort blok rumah otomatis ikut sort nomor rumah
                $query->orderBy('blok_rumah', $sortDir)
                      ->orderBy('nomor_rumah', $sortDir);
                break;

            case 'created_at':
            default:
                $sortBy = 'created_at';
                $query->orderBy('created_at', $sortDir);
                break;
        }

        $data = $query->paginate(20)->withQueryString();

        return view('admin.dashboard', [
            'data'    => $data,
            'sortBy'  => $sortBy,
            'sortDir' => $sortDir,
            'filters' => $request->only(['search', 'blok', 'tanggal_awal', 'tanggal_akhir']),
        ]);
    }

    /**
     * Cetak PDF laporan kehadiran.
     * Selalu diurutkan berdasarkan Blok lalu Nomor Rumah,
     * mengikuti filter (search/blok/tanggal) yang aktif di halaman.
     */
    public function cetakPdf(Request $request)
    {
        $query = Absensi::query();

        if ($request->filled('search')) {
            $query->where('nama_lengkap', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('blok')) {
            $query->where('blok_rumah', $request->blok);
        }

        if ($request->filled('tanggal_awal')) {
            $query->whereDate('created_at', '>=', $request->tanggal_awal);
        }
        if ($request->filled('tanggal_akhir')) {
            $query->whereDate('created_at', '<=', $request->tanggal_akhir);
        }

        $data = $query->orderBy('blok_rumah', 'asc')
                       ->orderBy('nomor_rumah', 'asc')
                       ->get();

        $dicetakPada = Carbon::now()->addHours(7)->translatedFormat('d F Y H:i') . ' WIB';

        $pdf = Pdf::loadView('admin.laporan-pdf', [
            'data'        => $data,
            'dicetakPada' => $dicetakPada,
        ])->setPaper('a4', 'portrait');

        return $pdf->stream('laporan-absensi-' . Carbon::now()->format('Ymd-His') . '.pdf');
    }

    /**
     * Form tambah peserta baru oleh admin.
     */
    public function create()
    {
        return view('admin.peserta.create', [
            'blokList' => self::DAFTAR_BLOK,
        ]);
    }

    /**
     * Simpan peserta baru. Nomor undian dibuat otomatis & dijamin unik
     * (sama seperti alur pendaftaran publik), admin tidak perlu isi manual.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_lengkap' => ['required', 'string', 'max:255'],
            'usia'         => ['required', 'integer', 'min:1', 'max:120'],
            'blok_rumah'   => ['required', Rule::in(self::DAFTAR_BLOK)],
            'nomor_rumah'  => ['required', 'string', 'max:20'],
        ], [
            'nama_lengkap.required' => 'Nama lengkap wajib diisi.',
            'usia.required'         => 'Usia wajib diisi.',
            'blok_rumah.required'   => 'Blok rumah wajib dipilih.',
            'nomor_rumah.required'  => 'Nomor rumah wajib diisi.',
        ]);

        $peserta = $this->createPesertaDenganNomorUndianUnik($validated);

        return redirect()
            ->route('admin.dashboard')
            ->with('status', 'Peserta "' . $peserta->nama_lengkap . '" berhasil ditambahkan. Nomor undian: ' . $peserta->nomor_undian . '.');
    }

    /**
     * Form edit data peserta.
     */
    public function edit(Absensi $peserta)
    {
        return view('admin.peserta.edit', [
            'peserta'  => $peserta,
            'blokList' => self::DAFTAR_BLOK,
        ]);
    }

    /**
     * Update data peserta. Nomor undian boleh diubah manual oleh admin,
     * tetap divalidasi harus 4 digit angka & unik (kecuali milik peserta ini sendiri).
     */
    public function update(Request $request, Absensi $peserta)
    {
        $validated = $request->validate([
            'nama_lengkap' => ['required', 'string', 'max:255'],
            'usia'         => ['required', 'integer', 'min:1', 'max:120'],
            'blok_rumah'   => ['required', Rule::in(self::DAFTAR_BLOK)],
            'nomor_rumah'  => ['required', 'string', 'max:20'],
            'nomor_undian' => [
                'required',
                'string',
                'regex:/^[0-9]{4}$/',
                Rule::unique('absensis', 'nomor_undian')->ignore($peserta->id),
            ],
        ], [
            'nama_lengkap.required'  => 'Nama lengkap wajib diisi.',
            'usia.required'          => 'Usia wajib diisi.',
            'blok_rumah.required'    => 'Blok rumah wajib dipilih.',
            'nomor_rumah.required'   => 'Nomor rumah wajib diisi.',
            'nomor_undian.required'  => 'Nomor undian wajib diisi.',
            'nomor_undian.regex'     => 'Nomor undian harus 4 digit angka (contoh: 0231).',
            'nomor_undian.unique'    => 'Nomor undian ini sudah dipakai peserta lain.',
        ]);

        try {
            $peserta->update($validated);
        } catch (QueryException $e) {
            // Jaga-jaga kalau ada tabrakan unik di detik terakhir (race condition).
            return back()
                ->withErrors(['nomor_undian' => 'Nomor undian baru saja dipakai peserta lain, silakan pakai nomor lain.'])
                ->withInput();
        }

        return redirect()
            ->route('admin.dashboard')
            ->with('status', 'Data "' . $peserta->nama_lengkap . '" berhasil diperbarui.');
    }

    /**
     * Hapus data peserta.
     */
    public function destroy(Absensi $peserta)
    {
        $nama = $peserta->nama_lengkap;
        $peserta->delete();

        return redirect()
            ->route('admin.dashboard')
            ->with('status', 'Data "' . $nama . '" berhasil dihapus.');
    }

    /**
     * Buat peserta baru dengan nomor undian yang dijamin unik.
     * Kalau terjadi bentrok unique constraint di database
     * (misalnya ada request lain yang barengan), otomatis coba lagi
     * dengan nomor baru sampai berhasil atau batas percobaan habis.
     */
    private function createPesertaDenganNomorUndianUnik(array $data): Absensi
    {
        $percobaan = 0;

        while (true) {
            $percobaan++;

            try {
                return Absensi::create([
                    'session_id'   => (string) Str::uuid(),
                    'nama_lengkap' => $data['nama_lengkap'],
                    'usia'         => $data['usia'],
                    'blok_rumah'   => $data['blok_rumah'],
                    'nomor_rumah'  => $data['nomor_rumah'],
                    'nomor_undian' => $this->generateNomorUndianUnik(),
                ]);
            } catch (QueryException $e) {
                $isDuplicateError = $e->getCode() === '23000';

                if (!$isDuplicateError || $percobaan >= self::MAX_RETRY_NOMOR_UNDIAN) {
                    throw $e;
                }
            }
        }
    }

    private function generateNomorUndianUnik(): string
    {
        do {
            $kode = str_pad((string) random_int(0, 9999), 4, '0', STR_PAD_LEFT);
        } while (Absensi::where('nomor_undian', $kode)->exists());

        return $kode;
    }
}