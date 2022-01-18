<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeColumsToRatingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ratings', function (Blueprint $table) {
           $table->string('description', 1000)->change();
           $table->string('type_table')->after('list_specs')->change();
           $table->unsignedBigInteger('user_id')->after('id')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ratings', function (Blueprint $table) {
           $table->string('description', 300)->change();
           $table->string('type_table')->after('user_id')->change();
           $table->bigInteger('user_id')->after('deleted_at')->change();
        });
    }
}
