<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddShiftChangeRequestedToDutiesTable extends Migration
{
    public function up()
    {
        Schema::table('duties', function (Blueprint $table) {
            $table->boolean('shift_change_requested')->default(false);
        });
    }

    public function down()
    {
        Schema::table('duties', function (Blueprint $table) {
            $table->dropColumn('shift_change_requested');
        });
    }
}
