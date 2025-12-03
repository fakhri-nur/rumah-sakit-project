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
        Schema::table('iklan', function (Blueprint $table) {
            $table->string('nama');
            $table->string('gambar')->nullable();
            $table->text('keterangan')->nullable();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('iklan', function (Blueprint $table) {
            $table->dropColumn(['nama', 'gambar', 'keterangan']);
            $table->dropSoftDeletes();
        });
    }
};
