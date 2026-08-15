<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Password default untuk setiap admin/panitia baru yang dibuat.
     */
    private const DEFAULT_PASSWORD = 'password1234';

    /**
     * Pastikan hanya user dengan name = 'Panitia' yang boleh membuat user baru.
     * Dicek di controller (bukan cuma disembunyikan di view) supaya tetap aman
     * walau ada yang coba akses URL-nya langsung.
     */
    private function pastikanPanitia(): void
    {
        if (Auth::user()?->name !== 'Panitia') {
            abort(403, 'Hanya Panitia yang bisa menambahkan user baru.');
        }
    }

    /**
     * Form tambah admin/panitia baru.
     */
    public function create()
    {
        $this->pastikanPanitia();

        return view('admin.users.create');
    }

    /**
     * Simpan user baru. Password otomatis di-set 'password1234'
     * (di-hash), admin tidak perlu isi password manual.
     */
    public function store(Request $request)
    {
        $this->pastikanPanitia();

        $validated = $request->validate([
            'name'  => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users', 'email')],
        ], [
            'name.required'  => 'Nama wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email'    => 'Format email tidak valid.',
            'email.unique'   => 'Email ini sudah terdaftar.',
        ]);

        $user = User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => Hash::make(self::DEFAULT_PASSWORD),
        ]);

        return redirect()
            ->route('admin.dashboard')
            ->with('status', 'User "' . $user->name . '" berhasil dibuat. Password default: ' . self::DEFAULT_PASSWORD . ' (mohon minta user ganti password setelah login pertama).');
    }

    /**
     * Halaman edit profil untuk user yang sedang login.
     * Bisa ubah nama & password, email tidak bisa diubah.
     */
    public function editProfile()
    {
        return view('admin.profile.edit', [
            'user' => Auth::user(),
        ]);
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ], [
            'name.required'       => 'Nama wajib diisi.',
            'password.min'        => 'Password minimal 8 karakter.',
            'password.confirmed'  => 'Konfirmasi password baru tidak cocok.',
        ]);

        $user->name = $validated['name'];

        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        return redirect()
            ->route('admin.profile.edit')
            ->with('status', 'Profil berhasil diperbarui.');
    }
}