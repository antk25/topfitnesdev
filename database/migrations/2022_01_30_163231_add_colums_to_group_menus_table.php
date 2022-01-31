<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumsToGroupMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('group_menus', function (Blueprint $table) {
           $table->string('place')->after('name');
           $table->string('about')->nullable()->after('name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('group_menus', function (Blueprint $table) {
            $table->dropColumn('place');
            $table->dropColumn('about');
        });
    }
}
