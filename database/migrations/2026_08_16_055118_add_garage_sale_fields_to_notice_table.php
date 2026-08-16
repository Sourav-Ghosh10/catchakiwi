<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddGarageSaleFieldsToNoticeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('notice', function (Blueprint $table) {
            $table->text('gs_address')->nullable()->after('message_text');
            $table->decimal('gs_lat', 10, 7)->nullable()->after('gs_address');
            $table->decimal('gs_lng', 10, 7)->nullable()->after('gs_lat');
            $table->text('gs_additional_info')->nullable()->after('gs_lng');
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
            $table->dropColumn('gs_address');
            $table->dropColumn('gs_lat');
            $table->dropColumn('gs_lng');
            $table->dropColumn('gs_additional_info');
        });
    }
}
