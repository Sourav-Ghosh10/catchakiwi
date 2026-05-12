<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddExtraFieldsToNoticeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('notice', function (Blueprint $table) {
            $table->string('town_suburb')->nullable();
            $table->string('looking_for')->nullable();
            $table->string('job_location')->nullable();
            $table->string('start_date')->nullable();
            $table->string('budget')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('notice', function (Blueprint $table) {
            $table->dropColumn(['town_suburb', 'looking_for', 'job_location', 'start_date', 'budget']);
        });
    }
}
