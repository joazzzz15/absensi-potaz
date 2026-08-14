<?php
namespace App\Http\Controllers;
use App\Http\Requests\StoreAbsensiRequest;
use App\Models\Absensi;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
class AbsensiController extends Controller
{
    private array $infoAcara = [
        'judul'    => 'Kupon Undian Malam Tirakatan',
        'subjudul' => 'Semarak Kemerdekaan Indonesia Ke-81',
        'tanggal'  => 'Minggu, 16 Agustus 2026',
        'waktu'    => '19.30 WIB - Selesai',
        'lokasi'   => 'Perumahan Puri Potorono Asri',
    ];
    private const MAX_RETRY_NOMOR_UNDIAN = 10;

    public function index(Request $request)
    {
        if ($request->session()->has('absensi_group_id')) {
            return redirect()->route('absensi.hasil');
        }
        return view('absensi.index', [
            'maxPeserta' => StoreAbsensiRequest::MAX_PESERTA,
        ]);
    }
    public function store(StoreAbsensiRequest $request)
    {
        if ($request->session()->has('absensi_group_id')) {
            return redirect()->route('absensi.hasil');
        }
        $validated = $request->validated();
        $groupId = (string) Str::uuid();
        DB::transaction(function () use ($validated, $groupId) {
            foreach ($validated['peserta'] as $peserta) {
                $this->createPesertaDenganNomorUndianUnik($groupId, $peserta);
            }
        });
        $request->session()->put('absensi_group_id', $groupId);
        return redirect()->route('absensi.hasil');
    }
    private function createPesertaDenganNomorUndianUnik(string $groupId, array $peserta): Absensi
    {
        $percobaan = 0;

        while (true) {
            $percobaan++;
            try {
                return Absensi::create([
                    'session_id' => $groupId,
                    'nama_lengkap' => $peserta['nama_lengkap'],
                    'usia' => $peserta['usia'],
                    'blok_rumah' => $peserta['blok_rumah'],
                    'nomor_rumah' => $peserta['nomor_rumah'],
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
    public function hasil(Request $request)
    {
        $groupId = $request->session()->get('absensi_group_id');

        if (!$groupId) {
            return redirect()->route('absensi.index');
        }

        $peserta = Absensi::where('session_id', $groupId)
            ->orderBy('id')
            ->get();

        if ($peserta->isEmpty()) {
            $request->session()->forget('absensi_group_id');
            return redirect()->route('absensi.index');
        }
        $ticketsData = $peserta->map(function (Absensi $p) {
            return [
                'nama_lengkap' => $p->nama_lengkap,
                'blok_rumah' => $p->blok_rumah,
                'nomor_rumah' => $p->nomor_rumah,
                'nomor_undian' => $p->nomor_undian,
                'subjudul' => $this->infoAcara['subjudul'],
                'tanggal' => $this->infoAcara['tanggal'],
                'waktu' => $this->infoAcara['waktu'],
                'lokasi' => $this->infoAcara['lokasi'],
            ];
        })->values();

        return view('absensi.hasil', [
            'peserta' => $peserta,
            'ticketsData' => $ticketsData,
            'infoAcara' => $this->infoAcara,
        ]);
    }
    private function generateNomorUndianUnik(): string
    {
        do {
            $kode = str_pad((string) random_int(0, 9999), 4, '0', STR_PAD_LEFT);
        } while (Absensi::where('nomor_undian', $kode)->exists());

        return $kode;
    }
}