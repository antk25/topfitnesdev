<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddChangeColumsToManualsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('manuals', function (Blueprint $table) {

            $table->string('description', 1000)->nullable()->change();
            $table->mediumText('content')->change();

            $table->mediumText('content_raw')->after('description');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('manuals', function (Blueprint $table) {
           $table->string('description', 300)->nullable()->change();
           $table->text('content')->change();
           $table->dropColumn('content_raw');
        });
    }
}
