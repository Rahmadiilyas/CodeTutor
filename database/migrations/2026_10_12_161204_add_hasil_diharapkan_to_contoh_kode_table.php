<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('contoh_kode', 'hasil_diharapkan')) {
            Schema::table('contoh_kode', function (Blueprint $table) {
                $table->longText('hasil_diharapkan')->nullable()->after('kode_program');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('contoh_kode', 'hasil_diharapkan')) {
            Schema::table('contoh_kode', function (Blueprint $table) {
                $table->dropColumn('hasil_diharapkan');
            });
        }
    }
};
