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
        if (!Schema::hasColumn('notice', 'service_type')) {
            Schema::table('notice', function (Blueprint $table) {
                $table->string('service_type')->nullable()->after('looking_for');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('notice', 'service_type')) {
            Schema::table('notice', function (Blueprint $table) {
                $table->dropColumn('service_type');
            });
        }
    }
};
