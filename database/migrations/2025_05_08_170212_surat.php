<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('user', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('username')->unique();
            $table->string('password');
            $table->enum('role', ['admin', 'sekretaris', 'kepala_desa', 'staff'])->default('staff');
            $table->timestamps();
        });

        Schema::create('surat_masuk', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_surat');
            $table->date('tanggal_surat');
            $table->date('tanggal_terima');
            $table->string('pengirim');
            $table->string('perihal');
            $table->string('file')->nullable();
            $table->string('status')->default('baru');
            $table->text('disposisi')->nullable();
            $table->timestamps();
        });

        Schema::create('surat_keluar', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_surat');
            $table->date('tanggal_surat');
            $table->string('tujuan');
            $table->string('perihal');
            $table->text('isi');
            $table->string('file')->nullable();
            $table->string('status')->default('draft');
            $table->foreignId('penandatangan_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('log_aktivitas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('aktivitas');
            $table->string('tipe_surat')->nullable(); // masuk/keluar
            $table->unsignedBigInteger('surat_id')->nullable(); // tidak dibuat foreign key karena bisa mengacu ke dua tabel
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('log_aktivitas');
        Schema::dropIfExists('surat_keluar');
        Schema::dropIfExists('surat_masuk');
        Schema::dropIfExists('user');
    }
};
