<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddExtraFieldsToNoticeCategory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('notice_category', function (Blueprint $table) {
            $table->string('subtitle')->nullable();
            $table->string('icon')->nullable();
            $table->string('color')->nullable();
            $table->string('type')->nullable();
            $table->boolean('is_new')->default(false);
            $table->boolean('is_active')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('notice_category', function (Blueprint $table) {
            $table->dropColumn(['subtitle', 'icon', 'color', 'type', 'is_new', 'is_active']);
        });
    }
}
