<?php

namespace App\Http\Requests;

use App\Models\Absensi;
use App\Services\NameMatcher;
use Illuminate\Contracts\Validation\Validator as ValidatorContract;
use Illuminate\Foundation\Http\FormRequest;

class StoreAbsensiRequest extends FormRequest
{
    // Maksimal peserta per submit: 1 orang utama + 2 peserta tambahan
    public const MAX_PESERTA = 3;

    // Nama 1 kata (mononim, mis. "Vivian") minimal harus sepanjang ini,
    // supaya tidak dipakai buat menyamarkan inisial ("Al", "Bo", dst).
    private const MIN_LENGTH_SINGLE_WORD = 3;

    // Untuk nama 2 kata atau lebih, tiap kata minimal sepanjang ini,
    // supaya token 1 huruf (inisial) ditolak sejak input pertama.
    private const MIN_LENGTH_PER_WORD = 2;

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'peserta' => ['required', 'array', 'min:1', 'max:' . self::MAX_PESERTA],

            'peserta.*.nama_lengkap' => [
                'required',
                'string',
                'max:255',
                function ($attribute, $value, $fail) {
                    $this->validateNamaLengkap((string) $value, $fail);
                },
            ],

            'peserta.*.usia' => ['required', 'integer', 'min:1', 'max:120'],
            'peserta.*.blok_rumah' => ['required', 'in:A,B,C,D,E'],
            'peserta.*.nomor_rumah' => ['required', 'string', 'max:20'],
        ];
    }

    public function messages(): array
    {
        return [
            'peserta.required' => 'Data peserta wajib diisi.',
            'peserta.max' => 'Maksimal ' . self::MAX_PESERTA . ' peserta per pengisian (1 Anda + 2 tambahan).',

            'peserta.*.nama_lengkap.required' => 'Nama lengkap wajib diisi.',

            'peserta.*.usia.required' => 'Usia wajib diisi.',
            'peserta.*.usia.integer' => 'Usia harus berupa angka.',
            'peserta.*.blok_rumah.required' => 'Blok rumah wajib dipilih.',
            'peserta.*.nomor_rumah.required' => 'Nomor rumah wajib diisi.',
        ];
    }

    /**
     * Validasi format nama lengkap.
     *
     * Aturan:
     * - Boleh 1 kata (mononim, mis. "Vivian"), asal panjangnya >= MIN_LENGTH_SINGLE_WORD,
     *   supaya nama pendek asli tetap diterima tapi inisial ("Al", "Bo") tetap ditolak.
     * - Kalau 2 kata atau lebih, setiap kata wajib huruf & panjangnya >= MIN_LENGTH_PER_WORD,
     *   supaya token 1 huruf ("J J Pratama") ditolak sejak awal.
     * - Hanya boleh huruf & spasi (tanpa angka/simbol).
     */
    private function validateNamaLengkap(string $value, \Closure $fail): void
    {
        $trimmed = trim($value);

        if ($trimmed === '') {
            return; // rule 'required' yang menangani ini
        }

        if (!preg_match('/^[\p{L}]+(?:\s+[\p{L}]+)*$/u', $trimmed)) {
            $fail('Nama hanya boleh berisi huruf dan spasi (tanpa angka/simbol).');
            return;
        }

        $tokens = preg_split('/\s+/u', $trimmed);

        if (count($tokens) === 1) {
            if (mb_strlen($tokens[0]) < self::MIN_LENGTH_SINGLE_WORD) {
                $fail('Nama terlalu pendek. Kalau nama Anda memang hanya 1 kata, tulis lengkap (bukan singkatan/inisial).');
            }
            return;
        }

        foreach ($tokens as $token) {
            if (mb_strlen($token) < self::MIN_LENGTH_PER_WORD) {
                $fail('Tuliskan nama lengkap, jangan disingkat atau pakai inisial. Contoh: "Joshua Jeconia Pratama", bukan "J J Pratama".');
                return;
            }
        }
    }

    /**
     * Tambahan validasi setelah rule dasar lolos: cek duplikat nama.
     */
    public function withValidator(ValidatorContract $validator): void
    {
        $validator->after(function (ValidatorContract $validator) {
            $this->checkDuplicateNames($validator);
        });
    }

    private function checkDuplicateNames(ValidatorContract $validator): void
    {
        $pesertaInput = $this->input('peserta', []);

        if (!is_array($pesertaInput) || empty($pesertaInput)) {
            return;
        }

        // Ambil semua nama yang pernah absen sebelumnya (histori penuh, bukan cuma
        // sesi ini), supaya orang yang coba absen ulang dari HP/browser lain tetap
        // terdeteksi meski nama diketik dengan singkatan berbeda.
        $namaTerdaftar = Absensi::query()->pluck('nama_lengkap')->all();

        $namaDalamSubmission = [];

        foreach ($pesertaInput as $index => $peserta) {
            $namaBaru = trim((string) ($peserta['nama_lengkap'] ?? ''));

            if ($namaBaru === '') {
                continue; // biarkan rule 'required' yang menangani pesannya
            }

            // Kalau field ini sudah gagal di rule sebelumnya (mis. gagal format),
            // tidak perlu dobel pesan error.
            if ($validator->errors()->has("peserta.{$index}.nama_lengkap")) {
                continue;
            }

            // 1) Cek melawan nama peserta lain dalam submission yang sama
            //    (misalnya orang iseng input nama dirinya sendiri 2x di 1 form).
            foreach ($namaDalamSubmission as $namaLain) {
                if (NameMatcher::isSameName($namaBaru, $namaLain)) {
                    $validator->errors()->add(
                        "peserta.{$index}.nama_lengkap",
                        'Nama ini tampak sama dengan salah satu peserta lain yang baru saja Anda input di form ini.'
                    );
                    break;
                }
            }

            // 2) Cek melawan seluruh histori nama yang sudah pernah absen,
            //    termasuk kalau ditulis dengan singkatan/inisial berbeda.
            foreach ($namaTerdaftar as $namaLama) {
                if (NameMatcher::isSameName($namaBaru, $namaLama)) {
                    $validator->errors()->add(
                        "peserta.{$index}.nama_lengkap",
                        'Nama ini terindikasi sudah pernah absen sebelumnya. Jika ini bukan Anda atau ada kesalahan, silakan hubungi panitia.'
                    );
                    break;
                }
            }

            $namaDalamSubmission[] = $namaBaru;
        }
    }
}