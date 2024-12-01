<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRoleToUsersTable extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // Check if the 'role' column already exists
            if (!Schema::hasColumn('users', 'role')) {
                $table->enum('role', ['manager', 'janitor'])->default('janitor');
            }
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            // Remove the 'role' column during rollback
            if (Schema::hasColumn('users', 'role')) {
                $table->dropColumn('role');
            }
        });
    }
}
