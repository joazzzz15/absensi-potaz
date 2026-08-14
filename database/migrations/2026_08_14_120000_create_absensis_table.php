<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('absensis', function (Blueprint $table) {
            $table->id();

            // group_token menghubungkan 1 orang utama + peserta tambahan
            // yang di-submit dalam satu kali form (max 3 orang / submit)
            $table->string('session_id')->nullable()->index();

            $table->string('nama_lengkap');
            $table->unsignedTinyInteger('usia');
            $table->enum('blok_rumah', ['A', 'B', 'C', 'D', 'E']);
            $table->string('nomor_rumah', 20);

            // diisi belakangan oleh sistem saat generate undian
            $table->string('nomor_undian', 10)->nullable()->unique();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('absensis');
    }
};
